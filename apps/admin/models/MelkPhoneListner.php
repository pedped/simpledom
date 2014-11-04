<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Helper;

class MelkPhoneListner extends AtaModel {

    public function getSource() {
        return 'melkphonelistner';
    }

    public $userid;

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MelkPhoneListner
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Purpose ID
     * @var string
     */
    public $melkpurposeid;

    /**
     * Set Purpose ID
     * @param type $melkpurposeid
     * @return MelkPhoneListner
     */
    public function setMelkpurposeid($melkpurposeid) {
        $this->melkpurposeid = $melkpurposeid;
        return $this;
    }

    /**
     * Type ID
     * @var string
     */
    public $melktypeid;

    /**
     * Set Type ID
     * @param type $melktypeid
     * @return MelkPhoneListner
     */
    public function setMelktypeid($melktypeid) {
        $this->melktypeid = $melktypeid;
        return $this;
    }

    /**
     * Bedroom Start
     * @var string
     */
    public $bedroom_start;

    /**
     * Set Bedroom Start
     * @param type $bedroom_start
     * @return MelkPhoneListner
     */
    public function setBedroom_start($bedroom_start) {
        $this->bedroom_start = $bedroom_start;
        return $this;
    }

    /**
     * Bedroom End
     * @var string
     */
    public $bedroom_end;

    /**
     * Set Bedroom End
     * @param type $bedroom_end
     * @return MelkPhoneListner
     */
    public function setBedroom_end($bedroom_end) {
        $this->bedroom_end = $bedroom_end;
        return $this;
    }

    /**
     * Phone ID
     * @var string
     */
    public $phoneid;

    /**
     * Set Phone ID
     * @param type $phoneid
     * @return MelkPhoneListner
     */
    public function setPhoneid($phoneid) {
        $this->phoneid = $phoneid;
        return $this;
    }

    /**
     * Received Count
     * @var string
     */
    public $receivedcount;

    /**
     * Set Received Count
     * @param type $receivedcount
     * @return MelkPhoneListner
     */
    public function setReceivedcount($receivedcount) {
        $this->receivedcount = $receivedcount;
        return $this;
    }

    /**
     * Status
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return MelkPhoneListner
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Rent Price Start
     * @var string
     */
    public $rent_price_start;

    /**
     * Set Rent Price Start
     * @param type $rent_price_start
     * @return MelkPhoneListner
     */
    public function setRent_price_start($rent_price_start) {
        $this->rent_price_start = $rent_price_start;
        return $this;
    }

    /**
     * Rent Price End
     * @var string
     */
    public $rent_price_end;

    /**
     * Set Rent Price End
     * @param type $rent_price_end
     * @return MelkPhoneListner
     */
    public function setRent_price_end($rent_price_end) {
        $this->rent_price_end = $rent_price_end;
        return $this;
    }

    /**
     * Rahn Start
     * @var string
     */
    public $rent_pricerahn_start;

    /**
     * Set Rahn Start
     * @param type $rent_pricerahn_start
     * @return MelkPhoneListner
     */
    public function setRent_pricerahn_start($rent_pricerahn_start) {
        $this->rent_pricerahn_start = $rent_pricerahn_start;
        return $this;
    }

    /**
     * Rahn End
     * @var string
     */
    public $rent_pricerahn_end;

    /**
     * Set Rahn End
     * @param type $rent_pricerahn_end
     * @return MelkPhoneListner
     */
    public function setRent_pricerahn_end($rent_pricerahn_end) {
        $this->rent_pricerahn_end = $rent_pricerahn_end;
        return $this;
    }

    /**
     * Sale Start
     * @var string
     */
    public $sale_price_start;

    /**
     * Set Sale Start
     * @param type $sale_price_start
     * @return MelkPhoneListner
     */
    public function setSale_price_start($sale_price_start) {
        $this->sale_price_start = $sale_price_start;
        return $this;
    }

    /**
     * Sale End
     * @var string
     */
    public $Ssale_price_end;

