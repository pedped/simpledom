<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use DateTime;
use Promotion;
use PromotionForm;
use PromotionProduct;
use PromotionProductForm;
use Simpledom\Admin\BaseControllers\ControllerBase;

class PromotionController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('استراتژی تخیفیف');
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

        $fr = new PromotionForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $promotion = new \Promotion();

                // convert date to unix time
                $d = DateTime::createFromFormat('Y-m-d', $this->request->getPost('end_date', 'string'));
                $time = $d->getTimestamp();


                $promotion->title = $this->request->getPost('title', 'string');
                $promotion->byuserid = $this->user->userid;
                $promotion->end_date = $time;
                $promotion->total = $this->request->getPost('total', 'string');
                $promotion->default_percent = $this->request->getPost('default_percent', 'string');
                $promotion->default_fee = $this->request->getPost('default_fee', 'string');
                $promotion->status = $this->request->getPost('status', 'string');
                if (!$promotion->create()) {
                    $promotion->showErrorMessages($this);
                } else {
                    $promotion->showSuccessMessages($this, 'تخفیف جدید با موفقیت اضافه گردید');

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
        $promotions = Promotion::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $promotions,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد تخفیف', 'تیتر', 'تاریخ', 'توسط کاربر', 'تاریخ پایان', 'جداکثر تعداد فروش', 'وضعیت'
                ))->
                setFields(array(
                    'id', 'title', 'getDate()', 'byuserid', 'getEndDate()', 'total', 'status'
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
        $item = Promotion::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'promotion',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = Promotion::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this Promotion item');
            } else {
                $this->flash->success('Promotion item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'promotion',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction($id, $tab = "statistics", $page = 1) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        switch ($tab) {
            case "statistics" :
                $this->viewTabStatistics($id);
                break;
            case "info" :
                $this->viewTabProductInfo($id);
                break;
            case "products" :
                $this->viewTabProducts($id, $page);
                break;
            default :
                var_dump("invalid tab");
                die();
        }

        // set tab info
        $productItem = \Promotion::findFirst($id);
        $this->view->tab = $tab;
        $this->view->promotion = $productItem;
    }

    public function viewTabProductInfo($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }


        $promotionItem = Promotion::findFirst($id);

        // create form
        $fr = new PromotionForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $promotion = Promotion::findFirst($id);
                $promotion->title = $this->request->getPost('title', 'string');

                $promotion->byuserid = $this->request->getPost('byuserid', 'string');

                $promotion->end_date = $this->request->getPost('end_date', 'string');

                $promotion->total = $this->request->getPost('total', 'string');

                $promotion->default_percent = $this->request->getPost('default_percent', 'string');

                $promotion->default_fee = $this->request->getPost('default_fee', 'string');

                $promotion->status = $this->request->getPost('status', 'string');
                if (!$promotion->save()) {
                    $promotion->showErrorMessages($this);
                } else {
                    $promotion->showSuccessMessages($this, 'Promotion Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($promotionItem->title);
            $fr->get('byuserid')->setDefault($promotionItem->byuserid);
            $fr->get('end_date')->setDefault($promotionItem->end_date);
            $fr->get('total')->setDefault($promotionItem->total);
            $fr->get('default_percent')->setDefault($promotionItem->default_percent);
            $fr->get('default_fee')->setDefault($promotionItem->default_fee);
            $fr->get('status')->setDefault($promotionItem->status);
        }

        $this->view->form = $fr;
    }

    public function viewTabProducts($id, $page = 1) {

        


        $promotion = Promotion::findFirst($id);


        // add item
        $fr = new PromotionProductForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                $items = explode(",", $_POST["productid"]);

                // find product id for each item
                $prlist = array();
                foreach ($items as $item) {
                    $k = \Product::findFirst(array("title = :title:", "bind" => array("title" => $item)));
                    if ($k != FALSE) {
                        $prlist[] = $k->id;
                    }
                }

                if (count($prlist) > 0) {
                    // form is valid

                    foreach ($prlist as $pid) {

                        $promotionproduct = new \PromotionProduct();
                        $promotionproduct->byuserid = $this->user->userid;
                        $promotionproduct->productid = $pid;
                        $promotionproduct->promotionid = $promotion->id;
                        $promotionproduct->totalorderperuser = $this->request->getPost('totalorderperuser', 'string');
                        $promotionproduct->totalorder = $this->request->getPost('totalorder', 'string');
                        $promotionproduct->title = $this->request->getPost('title', 'string');
                        $promotionproduct->percent = $this->request->getPost('percent', 'string');
                        $promotionproduct->fee = $this->request->getPost('fee', 'string');
                        $promotionproduct->status = $this->request->getPost('status', 'string');
                        if (!$promotionproduct->create()) {
                            $promotionproduct->showErrorMessages($this);
                        }

                        // show message
                        $promotionproduct->showSuccessMessages($this, 'New PromotionProduct added Successfully');

                        // clear the title and message so the user can add better info
                        $fr->clear();
                    }
                } else {
                    $this->flash->error("محصولی با نام وارد شده یافت نگردید");
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {
            // this is not post
            $fr->get("percent")->setDefault($promotion->default_percent);
            $fr->get("fee")->setDefault($promotion->default_fee);
        }
        $this->view->form = $fr;
        
        
        
        
        
        
        
        
        
        
        
        
        // load the users
        $promotionproducts = PromotionProduct::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $promotionproducts,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'کد', 'تاریخ افزوده شدن', 'کد محصول', 'حداکثر سفارش برای هر کاربر', 'حداکثر سفارش از این محصول', 'درصد تخفیف', 'هزینه تخفیف', 'وضعیت'
                ))->
                setFields(array(
                    'id', 'getDate()', 'getProductName()', 'totalorderperuser', 'totalorder', 'percent', 'fee', 'getStatusWithLabelBox()'
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

    public function viewTabStatistics($id) {
        
    }

}
