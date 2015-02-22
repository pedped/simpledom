<?php

namespace Simpledom\Api\Controllers;

use Area;
use Bongah;
use BongahAction;
use BongahSubscribeItem;
use City;
use Melk;
use MelkArea;
use MelkImage;
use MelkInfo;
use MelkPhoneListner;
use MelkPurpose;
use MelkType;
use OneTimeToken;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\Classes\Helper;
use Simpledom\Core\Classes\Order;
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

    public function melkviewAction() {

        $melkid = (int) $_POST["melkid"];
        $fromcitylist = (int) $_POST["fromcitylist"];

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_VIEWMELK, "melkid: " . $melkid . "| From City List: " . $fromcitylist);
    }

    public function allmelksAction() {


        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];


        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, BongahAction::ACTION_LOADALLMELKS, "start: " . $start . "| end: " . $limit);


        // find all city
        $melks = Melk::find(
                        array(
                            'cityid = :cityid: AND status = 1 AND approved  = 1',
                            'order' => 'id DESC',
                            "limit" => $start . " , " . $limit,
                            "bind" => array(
                                "cityid" => $this->bongah->cityid
                            )
        ));

        $items = array();
        foreach ($melks as $melk) {
            $items[] = $melk->getBongahResponse($this->user->userid);
        }
        return $this->getResponse($items);
    }

    public function removemelkAction() {

        // load id
        $id = $this->request->getPost("id");


        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_REMOVEMELK, "id: " . $id);


        // check for melk 
        $melk = Melk::findFirst(array("id = :id:", "bind" => array("id" => $id)));
        if (!$melk || intval($melk->userid) != intval($this->user->userid) || $melk->status == Melk::MELKSTATUS_DELETEDBYSUBMITTER || $melk->status == Melk::MELKSTATUS_DELETEDBYADMIN) {
            $this->errors[] = "ملک یافت نگردید، یا هم اکنون حذف شده است";
            return $this->getResponse(false);
        }

        // set statte
        $melk->status = Melk::MELKSTATUS_DELETEDBYSUBMITTER;
        $result = $melk->save();

        // send response
        return $this->getResponse($result);
    }

    public function purchasebongahplanAction() {


        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, BongahAction::ACTION_PURCHASEBONGAHPLAN, null);


        $id = $this->request->getPost("id");

        // check sms credit id exist
        if (BongahSubscribeItem::count(array("id = :id:", "bind" => array("id" => $id))) == 0) {
            $this->errors[] = "کد وارد شده نامعتبر است";
            return $this->getResponse(false);
        }

        // sms credit item exist, we have to create new order and request user to pay that
        $onetimetoken = OneTimeToken::GenerateToken($this->user->userid);
        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 5, $id);

        // check if we have no error
        if (intval($orderID) > 0 && !$this->hasError() && strlen($onetimetoken) > 0) {
            // valid request, we have to create link for user to purchase
            $link = Config::getPublicUrl() . "index/buywithmobile/" . $orderID . "?ottoken=" . $onetimetoken;
            return $this->getResponse($link);
        }

        // there was a problem
        return $this->getResponse(false);
    }

    public function purchasesmscreditAction() {


        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_PURCHASESMSCREDIT, "id: " . $id);


        $id = $this->request->getPost("id");

        // check sms credit id exist
        if (SMSCreditCost::count(array("id = :id:", "bind" => array("id" => $id))) == 0) {
            $this->errors[] = "کد وارد شده نامعتبر است";
            return $this->getResponse(false);
        }

        // sms credit item exist, we have to create new order and request user to pay that
        $onetimetoken = OneTimeToken::GenerateToken($this->user->userid);
        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 3, $id);

        // check if we have no error
        if (intval($orderID) > 0 && !$this->hasError() && strlen($onetimetoken) > 0) {
            // valid request, we have to create link for user to purchase
            $link = Config::getPublicUrl() . "index/buywithmobile/" . $orderID . "?ottoken=" . $onetimetoken;
            return $this->getResponse($link);
        }

        // there was a problem
        return $this->getResponse(false);
    }

    public function getbongahplansAction() {

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_GETBONGAHPLAN, null);


        $start = (int) $_POST["start"];

        // get plans
        $plans = BongahSubscribeItem::find(array(
                    "enable = 1",
                    "limit" => "$start , 100"
        ));

        // load plans in array
        $items = array();
        foreach ($plans as $plan) {
            $items[] = $plan->getPublicResponse();
        }

        return $this->getResponse($items);
    }

    public function getsmsplansAction() {

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_GETSMSPLAN, null);

        $start = (int) $_POST["start"];

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

    public function androidtutAction() {

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_VIEWTUTORIAL, null);

        return $this->getResponse("<h1><font color='#b9140c'>افزودن ملک</font></h1>

اولین قدم در راستای جذب مشتری، افزودن ملک است. با استفاده از کلید '+' در گوشه سمت راست بالای برنامه، مشخصات املاک خود را وارد نمایید.

<h6>مشاهده مشتریان پیشنهادی بعد از افزودن ملک</h6>
بعد از افزودن ملک، سامانه املاک گستر به صورت خودکار به دنبال مشتریانی می گردد که نیازمند ملکی با مشخصات وارد شده باشند. در صورت وجود، شما لیستی از مشتریان را مشاهده خواهید نمود. تنها با فشار دادن کلید ارسال، مشخصات ملک شما برای مشتریان انتخابی ارسال می گردد.

<h1><font color='#b9140c'>لیست مشتریان</font></h1>
 روزانه تعداد زیادی مشتری، مشخصات ملک مورد نیاز خود را در سامانه املاک گستر ثبت می نمایند، شما می توانید مشخصات املاک درخواست شده به همراه شماره تماس در صفحه اول برنامه و در لیست 'مشتریان' مشاهده نمایید.<br/>
سامانه املاک گستر، به صوردت خودکار در لیست املاک شما جستجو نموده و  املاک متناسب با نیاز هر مشتری را پیدا می نمایید. شما میتوانید تعداد املاک پیدا شده را در کنار گزینه هر مشتری مشاهده نمایید.

<h6>مشاهده و ارسال اطلاعات ملک به مشتری</h6>
در صورتی که در لیست مشتریان برنامه، موردی را مشاهده نمودید که برای آن تعدادی ملک موجود بود، بر روی مشتری کلیک نمایید. سپس کلید 'ارسال املاک به مشتری' را فشار دهید و بعد از انتخاب املاک مورد نظر، کلید 'ارسال' را فشار دهید.

<h1><font color='#b9140c'>جستجو</font></h1>
جهت جستجو در املاک شما،  کافیست به بخش 'جستجو'ی برنامه بروید. <br/>
وارد نمودن تعداد اتاق و قیمت در هنگام جستجو اختیاری است.

<h6>ارسال نتایج جستحو به مشتری</h6>
بعضا برای شما هم اتفاق می افتد که مشتری با شما تماس گرفته در حالی که خارج از محل کار و به دور از لیست املاک خود هستید. از آنجایی که املاک اضافه شده شما در سامانه املاک گستر همیشه به همراه شما در برنامه خواهد بود، به راحتی میتوانید ملک مورد نیاز مشتری را جستجو نموده و بعد از وارد نمودن شماره مشتری، نتایج پیدا شده را برای مشتری ارسال نمایید.


<h1><font color='#0b4aaa'>سوالات متداول</font></h1>

<h6>- مشتریان چگونه مشخصات ملک درخواستی خود را به املاک گستر اعلام مینمایند؟</h6>
افرادی که نیازمند ملک هستند، با استفاده از وبسایت رسمی املاک گستر به نشانی www.amlakgostar.ir مشخصات ملک مورد نیاز خود را ارائه می نمایند.

<h6>- آیا املاکی که به برنامه اضافه می کنم، به وبسایت هم ارسال می شود؟</h6>
بله، مشخصات املاک شما به وبسایت هم ارسال می شود تا در اختیار بازدیدکنندگان قرار گیرد.

<h6>- چگونه میتوانم املاک موجود در مشاور املاک را به برنامه اضافه نمایم؟</h6>
برای اضافه نمودن ملک، کلید '+' در بالای برنامه را فشار دهید.

<h6>- در صورتی که در هنگام اضافه کردن ملک، به اینترنت دسترسی نداشته باشم، چه اتفاقی خواهد افتاد؟</h6>
مشخصات ملک به صورت آفلاین در برنامه ذخیره شده و در هنگام اتصال به اینترنت به صورت خودکار به سرور ارسال می گردد.

<h6>- در هنگام افزودن ملک، از من شماره تماس صاحب ملک و آدرس ملک خواسته می شود. من دوست ندارم اینگونه مشخصات را در اختیار شما قرار دهم.</h6>
شماره تماس مالک و آدرس ملک تنها برای استفاده در قسمت های دیگر برنامه قرار خواهد گرفت و به هیچ وجه در اختیار دیگر مشاوران املاک و یا بازدید کنندگان قرار نخواهد گرفت. در هنگام ارسال اطلاعات ملک، شماره و آدرس دفتر مشاور املاک شما به جای شماره تماس و آدرس مالک ارسال خواهد گردید. همچنین در وبسایت اطلاعات بنگاه شما به عنوان محل قابل رجوع جهت مشاهده ملک قرار خواهد گرفت. با این اوصاف در صورتی که هنوز تمایلی به ارائه آدرس ملک و شماره تماس مالک ندارید، می توانید این گزینه ها را با مشخصات مشاور املاک خود جایگزین نمایید. 

<h6>- در هنگام ارسال مشخصات ملک، چه اطلاعاتی برای مشتری ارسال خواهد شد؟</h6>
نمونه ای از پیامک ارسالی را در زیر می توانید مشاهده نمایید : <br/><br/>

<small ><font color:'#999'>
مشتری گرامی، ملک جدید مطابق با نیاز شما به مشاور املاک راه سبز سپرده گردید. 

<br/><br/>
خانه، 2 خوابه،متراژ200.00 مترمربع، زیربنا140.00 مترمربع، جهت فروش به مبلغ 140.00 میلیون تومان ،واقع در فرهنگ شهر. کد ملک: 35

<br/><br/>
با تشکر، مشاور املاک راه سبز
7131212121

</font>
</small>

 ");
    }

    public function sendmelkinfomationAction() {

        $ids = $_POST["ids"];
        $melkid = (int) $_POST["melkid"];

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_SENDMELKINFO, "melkid: " . $melkid);

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

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_GETPHONESUGGESTION, "melkid : " . $melkid);

        // check if the melk is belong to user
        $melk = Melk::findFirst(array("id = :id: AND status = 1", "bind" => array("id" => $melkid)));
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

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_ADDMELK, null);

        // get correcrt phone number
        $phone = Helper::getCorrectIraninanMobilePhoneNumber($this->request->getPost('mobile', "string"));
        if (!$phone) {
            $this->errors[] = "شماره موبایل وارد شده نامعتبر می باشد";
        }

        // check if melk uuid is not exist in server
        if (Melk::count(array("uuid = :uuid:", "bind" => array("uuid" => $this->request->getPost("uuid")))) > 0) {
            $this->errors[] = "این ملک قبلا ارسال شده است";
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
            $melk->home_size = Helper::GetCorrectMelkSize($this->request->getPost('zirbana', 'string'));
            $melk->lot_size = Helper::GetCorrectMelkSize($this->request->getPost('metraj', 'string'));
            $melk->sale_price = $this->request->getPost('saleprice', 'string');
            $melk->rent_price = $this->request->getPost('ejare', 'string');
            $melk->rent_pricerahn = $this->request->getPost('rahn', 'string');
            $melk->bedroom = $this->request->getPost('bedroom', 'string');
            $melk->bath = $this->request->getPost('bath', 'string');
            $melk->uuid = $this->request->getPost('uuid', 'string');
            $melk->offlineadd = $this->request->getPost('offlineadd', 'string');
            $melk->stateid = $stateid;
            $melk->cityid = $cityid;
            $melk->createby = 1;
            $melk->featured = 0;
            $melk->approved = 1;
            $melk->validdate = time() + 3600 * 24 * 180;

            if (!$melk->create()) {
                $this->errors[] = $melk->getMessagesAsLines();
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
                //$melkinfo->private_phone = $this->request->getPost('phone', "string");
                $melkinfo->facilities = isset($_POST["facilities"]) && is_array($_POST["facilities"]) && count($_POST["facilities"]) > 0 ? implode(",", $_POST["facilities"]) : "";
                if (!$melkinfo->create()) {
                    $this->errors[] = $melkinfo->getMessagesAsLines();
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
//                    $userPhone = UserPhone::findFirst(array("phone = :phone:", "bind" => array("phone" => $phone)));
//                    if (!$userPhone) {
//                        // user phone is not exist
//                        $userPhone = new UserPhone();
//                        $userPhone->phone = $melkinfo->private_mobile;
//                        $userPhone->userid = $this->user->userid;
//                        if ($userPhone->create()) {
//                            //$userPhone->sendVerificationNumber();
//                            //$this->redirectToPhoneVerifyPage($melk->id, $userPhone->phone);
//                        }
//                    } 


                    // success
                    $result = new stdClass();
                    $result->totallistner = $melk->findApprochMelkPhoneListners()->count();
                    $result->melkid = $melk->id;
                    $result->melkinfo = $melk->getBongahResponse($this->user->userid);
                    return $this->getResponse($result);
                }
            }
        }

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_PROBLEMINADDMELK, implode(",", $this->errors));

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

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_SENDMELKINFOFORLISTNER, "phonelistnerid : " . $phoneListnerID . "|" . "melkids: " . implode(",", $itemIDs));


        $sentMessage = "";

        // we have to send melk info
        $bongah = $this->user->getFirstBongah();
        foreach ($itemIDs as $melkID) {
            $bongah->sendMelkInfo($this->errors, $phoneListnerID, $melkID, $needToIncrease, $sentMessage);
            if (count($this->errors) > 0) {
                // return false
                return $this->getResponse(false);
            }
        }

        // success, we have to send user last sms credit
        $result = new stdClass();
        $result->message = $sentMessage;
        $result->smscredit = $this->user->getSMSCredit();
        return $this->getResponse($result);
    }

    public function getphonelistnerstatusAction() {

        // get id
        $id = $this->request->getPost("id");

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_VIEWPHONELISTNER, "phonelistnerid : " . $id);

        // check for phone listner
        $phoneListner = \MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $id)));
        if (!$phoneListner) {
            return $this->getResponse(0);
        } else {
            return $this->getResponse(intval($phoneListner->status) == 1 ? 1 : 0);
        }
    }

    public function fetchmelkcanbesentAction($melkphonelistnerid) {

        // find phone listner
        $phonelistner = MelkPhoneListner::findFirst(array("id = :id:", "bind" => array("id" => $melkphonelistnerid)));
        if (!$phonelistner) {
            $this->show404();
            return;
        }

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_FETCHMELKCANBESEND, "phonelistnerid : " . $melkphonelistnerid);


        // find melks
        $melks = $phonelistner->findApprochMelk($this->user->getFirstBongah()->id);
        $items = array();
        foreach ($melks as $melk) {
            $items[] = $melk->getBongahResponse($this->user->userid);
        }
        return $this->getResponse($items);
    }

    /**
     * @mobile
     */
    public function getusercreditAction() {

        $result = new stdClass();
        $result->remaindays = $this->user->getFirstBongah()->getRemainingPlanDays();
        $result->smscredit = $this->user->getSMSCredit();
        $result->melks = $this->user->getFirstBongah()->getMelksCount();
        $result->bongahname = $this->bongah->title;
        $result->mobile = UserPhone::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)))->phone;
        $result->showcitymelk = Config::ShowFullCityMelkInAndroid();
        $result->cityname = $this->bongah->getCityName();
        $result->showstatusbox = Config::ShowAndroidStatusBox();
        return $this->getResponse($result);
    }

    /**
     * @mobile
     * @return type
     */
    public function getnewrequestAction() {

        // save last alive
        $this->bongah->lastalive = time();
        $this->bongah->save();

        $lastSeenID = (int) $_POST["lastid"];

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'id > :id: AND cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "bind" => array(
                                "id" => $lastSeenID,
                                "cityid" => $this->bongah->cityid
                            )
        ));

        $items = array();
        foreach ($melkphonelistners as $value) {
            $items[] = $value->getMobileResponse($this->bongah);
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

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, \BongahAction::ACTION_FETCHPHONELISTNERLIST, "start : " . $start);

        // save last alive
        $this->bongah->lastappvisit = time();
        $this->bongah->save();

        // find all city
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'cityid = :cityid: AND status = "1"',
                            'order' => 'id DESC',
                            "limit" => $start . " , " . $limit,
                            "bind" => array(
                                "cityid" => $this->bongah->cityid
                            )
        ));

        $items = array();
        foreach ($melkphonelistners as $value) {
            $items[] = $value->getMobileResponse($this->bongah);
        }
        return $this->getResponse($items);
    }

    public function getmelksAction() {

        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        // create new bongahaction
        BongahAction::CreateAction($this->bongah->id, BongahAction::ACTION_LOADMELKS, "start : " . $start);

        // find all city
        $melks = Melk::find(
                        array(
                            'userid = :userid: AND status IN ( 1 , 2 )',
                            'order' => 'id DESC',
                            "limit" => $start . " , " . $limit,
                            "bind" => array(
                                "userid" => $this->user->userid
                            )
        ));

        $items = array();
        foreach ($melks as $melk) {
            $items[] = $melk->getBongahResponse($this->user->userid);
        }
        return $this->getResponse($items);
    }

}
