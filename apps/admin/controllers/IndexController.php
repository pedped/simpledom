<?php

namespace Simpledom\Admin\Controllers;

use BaseUser;
use Bongah;
use BongahSentMelk;
use BongahSubscriber;
use LineChartElement;
use Melk;
use MelkPhoneListner;
use ModelChart;
use Simpledom\Admin\BaseControllers\IndexControllerBase;
use Simpledom\Core\AtaForm;
use Simpledom\Core\Classes\Helper;
use UserOrder;
use UserPhone;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();

        // load chart
        $this->loadAmlakGostarCharts();

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

        // load user phone
        $this->view->totalUserPhone = UserPhone::Count();

        // Today User Phone
        $this->view->todayUserPhone = UserPhone::Count(array("date >= :date:", "bind" => array("date" => Helper::GetTodayStartTime())));
    }

    public function loadAmlakGostarCharts() {
        // create new form
        $form = new AtaForm();
        $user = new BaseUser();

        // load chart box
        // fetch data
        $modelChart = new ModelChart("userphonechart", new UserPhone());
        $chartlement = $modelChart->getChart();
        $chartlement->setTitle("User Phone Chart");
        $chartlement->setSubtitle("total register count per day");
        $chartlement->setXName("Date");
        $chartlement->setYAxis("Count");

        // add element to form
        $form->add($chartlement);

        // set view form
        $this->view->amlakgostarform = $form;
        $this->handleFormScripts($form);
    }

}
