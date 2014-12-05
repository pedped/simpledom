<?php

namespace Simpledom\Admin\Controllers;

use Bongah;
use Melk;
use MelkPhoneListner;
use Simpledom\Admin\BaseControllers\IndexControllerBase;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();

        // load total bongahs
        $this->view->totalBongahs = Bongah::count();

        // load total melks
        $this->view->totalMelks = Melk::count();

        // load total phone listners
        $this->view->totalPhoneListners = MelkPhoneListner::count();
    }

}
