<?php

namespace Simpledom\Admin\BaseControllers;

use BaseUser;
use Feedback;
use Invoice;
use ModelChart;
use Product;
use Simpledom\Core\AtaForm;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\SendSMSForm;
use SMSManager;
use SMSProvider;

class IndexControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {

        // load total contacts
        $this->view->totalUsers = BaseUser::count();
        $this->view->totalOpinions = Product::count();
        $this->view->totalContacts = Feedback::count();
        $this->view->totalProdcutSale = Invoice::count();

        // check if we have to fetch user credit on admin panel
        if (Config::CheckForSMSCreditOnAdminPanel()) {

            $credits = array();

            // list providers
            $providers = SMSProvider::find("enable = 1");

            // load each credit on request
            foreach ($providers as $providerName) {
                $provider = SMSManager::getProvider($providerName->name)->init($providerName->infos);
                $credits[$providerName->name] = $provider->getRemain(true);
            }

            $this->view->smsProvidersCredit = $credits;
        }

        $this->loadRegisterChart();
    }

    public function sendsmsaction() {
        $fr = new SendSMSForm();
        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
            } else {
                $phones = explode(",", $this->request->getPost("phones", "string"));
                $message = $this->request->getPost("message");
                $numberID = $this->request->getPost("fromnumber");

                // Send SMSs
                $result = SMSManager::SendSMS($phones, $message, $numberID);

                // check if we have successfully sent messages
                if ($result) {
                    $this->flash->success("Your message has been sent successfully to these numbers:<br/><br/>" . implode("<br/>", $phones));
                } else {
                    $this->flash->error("There was a problem in sending message");
                }
            }
        }
        $this->view->form = $fr;
    }

    protected function ValidateAccess($id) {
        
    }

    public function loadRegisterChart() {

        // create new form
        $form = new AtaForm();
        $user = new BaseUser();

        // load chart box
        // fetch data
        $invoiceCountChart = new ModelChart("invoicecount", new Invoice(), "date");
        $invoicechart = $invoiceCountChart->getChart();
        $invoicechart->setTitle("آمار سفارش");
        $invoicechart->setSubtitle("تعداد سفارشات جدید در هر روز");
        $invoicechart->setXName("تاریخ");
        $invoicechart->setYAxis("تعداد");
        // add element to form
        $form->add($invoicechart);


        // load chart box
        // fetch data
        $registerchartBox = new ModelChart("registerchart", new BaseUser(), "registerdate");
        $registerchart = $registerchartBox->getChart();
        $registerchart->setTitle("آمار عضویت");
        $registerchart->setSubtitle("تعداد اعضای جدید در هر روز");
        $registerchart->setXName("تاریخ");
        $registerchart->setYAxis("تعداد");
        // add element to form
        $form->add($registerchart);


        // set view form
        $this->view->form = $form;
        $this->handleFormScripts($form);
    }

}
