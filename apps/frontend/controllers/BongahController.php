<?php

namespace Simpledom\Frontend\Controllers;

use Area;
use AtaPaginator;
use BaseSystemLog;
use Bongah;
use BongahImage;
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
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use SendBongahSmsForm;
use Simpledom\Core\AtaForm;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\Classes\Helper;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use SMSCredit;
use SMSManager;
use SmsNumber;
use SystemLogType;
use TextElement;
use User;
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

//        // create user and password based on each user
//        $bongahs = BongahAmlakKeshvar::find(array("group" => "mobile"));
//        foreach ($bongahs as $bongah) {
//            $user = new User();
//            $user->email = $bongah->code;
//            $user->fname = "نامشخص";
//            $user->lname = "نامشخص";
//            $user->gender = 1;
//            $user->level = USERLEVEL_BONGAHDAR;
//            $pass = $user->generateRandomString(8);
//            $user->password = $pass;
//            if ($user->create()) {
//
//                // check if user phone is not exist
//                $userPhone = new UserPhone();
//                $userPhone->phone = $bongah->mobile;
//                $userPhone->userid = $user->userid;
//                $userPhone->create();
//
//                // save to database
//                $tempUser = new Tempuser();
//                $tempUser->bongahamlakid = $bongah->id;
//                $tempUser->userid = $user->userid;
//                $tempUser->password = $pass;
//                $tempUser->create();
//            }
//
//            //return;
//        }

        if (!isset($this->user)) {
            // check if we have to show review page
            if ($this->dispatcher->getActionName() == "home") {
                //$this->flash->notice("عضویت مشاوران املاک رایگان می باشد، در صورتی که قبلا در سایت" . "<a href='user/register'>" . _(" ثبت نام") . "</a>" . " نموده اید مشخصات ورود خود را وارد نمایید، در غیر این صورت ابتدا در سایت " . "<a href='user/register'>" . _(" ثبت نام") . "</a>" . " نمایید.");
                $this->dispatcher->forward(array(
                    "controller" => "bongah",
                    "action" => "review",
                    "params" => array()
                ));
            } else if ($this->dispatcher->getActionName() == "add") {
                // we have to show add page
                $this->dispatcher->forward(array(
                    "controller" => "bongah",
                    "action" => "add",
                    "params" => array()
                ));
            } else {
                $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "login",
                    "params" => array()
                ));
            }
            return;
        }

        // get bongah id
        $bParam = $this->dispatcher->getParam("bongahid");
        $bongahID = isset($bParam) ? $bParam : false;
        if (!$bongahID) {
            $this->bongah = Bongah::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)));
            if (!$this->bongah) {
                // set user level to normal
                $this->user->level = USERLEVEL_USER;
                $this->user->save();

                // user do not have any bongah, redirect him to create page
                $this->dispatcher->forward(array(
                    "controller" => "bongah",
                    "action" => "add",
                    "params" => array()
                ));
                return;
            }

            // check if bongah has valid date
            if (intval($this->bongah->getRemainingPlanDays()) < 0) {
                // bongah need to renew plans
                // show message
                $this->flash->error("مشاور املاک گرامی، مدت زمان سرویس شما پایان یافته است، لطفا یکی از پلان های زیر را خریداری نمایید");

                // forward
                $this->dispatcher->forward(array(
                    "controller" => "bongahsubscribe",
                    "action" => "plans",
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
                Helper::RedirectToURL("bongah/waitforapprove");
                return;
            } else if (intval($this->bongah->enable) == 0) {
                $this->show404();
                return;
            }
        }

        // fetch user subscription
        $publicUrl = Config::getPublicUrl();
        if (intval($this->bongah->bongahsubscribeitemid) == 0) {
            $this->view->subscriptionText = "<a class='current-subscription-plan' href='$publicUrl" . "bongahsubscribe/plans'><b style='color:#e30'>رایگان</b></a>";
        } else {
            $subscriptionTitle = BongahSubscribeItem::findFirst($this->bongah->bongahsubscribeitemid)->name;
            $this->view->subscriptionText = "<a class='current-subscription-plan' href='$publicUrl" . "bongahsubscribe/plans'><span style='color:#EE22BD'>" . $subscriptionTitle . "</span></a>";
        }

        // load sms credit
        $this->view->currentSMSCredit = $this->user->getSMSCredit();

        // load bongah
        $this->view->currentBongah = $this->bongah;
    }

    public function homeAction() {

        if (intval($this->bongah->visitedtutorial) == 0) {
            // user need to visit tourial page
            $this->dispatcher->forward(array(
                "controller" => "bongah",
                "action" => "tutorial",
                "bongahid" => $this->bongah->id,
                "params" => array()
            ));
        } else {
            // user need to visit melks page
            $this->dispatcher->forward(array(
                "controller" => "bongah",
                "action" => "melks",
                "bongahid" => $this->bongah->id,
                "params" => array()
            ));
        }
    }

    public function reviewAction() {
        $this->setPageTitle("ویژگی پنل مشاوران املاک");

        $fr = new AtaForm();

        // Mobile
        $private_mobile = new TextElement('phonenumber');
        $private_mobile->setAttribute('placeholder', 'شماره موبایل');
        $private_mobile->setAttribute('class', 'form-control input-lg');
        $private_mobile->setAttribute('style', 'text-align:center');
        $private_mobile->setAttribute('required', 'required');
        $private_mobile->addValidator(new PresenceOf(array(
        )));
        $fr->add($private_mobile);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary btn-lg');
        $fr->add($submit);

        if ($this->request->isPost() && $fr->isValid($_POST)) {
            $phone = $this->request->getPost("phonenumber");
            $this->LogInfo("New Bongah Request", "new request for phone : " . $phone);
            SMSManager::SendSMS("09399477290", "want to signup as bongah: " . $phone, SmsNumber::findFirst()->id);
//            $this->flash->success("شماره تماس شما با موفقیت ارسال گردید، همکاران ما به زودی با شما تماس خواهند گرفت");
//            $fr->clear();
            // forward to add page
            Helper::RedirectToURL("http://amlak.edspace.org/bongah/add");
            die();
        }

        // show form
        $this->view->form = $fr;
    }

    public function waitforapproveAction() {
        $this->setPageTitle("در انتظار تایید");
    }

    public function tutorialAction() {

        $this->AddUserLog("مشاهده صفحه آموزش");

        // user visited home page
        if ($this->request->isPost()) {
            $this->bongah->visitedtutorial = 1;
            $this->bongah->save();

            // forward to melks page
            $this->dispatcher->forward(array(
                "controller" => "bongah",
                "action" => "melks",
                "bongahid" => $this->bongah->id,
                "params" => array()
            ));
        }


        $this->setPageTitle("راهنمای استفاده");
    }

    public function addmelkAction() {

        $this->AddUserLog("مشاهده صفحه افزودن ملک");

        $this->setPageTitle("افزودن ملک");

        // show cities to view
        $this->view->cities = City::find();

        $fr = new CreateMelkForm();
        $fr->remove("fname");
        $fr->remove("lname");
        $fr->remove("email");
        $this->handleFormScripts($fr);

        if ($this->request->isPost()) {

            $this->AddUserLog("تلاش برای اضافه کردن ملک جدید");

            //var_dump($_POST);
            if ($fr->isValid($_POST)) {

                // get correcrt phone number
                $phone = Helper::getCorrectIraninanMobilePhoneNumber($this->request->getPost('private_mobile', "string"));
                if (!$phone) {
                    $this->errors[] = "شماره موبایل وارد شده نامعتبر می باشد";
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


                        $this->AddUserLog("ملک جدید اضافه گردید");

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


                            // check total number of users who need this melk
                            if ($melk->findApprochMelkPhoneListners()->count() > 0) {

                                // we have some phone suggestion
                                $this->dispatcher->forward(array(
                                    "controller" => "bongah",
                                    "action" => "suggestphone",
                                    "bongahid" => $this->bongah->id,
                                    "params" => array(
                                        $melk->id
                                    )
                                ));
                            } else {
                                // we do not have any phone lsitner who need this melk
                                $this->dispatcher->forward(array(
                                    "controller" => "bongah",
                                    "action" => "melks",
                                    "bongahid" => $this->bongah->id,
                                    "params" => array()
                                ));
                            }

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

        if (count($this->errors) > 0) {
            $this->flash->error(implode("<br/>", $this->errors));
            $this->AddUserLog("خطا در اضافه کردن ملک : " . implode("<br/>", $this->errors));
        }
        $this->view->form = $fr;
    }

    /**
     * 
     * @return SMSCredit
     */
    private function calcUserCredit() {
        // get user credit
        $smsCredit = $this->user->getSMSCredit();
        if (!$smsCredit) {
            $this->view->hadSMSCredit = false;
            $this->view->totalSMSCanSend = 0;
        } else {
            $this->view->hadSMSCredit = true;
            $this->view->totalSMSCanSend = $smsCredit;
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
                $this->errors[] = "اعتبار پیامکی شما برای ارسال پیام کافی نمی باشد. لطفا اعتبار خود را افزایش دهید";
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

        $this->AddUserLog("مشاهده صفحه ارسال پیامک");
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



        // set text
        $text.="\n=====\n" . "ارسال شده از طرف مشاور املاک " . $this->bongah->title . " توسط سامانه املاک گستر" . "\n" . $this->bongah->phone;

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

    public function allmelksAction($page = 1) {

        $bongahid = $this->bongah->id;
        $this->setPageTitle("لیست املاک");
        $this->getMelksList($page, "cityid = :cityid: AND approved = 1", array("cityid" => $this->bongah->cityid), 'id DESC', 'bongah' . "/" . $bongahid);
    }

    public function suggestphoneAction($melkid) {

        $this->AddUserLog("مشاهده صفحه املاک پیشنهادی برای ملک شماره" . $melkid);

        // check if melk exist
        $melk = Melk::findFirst(array("id = :id:", "bind" => array("id" => $melkid)));
        if (!$melk) {
            // invalid request
            $this->show404();
            return;
        }

        // check if melk is for bongah
        if ($melk->getInfo()->bongahid != $this->bongah->id) {
            // invalid request
            $this->show404();
            return;
        }

        // find ideal melk phone listners
        $melkPhoneListners = $melk->findApprochMelkPhoneListners();

        // check if user want to send melk info
        if ($this->request->isPost()) {

            $this->AddUserLog("ارسال ملک به افراد پیشنهادی");

            // user want to send melk info
            foreach ($melkPhoneListners as $melkPhoneListner) {
                $this->sendMelkInfoToPhone($melkPhoneListner, $melk, FALSE);
            }

            // show success message
            $this->flash->success("اطلاعات ملک شما با موفقیت برای " . count($melkPhoneListners) . " نفر ارسال گردید");
        }


        //
        // find user sent messages
        //
        $sentMelk = BongahSentMelk::find(array("bongahid = :bongahid: AND melkid = :melkid:", "bind" => array("melkid" => $melk->id, "bongahid" => $this->bongah->id)));
        $sentMelkPaginator = new AtaPaginator(array(
            'data' => $sentMelk,
            'limit' => 1000,
            'page' => 1
        ));
        $sentMelkPaginator->
                setTableHeaders(array(
                    'کد', 'کد مشاور املاک', 'کد ملک', 'متن', 'شماره موبایل', 'تاریخ'
                ))->
                setFields(array(
                    'id', 'bongahid', 'melkid', 'message', 'getPhoneNumber()', 'getDate()'
                ))->setListPath(
                "");

        $this->view->sentmelklist = $sentMelkPaginator->getPaginate();


        //
        // Find Phone Listners
        //
        

        // create paginator
        $melkPhoneListnerPaginator = new AtaPaginator(array(
            'data' => $melkPhoneListners,
            'limit' => 1000,
            'page' => 1
        ));


        $melkPhoneListnerPaginator->
                setTableHeaders(array(
                    'کد', "مناطق درخواستی", 'منظور', 'نوع ملک', 'حداقل اتاق', 'حداکثر اتاق', 'حداقل اجاره', 'حداکثر اجاره', 'حداقل رهن', 'حداکثر رهن', 'حداقل قیمت', 'حداکثر قیمت', 'تاریخ', 'شهر', 'شماره تماس', 'پیامک های دریافتی', 'تعداد املاک متناسب شما'
                ))->
                setFields(array(
                    'id', 'getAreasNames()', 'getPurposeTitle()', 'getTypeTitle()', 'bedroom_start', 'bedroom_end', 'getRentPriceStartHuman()', 'getRentPriceEndHuman()', 'getRentPriceRahnStartHuman()', 'getRentPriceRahnEndHuman()', 'getSalePriceStartHuman()', 'getSalePriceEndHuman()', 'getDate()', 'getCityName()', 'getPhoneNumber()', 'getReceivedCount()', 'findApprochMelkCountByBongah()'
                ))->setListPath(
                'bongah/userscansupport');

        $this->view->melkPhoneListners = $melkPhoneListnerPaginator->getPaginate();
    }

    public function melksAction($page = 1) {
        $this->setPageTitle("لیست املاک شما");
        $this->AddUserLog("مشاهده لیست املاک");

        $this->view->totalMelks = $this->bongah->getTotalMelks();
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

        $this->AddUserLog("مشاهده لیست املاک موجود برای یک ملک درخواستی");

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
                    'کد', 'کد مشاور املاک', 'کد ملک', 'متن', 'شماره موبایل', 'تاریخ'
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

        $this->AddUserLog("تلاش برای ارسال ملک به درخواست کننده ملک");

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

        // send melk info
        $this->sendMelkInfoToPhone($phonelistner, $melk);




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

    private function sendMelkInfoToPhone($phonelistner, $melk, $showMessage = true) {
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
                )
            ));
            return false;
        }

        // create message
        $message = "متقاضی گرامی، ملک جدید مطابق با نیاز شما به مشاور املاک " . $this->bongah->title . " اضافه گردید";
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
        $bongahSentMessage->melkid = $melk->id;
        $bongahSentMessage->melkphonelistnerid = $phonelistner->id;
        $bongahSentMessage->message = $message;
        $bongahSentMessage->create();

        // show success messgae
        if ($showMessage) {
            $this->AddUserLog("ملک برای درخواست کننده ملک ارسال گردید");
            $this->flash->success(nl2br("ملک شما با موفقیت ارسال گردید، متن ارسال شده به صورت زیر می باشد: \n<hr/><blockquote>" . $message . "</blockquote>"));
        }
        return true;
    }

    public function userscansupportAction($currentPage = 1, $maxDistance = 10) {

        $this->setPageTitle("املاک درخواستی");

        $this->AddUserLog("مشاهده املاک درخواستی");

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "bind" => array(
                                "cityid" => $this->bongah->cityid
                            )
        ));

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melkphonelistners,
            'limit' => 10,
            'page' => $currentPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', "مناطق درخواستی", 'منظور', 'نوع ملک', 'حداقل اتاق', 'حداکثر اتاق', 'حداقل اجاره', 'حداکثر اجاره', 'حداقل رهن', 'حداکثر رهن', 'حداقل قیمت', 'حداکثر قیمت', 'تاریخ', 'شهر', 'شماره تماس', 'پیامک های دریافتی', 'تعداد املاک متناسب شما'
                ))->
                setFields(array(
                    'id', 'getAreasNames()', 'getPurposeTitle()', 'getTypeTitle()', 'bedroom_start', 'bedroom_end', 'getRentPriceStartHuman()', 'getRentPriceEndHuman()', 'getRentPriceRahnStartHuman()', 'getRentPriceRahnEndHuman()', 'getSalePriceStartHuman()', 'getSalePriceEndHuman()', 'getDate()', 'getCityName()', 'getPhoneNumber()', 'getReceivedCount()', 'findApprochMelkCountByBongah()'
                ))->setListPath(
                "bongah/userscansupport");

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

        $this->setPageTitle("عضویت مشاور املاک");

        // load citties list
        $this->view->cities = City::find();

        // create form
        $fr = new CreateBongahForm();

        $this->handleFormScripts($fr);


        // check if user is not logged in, set the reuqired for email and password
        if (!isset($this->user)) {
            $fr->get("email")->addValidator(new PresenceOf(array(
            )));
            $fr->get("password")->addValidator(new PresenceOf(array(
            )));
        } else {
            $fr->remove("email");
            $fr->remove("password");
        }
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {

                $needToVerify = false;
                // we have to check if the user is logged in
                if (!isset($this->user)) {
                    // we need to create an account for the user
                    $this->user = new User();
                    $fname = $this->request->getPost("fname");
                    $lname = $this->request->getPost("lname");
                    $email = $this->request->getPost("email", "email");
                    $password = $this->request->getPost("password");
                    $mobile = $this->request->getPost("mobile");
                    $result = $this->user->registerAccount($this, $this->errors, $fname, $lname, 1, $email, $password, USERLEVEL_USER, $mobile);
                    if (!$this->hasError() && $result == true) {
                        // user successfully created 
                        $this->user->setSession($this);
                        $needToVerify = true;
                    }
                }

                if (!$this->hasError()) {
                    // form is valid
                    $bongah = new Bongah();
                    $bongah->userid = $this->user->userid;
                    $bongah->title = $this->request->getPost('title', 'string');
//                    $bongah->peygiri = $this->request->getPost('peygiri', 'string');
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

                    // valid bongah for 30 days
                    $bongah->planvaliddate = (3600 * 24 * Config::GetBongahFreeDate() + 3600) + time();



                    if (!$bongah->create()) {
                        $bongah->showErrorMessages($this);
                    } else {

                        $this->user->level = USERLEVEL_BONGAHDAR;
                        $this->user->save();

                        // save images
                        if ($this->request->hasFiles()) {
                            // valid request, load the files
                            foreach ($this->request->getUploadedFiles() as $file) {
                                $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                                if ($image) {
                                    $melkImage = new BongahImage();
                                    $melkImage->imageid = $image->id;
                                    $melkImage->bongahid = $bongah->id;
                                    $melkImage->create();
                                }
                            }
                        }

                        // add sms credit for the user
                        // increase user credit
                        if (SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)))) {
                            $item = SMSCredit::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)));
                            $item->value += Config::GetDefaultSMSCreditOnBongahSignUp();
                            $item->save();
                        } else {
                            // we have to create new item
                            $smscredit = new SMSCredit();
                            $smscredit->value = Config::GetDefaultSMSCreditOnBongahSignUp();
                            $smscredit->userid = $this->user->userid;
                            $smscredit->create();
                        }


                        $bongah->showSuccessMessages($this, 'مشاور املاک با موفقیت اضافه گردید');

                        // clear the title and message so the user can add better info
                        $fr->clear();

                        if ($needToVerify) {
                            // user need to verify phone number
                            $this->dispatcher->forward(array(
                                "controller" => "phone",
                                "action" => "verify",
                                "params" => array(
                                    $bongah->mobile
                                )
                            ));
                        } else {
                            // user do not need to verify phone, he can visit home page
                            $this->dispatcher->forward(array(
                                "controller" => "bongah",
                                "action" => "home",
                                "bongahid" => $bongah->id,
                                "params" => array(
                                    "bongahid" => $bongah->id
                                )
                            ));
                        }


                        // send sms about add
                        SMSManager::SendSMS($bongah->mobile, "مشاور املاک گرامی، مشخصات شما برای بررسی به مسئولان سایت ارسال گردید، همکاران ما به زودی با شما تماس خواهند گرفت", SmsNumber::findFirst()->id);

                        // send sms to myself
                        SMSManager::SendSMS("09399477290", "بنگاه جدیدی به عضویت در سایت درآمد", SmsNumber::findFirst()->id);
                    }
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }


        if (count($this->errors) > 0) {
            $this->flash->error(implode("<br/>", $this->errors));
            BaseSystemLog::init($aaa)->setTitle("خطا در عضویت مشاور املاک برای شماره" . " " . $this->request->getPost('mobile', 'string'))->setType(SystemLogType::Debug)->setMessage(implode("\n", $this->errors))->setIP($_SERVER["REMOTE_ADDR"])->create();
        }

        $this->view->form = $fr;
    }

    public function settingsAction() {

        $this->AddUserLog("مشاهده تنظیمات");

        $bongah = $this->bongah;
        $this->view->cities = City::find();

        if (!$this->ValidateAccess($bongah->id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setPageTitle('تنظیمات مشاور املاک');

        $fr = new CreateBongahForm();
        $fr->remove("email");
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
                    $bongah->showSuccessMessages($this, 'مشاور املاک با موفقیت ذخیره گردید');
                    $this->AddUserLog("تغییر تنظیمات");
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
