<?php

namespace Simpledom\Frontend\Controllers;

use Simpledom\Core\Classes\Order;
use Simpledom\Frontend\BaseControllers\OrderControllerBase;

class OrderController extends OrderControllerBase {

    public function startAction($id) {
        $this->errors = array();
        $order = new Order(1);
        $orderID = $order->CreateOrder($this->errors, 1, 1);
        $order->PayOrder($this->errors, $orderID, 1);
    }

}
