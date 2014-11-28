<?php

namespace Simpledom\Frontend\Controllers;

use BaseSystemLog;
use City;
use MelkPhoneListner;
use Phalcon\Validation\Validator\PresenceOf;
use RequestMelkForm;
use Settings;
use Simpledom\Core\Classes\Helper;
use SMSManager;
use SmsNumber;
use SystemLogType;
use User;

class RequestmelkController extends ControllerBaseFrontEnd {

    protected function ValidateAccess($id) {
        
    }

    public function initialize() {
        parent::initialize();

        $this->loadSmallPriceOption();
    }

    public function addAction() {

        $this->setPageTitle("درخواست ملک");

        // show cities to view
        $this->view->cities = City::find();

        $fr = new RequestMelkForm();

        if ($this->request->isPost()) {

            if (!$fr->isValid($_POST)) {
                // invalid request
                foreach ($fr->getMessages() as $message) {
                    $this->errors[] = $message;
                }
            } else {

                // get correcrt phone number
                $phone = Helper::getCorrectIraninanMobilePhoneNumber($this->request->getPost("mobile"));
                if (!$phone) {
                    $this->errors[] = "شماره موبایل وارد شده نامعتبر میباشد";
                }

                if (!$this->hasError()) {


                    // create listner
                    $result = MelkPhoneListner::subscribeUser($this->errors, null, $phone);
                    if ($result > 0) {
                        if ($result == 1) {
                            // added successfully
                            $this->flash->success("شماره شما با موفقیت به سامانه اضافه گردید، املاک جدید برای شما ارسال خواهد گردید");
                            $this->dispatcher->forward(array(
                                "controller" => "index",
                                "action" => "index",
                                "params" => array()
                            ));
                        } else if ($result == 2) {
                            // need to verify
                            $this->flash->success("لطفا شماره تماس خود را تایید نمایید");
                            $this->dispatcher->forward(array(
                                "controller" => "phone",
                                "action" => "verify",
                                "params" => array(
                                    $phone
                                )
                            ));
                        }
                    } else {
                        // there is problem in adding item
                    }
                }
            }


            // set default values
            $fr->get("bedroom_range")->setCurrentMinValue($this->request->getPost("bedroom_range_min"));
            $fr->get("bedroom_range")->setCurrentMaxValue($this->request->getPost("bedroom_range_max"));

            $fr->get("sale_range")->setCurrentMinValue(array_search($this->request->getPost("sale_range_min"), $this->saleRangeValues));
            $fr->get("sale_range")->setCurrentMaxValue(array_search($this->request->getPost("sale_range_max"), $this->saleRangeValues));

            $fr->get("rahn_range")->setCurrentMinValue(array_search($this->request->getPost("rahn_range_min"), $this->rahnRangeValues));
            $fr->get("rahn_range")->setCurrentMaxValue(array_search($this->request->getPost("rahn_range_max"), $this->rahnRangeValues));

            $fr->get("ejare_range")->setCurrentMinValue(array_search($this->request->getPost("ejare_range_min"), $this->ejareRangeValues));
            $fr->get("ejare_range")->setCurrentMaxValue(array_search($this->request->getPost("ejare_range_max"), $this->ejareRangeValues));
        }

        if ($this->hasError()) {
            $this->flash->error(implode("\n", $this->errors));
            BaseSystemLog::init($aaa)->setTitle("خطا در درخواست ملک")->setType(SystemLogType::Debug)->setMessage(implode("\n", $this->errors))->setIP($_SERVER["REMOTE_ADDR"])->create();
        }
        $this->handleFormScripts($fr);
        $this->view->form = $fr;
    }

}
