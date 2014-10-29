<?php

namespace Simpledom\Frontend\Controllers;

use MelkSubscribeItem;
use Simpledom\Core\Classes\Order;

class UsersubscribeController extends ControllerBaseFrontEnd {

    protected function ValidateAccess($id) {
        
    }

    public function plansAction() {
        $this->view->plans = MelkSubscribeItem::find('enable = 1');
    }

    public function purchaseAction($planID) {
        $this->errors = array();
        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 4, $planID);
        $order->PayOrder($this->errors, $orderID, 1);
        if (count($this->errors) > 0) {
            var_dump($this->errors);
        }
    }

}
