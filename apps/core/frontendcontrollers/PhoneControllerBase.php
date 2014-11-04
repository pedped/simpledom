<?php

namespace Simpledom\Frontend\BaseControllers;

use Simpledom\Core\VerifyPhoneForm;
use UserPhone;

class PhoneControllerBase extends ControllerBase {

    public function invalidAction($phone) {
        
    }

    public function alreadyverifiedAction($phone) {
        
    }

    public function verifyAction($phone) {

        $this->view->show = 1;

        // check if the the phone belongs to user
        $userphone = UserPhone::find(array("userid = :userid: AND phone = :phone:", "bind" => array(
                        "userid" => $this->user->userid,
                        "phone" => $phone
        )));

        if ($userphone->count() == 0) {
            $this->flash->error(sprintf(_("Unable to find your phone number, or may be %s is not your phone"), $phone));
            $this->response->redirect("phone/invalid/" . $phone);
            $this->view->show = 0;
            return;
        }

        // check if already verified
        $uphone = $userphone->getFirst();
        if (intval($uphone->verified) == 1) {
            $this->response->redirect("phone/alreadyverified/" . $phone);
            $this->view->show = 0;
            return;
        }



        // check if the phone already verified
        // phone founded, we have to check if the phone is verifiyed
        $fr = new VerifyPhoneForm();

        // check if we have to resend the url
        if ($this->request->hasPost("resend")) {
            // send phone number
            if ($uphone->sendVerificationNumber()) {
                $this->flash->success(sprintf(_('"SMS Message has been sent to %s. Please check your phone and type your verification number here"'), $phone));
            }
        }

        // check if user entered any number
        if ($this->request->hasPost("verifycode")) {
            $userverifycode = $this->request->getPost("verifycode");
            $userPhone = UserPhone::findFirst(array("userid = :userid: AND phone = :phone:", "bind" => array(
                            "userid" => $this->user->userid,
                            "phone" => $phone
            )));

            // check if both items are equal
            if (intval($userverifycode) === intval($userPhone->verifycode)) {
                // verification equals to user eneterd number
                $userPhone->verified = "1";
                $userPhone->save();
                $this->flash->success(sprintf(_("Your Phone Number, %s, has been verified successfully"), $phone));
                $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "phones",
                    "params" => array()
                ));
            } else {
                // invalid number
                $this->flash->error(_("Invalid Number, Please Check Your SMS Again"));
            }
        }

        $this->view->form = $fr;
        $this->view->requestedPhone = $phone;
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
