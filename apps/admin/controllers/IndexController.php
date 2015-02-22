<?php

namespace Simpledom\Admin\Controllers;

use AppDownload;
use AppEmailRequest;
use AtaPaginator;
use BaseUser;
use Bongah;
use BongahAction;
use BongahSentMelk;
use BongahSubscriber;
use Melk;
use MelkPhoneListner;
use ModelChart;
use Sentsms;
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
        $this->view->totalRevenue = Helper::GetPrice(UserOrder::sum(array("done = '1'", 'column' => "price")) / 10000000);

        // load user phone
        $this->view->totalUserPhone = UserPhone::Count();

        // load total app email request
        $this->view->totalAppEmailRequest = AppEmailRequest::Count();

        // load total app email request
        $this->view->totalAppEmailRequestToday = AppEmailRequest::Count(array("date >= :date:", "bind" => array("date" => Helper::GetTodayStartTime())));

        // Today User Phone
        $this->view->todayUserPhone = UserPhone::Count(array("date >= :date:", "bind" => array("date" => Helper::GetTodayStartTime())));

        // load bongah action list
        $this->loadBongahActionList();
    }

    public function loadAmlakGostarCharts() {
        // create new form
        $form = new AtaForm();
        $user = new BaseUser();

        // load chart box
        // fetch data
        $modelChart = new ModelChart("userphonechart", new UserPhone());
        $chartlement = $modelChart->getChart();
        $chartlement->setTitle("املاک درخواستی");
        $chartlement->setSubtitle("تعداد املاک درخواستی در هر روز");
        $chartlement->setXName("تاریخ");
        $chartlement->setYAxis("تعداد");

        // Load Download Chart
        // fetch data
        $downloadChart = new ModelChart("appdownloadchart", new AppDownload());
        $downloadappelement = $downloadChart->getChart();
        $downloadappelement->setTitle("دانلود برنامه موبایل");
        $downloadappelement->setSubtitle("تعداد دانلود برنامه در هر روز");
        $downloadappelement->setXName("تاریخ");
        $downloadappelement->setYAxis("تعداد");

        // Load Download Chart
        // fetch data
        $sentSMSChart = new ModelChart("sentsmsdownload", new Sentsms());
        $sendsmselement = $sentSMSChart->getChart();
        $sendsmselement->setTitle("پیامک ارسالی در هر روز");
        $sendsmselement->setSubtitle("تعداد ارسال پیامک ارسال پیامک در هر روز");
        $sendsmselement->setXName("تاریخ");
        $sendsmselement->setYAxis("تعداد");


        // add element to form
        $form->add($chartlement);
        $form->add($downloadappelement);
        $form->add($sendsmselement);

        // set view form
        $this->view->amlakgostarform = $form;
        $this->handleFormScripts($form);
    }

    public function loadBongahActionList() {
        // load the users
        $bongahactions = BongahAction::find(
                        array(
                            "limit" => "100",
                            'order' => 'id DESC'
        ));
        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $bongahactions,
            'limit' => 100,
            'page' => 1
        ));


        $paginator->
                setTableHeaders(array(
                    'شناسه', 'کد بنگاه', 'کد عمل', 'نام بنگاه', 'شهر', 'عمل', 'اطلاعات', 'تاریح'
                ))->
                setFields(array(
                    'id', 'bongahid', 'actioncode', 'getBongahName()', 'getCityName()', 'getActionName()', 'data', 'getDate()'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'list');

        $this->view->bongahActionList = $paginator->getPaginate();
    }

}
