<?php

namespace Simpledom\Frontend\Controllers;

use DBServer;
use Product;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Order;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use UserOrder;

class IndexController extends IndexControllerBase {

    public function testAction() {
        
        
        var_dump(\Product::findFirst(5)->getPublicResponse());
        die();

//        // we have to find the products top sales in last 3 days
//        $topSalesDay = Config::TopSalesDayLimit();
//
//        // find the product list in the factor items 
//        $productIDs = DBServer::LoadTopSaleProducts($topSalesDay);
//
//        if (count($productIDs) > 0) {
//            // convert them to string
//            $pdis = implode(", ", $productIDs);
//            $products = Product::find("id IN (" . $pdis . ")");
//            var_dump($products->toArray());
//            die();
//        } else {
//            $products = array();
//            var_dump($products);
//        }
//        die();
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
