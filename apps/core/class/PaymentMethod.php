<?php

namespace Simpledom\Core\Classes;

use PaymentType;

abstract class PaymentMethod {

    protected $paymentMethodName;

    public abstract function OnFinishPayment(&$errors, $parameters);

    public abstract function CheckPayed($paymentID);

    public abstract function CreatePayment(&$errors, $userid, $amount, $currency, $userTransactionID);

    public abstract function VerifyValidPayment(&$errors);

    protected abstract function SetPayed(&$errors);

    public abstract function RequestStartPayment(&$errors, $userid, $paymentID, $amount, $currency);

    public abstract function GetPaymentInfo($paymentitemid);

//    public static function PaymentInfo($paymenttype, $paymentitemid) {
//        switch ($paymenttype) {
//            case __ORDERPAYMENTTYPE_PAYPAL:
//                // it was paypal payment info]
//                die("not implanted");
//                break;
//            case __ORDERPAYMENTTYPE_MELLAT:
//                // it was mellat payment
//                require_once 'class.payment.mellat.php';
//                $mp = new MellatPayment(0);
//                $paymentinfo = $mp->GetPaymentInfo($paymentitemid);
//                return $paymentinfo;
//            case __ORDERPAYMENTTYPE_PAYLINE:
//                // it was mellat payment
//                require_once 'class.payment.payline.php';
//                $pp = new PaymentPayline(0);
//                $paymentinfo = $pp->GetPaymentInfo($paymentitemid);
//                return $paymentinfo;
//            default:
//                die("getPaymentInfo implanted");
//                break;
//        }
//    }

    /**
     * this function will start payment
     * @param type $errors
     * @param type $paymentID
     * @param type $amount
     * @param type $currency
     * @return type
     */
    public function StartPayment(&$errors, $userid, $amount, $currency, $transactionID, $orderID = null) {

        $paymentID = $this->CreatePayment($errors, $userid, $amount, $currency, $transactionID);

        // check if this payment is for the order, set the payment info for order
        if (isset($orderID) && intval($orderID) > 0) {
            // it is for order id
            $order = new Order($userid);
            $paymentType = $this->getPaymentTypeID();
            $order->UpdateOrderPaymentInfo($errors, $orderID, $userid, $paymentType, $paymentID);

            // check if we have no erorrs
            if (count($errors) > 0) {
                // we have sme problems
                //var_dump($errors);
                return;
            }
        }

        // we have to start the payment
        $this->RequestStartPayment($errors, $userid, $paymentID, $amount, $currency);
    }

    public function getPaymentTypeID() {
        return PaymentType::findFirst("key = '$this->paymentMethodName'")->id;
    }

}
