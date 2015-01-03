<?php

namespace Simpledom\Api\Controllers;

use Area;
use Bongah;
use City;
use Melk;
use MelkArea;
use MelkImage;
use MelkInfo;
use MelkPhoneListner;
use MelkPurpose;
use MelkType;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\Classes\Helper;
use SMSCreditCost;
use State;
use stdClass;
use UserPhone;

class BongahController extends ControllerBase {

    /**
     *
     * @var Bongah 
     */
    private $bongah;

    public function initialize() {
        parent::initialize();

        if (!$this->user->isBongahDar()) {
            //return $this->getResponse("You are not bongah dar");
        }

        $this->bongah = $this->user->getFirstBongah();
    }

    public function getsmsplansAction() {

        $start = (int)$_POST["start"];
        
        // get plans
        $plans = SMSCreditCost::find(array(
            "limit" => "$start , 100"
        ));

        // load plans in array
        $items = array();
        foreach ($plans as $plan) {
            $items[] = $plan->getPublicResponse();
        }

        return $this->getResponse($items);
    }

    public function sendmelkinfomationAction() {

        $ids = $_POST["ids"];
        $melkid = (int) $_POST["melkid"];


        // parse ids
        $ids = explode(",", $ids);
        $itemIDs = array();
        foreach ($ids as $value) {
            $itemIDs[] = (int) $value;
        }

        // user want to send melk info
        foreach ($itemIDs as $phoneListnerID) {
            $this->bongah->sendMelkInfo($this->errors, $phoneListnerID, $melkid, $needToIncrease);
            if (count($this->errors) > 0) {
                // return false
                if ($needToIncrease) {
                    $this->errors = array();
                    $this->getResponse(-1);
                } else {
                    return $this->getResponse(false);
                }
            }
        }

        return $this->getResponse(1);
    }

    public function getphonesuggestionAction($melkid) {
        // check if the melk is belong to user
        $melk = Melk::findFirst(array("id = :id:", "bind" => array("id" => $melkid)));
        if (!$melk || intval($melk->approved) == -2) {
            $this->errors[] = "ملک مورد نظر یافت نگردید";
            return $this->getResponse(false);
        }

        // melk exist, we have to get phone suggestions
        $list = array();
        $melkPhoneListners = $melk->findApprochMelkPhoneListners();
        foreach ($melkPhoneListners as $melkPhoneListner) {
            $list[] = $melkPhoneListner->getMobileResponse($this->bongah);
        }
        return $this->getResponse($list);
    }

    /**
     * @mobile
     */
    public function addmelkAction() {

        // get correcrt phone number
        $phone = Helper::getCorrectIraninanMobilePhoneNumber($this->request->getPost('mobile', "string"));
        if (!$phone) {
            $this->errors[] = "شماره موبایل وارد شده نامعتبر می باشد";
        }

        // check if we have any error
        if (!$this->hasError()) {


            // get melk type and purpose
            $typeid = MelkType::findFirst(array("name = :name:", "bind" => array("name" => $this->request->getPost('type', 'string'))))->id;
            $porposeid = MelkPurpose::findFirst(array("name = :name:", "bind" => array("name" => $this->request->getPost('manzoor', 'string'))))->id;
            $stateid = State::findFirst(array("name = :name:", "bind" => array("name" => $this->request->getPost('state', 'string'))))->id;
            $cityid = City::findFirst(array("name = :name:", "bind" => array("name" => $this->request->getPost('city', 'string'))))->id;


            // form is valid
            $melk = new Melk();
            $melk->userid = $this->user->userid;
            $melk->melktypeid = $typeid;
            $melk->melkpurposeid = $porposeid;
            $melk->melkconditionid = $this->request->getPost('melkconditionid', 'string');
            $melk->home_size = $this->request->getPost('zirbana', 'string');
            $melk->lot_size = $this->request->getPost('metraj', 'string');
            $melk->sale_price = $this->request->getPost('saleprice', 'string');
            $melk->rent_price = $this->request->getPost('ejare', 'string');
            $melk->rent_pricerahn = $this->request->getPost('rahn', 'string');
            $melk->bedroom = $this->request->getPost('bedroom', 'string');
            $melk->bath = $this->request->getPost('bath', 'string');
            $melk->stateid = $stateid;
            $melk->cityid = $cityid;
            $melk->createby = 1;
            $melk->featured = 0;
            $melk->approved = 1;
            $melk->validdate = time() + 3600 * 24 * 180;

            if (!$melk->create()) {
                $melk->showErrorMessages($this);
            } else {


                //$this->AddUserLog("ملک جدید اضافه گردید");
                // we have to create melk info
                $melkinfo = new MelkInfo();
                $melkinfo->description = $this->request->getPost('description', 'string');
                $melkinfo->address = $this->request->getPost('blvd', 'string');
                $melkinfo->latitude = "0";
                $melkinfo->longitude = "0";
                $melkinfo->melkid = $melk->id;
                $melkinfo->private_address = $this->request->getPost('address', "string");
                $melkinfo->private_mobile = $phone;
                $melkinfo->bongahid = $this->bongah->id;
                $melkinfo->private_phone = $this->request->getPost('phone', "string");
                $melkinfo->facilities = isset($_POST["facilities"]) && is_array($_POST["facilities"]) && count($_POST["facilities"]) > 0 ? implode(",", $_POST["facilities"]) : "";
                if (!$melkinfo->create()) {
                    //$melkinfo->showErrorMessages($this);
                } else {

                    // save images
                    if ($this->request->hasFiles()) {
                        // valid request, load the files
                        foreach ($this->request->getUploadedFiles() as $file) {
                            $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                            if ($image) {
                                $melkImage = new MelkImage();
                                $melkImage->imageid = $image->id;
                                $melkImage->melkid = $melk->id;
                                $melkImage->create();
                            }
                        }
                    }

                    // create area if not exist
                    $areaid = Area::GetID($melk->cityid, $melkinfo->address);

                    // add melk area
                    $melkArea = new MelkArea();
                    $melkArea->areaid = $areaid;
                    $melkArea->byuserid = $this->user->userid;
                    $melkArea->cityid = $melk->cityid;
                    $melkArea->ip = $_SERVER["REMOTE_ADDR"];
                    $melkArea->melkid = $melk->id;
                    $melkArea->create();

                    // check if we have user phone
                    $userPhone = UserPhone::findFirst(array("phone = :phone:", "bind" => array("phone" => $phone)));
                    if (!$userPhone) {
                        // user phone is not exist
                        $userPhone = new UserPhone();
                        $userPhone->phone = $melkinfo->private_mobile;
                        $userPhone->userid = $this->user->userid;
                        if ($userPhone->create()) {
                            //$userPhone->sendVerificationNumber();
                            //$this->redirectToPhoneVerifyPage($melk->id, $userPhone->phone);
                        }
                    }


                    // success
                    $result = new stdClass();
                    $result->totallistner = $melk->findApprochMelkPhoneListners()->count();
                    $result->melkid = $melk->id;
                    return $this->getResponse($result);
                }
            }
        }

        // unsuccess
        return $this->getResponse(false);
    }

