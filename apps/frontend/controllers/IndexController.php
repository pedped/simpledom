<?php

namespace Simpledom\Frontend\Controllers;

use Area;
use City;
use Simpledom\Core\Classes\Order;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use UserOrder;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();
        $cities = City::find(array("captial = 1", "order" => "name ASC"));
        $this->view->cities = $cities;


        // load area for cities
        $areas = array();
        foreach ($cities as $city) {
            $areas[$city->id] = Area::getHighestArea($city->id);
        }
        $this->view->cityAreas = $areas;
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
