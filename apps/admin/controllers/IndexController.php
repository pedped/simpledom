<?php

namespace Simpledom\Admin\Controllers;

use Advertise;
use Device;
use Simpledom\Admin\BaseControllers\IndexControllerBase;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        $this->setTitle("داشبورد");

        parent::indexAction();
        $this->view->totalads = Advertise::count();
        $this->view->totalwairingads = Advertise::count("status = -1");
        $this->view->totaldevice = Device::count();
    }

}
