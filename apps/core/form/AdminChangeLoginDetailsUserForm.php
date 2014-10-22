<?php

namespace Simpledom\Core;

use PasswordElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use TextElement;

class AdminChangeLoginDetailsUserForm extends AtaForm {

    public function initialize() {

        // ٍEmail
        $email = new TextElement("email");
        $email->setLabel(_("Email"));
        $email->setAttribute("placeholder", _("Enter Email"));
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // Password
        $password = new PasswordElement("password");
        $password->setLabel(_("Password"));
        $password->setAttribute("placeholder", _("Enter New Password"));
        $password->setAttribute("class", "form-control");
//        $password->addValidator(new Confirmation(array(
//            'with' => 'confirmpassword'
//        )));
        $this->add($password);

        $confirmpassword = new PasswordElement("confirmpassword");
        $confirmpassword->setLabel(_("Confirm Password"));
        $confirmpassword->setAttribute("placeholder",  _("Enter New Password Again"));
        $confirmpassword->setAttribute("class", "form-control");
        $this->add($confirmpassword);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