    /**
     * Set Sale End
     * @param type $sale_price_end
     * @return MelkPhoneListner
     */
    public function setSale_price_end($sale_price_end) {
        $this->sale_price_end = $sale_price_end;
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
     * @return MelkPhoneListner
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * City ID
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return MelkPhoneListner
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    public function getDate() {
        return Helper::GetPersianDate($this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return MelkPhoneListner
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->status = "1";
        $this->receivedcount = "0";
        $this->ip = $_SERVER["REMOTE_ADDR"];
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * melkphonelistner
     * @param type $cityID
     * @param type $latitude
     * @param type $longitude
     * @param type $maxDistance
     * @return Resultset
     */
    public static function getNearest($cityID, $latitude, $longitude, $maxDistance) {
        return null;
    }

    public function getPurposeTitle() {
        return MelkPurpose::findFirst($this->melkpurposeid)->name;
    }

    public function getTypeTitle() {
        return MelkType::findFirst($this->melktypeid)->name;
    }

    public function getPhoneNumber() {
        return UserPhone::findFirst($this->phoneid)->phone;
    }

    public function getCityName() {
        return City::findFirst($this->cityid)->name;
    }

    public function getRentPriceStartHuman() {
        return $this->rent_price_start <= 0 ? "-" : Helper::GetPrice($this->rent_price_start);
    }

    public function getRentPriceEndHuman() {
        return $this->rent_price_end <= 0 ? "-" : Helper::GetPrice($this->rent_price_end);
    }

    public function getRentPriceRahnStartHuman() {
        return $this->rent_pricerahn_start <= 0 ? "-" : Helper::GetPrice($this->rent_pricerahn_start);
    }

    public function getRentPriceRahnEndHuman() {
        return $this->rent_pricerahn_end <= 0 ? "-" : Helper::GetPrice($this->rent_pricerahn_end);
    }

    public function getSalePriceStartHuman() {
        return $this->sale_price_start <= 0 ? "-" : Helper::GetPrice($this->sale_price_start);
    }

    public function getSalePriceEndHuman() {
        return $this->sale_price_end <= 0 ? "-" : Helper::GetPrice($this->sale_price_end);
    }

    public static function subscribeUser(&$errors, $userid, $phone) {

        // valid phone number, we have to check if the phone number is exist
        $userPhone = UserPhone::findFirst(array("phone = :phone:", "bind" => array("phone" => $phone)));


        // check for userid
        if ($userPhone && intval($userPhone->userid) != intval($userid)) {
            // user is ot valid
            $errors[] = ("شماره تماس شما توسط شخص دیگری ثبت گردیده است، در صورت اطمینان از شماره خود، توسط فرم تماس با ما این مهم را در جریان بگزارید");
            return false;
        } else if ($userPhone && intval($userPhone->userid) == intval($userid)) {
            
        } else {
            // user phone is not exist, create user phone
            $userPhone = new UserPhone();
            $userPhone->phone = $phone;
            $userPhone->userid = $userid;
            if (!$userPhone->create()) {
                $errors[] = ("خطا در هنگام اضافه کردن شماره تماس");
                $errors[] = $userPhone->getMessagesAsLines();
                //$controller->LogError("Problem In Adding User Phone", "khata dar hengame ezafe kardane shomare shaks : " . $userPhone->getMessagesAsLines());
                return false;
            }
        }


        $melkListner = new MelkPhoneListner();

        $melkListner->cityid = $_POST["cityid"];
        $melkListner->melkpurposeid = $_POST["melkpurposeid"];
        $melkListner->melktypeid = $_POST["melktypeid"];

        $melkListner->phoneid = $userPhone->id;

        $melkListner->bedroom_start = $_POST["bedroom_start"];
        $melkListner->bedroom_end = $_POST["bedroom_end"];

        $melkListner->rent_price_start = $_POST["rent_price_start"];
        $melkListner->rent_price_end = $_POST["rent_price_end"];

        $melkListner->rent_pricerahn_start = $_POST["rent_pricerahn_start"];
        $melkListner->rent_pricerahn_end = $_POST["rent_pricerahn_end"];

        $melkListner->sale_price_start = $_POST["sale_price_start"];
        $melkListner->sale_price_end = $_POST["sale_price_end"];




        if (!$melkListner->create()) {
            $errors[] = ("خطا در هنگام اضافه کردن شماره تماس");
            //$controller->LogError("Problem In Adding User Phone", "khata dar hengame ezafe kardane agahsaz : " . $melkListner->getMessagesAsLines());
            return false;
        }


        // add supported areas
        $areaIDs = Area::GetMultiID($melkListner->cityid, $_POST['address']);
        foreach ($areaIDs as $areaid) {
            $melklistnerarea = new MelkPhoneListnerArea();
            $melklistnerarea->melkphonelistnerid = $melkListner->id;
            $melklistnerarea->areaid = $areaid;
            $melklistnerarea->create();
        }

        // check if the phone is valid
        if (!$userPhone->verified) {
            $userPhone->sendVerificationNumber();
            return 2;
        } else {
            return 1;
        }
    }

}
