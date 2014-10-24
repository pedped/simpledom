<?php

namespace Simpledom\Frontend\Controllers;

class UsersubscribeController extends ControllerBaseFrontEnd {

    protected function ValidateAccess($id) {
        
    }

    public function plansAction() {
        $this->view->plans = \MelkSubscribeItem::find('enable = 1');
    }

}
