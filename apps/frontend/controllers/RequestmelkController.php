<?php

namespace Simpledom\Frontend\Controllers;

use City;
use MelkPhoneListner;
use Phalcon\Validation\Validator\PresenceOf;
use RequestMelkForm;
use Simpledom\Frontend\BaseControllers\ControllerBase;

class RequestmelkController extends ControllerBase {

    protected function ValidateAccess($id) {
        
    }

    public function addAction() {
        // show cities to view
        $this->view->cities = City::find();

        $fr = new RequestMelkForm();

        if (!isset($this->user)) {
            $fr->get("fname")->addValidator(new PresenceOf(array(
            )));

            $fr->get("lname")->addValidator(new PresenceOf(array(
            )));

            $fr->get("email")->addValidator(new PresenceOf(array(
            )));

            $fr->get("password")->addValidator(new PresenceOf(array(
            )));
        } else {
            $fr->remove("email");
            $fr->remove("password");
            $fr->remove("fname");
            $fr->remove("lname");
        }

        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
            } else {
                // valid request
                // we have to check if the user is logged in
                if (!isset($this->user)) {
                    // we need to create an account for the user
                    $user = new User();
                    $fname = $this->request->getPost("fname");
                    $lname = $this->request->getPost("lname");
                    $email = $this->request->getPost("email", "email");
                    $password = $this->request->getPost("password");
                    $phone = $this->request->getPost("phone");
                    $result = $user->registerAccount($this, $this->errors, $fname, $lname, 1, $email, $password, USERLEVEL_USER, $phone);
                    if (!$this->hasError() && $result == true) {
                        // user successfully created 
                        $this->user = $user;
                        $user->setSession($this);
                    }
                }

                // create listner
                $result = MelkPhoneListner::subscribeUser($this->errors, $this->user->userid, $this->request->getPost("mobile"));
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
                                $this->request->getPost("mobile")
                            )
                        ));
                    }
                } else {
                    // there is problem in adding item
                }
            }
        }

        $this->handleFormScripts($fr);
        $this->view->form = $fr;
    }

}
