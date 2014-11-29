<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Admin\BaseControllers\ControllerBase;
use AtaPaginator;
use Melk;
use MelkForm;

class MelkController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Melk');
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

        $fr = new MelkForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $melk = new \Melk();

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
                if (!$melk->create()) {
                    $melk->showErrorMessages($this);
                } else {
                    $melk->showSuccessMessages($this, 'New Melk added Successfully');

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
        $melks = Melk::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $melks,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->setTableHeaders(array(
                     'کد ملک', 'نوع', 'منظور', 'وضعیت', 'ارائه شده توسط', 'شهر', 'ویژه', 'تایید شده', 'تاریخ', 'شماره تماس'
                ))->
                setFields(array(
                    'id', 'getTypeName()', 'getPurposeType()', 'getCondiationType()', 'getCreateByTilte()', 'getCityName()', 'featured', 'approved', 'getDate()' , 'getContactPhone()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'melk/list');

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

}