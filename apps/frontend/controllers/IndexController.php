<?php

namespace Simpledom\Frontend\Controllers;

use Phalcon\Mvc\View;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;

class IndexController extends IndexControllerBase {

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
