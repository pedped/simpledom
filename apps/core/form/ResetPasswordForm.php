<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class ResetPasswordForm extends AtaForm {

    public function initialize() {

        // Password
        $password = new TextElement("newpassword");
        $password->setLabel("رمز عبور");
        $password->setAttribute("class", "form-control");
        $password->addValidator(new PresenceOf(array(
        )));
        $password->addValidator(new StringLength(array(
            'min' => 8
        )));
        $this->add($password);

        // Confirm Password
        $confirmnewpassword = new TextElement("newpasswordconfirm");
        $confirmnewpassword->setLabel("تکرار رمز عبور");
        $confirmnewpassword->setAttribute("class", "form-control");
        $confirmnewpassword->addValidator(new PresenceOf(array(
        )));
        $confirmnewpassword->addValidator(new StringLength(array(
            'min' => 8
        )));
        $this->add($confirmnewpassword);

        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", "تغییر رمز عبور");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
