<?php

use Simpledom\Core\Classes\Helper;

define("EMAILTEMPLATE_REGISTER", "REGISTER");
define("EMAILTEMPLATE_RESETPASSWORD", "RESET_PASSWORD");
define("EMAILTEMPLATE_BULKEMAIL", "BULK_EMAIL");
define("EMAILTEMPLATE_PAYMENTRECEIPT", "PAYMENT_RECEIPT");

class EmailItems extends EmailManager {

    /**
     * Send Payment Receipt
     * @param type $paymentname
     * @param type $userid
     * @param type $name
     * @param type $email
     * @param type $price
     * @param type $currency
     * @param type $paymentinfos
     * @param type $date
     * @return type
     */
    public function sendPaymentReceipt($paymentname, $userid, $name, $email, $price, $currency, $paymentinfos, $date) {
        // load the email template from server
        $emailTemplate = BaseEmailTemplate::findFirst("name = '" . EMAILTEMPLATE_PAYMENTRECEIPT . "'");
        $emailTemplate->setParameters(array(
            "paymentname" => $paymentname,
            "userid" => $userid,
            "name" => $name,
            "email" => $email,
            "price" => $price,
            "currency" => $currency,
            "paymentinfo" => $paymentinfos,
            "date" => Helper::formatDate($date),
        ));

        // set email template
        return $this->setSubject("Payment Receipt")->setEmailTemplate($emailTemplate)->setReceivers($email)->sendEmail();
    }

    /**
     * Send Reset Password Request Link
     * @param type $name
     * @param type $email
     * @param type $resetcode
     * @return boolean
     */
    public function sendPasswordRequest($name, $email, $resetcode) {
        // load the email template from server
        $emailTemplate = BaseEmailTemplate::findFirst("name = '" . EMAILTEMPLATE_RESETPASSWORD . "'");
        $emailTemplate->setParameters(array(
            "name" => $name,
            "email" => $email,
            "resetcode" => $resetcode,
            "link" => $resetcode,
        ));

        // set email template
        return $this->setSubject("Reset Password")->setEmailTemplate($emailTemplate)->setReceivers($email)->sendEmail();
    }

    /**
     * @templatename(EMAILTEMPLATE_REGISTER)
     * When a user register to the site, we will send email to the user
     * @param type $userid
     * @param type $name
     * @param type $email
     * @param type $verifycode
     * @return boolean
     */
    public function sendRegsiterNotification($userid, $name, $email, $verifycode) {
        // load the email template from server
        $emailTemplate = BaseEmailTemplate::findFirst("name = '" . EMAILTEMPLATE_REGISTER . "'");
        $emailTemplate->setParameters(array(
            "userid" => $userid,
            "name" => $name,
            "email" => $email,
            "verifycode" => $verifycode,
        ));

        // set email template
        return $this->setSubject("Welcome to " . Settings::Get()->websitename)->setEmailTemplate($emailTemplate)->setReceivers($email)->sendEmail();
    }

    /**
     * Send Bulk Email
     * @param type $emails
     * @param type $subject
     * @param type $message
     * @return type
     */
    public function sendBulkEmail($emails, $subject, $message) {

        // load the email template from server
        $emailTemplate = BaseEmailTemplate::findFirst("name = '" . EMAILTEMPLATE_BULKEMAIL . "'");

        $emailTemplate->setParameters(array(
            "message" => $message,
        ));

        // set email template
        return $this->setSubject($subject)->setEmailTemplate($emailTemplate)->setReceivers($emails)->sendEmail();
    }

}
