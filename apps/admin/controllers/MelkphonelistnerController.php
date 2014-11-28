<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use MelkPhoneListner;
use MelkPhoneListnerForm;

class MelkPhoneListnerController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('MelkPhoneListner');
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

        $fr = new MelkPhoneListnerForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkphonelistner = new \MelkPhoneListner();

                $melkphonelistner->melkpurposeid = $this->request->getPost('melkpurposeid', 'string');
                $melkphonelistner->melktypeid = $this->request->getPost('melktypeid', 'string');
                $melkphonelistner->bedroom_start = $this->request->getPost('bedroom_start', 'string');
                $melkphonelistner->bedroom_end = $this->request->getPost('bedroom_end', 'string');
                $melkphonelistner->phoneid = $this->request->getPost('phoneid', 'string');
                $melkphonelistner->receivedcount = $this->request->getPost('receivedcount', 'string');
                $melkphonelistner->status = $this->request->getPost('status', 'string');
                $melkphonelistner->rent_price_start = $this->request->getPost('rent_price_start', 'string');
                $melkphonelistner->rent_price_end = $this->request->getPost('rent_price_end', 'string');
                $melkphonelistner->rent_pricerahn_start = $this->request->getPost('rent_pricerahn_start', 'string');
                $melkphonelistner->rent_pricerahn_end = $this->request->getPost('rent_pricerahn_end', 'string');
                $melkphonelistner->sale_price_start = $this->request->getPost('sale_price_start', 'string');
                $melkphonelistner->sale_price_end = $this->request->getPost('sale_price_end', 'string');
                $melkphonelistner->date = $this->request->getPost('date', 'string');
                $melkphonelistner->cityid = $this->request->getPost('cityid', 'string');
                if (!$melkphonelistner->create()) {
                    $melkphonelistner->showErrorMessages($this);
                } else {
                    $melkphonelistner->showSuccessMessages($this, 'New MelkPhoneListner added Successfully');

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
        $melkphonelistners = MelkPhoneListner::find(
                        array(
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
                    'شناسه', 'نوع', 'منظور', 'موبایل', 'حداقل خواب', 'حداکثر خواب', ' حداقل اجاره', 'حداکثر اجاره', 'حداقل رهن', 'حداکثر رهن', 'حداقل قیمت', 'حداکثر قیمت', 'تارخ', 'شهر', 'مناطق', 'پیامک', 'وضعیت'
                ))->
                setFields(array(
                    'id', 'getTypeTitle()', 'getPurposeTitle()', 'getPhoneNumber()', 'bedroom_start', 'bedroom_end', 'getRentPriceStartHuman()', 'getRentPriceEndHuman()', 'getRentPriceRahnStartHuman()', 'getRentPriceRahnEndHuman()', 'getSalePriceStartHuman()', 'getSalePriceEndHuman()', 'getDate()', 'getCityName()', 'getAreasNames()', 'receivedcount', 'status',
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'melkphonelistner/list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = MelkPhoneListner::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'melkphonelistner',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = MelkPhoneListner::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this MelkPhoneListner item');
            } else {
                $this->flash->success('MelkPhoneListner item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'melkphonelistner',
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
        $this->setTitle('Edit MelkPhoneListner');

        $melkphonelistnerItem = MelkPhoneListner::findFirst($id);

        // create form
        $fr = new MelkPhoneListnerForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melkphonelistner = MelkPhoneListner::findFirst($id);
                $melkphonelistner->melkpurposeid = $this->request->getPost('melkpurposeid', 'string');

                $melkphonelistner->melktypeid = $this->request->getPost('melktypeid', 'string');

                $melkphonelistner->bedroom_start = $this->request->getPost('bedroom_start', 'string');

                $melkphonelistner->bedroom_end = $this->request->getPost('bedroom_end', 'string');

                $melkphonelistner->phoneid = $this->request->getPost('phoneid', 'string');

                $melkphonelistner->receivedcount = $this->request->getPost('receivedcount', 'string');

                $melkphonelistner->status = $this->request->getPost('status', 'string');

                $melkphonelistner->rent_price_start = $this->request->getPost('rent_price_start', 'string');

                $melkphonelistner->rent_price_end = $this->request->getPost('rent_price_end', 'string');

                $melkphonelistner->rent_pricerahn_start = $this->request->getPost('rent_pricerahn_start', 'string');

                $melkphonelistner->rent_pricerahn_end = $this->request->getPost('rent_pricerahn_end', 'string');

                $melkphonelistner->sale_price_start = $this->request->getPost('sale_price_start', 'string');

                $melkphonelistner->sale_price_end = $this->request->getPost('sale_price_end', 'string');

                $melkphonelistner->date = $this->request->getPost('date', 'string');

                $melkphonelistner->cityid = $this->request->getPost('cityid', 'string');
                if (!$melkphonelistner->save()) {
                    $melkphonelistner->showErrorMessages($this);
                } else {
                    $melkphonelistner->showSuccessMessages($this, 'MelkPhoneListner Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('melkpurposeid')->setDefault($melkphonelistnerItem->melkpurposeid);
            $fr->get('melktypeid')->setDefault($melkphonelistnerItem->melktypeid);
            $fr->get('bedroom_start')->setDefault($melkphonelistnerItem->bedroom_start);
            $fr->get('bedroom_end')->setDefault($melkphonelistnerItem->bedroom_end);
            $fr->get('phoneid')->setDefault($melkphonelistnerItem->phoneid);
            $fr->get('receivedcount')->setDefault($melkphonelistnerItem->receivedcount);
            $fr->get('status')->setDefault($melkphonelistnerItem->status);
            $fr->get('rent_price_start')->setDefault($melkphonelistnerItem->rent_price_start);
            $fr->get('rent_price_end')->setDefault($melkphonelistnerItem->rent_price_end);
            $fr->get('rent_pricerahn_start')->setDefault($melkphonelistnerItem->rent_pricerahn_start);
            $fr->get('rent_pricerahn_end')->setDefault($melkphonelistnerItem->rent_pricerahn_end);
            $fr->get('sale_price_start')->setDefault($melkphonelistnerItem->sale_price_start);
            $fr->get('sale_price_end')->setDefault($melkphonelistnerItem->sale_price_end);
            $fr->get('date')->setDefault($melkphonelistnerItem->date);
            $fr->get('cityid')->setDefault($melkphonelistnerItem->cityid);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = MelkPhoneListner::findFirst($id);
        $this->view->item = $item;

        $form = new MelkPhoneListnerForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('melkpurposeid')->setDefault($item->melkpurposeid);
        $form->get('melktypeid')->setDefault($item->melktypeid);
        $form->get('bedroom_start')->setDefault($item->bedroom_start);
        $form->get('bedroom_end')->setDefault($item->bedroom_end);
        $form->get('phoneid')->setDefault($item->phoneid);
        $form->get('receivedcount')->setDefault($item->receivedcount);
        $form->get('status')->setDefault($item->status);
        $form->get('rent_price_start')->setDefault($item->rent_price_start);
        $form->get('rent_price_end')->setDefault($item->rent_price_end);
        $form->get('rent_pricerahn_start')->setDefault($item->rent_pricerahn_start);
        $form->get('rent_pricerahn_end')->setDefault($item->rent_pricerahn_end);
        $form->get('sale_price_start')->setDefault($item->sale_price_start);
        $form->get('sale_price_end')->setDefault($item->sale_price_end);
        $form->get('date')->setDefault($item->date);
        $form->get('cityid')->setDefault($item->cityid);
        $this->view->form = $form;
    }

}
