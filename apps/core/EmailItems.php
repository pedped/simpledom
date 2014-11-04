<?php

use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;

define("EMAILTEMPLATE_REGISTER", "REGISTER");
define("EMAILTEMPLATE_RESETPASSWORD", "RESET_PASSWORD");
define("EMAILTEMPLATE_BULKEMAIL", "BULK_EMAIL");
define("EMAILTEMPLATE_PAYMENTRECEIPT", "PAYMENT_RECEIPT");
define("EMAILTEMPLATE_REPLY", "REPLY");
define("EMAILTEMPLATE_VERIFY", "VERIFY");
define("EMAILTEMPLATE_MELKCONTACTEMAIL", "MELKCONTACTEMAIL");

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
            "link" => Config::getPublicUrl(),
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
            "url" => Config::getPublicUrl(),
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

        // we have to send each email as seperate email in order
        // to send each email user
        // in each email
        foreach ($emails as $email) {
            // set email template
            $this->setSubject($subject)->setEmailTemplate($emailTemplate)->setReceivers($email)->sendEmail();
        }
        return TRUE;
    }

    public function sendReply($useremail, $name, $message, $repliedmessage) {
        // load the email template from server
        $emailTemplate = BaseEmailTemplate::findFirst("name = '" . EMAILTEMPLATE_REPLY . "'");
        $emailTemplate->setParameters(array(
            "message" => $message,
            "name" => $name,
            "useremail" => $useremail,
            "repliedmessage" => $repliedmessage,
        ));

        // set email template
        return $this->setSubject("Reply To Your Message")->setEmailTemplate($emailTemplate)->setReceivers($useremail)->sendEmail();
    }

    /**
     * Send Verify Code to email
     * @param type $userid
     * @param type $name
     * @param type $email
     * @param type $verifycode
     * @return type
     */
    public function sendVerifyCode($userid, $name, $email, $verifycode) {
        // load the email template from server
        $emailTemplate = BaseEmailTemplate::findFirst("name = '" . EMAILTEMPLATE_VERIFY . "'");
        $emailTemplate->setParameters(array(
            "userid" => $userid,
            "name" => $name,
            "email" => $email,
            "verifycode" => $verifycode,
            "url" => Config::getPublicUrl(),
        ));

        // set email template
        return $this->setSubject("Verify Your Email")->setEmailTemplate($emailTemplate)->setReceivers($email)->sendEmail();
    }

    /**
     * Send Contact Email
     * @param type $melkID
     * @param type $melkEmail
     * @param type $melkPhone
     * @param type $name
     * @param type $phone
     * @param type $message
     * @return type
     */
    public function sendMelkContact($melkID, $melkEmail, $melkPhone, $name, $phone, $message) {
        // load the email template from server
        $emailTemplate = BaseEmailTemplate::findFirst("name = '" . EMAILTEMPLATE_MELKCONTACTEMAIL . "'");
        $emailTemplate->setParameters(array(
            "melkid" => $melkID,
            "melkemail" => $melkEmail,
            "name" => $name,
            "phone" => $phone,
            "message" => $message,
            "url" => Config::getPublicUrl(),
        ));

        // set email template
        return $this->setSubject("پیام جدید در ارتباط با ملک شما")->setEmailTemplate($emailTemplate)->setReceivers($melkEmail)->sendEmail();
    }

}
