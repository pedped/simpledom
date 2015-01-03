<?php

namespace Simpledom\Frontend\BaseControllers;

use Simpledom\Core\Classes\Order;
use SMSCredit;

class SmscreditControllerBase extends ControllerBase {

    public function indexAction() {
        //SMSCredit::decreaseCredit($this->errors, 1, 10, 5);
    }

    public function buyAction($id = 2) {
        $this->errors = array();
        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 3, $id);
        $order->PayOrder($this->errors, $orderID, 1);
        var_dump($this->errors);
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
