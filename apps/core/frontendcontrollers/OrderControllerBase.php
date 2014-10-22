<?php

namespace Simpledom\Frontend\BaseControllers;

use Simpledom\Core\Classes\Order;

class OrderControllerBase extends ControllerBase {

    public function startAction($id) {
        $this->errors = array();
        $order = new Order(1);
        $orderID = $order->CreateOrder($this->errors, 1, 1);
        $order->PayOrder($this->errors, $orderID, 1);
    }

}
