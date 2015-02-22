<?php

use Simpledom\Core\AtaModel;

class BongahAction extends AtaModel {

    const ACTION_VIEWMELK = "1";
    const ACTION_LOADALLMELKS = "2";
    const ACTION_REMOVEMELK = "3";
    const ACTION_PURCHASESMSCREDIT = "4";
    const ACTION_PURCHASEBONGAHPLAN = "5";
    const ACTION_GETBONGAHPLAN = "6";
    const ACTION_VIEWTUTORIAL = "7";
    const ACTION_GETSMSPLAN = "8";
    const ACTION_SENDMELKINFO = "9";
    const ACTION_GETPHONESUGGESTION = "10";
    const ACTION_ADDMELK = "11";
    const ACTION_PROBLEMINADDMELK = "12";
    const ACTION_LOADMELKS = "13";
    const ACTION_FETCHPHONELISTNERLIST = "14";
    const ACTION_FETCHMELKCANBESEND = "15";
    const ACTION_VIEWPHONELISTNER = "16";
    const ACTION_SENDMELKINFOFORLISTNER = "17";

    public function getSource() {
        return 'bongah_action';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahAction
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Bongah ID
     * @var string
     */
    public $bongahid;

    /**
     * Set Bongah ID
     * @param type $bongahid
     * @return BongahAction
     */
    public function setBongahid($bongahid) {
        $this->bongahid = $bongahid;
        return $this;
    }

    /**
     * Action Code
     * @var string
     */
    public $actioncode;

    /**
     * Set Action Code
     * @param type $actioncode
     * @return BongahAction
     */
    public function setActioncode($actioncode) {
        $this->actioncode = $actioncode;
        return $this;
    }

    /**
     * Data
     * @var string
     */
    public $data;

    /**
     * Set Data
     * @param type $data
     * @return BongahAction
     */
    public function setData($data) {
        $this->data = $data;
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
     * @return BongahAction
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return Jalali::date('Y-m-d H:i:s', $this->date);
    }

    public function getBongahName() {
        return Bongah::findFirst(array("id = :id:", "bind" => array("id" => $this->bongahid)))->title;
    }

    public function getActionName() {
        $actionstring = strval($this->actioncode);

        switch ($actionstring) {
            case BongahAction::ACTION_VIEWMELK;
                return "مشاهده ملک";
            case BongahAction::ACTION_LOADALLMELKS;
                return "دریافت املاک شهر";
            case BongahAction::ACTION_REMOVEMELK;
                return "حذف ملک";
            case BongahAction::ACTION_PURCHASESMSCREDIT;
                return "خرید پلان پیامک";
            case BongahAction::ACTION_PURCHASEBONGAHPLAN;
                return "خرید پلان بنگاه";
            case BongahAction::ACTION_GETBONGAHPLAN;
                return "دریافت پلان بنگاه";
            case BongahAction::ACTION_VIEWTUTORIAL;
                return "مشاهده آموزش";
            case BongahAction::ACTION_GETSMSPLAN;
                return "دریافت پلان پیامک";
            case BongahAction::ACTION_SENDMELKINFO;
                return "ارسال اطلاعات ملک";
            case BongahAction::ACTION_GETPHONESUGGESTION;
                return "دریافت مشتریان پیشنهادی";
            case BongahAction::ACTION_ADDMELK;
                return "افزودن ملک";
            case BongahAction::ACTION_PROBLEMINADDMELK;
                return "خطا در افزودن ملک";
            case BongahAction::ACTION_LOADMELKS;
                return "دریافت املاک";
            case BongahAction::ACTION_FETCHPHONELISTNERLIST;
                return "دریافت لیست مشتریان";
            case BongahAction::ACTION_FETCHMELKCANBESEND;
                return "دریافت املاک قابل ارسال";
            case BongahAction::ACTION_VIEWPHONELISTNER;
                return "مشاهده مشتری";
            case BongahAction::ACTION_SENDMELKINFOFORLISTNER;
                return "ارسال اطلاعات ملک به مشتری";
            default :
                return "ذکر نگردید";
        }
    }

    public function getCityName() {
        return Bongah::findFirst(array("id = :id:", "bind" => array("id" => $this->bongahid)))->getCityName();
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return BongahAction
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    public static function CreateAction($bongahid, $actionCode, $parameters = null) {
        $bongahAction = new BongahAction();
        $bongahAction->bongahid = $bongahid;
        $bongahAction->actioncode = $actionCode;
        $bongahAction->data = $parameters;
        $bongahAction->create();
    }

}
