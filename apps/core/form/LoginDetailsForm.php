<?php

use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class LoginDetailsForm extends AtaForm {

    public function initialize() {


        // ٍEmail
        $email = new Text("email");
        $email->setLabel(_("Email"));
        $email->setAttribute("disabled", "true");
        $email->setAttribute("class", "form-control disabled");
        $this->add($email);


        // Password
        $password = new Password("password");
        $password->setLabel(_("Current Password"));
        $password->setAttribute("class", "form-control");
        $password->addValidator(new PresenceOf(array(
        )));
        $this->add($password);

        // New Password
        $newpassword = new Password("newpassword");
        $newpassword->setLabel(_("New Password"));
        $newpassword->setAttribute("class", "form-control");
        $newpassword->addValidator(new PresenceOf(array(
        )));
        $this->add($newpassword);

        // New Password Confirm
        $newpasswordconfirm = new Password("newpasswordconfirm");
        $newpasswordconfirm->setLabel(_("Confirm New Password"));
        $newpasswordconfirm->setAttribute("class", "form-control");
        $newpasswordconfirm->addValidator(new PresenceOf(array(
        )));
        $this->add($newpasswordconfirm);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
