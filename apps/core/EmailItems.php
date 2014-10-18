<?php

define("EMAILTEMPLATE_RESETPASSWORD", "RESET_PASSWORD");
define("EMAILTEMPLATE_BULKEMAIL", "BULK_EMAIL");

class EmailItems extends EmailManager {

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
