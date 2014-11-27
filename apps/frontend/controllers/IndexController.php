<?php

namespace Simpledom\Frontend\Controllers;

use Phalcon\Mvc\View;
use PriceViewer;
use Simpledom\Core\AtaForm;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use SMSCreditCost;
use TagEditElement;

class IndexController extends IndexControllerBase {

    public function testAction() {
        $element = new TagEditElement("test");
        $element->setDefault(implode(",", array("سلام", "شیراز")));
//        $element->setAutocompleteSource("function(query ,response){"
//                . "console.log(query ,response);"
//                . "response(query.term + 'yes');"
//                . "}");

        $element->setAutocompleteSource("'http://notifysystem.edspace.org/api/user/list'");

        $fr = new AtaForm();
        $fr->add($element);
        $this->view->form = $fr;
        $this->handleFormScripts($fr);


        $viewr = new PriceViewer();
        $viewr->setPlans(SMSCreditCost::find());
        $viewr->setHeaderFieldName("title");
        $viewr->setFields(array(
            "id",
            "title",
        ));
        $viewr->setInfos(array(
            "کد",
            "تیتر",
        ));

        $this->view->plansss = $viewr->Create();
    }

    public function indexAction() {
        parent::indexAction();
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);

        // we have to create sample new message received
        //  $smsNumber = "30002666262609";
        //   $phone = "9399477290";
        //$message = "استاد 8985213\nاین یک پیام جدید از طرف من است به شما دانشجوی گرامی";
        $smsNumber = "30002666262609";
        $phone = "9378231418";
        $message = "اعضا کلاس 20\nاین یک پاست به شما دانشجوی گرامی";
        //$message = ReceivedSMS::find()->getLast()->message;
        //NotifySMSManager::onNewMessageReceived($this->errors, $smsNumber, $phone, $message);
        //var_dump($this->errors);
        //die();
    }

}
