<?php

namespace Simpledom\Frontend\Controllers;

use BongahSubscribeItem;

class BongahsubscribeController extends ControllerBaseFrontEnd {

    protected function ValidateAccess($id) {
        
    }

    public function plansAction() {
        $this->view->plans = BongahSubscribeItem::find('enable = 1');
    }

}
