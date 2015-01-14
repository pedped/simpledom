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
    public $sale_price_end;

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

    public function getSimpleDate() {
        return Jalali::date("Y/m/d", $this->date);
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

        if (intval($this->melkpurposeid) == 1) {
            $this->rent_price_start = "-1";
            $this->rent_price_end = "-1";
            $this->rent_pricerahn_start = "-1";
            $this->rent_pricerahn_end = "-1";
        } else {
            $this->sale_price_start = "-1";
            $this->sale_price_end = "-1";
        }
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        $item = new stdClass();



        return $item;
    }

    /**
     * 
     * @param Bongah $bongah
     * @return stdClass
     */
    public function getMobileResponse($bongah) {
        $item = new stdClass();

        $item->id = $this->id;
        $item->unixdate = $this->date;
        $item->header = $this->getPurposeTitle() . " " . $this->getTypeTitle();
        $item->type = $this->getTypeTitle();
        $item->phone = $this->getPhoneNumber();
        $rateInfo = $this->getSuccessRateForBongah($bongah);
        $item->rate = $rateInfo->rate;
        $item->rateinfo = $rateInfo->messages;
        $item->review = $this->getReview();

        // get requested areas
        $item->area = $this->getAreasNames();
        $item->city = $this->getCityName();
        if (intval($this->bedroom_start) == intval($this->bedroom_end)) {
            $item->bedroom = $this->bedroom_start;
        } else {
            $item->bedroom = $this->bedroom_start . "-" . $this->bedroom_end;
        }
        // find melks can be sent
        $item->melkscanbesentcount = $rateInfo->melkscansend;

        if (intval($rateInfo->melkscansend) > 0) {
            $item->melkcountinfo = "<font color='#18b318'>" . "شما " . "<strong>" . $rateInfo->melkscansend . "</strong>" . " ملک مناسب این شخص دارید" . "</font>";
            // $item->melkcountinfo = "ملکی مناسب این مشتری یافت نگردید";
        } else {
            $item->melkcountinfo = "ملکی مناسبی برای این مشتری یافت نگردید";
        }
        $item->tobesend = true;

        // get price range
        if (intval($this->melkpurposeid) == 1) {
            // kharid
            $item->pricerange = $this->getSalePriceStartHuman() . " " . "تا" . " " . $this->getSalePriceEndHuman();
        } else if (intval($this->melkpurposeid) == 2) {
            // rahn va ejare
            $item->pricerange = "رهن: " . $this->getRentPriceRahnStartHuman() . " " . "تا" . " " . $this->getRentPriceRahnEndHuman();
            $item->pricerange .= "،" . "اجاره: " . $this->getRentPriceStartHuman() . " " . "تا" . " " . $this->getRentPriceEndHuman();
        }

        $item->date = $this->getSimpleDate();

        return $item;
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
        return str_replace("فروش", "خرید", MelkPurpose::findFirst($this->melkpurposeid)->name);
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

        // get correcrt phone number
        $phone = Helper::getCorrectIraninanMobilePhoneNumber($phone);
        if (!$phone) {
            $errors[] = "شماره موبایل وارد شده نامعتبر می باشد";
            return false;
        }


        // valid phone number, we have to check if the phone number is exist
        $userPhone = UserPhone::findFirst(array("phone = :phone:", "bind" => array("phone" => $phone)));


        // check for userid
        if (!$userPhone) {
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

        $melkListner->bedroom_start = $_POST["bedroom_range_min"];
        $melkListner->bedroom_end = $_POST["bedroom_range_max"];

        $melkListner->rent_price_start = $_POST["ejare_range_min"];
        $melkListner->rent_price_end = $_POST["ejare_range_max"];

        $melkListner->rent_pricerahn_start = $_POST["rahn_range_min"];
        $melkListner->rent_pricerahn_end = $_POST["rahn_range_max"];

        $melkListner->sale_price_start = $_POST["sale_range_min"];
        $melkListner->sale_price_end = $_POST["sale_range_max"];

        if (!$melkListner->create()) {
            $errors[] = ("خطا در هنگام اضافه کردن شماره تماس");
            //$controller->LogError("Problem In Adding User Phone", "khata dar hengame ezafe kardane agahsaz : " . $melkListner->getMessagesAsLines());
            return false;
        }


        // add supported areas
        if (isset($_POST["address"]) && strlen($_POST["address"])) {
            $areaIDs = Area::GetMultiID($melkListner->cityid, $_POST['address']);
            foreach ($areaIDs as $areaid) {
                $melklistnerarea = new MelkPhoneListnerArea();
                $melklistnerarea->melkphonelistnerid = $melkListner->id;
                $melklistnerarea->areaid = $areaid;
                $melklistnerarea->create();
            }
        }
        // check if the phone is valid
        if (!$userPhone->verified) {
            $userPhone->sendVerificationNumber();
            return 2;
        } else {
            return 1;
        }
    }

    /**
     * return the area names
     * @param type $implodeResult should be imploded with comma
     * @return string|array
     */
    public function getAreasNames($implodeResult = true) {
        $items = MelkPhoneListnerArea::find(array("melkphonelistnerid = :melkphonelistnerid:", "bind" => array("melkphonelistnerid" => $this->id)));
        $names = array();
        foreach ($items as $melkPhoneListner) {
            $names[] = Area::findFirst(array("id = :id:", "bind" => array("id" => $melkPhoneListner->areaid)))->name;
        }

        if ($implodeResult) {
            return implode("، ", $names);
        } else {
            return $names;
        }
    }

    /**
     * find users based on the areaids
     * @param type $areaIDs
     * @return Resultset MelkPhoneListner
     */
    public static function findBestItems($areaIDs) {
        $melkPhoneListnersIDs = array();

        foreach ($areaIDs as $areaid) {
            $melkSubscripts = MelkPhoneListnerArea::find(array("areaid = :areaid:", "bind" => array("areaid" => $areaid)));
            foreach ($melkSubscripts as $item) {
                $melkPhoneListnersIDs[] = $item->melkphonelistnerid;
            }
        }

        // now we have melk phone listners
        $melkPhoneListners = MelkPhoneListner::find(array("id IN (:ids:) AND status = 1", "group" => "phoneid", "bind" => array("ids" => implode(", ", $melkPhoneListnersIDs))));

        return $melkPhoneListners;
    }

    public function getReceivedCount() {
        return BongahSentMelk::count(array("melkphonelistnerid = :melkphonelistnerid:", "bind" => array("melkphonelistnerid" => $this->id)));
    }

    public function findApprochMelkCount() {
        return $this->findApprochMelk()->count();
    }

    public function findApprochMelkCountByBongah($bongahid = null) {

        if (!isset($bongahid)) {
            $bongahid = Bongah::findFirst(array("userid = :userid:", "bind" => array("userid" => $_SESSION["userid"])))->id;
        }
        return $this->findApprochMelk($bongahid)->count();
    }

    /**
     * find best melk based on this item
     * @return Resultset
     */
    public function findApprochMelks() {
        return $this->findApprochMelk();
    }

    /**
     * find best melk approch by bongah
     * @return Resultset
     */
    public function findApprochMelkByBongah($bongahid = null) {
        if (!isset($bongahid)) {
            $bongahid = Bongah::findFirst(array("userid = :userid:", "bind" => array("userid" => $_SESSION["userid"])))->id;
        }
        return $this->findApprochMelk($bongahid);
    }

    /**
     * find best melk based on user request
     * @param type $bongahid
     * @return Resultset
     */
    public function findApprochMelk($bongahid = null) {

        $melk = new Melk();

        $query = "cityid = :cityid: ";
        $bindparams["cityid"] = $this->cityid;

        // check if we have to find melk based on bongah
        if (isset($bongahid)) {
            $bongahUserID = Bongah::findFirst(array("id = :id:", "bind" => array("id" => $bongahid)))->userid;
            $query .= "AND userid = :userid: ";
            $bindparams["userid"] = $bongahUserID;
        }

        // add default parameters
        switch ($this->melkpurposeid) {
            case 1:
                // SALE
                if ($this->sale_price_start > 0) {
                    // we have to add user requested price range
                    $query .= "AND melktypeid = :melktypeid: AND melkpurposeid = :melkpurposeid:  AND sale_price >= :sale_price_start: AND sale_price <= :sale_price_end: ";
                    $bindparams["melktypeid"] = $this->melktypeid;
                    $bindparams["melkpurposeid"] = "1";
                    $bindparams["sale_price_start"] = $this->sale_price_start;
                    $bindparams["sale_price_end"] = $this->sale_price_end;
                } else {
                    $query .= "AND melktypeid = :melktypeid: AND melkpurposeid = :melkpurposeid:";
                    $bindparams["melktypeid"] = $this->melktypeid;
                    $bindparams["melkpurposeid"] = "1";
                }

                break;
            case 2:
                // RENT
                $query .= "AND melktypeid = :melktypeid: AND melkpurposeid = :melkpurposeid: ";
                $bindparams["melktypeid"] = $this->melktypeid;
                $bindparams["melkpurposeid"] = "2";

                if ($this->rent_price_start > 0) {
                    $query .= "AND rent_price >= :rent_price_start: AND rent_price <= :rent_price_end:  ";
                    $bindparams["rent_price_start"] = $this->rent_price_start;
                    $bindparams["rent_price_end"] = $this->rent_price_end;
                }
                if ($this->rent_pricerahn_start > 0) {
                    $query .= "AND rent_pricerahn >= :rent_pricerahn_start: AND rent_pricerahn <= :rent_pricerahn_end: ";
                    $bindparams["rent_pricerahn_start"] = $this->rent_pricerahn_start;
                    $bindparams["rent_pricerahn_end"] = $this->rent_pricerahn_end;
                }

                break;
        }


        switch ($this->melktypeid) {
            case 1 :
            case 2 :
            case 3 :
            case 6 :
                // khane
                // apartemnatn
                // daftar kar
                // otaghe kar
                if ($this->bedroom_start > 0) {
                    $query.= "AND bedroom >= :bedroom_start: AND bedroom <= :bedroom_end: ";
                    $bindparams["bedroom_start"] = $this->bedroom_start;
                    $bindparams["bedroom_end"] = $this->bedroom_end;
                }
                break;
            case 4 :
                break;
            case 5 :
                break;
            default:
                $this->LogError("Invalid Melk Type", "Melk type has invalid value");
                break;
        }

        $query.= "AND approved = 1";
        //var_dump($query);
        //die();

        return $melk->find(array($query, "order" => "id DESC", "bind" => $bindparams));
    }

    /**
     * find success rate for bongah
     * @param Bongah $bongah
     */
    public function getSuccessRateForBongah($bongah) {

        $result = new stdClass();
        $messages = array();

        $rate = 0;


        // 1 : have melk that can be supported and did not sent yet
        $melkCount = $this->findApprochMelkCountByBongah($bongah->id);
        $result->melkscansend = $melkCount;
        if ($melkCount > 0) {
            $rate +=$melkCount > 0 ? 1 : 0;
            $messages[] = "شما " . "<b>" . $melkCount . "</b>" . " ملک متناسب با نیاز این متقاضی دارید";
        }

        // 0 : find located areas
        $unionAreas = $this->getUnionAreaNames($bongah);
        if (strlen($unionAreas) > 0) {
            $rate += 2;
            $messages[] = "متقاضی به دنبال ملکی می باشد که در محدوده مشاور املاک شما است" . " : <b>" . $unionAreas . "</b>";
        }


        // 2 : user request date is lower than 30 day
        $rate += $this->date > time() - (3600 * 24 * 30) ? 1 : 0;
        $messages[] = "از زمان درخواست ملک کمتر از یک ماه میگذرد";

        // 3 : user received less than 20 melk
        $result->totalMessageSent = BongahSentMelk::count(array("melkphonelistnerid = :melkphonelistnerid:", "bind" => array("melkphonelistnerid" => $this->id)));
        $rate += $result->totalMessageSent < 20 ? 1 : 0;
        $messages[] = "تعداد پیامک های دریافتی این شخص کمتر از 20 مورد است";

        // set rate
        $result->rate = $rate;



        $infos = array();
        foreach ($messages as $value) {
            $infos[] = "<li>$value</li>";
        }

        // set message
        $result->messages = implode("\n", $infos);

        return $result;
    }

    public function getStatusText() {
        return $this->status ? "فعال" : "غیر فعال";
    }

    /**
     * find union areas in bongah and melk area
     * @param Bongah $bongah
     * @return Boolean|Resultset when we find some items, we get result set, otherwise we get false
     */
    public function getUnionAreas($bongah) {
        $melkAreas = MelkPhoneListnerArea::find(array("melkphonelistnerid = :melkphonelistnerid:", "bind" => array("melkphonelistnerid" => $this->id)));
        if ($melkAreas->count() == 0) {
            return false;
        }

        // find bongah areas
        $bongahSupportedAreas = explode(",", $bongah->locationscansupport);
        if (count($bongahSupportedAreas) == 0) {
            return false;
        }


        $unionIDs = array();
        // find union area
        foreach ($melkAreas as $melkArea) {
            foreach ($bongahSupportedAreas as $bongahArea) {
                if (intval($melkArea->areaid) == intval($bongahArea)) {
                    $unionIDs[] = intval($bongahArea);
                }
            }
        }

        // check if we have any union item
        if (count($unionIDs) > 0) {
            return Area::find("id IN (" . implode(",", $unionIDs) . ")");
        } else {
            // we do not have any union items
            return false;
        }
    }

    /**
     * 
     * @param Bongah $bongah
     * @return string
     */
    public function getUnionAreaNames($bongah) {
        $items = $this->getUnionAreas($bongah);
        if ($items) {
            $k = array();
            foreach ($items as $v) {
                $k[] = $v->name;
            }
            return implode(", ", $k);
        } else {

            return "";
        }
    }

    /**
     * get invlisible phone number 0917XXXXX18
     * @return string
     */
    public function getSimplePhoneNumber() {
        return substr($this->getPhoneNumber(), 0, 4) . "XXXXX" . substr($this->getPhoneNumber(), 9);
    }

    public function getReview() {
        $result = "";
        $result.= "نیازمند " . $this->getTypeTitle() . " جهت" . " " . $this->getPurposeTitle();

        // check if user requested special place
        $areaNames = $this->getAreasNames(false);
        if (count($areaNames) > 0) {

            // check if user want one place
            if (count($areaNames) == 1) {
                $result.= " در" . " " . $areaNames[0];
            } else {
                $result.= " واقع در مناطق" . " " . implode(", ", $areaNames);
            }
        }

        return $result;
    }

}
