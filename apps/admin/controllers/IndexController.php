<?php

namespace Simpledom\Admin\Controllers;

use Bongah;
use BongahSentMelk;
use BongahSubscriber;
use Melk;
use MelkPhoneListner;
use Simpledom\Admin\BaseControllers\IndexControllerBase;
use Simpledom\Core\Classes\Helper;
use UserOrder;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();

        // load total bongahs
        $this->view->totalBongahs = Bongah::count();

        // load total melks
        $this->view->totalMelks = Melk::count();

        // load total phone listners
        $this->view->totalPhoneListners = MelkPhoneListner::count();

        // load total bongah Packages
        $this->view->totalBongahPackages = BongahSubscriber::count();

        // load total sent melk
        $this->view->totalSentMelk = BongahSentMelk::count();

        // load revenue
        $this->view->totalRevenue = Helper::GetPrice(UserOrder::sum(array("done = '1'", 'column' => "price")) / 1000000);
    }

}
