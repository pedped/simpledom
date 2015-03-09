<?php

namespace Simpledom\Frontend\Controllers;

use Advertise;
use Phalcon\Mvc\View;
use Simpledom\Frontend\BaseControllers\ControllerBase;

class AdvertController extends ControllerBase {

    public function viewAction($advertid, $hide = null) {
        $advertid = (int) $advertid;
        $advert = Advertise::findFirst(array("id = :id:", "bind" => array("id" => $advertid)));
        $this->view->advert = $advert->getPublicResponse();
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);


        if (isset($hide)) {
            $this->view->hidenumber = true;
        }
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
