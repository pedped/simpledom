<?php

class EmailManager {

    /**
     * email template that be used to send email
     * @var BaseEmailTemplate 
     */
    private $emailTemplate = null;
    private $receivers = null;
    public $subject;

    /**
     * Set recivers
     * @param ArrayObject|String $emails
     * @return EmailManager
     */
    public function setReceivers($emails) {
        if (is_array($emails)) {
            $this->receivers = $emails;
        } else {
            $this->receivers = array();
            $this->receivers[] = $emails;
        }
        return $this;
    }

    /**
     * Set email subject
     * @param type $subject
     * @return EmailManager
     */
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    /**
     * this function replace template key with values
     * @return String
     */
    private function getOutput() {
        $output = $this->emailTemplate->template;
        foreach ($this->emailTemplate->getParameters() as $key => $value) {
            $output = str_replace("[[$key]]", $value, $output);
        }
        return $output;
    }

    /**
     * Manage Sending emails
     * @return boolean
     */
    public function sendEmail() {

        // we have to get real email template
        $content = $this->getOutput();


        // create new sent email object
        $sentEmailModel = new BaseSentEmail();
        $sentEmailModel->content = $content;
        $sentEmailModel->generaltemplate = $this->emailTemplate->template;
        $sentEmailModel->ip = $_SERVER["REMOTE_ADDR"];
        $sentEmailModel->subject = $this->subject;

        try {
            // now we have email object, we have to send the email
            // Create the Transport
            $transport = Swift_SmtpTransport::newInstance('smtp.example.org', 25)
                    ->setUsername('your username')
                    ->setPassword('your password');

            /*
              You could alternatively use a different transport such as Sendmail or Mail:

              // Sendmail


              // Mail
              $transport = Swift_MailTransport::newInstance();
             */

            // Create the Mailer using your created Transport
            $mailer = Swift_Mailer::newInstance($transport);

            // Create a message
            $message = Swift_Message::newInstance($this->subject)
                    ->setFrom(array('john@doe.com' => 'John Doe'))
                    ->setTo($this->receivers)
                    ->setBody($content);

            // Send the message
            $result = $mailer->send($message);

            // set sent email result and save that
            $sentEmailModel->sentresult = $result;
            $sentEmailModel->receivers = json_encode($this->receivers);
            $sentEmailModel->create();


            // resturn the result
            return $result;
        } catch (Exception $exc) {
            // Log the problem
            echo $exc->getMessage();
        }
        return false;
    }

    /**
     * 
     * @return BaseEmailTemplate
     */
    public function getEmailTemplate() {
        return $this->emailTemplate;
    }

    /**
     * 
     * @param type $emailTemplate
     * @return EmailManager
     */
    public function setEmailTemplate($emailTemplate) {
        $this->emailTemplate = $emailTemplate;
        return $this;
    }

}
