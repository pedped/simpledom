<?php

namespace Simpledom\Frontend\Controllers;

use AtaPaginator;
use CreateMelkForm;
use Melk;
use MelkForm;
use MelkInfo;
use MelkPhoneListner;
use MelkSearch;
use UserPhone;

class MelkController extends ControllerBaseFrontEnd {

    public function initialize() {
        parent::initialize();
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

            // this function will create new melk 
            $this->response->redirect("melk/create");
        }
    }

    public function loginfirstAction() {
        $this->setPageTitle("اضافه کردن ملک");
    }

    public function createAction() {

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
                if (!$melk->create()) {
                    $melk->showErrorMessages($this);
                } else {

                    // we have to create melk info
                    $melkinfo = new MelkInfo();
                    $melkinfo->address = $this->request->getPost('address', 'string');
                    $melkinfo->latitude = $this->request->getPost('map_latitude');
                    $melkinfo->longitude = $this->request->getPost('map_longitude');
                    $melkinfo->melkid = $melk->id;
                    $melkinfo->private_address = $this->request->getPost('private_address', "string");
                    $melkinfo->private_mobile = $this->request->getPost('private_address', "string");
                    $melkinfo->private_phone = $this->request->getPost('private_address', "string");
                    if (!$melkinfo->create()) {
                        $melkinfo->showErrorMessages($this);
                    } else {
                        $melk->showSuccessMessages($this, 'ملک شما با موفقیت اضافه گردید');

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

    public function listAction($page = 1) {



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
        }


        $this->view->form = $form;

        // load the users
        $melks = Melk::find(
                        array($query,
                            "bind" => $bindparams,
                            'order' => 'id DESC'
        ));


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
        $this->view->item = $item;

        $form = new MelkForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('validdate')->setDefault($item->validdate);
        $form->get('userid')->setDefault($item->userid);
        $form->get('melktypeid')->setDefault($item->melktypeid);
        $form->get('melkpurposeid')->setDefault($item->melkpurposeid);
        $form->get('melkconditionid')->setDefault($item->melkconditionid);
        $form->get('home_size')->setDefault($item->home_size);
        $form->get('lot_size')->setDefault($item->lot_size);
        $form->get('sale_price')->setDefault($item->sale_price);
        $form->get('price_per_unit')->setDefault($item->price_per_unit);
        $form->get('rent_price')->setDefault($item->rent_price);
        $form->get('rent_pricerahn')->setDefault($item->rent_pricerahn);
        $form->get('bedroom')->setDefault($item->bedroom);
        $form->get('bath')->setDefault($item->bath);
        $form->get('stateid')->setDefault($item->stateid);
        $form->get('cityid')->setDefault($item->cityid);
        $form->get('createby')->setDefault($item->createby);
        $form->get('featured')->setDefault($item->featured);
        $form->get('approved')->setDefault($item->approved);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

    protected function ValidateAccess($id) {
        
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
            $this->flash->success("شماره شما با موفقیت به سامانه اضافه گردید، املاک جدید برای شما ارسال خواهد گردید");
        }
    }

}
