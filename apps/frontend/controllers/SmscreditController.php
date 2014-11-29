<?php

namespace Simpledom\Frontend\Controllers;

use Simpledom\Frontend\BaseControllers\SmscreditControllerBase;
use SMSCreditCost;

class SmscreditController extends SmscreditControllerBase {

    public function plansAction() {
        $this->view->plans = SMSCreditCost::find();

        $this->setPageTitle("خرید بسته های پیامکی");
    }

}
