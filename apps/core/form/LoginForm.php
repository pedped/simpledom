<?php

namespace Simpledom\Core;

use CheckElement;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use TextElement;

class LoginForm extends AtaForm {

    public function initialize() {

        // ٍEmail
        $email = new TextElement("email");
        $email->setLabel(_("Email"));
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // Remember
        $remmeber = new CheckElement("remember");
        $remmeber->setCheckboxText("مرا به خاطر بسپار");
        $remmeber->setAttribute("value", "1");
        $remmeber->setAttribute("checked", "checked");
        $this->add($remmeber);

        // Password
        $password = new Password("password");
        $password->setLabel(_("Password"));
        $password->setAttribute("class", "form-control");
        $password->addValidator(new PresenceOf(array(
        )));
//        $password->addValidator(new Between(array(
//            'max' => 50,
//            'min' => 8,
//            'messageMaximum' => 'The password should be at maximum 8 characters',
//            'messageMinimum' => 'The password should be at least 8 characters'
//        )));
        $this->add($password);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
