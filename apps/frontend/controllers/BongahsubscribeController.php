<?php

namespace Simpledom\Frontend\Controllers;

use BongahSubscribeItem;
use Simpledom\Core\Classes\Order;

class BongahsubscribeController extends ControllerBaseFrontEnd {

    protected function ValidateAccess($id) {
        
    }

    public function plansAction() {
        $this->setPageTitle("پلان بنگاه داران");
        $this->view->plans = BongahSubscribeItem::find('enable = 1');
    }

    public function purchaseAction($planID) {

        if (!isset($this->user)) {
            $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "login",
                "params" => array()
            ));
            return;
        }

        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 5, $planID);
        $order->PayOrder($this->errors, $orderID, 1);
        if (count($this->errors) > 0) {
            var_dump($this->errors);
        }
    }

}
