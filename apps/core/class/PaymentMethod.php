<?php

namespace Simpledom\Core\Classes;

use BaseUser;
use EmailItems;
use PaymentType;
use Settings;
use SMSManager;
use SmsNumber;

abstract class PaymentMethod {

    protected $paymentMethodName;

    public abstract function getPaymentCost(&$errors, $paymentid);

    public abstract function OnFinishPayment(&$errors, $parameters);

    public abstract function CheckPayed($paymentID);

    public abstract function CreatePayment(&$errors, $userid, $amount, $currency, $userTransactionID);

    public abstract function VerifyValidPayment(&$errors);

    protected abstract function SetPayed(&$errors);

    public abstract function RequestStartPayment(&$errors, $userid, $paymentID, $amount, $currency);

    public abstract function GetPaymentInfo($paymentitemid);

    public abstract function GetPaymentReceiptInfos($id);

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

    public function sendPaymentReceipt($paymentName, $userid, $name, $receiptEmail, $amount, $currency, $paymentDetails, $date) {

        // check if we have to send receipt by email
        if (intval(Settings::Get()->sendpaymentreceiptbyemail) == 1) {
            // create template for items
            $template = "";
            foreach ($paymentDetails as $key => $value) {
                $template .= "<p>$key : <b>$value</b></p><br/>";
            }
            $emailtemplate = new EmailItems();
            $emailtemplate->sendPaymentReceipt($paymentName, $userid, $name, $receiptEmail, $amount, $currency, $template, $date);
        }

        // check if we have to send receipt by sms
        if (intval(Settings::Get()->sendpaymentreceiptbysms) == 1) {

            $user = BaseUser::findFirst($userid);
            // check if teh user has verified email
            if ($user->hasVerifiedPhone()) {

                $userPhone = $user->getVerifiedPhone();
                // create template for items
                $sitename = \Settings::Get()->websitename;
                $template = "Dear $name\nHere is your $paymentName payment receipt from $sitename.\n\n";
                $template .= "Amount: $amount\nCurrency: $currency\n";
                foreach ($paymentDetails as $key => $value) {
                    $template .= "$key: $value\n";
                }

                // send sms
                SMSManager::SendSMS($userPhone, $template, SmsNumber::findFirst("enable = '1'")->id);
            }
        }
    }

}
