<?php

namespace Simpledom\Admin\Controllers;

use Area;
use AtaPaginator;
use BaseUserLog;
use Bongah;
use BongahForm;
use BongahSentMelk;
use BongahSentMessage;
use BongahSubscriber;
use City;
use Opinion;
use Phalcon\Text;
use Simpledom\Admin\BaseControllers\ControllerBase;
use SMSCreditChange;
use SMSManager;
use SmsNumber;
use UserOrder;

class BongahController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Bongah');
    }

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return true;
    }

    public function addAction() {

        $fr = new BongahForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongah = new \Bongah();

                $bongah->title = $this->request->getPost('title', 'string');
                $bongah->peygiri = $this->request->getPost('peygiri', 'string');
                $bongah->fname = $this->request->getPost('fname', 'string');
                $bongah->lname = $this->request->getPost('lname', 'string');
                $bongah->address = $this->request->getPost('address', 'string');
                $bongah->cityid = $this->request->getPost('cityid', 'string');
                $bongah->latitude = $this->request->getPost('latitude', 'string');
                $bongah->longitude = $this->request->getPost('longitude', 'string');
                $bongah->locationscansupport = $this->request->getPost('locationscansupport', 'string');
                $bongah->mobile = $this->request->getPost('mobile', 'string');
                $bongah->phone = $this->request->getPost('phone', 'string');
                $bongah->enable = $this->request->getPost('enable', 'string');
                $bongah->featured = $this->request->getPost('featured', 'string');
                $bongah->date = $this->request->getPost('date', 'string');
                if (!$bongah->create()) {
                    $bongah->showErrorMessages($this);
                } else {
                    $bongah->showSuccessMessages($this, 'New Bongah added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $bongahs = Bongah::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'نام بنگاه', 'کدصنفی', 'نام', 'نام خانوادگی', 'آدرس', 'شهر', 'مناطق تخت پوشش', 'شماره موبایل', 'شماره تماس', 'وضعیت', 'ویژه', 'تاریخ', 'املاک ارسالی'
                ))->
                setFields(array(
                    'id', 'title', 'peygiri', 'fname', 'lname', 'address', 'getCityName()', 'getSupporrtedLocationsNameAsString()', 'mobile', 'phone', 'enable', 'featured', 'getDate()', 'getSentMelkCount()'
                ))->
                setEditUrl(
                        'view'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'bongah/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = Bongah::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'bongah',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Bongah::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Bongah item');
            } else {
                $this->flash->success('Bongah item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'bongah',
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
        $this->setTitle('Edit Bongah');

        $bongahItem = Bongah::findFirst($id);

        // create form
        $fr = new BongahForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $bongah = Bongah::findFirst($id);
                $bongah->title = $this->request->getPost('title', 'string');

                $bongah->peygiri = $this->request->getPost('peygiri', 'string');

                $bongah->fname = $this->request->getPost('fname', 'string');

                $bongah->lname = $this->request->getPost('lname', 'string');

                $bongah->address = $this->request->getPost('address', 'string');

                $bongah->cityid = $this->request->getPost('cityid', 'string');

                $bongah->latitude = $this->request->getPost('latitude', 'string');

                $bongah->longitude = $this->request->getPost('longitude', 'string');

                $bongah->locationscansupport = $this->request->getPost('locationscansupport', 'string');

                $bongah->mobile = $this->request->getPost('mobile', 'string');

                $bongah->phone = $this->request->getPost('phone', 'string');

                $bongah->enable = $this->request->getPost('enable', 'string');

                $bongah->featured = $this->request->getPost('featured', 'string');

                $bongah->date = $this->request->getPost('date', 'string');
                if (!$bongah->save()) {
                    $bongah->showErrorMessages($this);
                } else {
                    $bongah->showSuccessMessages($this, 'Bongah Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($bongahItem->title);
            $fr->get('peygiri')->setDefault($bongahItem->peygiri);
            $fr->get('fname')->setDefault($bongahItem->fname);
            $fr->get('lname')->setDefault($bongahItem->lname);
            $fr->get('address')->setDefault($bongahItem->address);
            $fr->get('cityid')->setDefault($bongahItem->cityid);
            $fr->get('latitude')->setDefault($bongahItem->latitude);
            $fr->get('longitude')->setDefault($bongahItem->longitude);
            $fr->get('locationscansupport')->setDefault($bongahItem->locationscansupport);
            $fr->get('mobile')->setDefault($bongahItem->mobile);
            $fr->get('phone')->setDefault($bongahItem->phone);
            $fr->get('enable')->setDefault($bongahItem->enable);
            $fr->get('featured')->setDefault($bongahItem->featured);
            $fr->get('date')->setDefault($bongahItem->date);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id, $tab = "userinfo", $page = 1) {


        $this->setTitle("اطلاعات بنگاه");


        switch ($tab) {
            case "userinfo" :
                $this->viewTabUserInfo($id);
                break;
            case "logindetails" :
                $this->viewTabLoginDetails($id);
                break;
            case "profileimage" :
                $this->viewTabImages($id);
                break;
            case "userlogs" :
                $this->viewTabUserLogs($id, $page);
                break;
            case "orders" :
                $this->viewTabOrder($id, $page);
                break;
            case "purchasedpackages" :
                $this->viewTabPurchasedPackages($id, $page);
                break;
            case "purchasedsmspackages" :
                $this->viewTabPurchasedSMSPackages($id, $page);
                break;
            case "sentmessages" :
                $this->viewTabSentMessagess($id, $page);
                break;
            case "sentmelkinfo" :
                $this->viewTabSentMelkInfo($id, $page);
                break;

            default :
                var_dump("invalid tab");
                die();
        }



        $item = Bongah::findFirst($id);
        $this->view->bongah = $item;


        // check if user is disabled
        if (intval($item->getUser()->active) == 0) {
            $this->flash->error(Text::upper("<b>User Is Deactiveted</b>"));
        }

        // calc the more infos
        $this->view->totalOpinions = Opinion::count(array("userid = :userid:", "bind" => array("userid" => $item->userid)));

        $this->view->totalOrdersCost = UserOrder::sum(
                        array(
                            "userid = :userid: AND done = '1' ",
                            "bind" => array("userid" => $id),
                            "column" => "price"));


        $this->view->totalOrders = UserOrder::find(array("userid = :userid: AND done = '1' ", "bind" => array("userid" => $item->userid)))->count();

        $this->view->tab = $tab;
    }

    public function viewTabUserInfo($id) {


        // load citties list
        $this->view->cities = City::find();

        $bongah = Bongah::findFirst($id);

        // create form
        $fr = new BongahForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {

                $oldStatus = $bongah->enable;
                // form is valid
                $bongah->title = $this->request->getPost('title', 'string');
                $bongah->peygiri = $this->request->getPost('peygiri', 'string');
                $bongah->enable = $this->request->getPost('enable');
                $bongah->featured = $this->request->getPost('featured');
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

                    // check if we have approved bongah
                    if (intval($oldStatus) == -1 && intval($bongah->enable) == 1) {
                        // bongah just approved
                        $phone = $bongah->mobile;
                        $name = $bongah->title;
                        SMSManager::SendSMS($bongah->mobile, "بنگاه دار گرامی " . $name . "، \nبنگاه شما توسط سامانه املاک گستر با موفقیت تایید گردید. هم اکنون میتوانید از سامانه استفاده نمایید.\n با تشکر، املاک گستر\nwww.amlakgostar.ir", SmsNumber::findFirst()->id);
                        $this->flash->success("پیام تایید بنگاه به شماره $phone ارسال گردید");
                    }


                    $bongah->showSuccessMessages($this, 'بنگاه با موفقیت ذخیره گردید');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }


        $fr->get('title')->setDefault($bongah->title);
        $fr->get('peygiri')->setDefault($bongah->peygiri);
        $fr->get('fname')->setDefault($bongah->fname);
        $fr->get('lname')->setDefault($bongah->lname);
        $fr->get('address')->setDefault($bongah->address);
        $fr->get('stateid')->setDefault($bongah->getStateID());
        $fr->get('cityid')->setDefault($bongah->cityid);
        $fr->get('map')->setLathitude($bongah->latitude);
        $fr->get('map')->setLongtude($bongah->longitude);
        $fr->get('locationscansupport')->setDefault(implode(",", $bongah->getSupporrtedLocationsName()));
        $fr->get('mobile')->setDefault($bongah->mobile);
        $fr->get('phone')->setDefault($bongah->phone);
        $fr->get('enable')->setDefault($bongah->enable);
        $fr->get('featured')->setDefault($bongah->featured);
        $fr->get('date')->setDefault($bongah->date);



        $this->view->viewForm = $fr;
    }

    public function viewTabLoginDetails($id) {
        
    }

    public function viewTabImages($id) {
        $this->setTitle("تصاویر");
    }

    public function viewTabUserLogs($id, $page) {

        $this->setTitle("لاگ");

        // load the users
        $userLogs = BaseUserLog::find(array("userid = :userid:", "bind" => array("userid" => Bongah::findFirst($id)->userid), 'order' => 'id DESC'));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userLogs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'عملیات', 'اطلاعات', 'تاریخ'
                ))->
                setFields(array(
                    'id', 'action', 'info', 'getDate()'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'bongah/view/' . $id . "/userlogs/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabPurchasedSMSPackages($id, $page) {

        $this->setTitle("بسته های پیامکی خریداری شده");

        $bongah = Bongah::findFirst($id);

        // load the users
        $userorders = SMSCreditChange::find(array(
                    "userid = :userid:",
                    "bind" => array(
                        "userid" => $bongah->userid),
                    'order' => 'id DESC'));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userorders,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'مقدار', 'تاریخ'
                ))->
                setFields(array(
                    'id', 'value', 'getDate()'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'bongah/view/' . $id . "/purchasedsmspackages/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabSentMessagess($id, $page) {

        $this->setTitle("پیامک های ارسالی");

        // load the users
        $sentMessages = BongahSentMessage::find(array(
                    "bongahid = :bongahid:",
                    "bind" => array(
                        "bongahid" => $id),
                    'order' => 'id DESC'));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $sentMessages,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'پیام', "به شماره", 'تاریخ'
                ))->
                setFields(array(
                    'id', 'message', 'tophone', 'getDate()'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'bongah/view/' . $id . "/sentmessages/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabOrder($id, $page) {

        $this->setTitle("بسته های خریداری شده");

        // load the users
        $userorders = UserOrder::find(array("userid = :userid:", "bind" => array("userid" => Bongah::findFirst($id)->userid), 'order' => 'id DESC'));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $userorders,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'نوع', 'تیتر', 'کد محصول', 'پرداخت کننده', 'کد پرداخت', 'قیمت', 'واحد', 'تاریخ', 'انجام شده'
                ))->
                setFields(array(
                    'id', 'getTypeName()', 'getItemTitle()', 'itemid', 'getPaymentTypeName()', 'paymentitemid', 'price', 'pricecurrency', 'getDate()', 'getDoneTag()'
                ))->
                setEditUrl(
                        'view'
                )->setListPath(
                'bongah/view/' . $id . "/orders/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabPurchasedPackages($id, $page) {

        $this->setTitle("بسته های خریداری شده");

        $userid = Bongah::findFirst($id)->userid;

        // load the users
        $bongahsubscribers = BongahSubscriber::find(array("userid = :userid:", "bind" => array("userid" => $userid), 'order' => 'id DESC'));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahsubscribers,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'کد کاربر', 'پلان سفارش داده شده', 'تاریخ', 'شماره سفارش'
                ))->
                setFields(array(
                    'id', 'userid', 'getSubscribeItemName()', 'getDate()', 'orderid'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'bongah/view/' . $id . "/purchasedpackages/{pn}");

        $this->view->list = $paginator->getPaginate();
    }

    public function viewTabSentMelkInfo($id, $page) {

        $this->setTitle("املاک ارسالی");

        // load the users
        $bongahsentmelks = BongahSentMelk::find(
                        array("bongahid = :bongahid:", "bind" => array("bongahid" => $id))
        );


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahsentmelks,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Bongah ID', 'Melk Phone Listner', 'Melk ID', 'Message', 'Date'
                ))->
                setFields(array(
                    'id', 'bongahid', 'melkphonelistnerid', 'melkid', 'message', 'getDate()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

}
