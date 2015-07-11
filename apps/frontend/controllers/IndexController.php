<?php

namespace Simpledom\Frontend\Controllers;

use IBSngFunctions;
use PriceViewer;
use RangeSlider;
use Settings;
use Simpledom\Core\AtaForm;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;
use Simpledom\Core\Classes\Order;
use Simpledom\Core\FreeForm;
use Simpledom\Core\PurchaseForm;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use SMSCreditCost;
use SMSManager;
use SmsNumber;
use User;
use UserOrder;
use UserPhone;

class IndexController extends IndexControllerBase {

    public function accountAction() {
        $this->setPageTitle("خرید حساب اینترنتی");

        // IBSngFunctions::GetUserID($this->errors, "09399477290");
        // add free form
        $fr = new PurchaseForm();
        $this->handleFormScripts($fr);

        // check if user submitted phone
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                // TODO check if phone is valid
                // get the phone number and check if phone is exist, else, we have
                // to create user for this user
                $phone = Helper::getCorrectIraninanMobilePhoneNumber($this->request->getPost("phone"));
                if (!$phone) {
                    // phone is not valid
                    $fr->flash->error("شماره وارد شده نامعتبر است");
                } else {
                    $type = $this->request->getPost("type");
                    $email = $phone . "@ibsng.com";
                    if (!User::count(array("email = :email:", "bind" => array("email" => $email))) > 0) {
                        // we have user account, we are not able to send free code again
                        $fr->flash->error("متاسفانه شماره تماس شما یافت نگردید");
                    } else {
                        // we have to create a account and try to send free code to the user
                        $user = new User();
                        $errors = array();
                        if ($user->Login($email, $phone)) {
                            // logged in successfully, we have to set session
                            $this->user = User::findFirst(array("email = :email:", "bind" => array("email" => $email)));
                            $this->user->setSession($this);
                            //var_dump($this->user);
                            //die();
                            // create a order and redirect user to order page
                            $order = new Order($this->user->userid);
                            $orderID = $order->CreateOrder($this->errors, 4, $type);
                            if (intval($orderID) > 0 && count($this->errors) == 0) {
                                $order->PayOrder($this->errors, $orderID, 1);
                            } else {
                                $this->flash->error("خطا در هنگلم ایجاد سفارش" . ": " . implode($this->errors, "\n"));
                            }
                        } else {
                            $fr->flash->error("خطای هنگام ورود");
                        }
                    }
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        $this->view->form = $fr;
    }

    public function successAction($phone) {
        
    }

    public function indexAction() {
        parent::indexAction();

        //SMSManager::SendSMS("09399477290", "salam", SmsNumber::findFirst("enable = 1"));
        //IBSngFunctions::GetUserID($this->errors, "09399477290");
        //die();
        // add free form
        $fr = new FreeForm();
        $this->handleFormScripts($fr);

        // check if user submitted phone
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                // TODO check if phone is valid
                // get the phone number and check if phone is exist, else, we have
                // to create user for this user
                $phone = Helper::getCorrectIraninanMobilePhoneNumber($this->request->getPost("phone"));
                if (!$phone) {
                    // phone is not valid
                    $fr->flash->error("شماره وارد شده نامعتبر است");
                } else {
                    $email = $phone . "@ibsng.com";
                    if (User::count(array("email = :email:", "bind" => array("email" => $email))) > 0) {
                        // we have user account, we are not able to send free code again
                        $url = Config::getPublicUrl() . "index/account";
                        $fr->flash->error("شماره شما قبلا در سایت ثبت شده است و شارژ رایگان به شماره شما ارسال گردیده است، در صورت تمایل به خرید کارت شارژ به صفحه <a href='$url' />خرید بسته اینترنتی</a> مراجعه نمایید.");
                    } else {
                        // we have to create a account and try to send free code to the user
                        $user = new User();
                        $errors = array();
                        $result = $user->registerAccount($this, $errors, $phone, $phone, 1, $email, $phone, USERLEVEL_USER, $phone);


                        // check if that was successfull
                        if ($result == TRUE && count($errors) == 0) {
                            // successfully creatd
                            $this->flash->success("حساب کاربری شما با موفقیت ساخته شد");

                            // we have to enable user phone
                            $userPhone = UserPhone::findFirst(array("userid = :userid:", "bind" => array("userid" => $user->userid)));
                            $userPhone->verified = 1;
                            $userPhone->save();
                        }

                        // we have to send free sms code
                        if (count($errors) == 0) {
                            // check if we already had that user name and password
                            if (IBSngFunctions::CheckUserExist($errors, $phone)) {
                                $this->errors[] = "شما قبلا با استفاده از این قسمت اعتبار رایگان دریافت نموده اید، جهت خرید بسته های اینترنتی از این قسمت وارد شوید";
                            } else {
                                //  user do not have error, he did not sign to site up. try to create new
                                //   user
                                $username = $phone;
                                $password = IBSngFunctions::GenerateRandomNumber(Settings::Get()->passwordlength);
                                $result = IBSngFunctions::CreateUser($errors, $username, $password);
                                if ($result == TRUE) {
                                    // successfully created new user, we have to send message to user 
                                    // about user name and password
                                    SMSManager::SendSMS($phone, str_replace("{{رمز}}", $password, str_replace("{{شماره}}", $username, Settings::Get()->freemessage, SmsNumber::findFirst("enable = 1"))));

                                    // show success message
                                    $this->flash->success("با تشکر، اطلاعات ورود به شماره شما ارسال گردید");
                                } else {
                                    $this->errors[] = "شما قبلا با استفاده از این قسمت اعتبار رایگان دریافت نموده اید، جهت خرید بسته های اینترنتی از این قسمت وارد شوید";
                                }
                            }
                        }
                    }
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }

        $this->view->form = $fr;
    }

    /**
     * @Cache(lifetime=60)
     */
    public function testAction() {

        $element = new RangeSlider("slider");
        $element->min = 50;
        $element->max = 500;
        $element->currentMinValue = 65;
        $element->currentMaxValue = 256;
        $element->betweenRangeTitle = "تا";


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

    public function buywithmobileAction($orderid) {


        // check if user is not logged in, show 404
        if (!isset($this->user)) {
            $this->show404();
            return;
        }

        // check if order id is valid
        $order = UserOrder::findFirst(array("id = :id:", "bind" => array("id" => $orderid)));
        if ($order == FALSE) {
            $this->show404();
            return;
        }

        // we have to request pay order
        $orderObject = new Order($this->user->userid);
        $orderObject->PayOrder($this->errors, $order->id, 1);
    }

}
