<?php

namespace Simpledom\Admin\BaseControllers;

use BaseContact;
use BaseUser;
use Opinion;
use Simpledom\Core\SendSMSForm;
use SMSManager;
use UserOrder;

class IndexControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {

        // load total contacts
        $this->view->totalUsers = BaseUser::count();
        $this->view->totalOpinions = Opinion::count();
        $this->view->totalContacts = BaseContact::count();
        $this->view->totalProdcutSale = UserOrder::count("done = '1'");
        $user = new BaseUser();
        $this->view->registerChart = $user->getLastMonthRegistarChart();
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

}