    /**
     * @mobile
     */
    public function sendmelkinfoAction() {


        $ids = $_POST["ids"];
        $phoneListnerID = (int) $_POST["phonelistnerid"];


        // parse ids
        $ids = explode(",", $ids);
        $itemIDs = array();
        foreach ($ids as $value) {
            $itemIDs[] = (int) $value;
        }


        // we have to send melk info
        $bongah = $this->user->getFirstBongah();
        foreach ($itemIDs as $melkID) {
            $bongah->sendMelkInfo($this->errors, $phoneListnerID, $melkID);
            if (count($this->errors) > 0) {
                // return false
                return $this->getResponse(false);
            }
        }

        // success, we have to send user last sms credit
        return $this->getResponse($this->user->getSMSCredit());
    }

    public function fetchmelkcanbesentAction($melkphonelistnerid) {

        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        // find phone listner
        $phonelistner = MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $melkphonelistnerid)));
        if (!$phonelistner) {
            $this->show404();
            return;
        }


        // find melks
        $melks = $phonelistner->findApprochMelk($this->user->getFirstBongah()->id);
        $items = array();
        foreach ($melks as $melk) {
            $items[] = $melk->getBongahResponse();
        }
        return $this->
                        getResponse($items);
    }

    /**
     * @mobile
     */
    public function getusercreditAction() {


        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        $result = new stdClass();
        $result->remaindays = $this->user->getFirstBongah()->getRemainingPlanDays();
        $result->smscredit = $this->user->getSMSCredit();
        $result->melks = $this->user->getFirstBongah()->getMelksCount();
        return $this->getResponse($result);
    }

    /**
     * @mobile
     * @return type
     */
    public function getnewrequestAction() {

        $lastSeenID = (int) $_POST["lastid"];

        //var_dump($this->user->fname);
        // check if the user is bonagh dar
        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        // get bongah
        $bongah = $this->user->getFirstBongah();

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'id > :id: AND cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "bind" => array(
                                "id" => $lastSeenID,
                                "cityid" => $bongah->cityid
                            )
        ));

        $items = array();
        foreach ($melkphonelistners as $value) {
            $items[] = $value->getMobileResponse($bongah);
        }
        return $this->getResponse($items);
    }

    /**
     * @mobile
     * @return type
     */
    public function getmelkrequestAction() {

        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        //var_dump($this->user->fname);
        // check if the user is bonagh dar
        if (!$this->user->isBongahDar()) {
            // return $this->getResponse("You are not bongah dar");
        }

        // get bongah
        $bongah = $this->user->getFirstBongah();

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "limit" => $start . " , " . $limit,
                            "bind" => array(
                                "cityid" => $bongah->cityid
                            )
        ));

        $items = array();
        foreach ($melkphonelistners as $value) {
            $items[] = $value->getMobileResponse($bongah);
        }
        return $this->getResponse($items);
    }

    public function getmelksAction() {
        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        //var_dump($this->user->fname);
        // check if the user is bonagh dar
        if (!$this->user->isBongahDar()) {
            //return $this->getResponse("You are not bongah dar");
        }

        // get bongah
        $bongah = $this->user->getFirstBongah();

        // find all city
        $melks = Melk::find(
                        array(
                            'userid = :userid:',
                            'order' => 'id DESC',
                            "limit" => $start . " , " . $limit,
                            "bind" => array(
                                "userid" => $this->user->userid
                            )
        ));

        $items = array();
        foreach ($melks as $melk) {
            $items[] = $melk->getBongahResponse();
        }
        return $this->getResponse($items);
    }

}
