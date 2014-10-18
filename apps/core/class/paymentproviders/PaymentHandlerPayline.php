<?php

use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;
use Simpledom\Core\Classes\Order;
use Simpledom\Core\Classes\PaymentMethod;

class PaymentHandlerPayline extends PaymentMethod {

    protected $paymentMethodName = "payline";

    /**
     * Check if the payment was payed before, this function will check from database, not payment server
     * @param type $paymentID
     * @return boolean
     */
    public function CheckPayed($paymentID) {
        return PaymentPayline::findFirst($paymentID)->done == 1;
    }

    /**
     * Create New Payline Payment Raw In Database And Return the ID
     * @param int $userid
     * @param float $amount
     * @param string $currency
     * @param int $userTransactionID
     * @return int Payline Payment ID
     */
    public function CreatePayment(&$errors, $userid, $amount, $currency, $userTransactionID) {
        $payment = new PaymentPayline();
        $payment->userid = $userid;
        $payment->amount = $amount;
        $payment->cur = $currency;
        $payment->usertransactionid = $userTransactionID;
        if (!$payment->create()) {
            $errors[] = _("Unable to create new payment");
            $errors = array_merge($errors, $payment->getMessages());
            return false;
        }

        // payment created successfully
        return $payment->id;
    }

    public function GetPaymentInfo($paymentID) {
        return PaymentPayline::findFirst($paymentID);
    }

    /**
     * this function will call when we have recived finish url
     * @param type $errors
     * @param type $parameters
     * @return boolean
     */
    public function OnFinishPayment(&$errors, $parameters) {

        //Get Inputs
        $paylineTransactionID = $parameters['trans_id'];
        $paylineGetID = $parameters['id_get'];
        $paylinePaylineID = $parameters['pid'];
        $userid = $parameters['userid'];

        // Add Payline Function
        if (!$this->SetPayed($errors, $paylineTransactionID, $paylineGetID, $paylinePaylineID, $userid)) {
            $errors = _("Unable to finish payment");
            return false;
        }


        // payment method set to done, check if this payment was belong to a order
        $order = new Order($userid);
        $paymentTypeID = $this->getPaymentTypeID();
        return $order->OnSuccessPayment($errors, $paymentTypeID, $paylinePaylineID);
    }

    /**
     * this function will Set Payment As Payed Payment
     * Parameters Are :
     * 
     *  $paylineTransactionID
     *  $paylineIDGet
     *  $paylinePaymentID
     *  $userid
     *  
     * @param type $errors
     * @return boolean
     */
    protected function SetPayed(&$errors) {

        $paylineTransactionID = func_get_arg(1);
        $paylineIDGet = func_get_arg(2);
        $paylinePaymentID = func_get_arg(3);
        $userid = func_get_arg(4);

        // we have to check if user really payed the price
        if (!$this->VerifyValidPayment($errors, $paylineTransactionID, $paylineIDGet) || !$this->VerifyPaylineIDGetAndPaylineID($paylinePaymentID, $paylineIDGet)) {
            $errors[] = _("Can not validate your payment");
            return false;
        }
        // Set Payed
        $payment = PaymentPayline::findFirst("paylineidget = '$paylineIDGet'");
        if ($payment->userid != $userid) {
            // invalid userid
            $errors[] = _("Invalid User ID");
            return false;
        }

        $payment->paylinetransactionid = $paylineTransactionID;
        $payment->done = 1;
        if (!$payment->save()) {
            // unable to save the payment
            $errors[] = _("Can not update database info, may be you have payed this order before or you are not authorzed to access this payment");
            $errors = array_merge($errors, $payment->getMessages());
            return false;
        }

        return true;
    }

    public function RequestStartPayment(&$errors, $userid, $paymentID, $amount, $currency) {

        function send($url, $api, $amount, $redirect) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&amount=$amount&redirect=$redirect");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        }

        $url = 'http://payline.ir/payment-test/gateway-send';
        $api = Config::GetPaylineAPI();
        $amount = filter_var($amount, FILTER_VALIDATE_INT);
        $redirect = urlencode(Config::getPublicUrl() . 'payment/finish/payline/' . $paymentID . "");
        $paylineGetID = send($url, $api, $amount, $redirect);
        if ($paylineGetID > 0 && is_numeric($paylineGetID)) {

            $payment = PaymentPayline::findFirst($paymentID);
            if (intval($payment->userid) != intval($userid)) {
                $errors[] = _("Invalid User ID");
                return;
            }
            $payment->paylineidget = $paylineGetID;
            if (!$payment->save()) {
                $errors[] = _("Unable to store payment info in database");
                return;
            }

            $url = "http://payline.ir/payment-test/gateway-$paylineGetID";
            Helper::RedirectToURL($url);
            return;
        }

        switch ($paylineGetID) {
            case '-1':
                $errors[] = _("invalid API");
                break;
            case '-2':
                $errors[] = _("amount is lower than 1000 rials");
                break;
            case '-3':
                $errors[] = _("invalid redirect url");
                break;
            case '-4':
                $errors[] = _("can not find requested payment or waiting");
                break;
        }
    }

    /**
     * Check if the payment is really payed by user
     * @param type $errors
     * @return boolean
     */
    public function VerifyValidPayment(&$errors) {

        $paylineTransactionID = func_get_arg(1);
        $paylineIDGet = func_get_arg(2);

        if ($paylineTransactionID == false || $paylineIDGet == false) {
            $errors[] = _("Invalid Parameters to verfiy your payment");
            return false;
        }

        // verfiy via payline verify proccess
        function get($url, $api, $trans_id, $id_get) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&id_get=$id_get&trans_id=$trans_id");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        }

        $url = 'http://payline.ir/payment-test/gateway-result-second';
        $api = Config::GetPaylineAPI();
        $trans_id = $paylineTransactionID;
        $id_get = $paylineIDGet;
        $result = get($url, $api, $trans_id, $id_get);
        switch ($result) {
            case '-1' :
                $errors[] = _("invalid payline api");
                return false;
            case '-2' :
                $errors[] = _("invalid Transaction ID");
                return false;
            case '-3' :
                $errors[] = _("invalid Payline GetID");
                return false;
            case '-4' :
                $errors[] = _("Payline can not find this transaction or is not valid");
                return false;
            case '1' :
                // valid payment
                return true;
        }

        return false;
    }

    /**
     * this function will check if the recived payment get id is equal to waht we have saved before
     * @param type $paylinePaymentID
     * @param type $paylineIDGet
     * @return boolean
     */
    public function VerifyPaylineIDGetAndPaylineID($paylinePaymentID, $paylineIDGet) {
        $payment = PaymentPayline::findFirst($paylinePaymentID);
        return intval($payment->paylineidget) == intval($paylineIDGet);
    }

}
