<?php

use Simpledom\Core\AtaModel;

class BaseSMSCredit extends AtaModel {

    public function getSource() {
        return 'smscredit';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseSMSCredit
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return BaseSMSCredit
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Value
     * @var string
     */
    public $value;

    /**
     * Set Value
     * @param type $value
     * @return BaseSMSCredit
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return BaseSMSCredit
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * 
     * @param type $parameters
     * @return SMSCredit
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    /**
     * this function will decrease user cerdit and add new raw to SMSCreditChange
     * @param array $errors
     * @param int $userid
     * @param int $smsid
     * @param int $totalsms
     */
    public static function decreaseCredit(&$errors, $userid, $smsid, $totalsms) {
        $smsCredit = SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $userid)));
        $smsCredit->value -= $totalsms;
        if (!$smsCredit->save()) {

            // log the problem
            BaseSystemLog::CreateLogError("Decrease SMS Credit", "Unable to decrease sms credit for userid '$userid' : " . $smsCredit->getMessagesAsLines());

            // show the message
            $errors[] = _("Unable to decrease user SMS credit");
            return false;
        }

        // we have to add new raw to SMSCredit Change
        $smsCreditChange = new SMSCreditChange();
        $smsCreditChange->userid = $userid;
        $smsCreditChange->smsid = $smsid;
        $smsCreditChange->value = "-" . $totalsms;
        if (!$smsCreditChange->create()) {
            BaseSystemLog::CreateLogError("Decrease SMS Credit", "Unable to add new sms credit change for userid '$userid' : " . $smsCreditChange->getMessagesAsLines());
            return true;
        }

        return true;
    }

}
