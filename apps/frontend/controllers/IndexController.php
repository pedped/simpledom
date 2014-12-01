<?php

namespace Simpledom\Frontend\Controllers;

use Phalcon\Mvc\View;
use Simpledom\Core\Classes\NotifySMSManager;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);

        // we have to create sample new message received
        //  $smsNumber = "30002666262609";
        //   $phone = "9399477290";
        $smsNumber = "30002666262609";
        $phone = "09399477290";
        $message = "استاد 8985213\nشببو قناری";
        //$message = "اعضا کلاس 20\nاین یک پاست به شما دانشجوی گرامی";
        //$message = ReceivedSMS::find()->getLast()->message;
        //NotifySMSManager::onNewMessageReceived($this->errors, $smsNumber, $phone, $message);
        //var_dump($this->errors);
        // die();
        //
    }

}
