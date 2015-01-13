<?php

namespace Simpledom\Frontend\Controllers;

use PriceViewer;
use RangeSlider;
use Simpledom\Core\AtaForm;
use Simpledom\Core\Classes\Order;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use SMSCreditCost;
use UserOrder;

class IndexController extends IndexControllerBase {

    public function testAction() {

        $element = new RangeSlider("slider");
        $element->min = 50;
        $element->max = 500;
        $element->currentMinValue = 65;
        $element->currentMaxValue = 256;
        $element->betweenRangeTitle = "تا";


        $fr = new AtaForm();
        $fr->add($element);
        $this->view->form = $fr;
        $this->handleFormScripts($fr);


        $viewr = new PriceViewer();
        $viewr->setPlans(SMSCreditCost::find());
        $viewr->setHeaderFieldName("title");
        $viewr->setFields(array(
            "id",
            "title",
        ));
        $viewr->setInfos(array(
            "کد",
            "تیتر",
        ));


        $this->view->plansss = $viewr->Create();
    }
    
     public function buywithmobileAction($orderid) {


        // check if user is not logged in, show 404
        if (!isset($this->user)) {
            $this->show404();
            return;
        }

        // check if order id is valid
        $order = UserOrder::findFirst(array("id = :id:", "bind" => array("id" => $orderid)));
        if ($order == FALSE) {
            $this->show404();
            return;
        }

        // we have to request pay order
        $orderObject = new Order($this->user->userid);
        $orderObject->PayOrder($this->errors, $order->id, 1);
    }

}
