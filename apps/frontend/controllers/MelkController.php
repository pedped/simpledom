<?php

namespace Simpledom\Frontend\Controllers;

use Area;
use AtaPaginator;
use City;
use CreateMelkForm;
use Melk;
use MelkArea;
use MelkContactForm;
use MelkForm;
use MelkImage;
use MelkInfo;
use MelkInfoViewForm;
use MelkPhoneListner;
use MelkSearch;
use MelkSubscribeItem;
use Simpledom\Core\Classes\FileManager;
use Simpledom\Core\VerifyPhoneForm;
use SMSManager;
use SmsNumber;
use UserPhone;

class MelkController extends ControllerBaseFrontEnd {

    /**
     *
     * @var MelkSubscribeItem 
     */
    private $melkSubscription;

    public function initialize() {
        parent::initialize();

        $cityID = $this->dispatcher->getParam("cityid");
        if (isset($cityID)) {
            $this->setPageTitle("املاک" . " " . City::findFirst($cityID)->name);
        }
    }

    public function startAction() {

        // check if user is logged in 
        if (!$this->session->has("userid")) {
            // user have to login first
            $this->dispatcher->forward(array(
                "controller" => "melk",
                "action" => "loginfirst",
            ));
            return;
        } else {

            // check if user need subscription
            $userMelksCount = Melk::find(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)))->count();
            if ($userMelksCount > 0) {
                // check if user has any valid suscription
                if (intval($this->user->melksubscriberplanid) == 0) {
                    // user has one melk before and now wants to add new melk, but 
                    // he do not have any valid subscription, he has to buy subscriptipn
                    $this->flash->error("برای افزودن ملک، نیاز است تا یکی از پلان های عضویت را خریداری نمایید");
                    $this->dispatcher->forward(array(
                        "controller" => "usersubscribe",
                        "action" => "plans"
                    ));
                    return;
                } else {
                    // we have to fetch user subscription
                    $subscriptionID = $this->user->melksubscriberplanid;
                    $melkSubscription = MelkSubscribeItem::findFirst(array("id = :id:", "bind" => array("id" => $subscriptionID)));
                    if ($melkSubscription->melkscanadd < $userMelksCount + 1) {
                        // user need to purchase more account
                        $this->flash->error("تعداد املاک شما در حال حاضر از تعداد املاک مجاز برای افزودن بیشتر است، لطفا پلان بالاتری خریداری نمایید");
                        $this->dispatcher->forward(array(
                            "controller" => "usersubscribe",
                            "action" => "plans"
                        ));
                        return;
                    }

                    $this->melkSubscription = $melkSubscription;
                }
            } else {
                
            }
            // this function will create new melk 
            $this->response->redirect("melk/create");
        }
    }

    public function loginfirstAction() {
        $this->setPageTitle("اضافه کردن ملک");
    }

    public function createAction() {

        // show cities to view
        $this->view->cities = City::find();

        $fr = new CreateMelkForm();
        $this->handleFormScripts($fr);

        if ($this->request->isPost()) {
            //var_dump($_POST);
            if ($fr->isValid($_POST)) {

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
                $melk->createby = 2;
                $melk->featured = 0;
                $melk->approved = 0;

                // calc teh valid date
                if (isset($this->melkSubscription)) {
                    $this->validdate = time() + 3600 * 24 * $this->melkSubscription->validdate;
                } else {
                    $this->validdate = time() + 3600 * 24 * 1;
                }


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
                    $melkinfo->private_mobile = $this->request->getPost('private_mobile', "string");
                    $melkinfo->private_phone = $this->request->getPost('private_phone', "string");
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
                        $area = Area::findFirst(array("name = :name:", "bind" => array("name" => $melkinfo->address)));
                        if (!$area) {
                            // area is not exist
                            $area = new Area();
                            $area->byuserid = $this->user->userid;
                            $area->cityid = $melk->cityid;
                            $area->name = trim($melkinfo->address);
                            $area->create();
                        }

                        // add melk area
                        $melkArea = new MelkArea();
                        $melkArea->areaid = $area->id;
                        $melkArea->byuserid = $this->user->userid;
                        $melkArea->cityid = $melk->cityid;
                        $melkArea->ip = $_SERVER["REMOTE_ADDR"];
                        $melkArea->melkid = $melk->id;
                        $melkArea->create();


                        // check if we have user phone
                        $userPhone = UserPhone::findFirst($melkinfo->private_phone);
                        if (!$userPhone) {
                            // user phone is not exist
                            $userPhone = new UserPhone();
                            $userPhone->phone = $melkinfo->private_phone;
                            $userPhone->userid = $this->user->userid;
                            if ($userPhone->create()) {
                                $userPhone->sendVerificationNumber();
                                $this->redirectToPhoneVerifyPage($melk->id, $userPhone->phone);
                            }
                        } else {
                            if (intval($userPhone->userid) == intval($this->user->userid)) {
                                // user phone is for the user
                                if (intval($userPhone->verified) == 1) {
                                    // redirect to after melk create
                                    $this->redirectAfterMelkCreating($melkinfo->private_mobile);
                                } else {
                                    // user phone is not verified yet
                                    $userPhone->sendVerificationNumber();
                                    $this->redirectToPhoneVerifyPage($melk->id, $userPhone->phone);
                                }
                            } else {
                                // shomare tamase shakse digar
                                $USERID = $this->user->userid;
                                $melk->showErrorMessages($this, 'شماره تماس شما مربوط به کاربر دیگری میباشد');
                                $this->LogWarning("شماره تماس نا معتبر", "کاربر در هنگام اضافه کردن ملک جدید، شماره تماسی را وارد نموده است که مربوط به شخص دیگری است. کد کاربر : $USERID");
                            }
                        }

                        // clear the title and message so the user can add better info
                        $fr->clear();
                    }
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        $this->view->form = $fr;
    }

    public function verifyphoneAction($melkid, $phone) {
        $fr = new VerifyPhoneForm();


        // check if user entered any number
        if ($this->request->hasPost("verifycode")) {
            $userverifycode = $this->request->getPost("verifycode");
            $userPhone = UserPhone::findFirst(array("userid = :userid: AND phone = :phone:", "bind" => array(
                            "userid" => $this->user->userid,
                            "phone" => $phone
            )));

            // check if both items are equal
            if (intval($userverifycode) === intval($userPhone->verifycode)) {
                // verification equals to user eneterd number
                $userPhone->verified = "1";
                $userPhone->save();
                $this->flash->success(sprintf(_("Your Phone Number, %s, has been verified successfully"), $phone));

                // user phone verificaed, we have to choose the buy option
                $this->redirectAfterMelkCreating($phone
                );
            } else {
                // invalid number
                $this->flash->error(_("Invalid Number, Please Check Your SMS Again"));
            }
        }

        $this->handleFormScripts($fr);
        $this->view->form = $fr;
        $this->view->phoneNumber = $phone;
    }

    public function listAction($page = 1) {

        $cityID = $this->dispatcher->getParam("cityid");
        if (!isset($cityID)) {
            $cityID = 1;
        }


        // search form
        $form = new MelkSearch();
        // we have to create query for item
        $query = "";
        $bindparams = array();


        // check if user submiteted search query
        if ($this->request->isPost()) {

            // allow user to show his phone
            $this->view->showMobileForm = 1;

            // add default parameters
            switch ($this->request->getPost("melkpurposeid")) {
                case 1:
                    // SALE
                    $query .= "melktypeid = :melktypeid: AND melkpurposeid = :melkpurposeid: AND cityid = :cityid: AND sale_price >= :sale_price_start: AND sale_price <= :sale_price_end: ";
                    $bindparams["melktypeid"] = $this->request->getPost("melktypeid");
                    $bindparams["melkpurposeid"] = $this->request->getPost("melkpurposeid");
                    $bindparams["cityid"] = $this->request->getPost("cityid");
                    $bindparams["sale_price_start"] = $this->request->getPost("sale_price_start");
                    $bindparams["sale_price_end"] = $this->request->getPost("sale_price_end");
                    break;
                case 2:
                    // RENT
                    $query .= "melktypeid = :melktypeid: AND melkpurposeid = :melkpurposeid: AND cityid = :cityid: AND rent_price >= :rent_price_start: AND rent_price <= :rent_price_end: AND rent_pricerahn >= :rent_pricerahn_start: AND rent_pricerahn <= :rent_pricerahn_end: ";
                    $bindparams["melktypeid"] = $this->request->getPost("melktypeid");
                    $bindparams["melkpurposeid"] = $this->request->getPost("melkpurposeid");
                    $bindparams["cityid"] = $this->request->getPost("cityid");
                    $bindparams["rent_price_start"] = $this->request->getPost("rent_price_start");
                    $bindparams["rent_price_end"] = $this->request->getPost("rent_price_end");
                    $bindparams["rent_pricerahn_start"] = $this->request->getPost("rent_pricerahn_start");
                    $bindparams["rent_pricerahn_end"] = $this->request->getPost("rent_pricerahn_end");
                    break;
            }


            switch ($this->request->getPost("melktypeid")) {
                case 1 :
                case 2 :
                case 3 :
                case 6 :
                    // khane
                    // apartemnatn
                    // daftar kar
                    // otaghe kar
                    $query.= " AND bedroom >= :bedroom_start: AND bedroom <= :bedroom_end: ";
                    $bindparams["bedroom_start"] = $this->request->getPost("bedroom_start");
                    $bindparams["bedroom_end"] = $this->request->getPost("bedroom_end");
                    break;
                case 4 :
                    break;
                case 5 :
                    break;
                default:
                    $this->LogError("Invalid Melk Type", "Melk type has invalid value");
                    break;
            }

            // check if user posted mobile phone
            if ($this->request->hasPost("subscribephone")) {
                // user want to subscribe to phone
                $phone = $this->request->getPost("subscribephone");
                if (strlen($phone) != 11 && strlen($phone) != 12) {
                    // user enetred invalid phone number
                    $this->flash->error("شماره موبایل وارد شده نامعتبر است");
                } else {
                    $this->subscribeUserPhone($phone);
                }
            }
        } else {
            $query = "cityid = :cityid:";
            $bindparams["cityid"] = $cityID;
        }


        $this->view->form = $form;

        $areaid = $this->dispatcher->getParam("areaid");
        if (isset($areaid)) {
            //$query .= " AND melk.id IN ( SELECT melkid FROM melkarea WHERE melkarea.cityid = :cityid: AND melkarea.areaid = :areaid:)";
            $m = new Melk();
            $melks = $m->rawQuery("SELECT melk.* FROM melk JOIN melkarea ON melk.id  = melkarea.melkid AND melkarea.areaid = ? ", array($areaid));
        } else {
            // load the users
            $melks = Melk::find(
                            array($query,
                                "bind" => $bindparams,
                                'order' => 'id DESC'
            ));
        }

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
                    'id', 'getTypeName()', 'getPurposeType()', 'getCondiationType()', 'getZirbana()', 'getMetraj()', 'getSalePrice()', 'getEjarePrice()', 'getRahnPrice()', 'bedroom', 'bath', 'getCityName()', 'getCreateByTilte()', 'getDate()', 'getViewButton()'
                ))->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Melk::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melk',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Melk::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Melk item');
            } else {
                $this->flash->success('Melk item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melk',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit Melk');

        $melkItem = Melk::findFirst($id);

        // create form
        $fr = new MelkForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melk = Melk::findFirst($id);
                $melk->validdate = $this->request->getPost('validdate', 'string');

                $melk->userid = $this->request->getPost('userid', 'string');

                $melk->melktypeid = $this->request->getPost('melktypeid', 'string');

                $melk->melkpurposeid = $this->request->getPost('melkpurposeid', 'string');

                $melk->melkconditionid = $this->request->getPost('melkconditionid', 'string');

                $melk->home_size = $this->request->getPost('home_size', 'string');

                $melk->lot_size = $this->request->getPost('lot_size', 'string');

                $melk->sale_price = $this->request->getPost('sale_price', 'string');

                $melk->price_per_unit = $this->request->getPost('price_per_unit', 'string');

                $melk->rent_price = $this->request->getPost('rent_price', 'string');

                $melk->rent_pricerahn = $this->request->getPost('rent_pricerahn', 'string');

                $melk->bedroom = $this->request->getPost('bedroom', 'string');

                $melk->bath = $this->request->getPost('bath', 'string');

                $melk->stateid = $this->request->getPost('stateid', 'string');

                $melk->cityid = $this->request->getPost('cityid', 'string');

                $melk->createby = $this->request->getPost('createby', 'string');

                $melk->featured = $this->request->getPost('featured', 'string');

                $melk->approved = $this->request->getPost('approved', 'string');

                $melk->date = $this->request->getPost('date', 'string');
                if (!$melk->save()) {
                    $melk->showErrorMessages($this);
                } else {
                    $melk->showSuccessMessages($this, 'Melk Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('validdate')->setDefault($melkItem->validdate);
            $fr->get('userid')->setDefault($melkItem->userid);
            $fr->get('melktypeid')->setDefault($melkItem->melktypeid);
            $fr->get('melkpurposeid')->setDefault($melkItem->melkpurposeid);
            $fr->get('melkconditionid')->setDefault($melkItem->melkconditionid);
            $fr->get('home_size')->setDefault($melkItem->home_size);
            $fr->get('lot_size')->setDefault($melkItem->lot_size);
            $fr->get('sale_price')->setDefault($melkItem->sale_price);
            $fr->get('price_per_unit')->setDefault($melkItem->price_per_unit);
            $fr->get('rent_price')->setDefault($melkItem->rent_price);
            $fr->get('rent_pricerahn')->setDefault($melkItem->rent_pricerahn);
            $fr->get('bedroom')->setDefault($melkItem->bedroom);
            $fr->get('bath')->setDefault($melkItem->bath);
            $fr->get('stateid')->setDefault($melkItem->stateid);
            $fr->get('cityid')->setDefault($melkItem->cityid);
            $fr->get('createby')->setDefault($melkItem->createby);
            $fr->get('featured')->setDefault($melkItem->featured);
            $fr->get('approved')->setDefault($melkItem->approved);
            $fr->get('date')->setDefault($melkItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Melk::findFirst($id);
        $melkInfo = \MelkInfo::findFirst(array("melkid = :melkid:", "bind" => array("melkid" => $item->id)));
        $form = new MelkInfoViewForm();
        $contactForm = new MelkContactForm();
        $this->handleFormScripts($form);
        $this->handleFormScripts($contactForm);

        $form->get('map')->setLathitude($melkInfo->latitude);
        $form->get('map')->setLongtude($melkInfo->longitude);
        $form->get('map')->setMarkTitle("موقعیت ملک");
        $form->get('map')->setMarkDescription("موقعیت ملک");
        $form->get('map')->setZoom(13);


        // get nearser bongahs
        $this->view->bongahs = $item->getNearsetBongahs();

        $this->view->form = $form;
        $this->view->contactform = $contactForm;
        $this->view->melk = $item;

        $this->view->item = $item;
    }

    protected
            function ValidateAccess($id) {
        
    }

    public function subscribeUserPhone($phone) {
        // valid phone number, we have to check if the phone number is exist
        $userPhone = UserPhone::findFirst(array("phone = :phone:", "bind" => array("phone" => $phone)));


        // check for userid
        if ($userPhone && intval($userPhone->userid) != intval($this->user->userid)) {
            // user is ot valid
            $this->flash->error("شماره تماس شما توسط شخص دیگری ثبت گردیده است، در صورت اطمینان از شماره خود، توسط فرم تماس با ما این مهم را در جریان بگزارید");
            return;
        }

        if ($userPhone && intval($userPhone->userid) == intval($this->user->userid)) {
            
        } else if (!$userPhone) {
            // create user phone
            $userPhone = new UserPhone();
            $userPhone->phone = $phone;
            $userPhone->userid = $this->user->userid;
            if (!$userPhone->create()) {
                $this->flash->success("خطا در هنگام اضافه کردن شماره تماس");
                $this->LogError("Problem In Adding User Phone", "khata dar hengame ezafe kardane shomare shaks : " . $userPhone->getMessagesAsLines());
                return;
            }
        }


        $melkListner = new MelkPhoneListner();

        $melkListner->cityid = $this->request->getPost("cityid");
        $melkListner->melkpurposeid = $this->request->getPost("melkpurposeid");
        $melkListner->melktypeid = $this->request->getPost("melktypeid");

        $melkListner->phoneid = $userPhone->id;

        $melkListner->bedroom_start = $this->request->getPost("bedroom_start");
        $melkListner->bedroom_end = $this->request->getPost("bedroom_end");

        $melkListner->rent_price_start = $this->request->getPost("rent_price_start");
        $melkListner->rent_price_end = $this->request->getPost("rent_price_end");

        $melkListner->rent_pricerahn_start = $this->request->getPost("rent_pricerahn_start");
        $melkListner->rent_pricerahn_end = $this->request->getPost("rent_pricerahn_end");

        $melkListner->sale_price_start = $this->request->getPost("sale_price_start");
        $melkListner->sale_price_end = $this->request->getPost("sale_price_end");

        if (!$melkListner->create()) {
            $this->flash->success("خطا در هنگام اضافه کردن شماره تماس");
            $this->LogError("Problem In Adding User Phone", "khata dar hengame ezafe kardane agahsaz : " . $melkListner->getMessagesAsLines());
            return;
        }


        // check if the phone is valid
        if (!$userPhone->verified) {
            $this->flash->success("برای دریافت املاک، نیاز است تا شماره خود را تایید نمایید");
            $this->dispatcher->forward(array(
                "controller" => "phone",
                "action" => "verify",
                "params" => array(
                    $phone
                )
            ));
        } else {
            $this->flash->success(
                    "شماره شما با موفقیت به سامانه اضافه گردید، املاک جدید برای شما ارسال خواهد گردید");
        }
    }

    public function redirectToPhoneVerifyPage($melkid, $phone) {
        $this->flash->success('برای تایید ملک خود نیاز است تا شماره تماس خود را تایید نمایید، لطفا کد ارسال شده به شماره خود را وارد نمایید');

        // forward user to phone verification page 
        $this->dispatcher->forward(array(
            "controller" => "melk",
            "action" => "verifyphone",
            "params" => array(
                $melkid,
                $phone
            )
        ));
    }

    public function redirectAfterMelkCreating($phone) {

        // Send SMS
        if (isset($this->melkSubscription)) {
            $username = $this->user->getFullName();
            $gender = $this->user->gender;
            $name = "";
            if (intval($gender) == 1) {
                $name = "جناب آقای " . $username;
            } else {
                $name = "سرکار خانم " . $username;
            }
            SMSManager::SendSMS($phone, $name . "،" . " " . "ملک شما با موفقیت اضافه گردید", SmsNumber::findFirst()->id);
            $this->flash->success('ملک شما با موفقیت اضافه گردید');
        } else {
            
        }
    }

}
