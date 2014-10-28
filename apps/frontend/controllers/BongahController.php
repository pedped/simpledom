<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use Bongah;
use BongahForm;
use BongahSentMessage;
use BongahSubscriber;
use CreateBongahForm;
use Melk;
use MelkPhoneListner;
use SendBongahSmsForm;
use Simpledom\Core\Classes\Config;
use Simpledom\Frontend\BaseControllers\ControllerBase;
use SMSCredit;

class BongahController extends ControllerBase {

    private $subscriptionText;

    /**
     *
     * @var \Bongah 
     */
    private $bongah;

    public function initialize() {
        parent::initialize();

        if (!isset($this->user)) {
            $this->response->redirect("user/login");
            return;
        }

        // fetch user subscription
        $subscription = BongahSubscriber::findFirst(array(
                    "order" => "id DESC"
        ));

        $publicUrl = Config::getPublicUrl();
        if (!$subscription) {

            $this->subscriptionText = "<a class='current-subscription-plan' href='$publicUrl/bongahsubscribe/plans'><b style='color:#e30'>رایگان</b></a>";
        }

        // set view
        $this->view->subscribeText = $this->subscriptionText;

        // get bongah id
        $this->bongah = Bongah::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->user->userid)));
        $this->view->currentBongah = $this->bongah;
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


            $sendingMessages = array();
            $phones = array();
            if ($toalluser) {
                $users = Melk::getNearest($this->bongah->cityid, $this->bongah->latitude, $this->bongah->longitude, 10);
                foreach ($users as $item) {

                    $b = new BongahSentMessage();
                    $b->bongahid = $this->bongah->id;
                    $b->bongahphone = $this->bongah->phone;
                    $b->bongahtitle = $this->bongah->title;
                    $b->message = $message;
                    $b->smsmessageid = $MESSAGEID;
                    $b->distance = $item->distance;
                    $b->tophone = $item->getInfo()->private_mobile;
                    $b->type = 2;
                }
            }

            if ($tophonelistner) {
                $users = MelkPhoneListner::getNearest($this->bongah->cityid, $this->bongah->latitude, $this->bongah->longitude, 10);
                foreach ($users as $item) {
                    $phones[] = $item->getPhoneNumber();
                }
            }

            $this->flash->notice(implode(",", $phones));
        } else {
            $this->response->redirect("bongah/sendsms");
        }
    }

    public function sendsmsAction() {

        // calc sms credit
        $this->calcUserCredit();

        $fr = new SendBongahSmsForm();
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
        // set view variables
        $this->view->areas = explode(",", $areas);
        $this->view->message = $text;
        $this->view->toPhoneListners = $tolistners;
        $this->view->toAllUsers = $tousers;
    }

    private function getMelkPaginator($page, $melks) {
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
                    'id', 'getTypeName()', 'getPurposeType()', 'getCondiationType()', 'home_size', 'lot_size', 'sale_price', 'rent_price', 'rent_pricerahn', 'bedroom', 'bath', 'getCityName()', 'createby', 'getDate()'
                ))->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function getMelksList($page = 1, $query = "", $bindparams = array(), $order = 'id DESC') {
        // load the users
        $melks = Melk::find(
                        array($query,
                            "bind" => $bindparams,
                            'order' => $order
        ));

        $this->getMelkPaginator($page, $melks);
    }

    public function indexAction($page = 1) {
        $this->getMelksList($page);
    }

    public function melkcansupportAction($bongahID, $page = 1, $maxDistance = 10) {

        // find bongah location
        $bongah = Bongah::findFirst($bongahID);

        // find nearset melks
        $melks = Melk::getNearest(1, $bongah->latitude, $bongah->longitude, $maxDistance);

        // load paginate
        $this->getMelkPaginator($page, $melks);
    }

    public function userscansupportAction($bongahID, $page = 1, $maxDistance = 10) {

//        // find bongah location
//        $bongah = Bongah::findFirst($bongahID);
//
//        // find neasrset users
//        $users = MelkPhoneListner::getNearest(1, $bongah->latitude, $bongah->longitude, $maxDistance);
//        var_dump($users);
        // load paginate
        // load the users
        $melkphonelistners = MelkPhoneListner::find(
                        array(
                            'status = "1"',
                            'order' => 'id DESC'
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
                    'کد', 'منظور', 'نوع ملک', 'حداقل اتاق', 'حداکثر اتاق', 'شماره تماس', 'پیامک های دریافتی', 'حداقل اجاره', 'حداکثر اجاره', 'حداقل رهن', 'حداکثر رهن', 'حداقل قیمت', 'حداکثر قیمت', 'تاریخ', 'شهر'
                ))->
                setFields(array(
                    'id', 'getPurposeTitle()', 'getTypeTitle()', 'bedroom_start', 'bedroom_end', 'getPhoneNumber(', 'receivedcount', 'rent_price_start', 'rent_price_end', 'rent_pricerahn_start', 'rent_pricerahn_end', 'sale_price_start', 'sale_price_end', 'getDate()', 'getCityName()'
                ))->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
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
                $bongah->locationscansupport = $this->request->getPost('locationscansupport', 'string');
                $bongah->mobile = $this->request->getPost('mobile', 'string');
                $bongah->phone = $this->request->getPost('phone', 'string');

                if (!$bongah->create()) {
                    $bongah->showErrorMessages($this);
                } else {
                    $bongah->showSuccessMessages($this, 'بنگاه با موفقیت اضافه گردید');

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
                    'کد', 'نام بنگاه', 'شماره پیگیری', 'نام', 'نام خانوادگی', 'آدرس', 'شهر', 'مناطق تحت پوشش', 'شماره موبایل', 'شماره تلفن', 'Date'
                ))->
                setFields(array(
                    'id', 'title', 'peygiri', 'fname', 'lname', 'address', 'getCityName()', 'locationscansupport', 'mobile', 'phone', 'getDate()'
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

    public function settingsAction($id) {

        $bongahItem = Bongah::findFirst($id);

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
                // form is valid
                $bongah = $bongahItem;
                $bongah->userid = $this->user->userid;
                $bongah->title = $this->request->getPost('title', 'string');
                $bongah->peygiri = $this->request->getPost('peygiri', 'string');
                $bongah->fname = $this->request->getPost('fname', 'string');
                $bongah->lname = $this->request->getPost('lname', 'string');
                $bongah->address = $this->request->getPost('address', 'string');
                $bongah->cityid = $this->request->getPost('cityid', 'string');
                $bongah->latitude = $this->request->getPost('map_latitude');
                $bongah->longitude = $this->request->getPost('map_longitude');
                $bongah->locationscansupport = $this->request->getPost('locationscansupport', 'string');
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
        } else {

            // set default values
            $fr->get('title')->setDefault($bongahItem->title);
            $fr->get('peygiri')->setDefault($bongahItem->peygiri);
            $fr->get('fname')->setDefault($bongahItem->fname);
            $fr->get('lname')->setDefault($bongahItem->lname);
            $fr->get('address')->setDefault($bongahItem->address);
            $fr->get('cityid')->setDefault($bongahItem->cityid);
            $fr->get('map')->setLathitude($bongahItem->latitude);
            $fr->get('map')->setLongtude($bongahItem->longitude);
            $fr->get('locationscansupport')->setDefault($bongahItem->locationscansupport);
            $fr->get('mobile')->setDefault($bongahItem->mobile);
            $fr->get('phone')->setDefault($bongahItem->phone);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = Bongah::findFirst($id);
        $this->view->item = $item;

        $form = new BongahForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('peygiri')->setDefault($item->peygiri);
        $form->get('fname')->setDefault($item->fname);
        $form->get('lname')->setDefault($item->lname);
        $form->get('address')->setDefault($item->address);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('latitude')->setDefault($item->latitude);
        $form->get('longitude')->setDefault($item->longitude);
        $form->get('locationscansupport')->setDefault($item->locationscansupport);
        $form->get('mobile')->setDefault($item->mobile);
        $form->get('phone')->setDefault($item->phone);
        $form->get('enable')->setDefault($item->enable);
        $form->get('featured')->setDefault($item->featured);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
