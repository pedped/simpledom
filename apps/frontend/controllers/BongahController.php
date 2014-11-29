<?php

namespace Simpledom\Frontend\Controllers;

use Area;
use AtaPaginator;
use Bongah;
use BongahSentMelk;
use BongahSentMessage;
use BongahSubscribeItem;
use City;
use CreateBongahForm;
use CreateMelkForm;
use Melk;
use MelkArea;
use MelkImage;
use MelkInfo;
use MelkPhoneListner;
use SendBongahSmsForm;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\Classes\Helper;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use SMSCredit;
use SMSManager;
use SmsNumber;
use UserPhone;

class BongahController extends ControllerBase {

    private $subscriptionText;

    /**
     *
     * @var Bongah 
     */
    private $bongah;

    public function initialize() {
        parent::initialize();

        if (!isset($this->user)) {

            $this->flash->notice("عضویت بنگاه داران رایگان میباشد، در صورتی که قبلا در سایت" . "<a href='user/register'>" . _(" ثبت نام") . "</a>" . " نموده اید مشخصات ورود خود را وارد نمایید، در غیر این صورت ابتدا در سایت " . "<a href='user/register'>" . _(" ثبت نام") . "</a>" . " نمایید.");
            $this->dispatcher->forward(array(
                "controller" => "bongah",
                "action" => "review",
                "params" => array()
            ));
            return;
        }

        // get bongah id
        $bongahID = $this->dispatcher->getParam("bongahid");
        if (!$bongahID) {
            $this->bongah = Bongah::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)));
            if (!$this->bongah) {
                // user do not have any bongah, redirect him to create page
                $this->dispatcher->forward(array(
                    "controller" => "bongah",
                    "action" => "add",
                    "params" => array()
                ));
                return;
            }
            $bongahID = $this->bongah->id;
        } else {
            $this->bongah = Bongah::findFirst(array("id = :id:", "bind" => array("id" => $bongahID)));
            if (!$this->bongah || intval($this->bongah->userid) != intval($this->user->userid)) {
                $this->show404();
                return;
            }
        }

        // bongah found
        if ($this->dispatcher->getActionName() != "waitforapprove") {
            if (intval($this->bongah->enable) == -1) {
                Helper::RedirectToURL("bongah/$bongahID/waitforapprove");
                return;
            } else if (intval($this->bongah->enable) == 0) {
                $this->show404();
                return;
            }
        }

        // fetch user subscription
        $publicUrl = Config::getPublicUrl();
        if (intval($this->bongah->bongahsubscribeitemid) == 0) {
            $this->view->subscriptionText = "<a class='current-subscription-plan' href='$publicUrl/bongahsubscribe/plans'><b style='color:#e30'>رایگان</b></a>";
        } else {
            $subscriptionTitle = BongahSubscribeItem::findFirst($this->bongah->bongahsubscribeitemid)->name;
            $this->view->subscriptionText = "<a class='current-subscription-plan' href='$publicUrl/bongahsubscribe/plans'><span style='color:#EE22BD'>" . $subscriptionTitle . "</span></a>";
        }

        // load sms credit
        $this->view->currentSMSCredit = $this->user->getSMSCredit();

        // load bongah
        $this->view->currentBongah = $this->bongah;
    }

    public function reviewAction() {
        
    }

    public function waitforapproveAction() {
        $this->setPageTitle("در انتظار تایید");
    }

    public function addmelkAction() {

        $this->setPageTitle("افزودن ملک");

        // show cities to view
        $this->view->cities = City::find();

        $fr = new CreateMelkForm();
        $fr->remove("fname");
        $fr->remove("lname");
        $fr->remove("email");
        $this->handleFormScripts($fr);

        if ($this->request->isPost()) {

            //var_dump($_POST);
            if ($fr->isValid($_POST)) {

                // get correcrt phone number
                $phone = Helper::getCorrectIraninanMobilePhoneNumber($this->request->getPost('private_mobile', "string"));
                if (!$phone) {
                    $this->errors[] = "شماره موبایل وارد شده نامعتبر میباشد";
                }

                // check if we have any error
                if (!$this->hasError()) {

                    // form is valid
                    $melk = new Melk();
                    $melk->userid = $this->user->userid;
                    $melk->melktypeid = $this->request->getPost('melktypeid', 'string');
                    $melk->melkpurposeid = $this->request->getPost('melkpurposeid', 'string');
                    $melk->melkconditionid = $this->request->getPost('melkconditionid', 'string');
                    $melk->home_size = $this->request->getPost('home_size', 'string');
                    $melk->lot_size = $this->request->getPost('lot_size', 'string');
                    $melk->sale_price = $this->request->getPost('sale_price', 'string');
                    $melk->rent_price = $this->request->getPost('rent_price', 'string');
                    $melk->rent_pricerahn = $this->request->getPost('rent_pricerahn', 'string');
                    $melk->bedroom = $this->request->getPost('bedroom', 'string');
                    $melk->bath = $this->request->getPost('bath', 'string');
                    $melk->stateid = $this->request->getPost('stateid', 'string');
                    $melk->cityid = $this->request->getPost('cityid', 'string');
                    $melk->createby = 1;
                    $melk->featured = 0;
                    $melk->approved = 1;
                    $melk->validdate = 3600 * 24 * 180;

                    if (!$melk->create()) {
                        $melk->showErrorMessages($this);
                    } else {

                        // we have to create melk info
                        $melkinfo = new MelkInfo();
                        $melkinfo->description = $this->request->getPost('description', 'string');
                        $melkinfo->address = $this->request->getPost('address', 'string');
                        $melkinfo->latitude = $this->request->getPost('map_latitude');
                        $melkinfo->longitude = $this->request->getPost('map_longitude');
                        $melkinfo->melkid = $melk->id;
                        $melkinfo->private_address = $this->request->getPost('private_address', "string");
                        $melkinfo->private_mobile = $phone;
                        $melkinfo->bongahid = $this->bongah->id;
                        $melkinfo->private_phone = $this->request->getPost('private_phone', "string");
                        $melkinfo->facilities = isset($_POST["facilities"]) && is_array($_POST["facilities"]) && count($_POST["facilities"]) > 0 ? implode(",", $_POST["facilities"]) : "";
                        if (!$melkinfo->create()) {
                            $melkinfo->showErrorMessages($this);
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

                            // forward location
                            $this->dispatcher->forward(array(
                                "controller" => "bongah",
                                "action" => "melks",
                                "bongahid" => $this->bongah->id,
                                "params" => array()
                            ));

                            // clear the title and message so the user can add better info
                            $fr->clear();
                        }
                    }
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        $this->view->form = $fr;
    }

    /**
     * 
     * @return SMSCredit
     */
    private function calcUserCredit() {
        // get user credit
        $smsCredit = SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)));
        if (!$smsCredit) {
            $this->view->hadSMSCredit = false;
        } else {
            $this->view->hadSMSCredit = true;
            $this->view->totalSMSCanSend = $smsCredit->value;
        }
        return $smsCredit;
    }

    public function smssentAction() {

        if ($this->request->isPost()) {

            $message = $this->request->getPost("message");
            $areas = $this->request->getPost("areas");
            $toalluser = intval($this->request->getPost("toalluser")) == 1;
            $tophonelistner = intval($this->request->getPost("tophonelistner")) == 1;


            // define phone numbers have to send
            $toPhones = array();

            // calc total sms count
            $isPersian = false;
            $totalSMSCount = $this->getMessageSize($message, $isPersian);
            $totalCalculatedCount = $isPersian ? $totalSMSCount : $totalSMSCount * 2; // becasue english messages has two time cost
            $this->view->messageSize = $totalCalculatedCount;
            $totalUsersSMSCount = 0;
            $areaIDs = Area::GetMultiID($this->bongah->cityid, $areas);


            $melkPhoneListners = null;
            $melks = null;

            // check total sms that have to be sent
            if ($tophonelistner) {

                // find best users
                $melkPhoneListners = MelkPhoneListner::findBestItems($areaIDs);
                $count = $melkPhoneListners->count();
                $totalUsersSMSCount += $count;
            }
            if ($toalluser) {
                // find best users
                $melks = Melk::findAreaLocatedMelks($areaIDs, true);
                $count = $melks->count();
                $totalUsersSMSCount += $count;
            }


            $totalCreditNeed = $totalUsersSMSCount * $totalCalculatedCount;
            $smsCredit = \SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)));
            if ($smsCredit->value < $totalCreditNeed) {
                $this->errors[] = "اعتبار پیامکی شما برای ارسال پیام کافی نمیباشد. لطفا اعتبار خود را افزایش دهید";
            }


            // user have enogh cost, decrese credit
            SMSCredit::decreaseCredit($this->errors, $this->user->userid, "-2", $totalCreditNeed);

            // check if we have no error, send messages
            if (!$this->hasError()) {

                if ($tophonelistner) {

                    // clear phone stack
                    $toPhones = array();

                    // get phone numbers
                    foreach ($melkPhoneListners as $melkPhoneListner) {
                        $number = $melkPhoneListner->getPhoneNumber();
                        if (isset($number) && strlen($number) > 0) {
                            $toPhones[] = $number;
                        }
                    }

                    // send message
                    SMSManager::SendSMS($toPhones, $message, SmsNumber::findFirst());

                    // store sent messages
                    foreach ($melkPhoneListners as $melkPhoneListner) {
                        $b = new BongahSentMessage();
                        $b->bongahid = $this->bongah->id;
                        $b->bongahphone = $this->bongah->phone;
                        $b->bongahtitle = $this->bongah->title;
                        $b->message = $message;
                        $b->smsmessageid = 1;
                        $b->distance = 0;
                        $b->tophone = $melkPhoneListner->getPhoneNumber();
                        $b->type = 1;
                        if (!$b->create()) {
                            $this->LogError("Unable to store bongah sent message", $b->getMessagesAsLines());
                        }
                    }
                }


                if ($toalluser) {

                    // clear phone stack
                    $toPhones = array();

                    // get phone numbers
                    foreach ($melks as $melk) {
                        $number = $melk->getInfo()->private_mobile;
                        if (isset($number) && strlen($number) > 0) {
                            $toPhones[] = $number;
                        }
                    }

                    // send message
                    SMSManager::SendSMS($toPhones, $message, SmsNumber::findFirst());

                    // store sent messages
                    foreach ($melks as $melk) {
                        $b = new BongahSentMessage();
                        $b->bongahid = $this->bongah->id;
                        $b->bongahphone = $this->bongah->phone;
                        $b->bongahtitle = $this->bongah->title;
                        $b->message = $message;
                        $b->smsmessageid = 1;
                        $b->distance = $melk->getDistanceFromLocation($this->bongah->latitude, $this->bongah->longitude);
                        $b->tophone = $melk->getInfo()->private_mobile;
                        $b->type = 2;
                        if (!$b->create()) {
                            $this->LogError("Unable to store bongah sent message", $b->getMessagesAsLines());
                        }
                    }
                }
                $this->flash->success("پیام شما با موفقیت ارسال گردید");
            }
        } else {
            $this->response->redirect("bongah/sendsms");
        }
    }

    public function sendsmsAction() {

        $this->setPageTitle("ارسال پیامک");

        // calc sms credit
        $this->calcUserCredit();

        $fr = new SendBongahSmsForm();

        // set default areas
        $fr->get("area")->setDefault(implode(",", $this->bongah->getSupporrtedLocationsName()));
        $fr->get("area")->setCityID($this->bongah->cityid);


        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid form
            } else {
                // valid
                $area = $this->request->getPost("area", "string");
                $message = $this->request->getPost("message", "string");
                $sendtophonelistners = $this->request->getPost("sendtolistners");
                $sendtomelkusers = $this->request->getPost("sendtomelkusers");

                $this->dispatcher->forward(array(
                    "controller" => "bongah",
                    "action" => "checksms",
                    "params" => array(
                        $area, $message, $sendtophonelistners, $sendtomelkusers
                    )
                ));
            }
        }

        $this->handleFormScripts($fr);
        $this->view->form = $fr;
    }

    public function checksmsAction($areas, $text, $tolistners = true, $tousers = true) {

        // calc total sms count
        $totalSMSCount = $this->getMessageSize($text, $isPersian);
        $totalCalculatedCount = $isPersian ? $totalSMSCount : $totalSMSCount * 2; // becasue english messages has two time cost
        $this->view->messageSize = $totalCalculatedCount;
        $totalUsersSMSCount = 0;


        // set view variables
        $areaIDs = Area::GetMultiID($this->bongah->cityid, $areas);
        $this->view->areas = explode(",", $areas);
        $this->view->message = $text;
        $this->view->toPhoneListners = $tolistners;
        if ($tolistners) {
            $count = MelkPhoneListner::findBestItems($areaIDs)->count();
            $totalUsersSMSCount += $count;
            $this->view->phoneListnerCount = $totalUsersSMSCount;
        }

        $this->view->toAllUsers = $tousers;
        if ($tousers) {
            $count = Melk::findAreaLocatedMelks($areaIDs, true)->count();
            $totalUsersSMSCount += $count;
            $this->view->haveMelkCount = Melk::findAreaLocatedMelks($areaIDs, true)->count();
        }

        // show total sms count
        $this->view->totalSMSCount = $totalUsersSMSCount . "(کاربر) * " . $totalCalculatedCount . "(" . "سایز هر پیامک" . ") = <b>" . ($totalCalculatedCount * $totalUsersSMSCount) . " پیامک" . "</b>";
    }

    private function getMelkPaginator($page, $melks, $listpath) {
        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melks,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد ملک', 'نوع', 'منظور', 'وضعیت', 'متراژ', 'زیربنا', 'قیمت فروش', 'اجاره', 'رهن', 'اتاق خواب', 'حمام', 'شهر', 'ارائه شده توسط', 'تاریخ', 'مشاهده'
                ))->
                setFields(array(
                    'id', 'getTypeName()', 'getPurposeType()', 'getCondiationType()', 'getMetraj()', 'getZirbana()', 'getSalePrice()', 'getEjarePrice()', 'getRahnPrice()', 'bedroom', 'bath', 'getCityName()', 'getCreateByTilte()', 'getDate()', 'getViewButton()'
                ))->setListPath(
                $listpath);

        $this->view->list = $paginator->getPaginate();
    }

    public function getMelksList($page = 1, $query = "", $bindparams = array(), $order = 'id DESC', $listpath = "list") {
        // load the users
        $melks = Melk::find(
                        array($query,
                            "bind" => $bindparams,
                            'order' => $order
        ));

        $this->
                getMelkPaginator($page, $melks, $listpath);
    }

    public function indexAction($page = 1) {

        $bongahid = $this->bongah->id;
        $this->setPageTitle("لیست املاک");
        $this->getMelksList($page, "cityid = :cityid: AND approved = 1", array("cityid" => $this->bongah->cityid), 'id DESC', 'bongah' . "/" . $bongahid);
    }

    public function melksAction($page = 1) {

        $this->setPageTitle("لیست املاک شما");
        $this->getMelksList($page, "userid = :userid:", array("userid" => $this->user->userid), 'id DESC', 'bongah' . "/" . $this->bongah->id . "/melks");
    }

    public function melkcansupportAction($bongahID, $page = 1, $maxDistance = 10) {

        $this->setPageTitle("لیست املاک قابل پوشش");

        // find bongah location
        $bongah = Bongah::findFirst($bongahID);

        // find nearset melks
        $melks = Melk::getNearest($this->bongah->cityid, $bongah->latitude, $bongah->longitude, $maxDistance);

        // load paginate
        $this->getMelkPaginator($page, $melks, 'bongah' . "/" . $this->bongah->id . "/melkcansupport");
    }

    public function approchmelksAction($phonelistnerid) {

        // find phone listner
        $phonelistner = MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $phonelistnerid)));
        if (!$phonelistner) {
            $this->show404();
            return;
        }

        $this->view->phoneListner = $phonelistner;


        //
        // find user sent messages
        //
        $sentMelk = BongahSentMelk::find(array("bongahid = :bongahid: AND melkphonelistnerid = :melkphonelistnerid:", "bind" => array("bongahid" => $this->bongah->id, "melkphonelistnerid" => $phonelistnerid)));
        $sentMelkPaginator = new AtaPaginator(array(
            'data' => $sentMelk,
            'limit' => 1000,
            'page' => 1
        ));
        $sentMelkPaginator->
                setTableHeaders(array(
                    'کد', 'کد بنگاه', 'کد ملک', 'متن', 'شماره موبایل', 'تاریخ'
                ))->
                setFields(array(
                    'id', 'bongahid', 'melkid', 'message', 'getPhoneNumber()', 'getDate()'
                ))->setListPath(
                "");

        $this->view->sentmelklist = $sentMelkPaginator->getPaginate();


        // 
        // find ideal melks based on this phone listner
        //
        $melkPaginator = new AtaPaginator(array(
            'data' => $phonelistner->findApprochMelkByBongah(),
            'limit' => 100,
            'page' => 1
        ));
        $melkPaginator->
                setTableHeaders(array(
                    'کد ملک', 'نوع', 'منظور', 'وضعیت', 'متراژ', 'زیربنا', 'قیمت فروش', 'اجاره', 'رهن', 'اتاق خواب', 'حمام', 'شهر', 'ارائه شده توسط', 'تاریخ', 'مشاهده'
                ))->
                setFields(array(
                    'id', 'getTypeName()', 'getPurposeType()', 'getCondiationType()', 'getZirbana()', 'getMetraj()', 'getSalePrice()', 'getEjarePrice()', 'getRahnPrice()', 'bedroom', 'bath', 'getCityName()', 'getCreateByTilte()', 'getSimpleDate()', 'getViewButton()'
                ))->setListPath("");

        $this->view->melks = $melkPaginator->getPaginate();
    }

    public function sendmelktolistnerAction($melkid, $phonelistnerID) {



        // check for melk
        $melk = Melk::findFirst(array("id = :id:", "bind" => array("id" => $melkid)));
        $phonelistner = \MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $phonelistnerID)));

        if (!$melk || !$phonelistner) {
            // one thing is not exist
            $this->show404();
        }

        // check if the bongah have not sent this item before this melk listner
        $sentBefore = BongahSentMelk::count(array("melkphonelistnerid = :melkphonelistnerid: AND melkid = :melkid:", "bind" => array(
                        "melkid" => $melkid,
                        "melkphonelistnerid" => $phonelistnerID
            ))) > 0;
        if ($sentBefore) {
            // user 
            $this->flash->error("شما قبلا ملک شماره " . $melkid . " را به شماره " . $phonelistner->getPhoneNumber() . " ارسال نموده اید");
            // forward to user page
            $this->dispatcher->forward(array(
                "controller" => "bongah",
                "action" => "approchmelks",
                "bongahid" => $this->bongah->id,
                "params" => array(
                    $phonelistnerID
                )
            ));
            return;
        }


        // check for user credit
        if ($this->user->getSMSCredit() <= 0) {
            // user do not have enogh money to send message
            $this->flash->error("اعتبار شما برای ارسال پیام کافی نیست، لطفا ابتدا اعتبار خود را افزایش دهید");
            // forward to user page
            $this->dispatcher->forward(array(
                "controller" => "smscredit",
                "action" => "plans",
                "bongahid" => $this->bongah->id,
                "params" => array(
                    $phonelistnerID
                )
            ));
            return;
        }

        // create message
        $message = "متقاضی گرامی، ملک جدید مطابق با نیاز شما به بنگاه " . $this->bongah->title . " اضافه گردید";
        $message .= "\n";
        $message .= "\n";
        $message .= $melk->getQuickInfo();
        $message .="\n";
        $message .="\n";
        $message .= "با تشکر";
        $message .= $this->bongah->title;
        $message .="\n";
        $message .= $this->bongah->phone;

        // we have to send sms
        SMSManager::SendSMS($phonelistner->getPhoneNumber(), $message, \SmsNumber::findFirst()->id);

        // TODO find sms id and use for decrease credit
        // decraese user sms credit
        $isPersian = false;
        $messageSize = $this->getMessageSize($message, $isPersian);
        SMSCredit::decreaseCredit($this->errors, $this->user->id, 12, $isPersian ? $messageSize * 2 : $messageSize );

        // we have to create new sent message
        $bongahSentMessage = new BongahSentMelk();
        $bongahSentMessage->bongahid = $this->bongah->id;
        $bongahSentMessage->melkid = $melkid;
        $bongahSentMessage->melkphonelistnerid = $phonelistnerID;
        $bongahSentMessage->message = $message;
        $bongahSentMessage->create();

        // show success messgae
        $this->flash->success(nl2br("ملک شما با موفقیت ارسال گردید، متن ارسال شده به صورت زیر میباشد: \n<hr/><blockquote>" . $message . "</blockquote>"));


        // forward to user page
        $this->dispatcher->forward(array(
            "controller" => "bongah",
            "action" => "approchmelks",
            "bongahid" => $this->bongah->id,
            "params" => array(
                $phonelistnerID
            )
        ));
    }

    public function userscansupportAction($page = 1, $maxDistance = 10) {

        $this->setPageTitle("املاک درخواستی");

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "bind" => array(
                                "cityid" => $this->bongah->cityid
                            )
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkphonelistners,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', "مناطق درخواستی", 'منظور', 'نوع ملک', 'حداقل اتاق', 'حداکثر اتاق', 'حداقل اجاره', 'حداکثر اجاره', 'حداقل رهن', 'حداکثر رهن', 'حداقل قیمت', 'حداکثر قیمت', 'تاریخ', 'شهر', 'شماره تماس', 'پیامک های دریافتی', 'تعداد املاک متناسب شما'
                ))->
                setFields(array(
                    'id', 'getAreasNames()', 'getPurposeTitle()', 'getTypeTitle()', 'bedroom_start', 'bedroom_end', 'getRentPriceStartHuman()', 'getRentPriceEndHuman()', 'getRentPriceRahnStartHuman()', 'getRentPriceRahnEndHuman()', 'getSalePriceStartHuman()', 'getSalePriceEndHuman()', 'getDate()', 'getCityName()', 'getPhoneNumber()', 'getReceivedCount()', 'findApprochMelkCountByBongah()'
                ))->setListPath(
                'bongah/' . $this->bongah->id . "/userscansupport");

        $this->view->list = $paginator->getPaginate();
    }

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return intval($this->bongah->userid) == intval($this->user->userid);
    }

    public function addAction() {

        $this->setPageTitle("عضویت بنگاه");

        // load citties list
        $this->view->cities = City::find();

        // create form
        $fr = new CreateBongahForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongah = new Bongah();

                $bongah->userid = $this->user->userid;
                $bongah->title = $this->request->getPost('title', 'string');
                $bongah->peygiri = $this->request->getPost('peygiri', 'string');
                $bongah->fname = $this->request->getPost('fname', 'string');
                $bongah->lname = $this->request->getPost('lname', 'string');
                $bongah->address = $this->request->getPost('address', 'string');
                $bongah->cityid = $this->request->getPost('cityid', 'string');
                $bongah->latitude = $this->request->getPost('map_latitude');
                $bongah->longitude = $this->request->getPost('map_longitude');
                $areaIDs = Area::GetMultiID($bongah->cityid, $this->request->getPost('locationscansupport', 'string'));
                $bongah->locationscansupport = implode(',', $areaIDs);
                $bongah->mobile = $this->request->getPost('mobile', 'string');
                $bongah->phone = $this->request->getPost('phone', 'string');

                if (!$bongah->create()) {
                    $bongah->showErrorMessages($this);
                } else {
                    $bongah->showSuccessMessages($this, 'بنگاه با موفقیت اضافه گردید');

                    // clear the title and message so the user can add better info
                    $fr->clear();

                    $this->dispatcher->forward(array(
                        "controller" => "bongah",
                        "action" => "index",
                        "params" => array(
                            "bongahid" => $bongah->id
                        )
                    ));


                    // send sms about add
                    SMSManager::SendSMS($bongah->mobile, "بنگاه دار گرامی، مشخصات شما برای بررسی به مسئولان سایت ارسال گردید، همکاران ما به زودی با شما تماس خواهند گرفت", SmsNumber::findFirst()->id);
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }



        $this->view->form = $fr;
    }

    public function settingsAction($id) {

        $bongah = Bongah::findFirst($id);
        $this->view->cities = City::find();

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setPageTitle('تنظیمات بنگاه');

        $fr = new CreateBongahForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                //  var_dump($_POST);
                // form is valid
                $bongah->userid = $this->user->userid;
                $bongah->title = $this->request->getPost('title', 'string');
                $bongah->peygiri = $this->request->getPost('peygiri', 'string');
                $bongah->fname = $this->request->getPost('fname', 'string');
                $bongah->lname = $this->request->getPost('lname', 'string');
                $bongah->address = $this->request->getPost('address', 'string');
                $bongah->cityid = $this->request->getPost('cityid', 'string');
                $bongah->latitude = $this->request->getPost('map_latitude');
                $bongah->longitude = $this->request->getPost('map_longitude');
                $areaIDs = Area::GetMultiID($bongah->cityid, $this->request->getPost('locationscansupport', 'string'));
                $bongah->locationscansupport = implode(',', $areaIDs);
                $bongah->mobile = $this->request->getPost('mobile', 'string');
                $bongah->phone = $this->request->getPost('phone', 'string');

                if (!$bongah->save()) {
                    $bongah->showErrorMessages($this);
                } else {
                    $bongah->showSuccessMessages($this, 'بنگاه با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        // set default values
        $fr->get('title')->setDefault($bongah->title);
        $fr->get('peygiri')->setDefault($bongah->peygiri);
        $fr->get('fname')->setDefault($bongah->fname);
        $fr->get('lname')->setDefault($bongah->lname);
        $fr->get('address')->setDefault($bongah->address);
        $fr->get('cityid')->setDefault($bongah->cityid);
        $fr->get('map')->setLathitude($bongah->latitude);
        $fr->get('map')->setLongtude($bongah->longitude);
        $fr->get('locationscansupport')->setDefault(implode(",", $bongah->getSupporrtedLocationsName()));
        $fr->get('mobile')->setDefault($bongah->mobile);
        $fr->get('phone')->setDefault($bongah->phone);


        $this->view->form = $fr;
    }

    public function iranlistAction($cityid = null, $page = 1) {
        
    }

    public function getMessageSize($text, &$isPersian) {

        $alhphabets = array();
        $alhphabets[] = "آ";
        $alhphabets[] = "ا";
        $alhphabets[] = "ب";
        $alhphabets[] = "پ";
        $alhphabets[] = "ت";
        $alhphabets[] = "ث";
        $alhphabets[] = "ج";
        $alhphabets[] = "چ";
        $alhphabets[] = "ه";
        $alhphabets[] = "خ";
        $alhphabets[] = "د";
        $alhphabets[] = "ذ";
        $alhphabets[] = "ر";
        $alhphabets[] = "ز";
        $alhphabets[] = "ژ";
        $alhphabets[] = "س";
        $alhphabets[] = "ش";
        $alhphabets[] = "ص";
        $alhphabets[] = "ض";
        $alhphabets[] = "ط";
        $alhphabets[] = "ظ";
        $alhphabets[] = "ع";
        $alhphabets[] = "غ";
        $alhphabets[] = "ف";
        $alhphabets[] = "ق";
        $alhphabets[] = "ک";
        $alhphabets[] = "گ";
        $alhphabets[] = "ل";
        $alhphabets[] = "م";
        $alhphabets[] = "ن";
        $alhphabets[] = "و";
        $alhphabets[] = "ه";
        $alhphabets[] = "ی";

        $isPersian = false;
        foreach ($alhphabets as $alpha) {
            if (strpos($alpha, $text) >= 0) {
                $isPersian = true;
                break;
            }
        }

        if ($isPersian) {
            return ((int) (mb_strlen($text) / 70) ) + 1;
        } else {
            return ((int) (mb_strlen($text) / 140) ) + 1;
        }
    }

}
