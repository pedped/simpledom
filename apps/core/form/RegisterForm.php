<?php

namespace Simpledom\Core;

use CheckElement;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use SelectElement;
use Settings;
use TextElement;

class RegisterForm extends AtaForm {

    public function initialize() {



        // First Name
        $firstname = new TextElement("firstname");
        $firstname->setLabel(_("First Name"));
        $firstname->setAttribute("class", "form-control");
        $firstname->addValidator(new PresenceOf(array(
        )));
        $firstname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($firstname);



        // Last Name
        $lastname = new TextElement("lastname");
        $lastname->setLabel(_("Last Name"));
        $lastname->setAttribute("class", "form-control");
        $lastname->addValidator(new PresenceOf(array(
        )));
        $lastname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($lastname);



        // Gender
        $gender = new SelectElement("gender", array(
            '1' => _('Male'),
            '0' => _('Female')
        ));
        $gender->setLabel(_("Gender"));
        $gender->setDefault("1");
        $gender->setAttribute("class", "form-control");
        $this->add($gender);

        // Agreement
        $agreement = new CheckElement("agreement");
        $agreement->setLabel(_("Agreement"));
        $agreement->setCheckboxText(sprintf(_("I Accept %s"), sprintf(_("<a target='_blank' href='../agreement/view/1'>%s</a>"), _("Signup Agreement"))));
//        $agreement->addValidator(new Identical(array(
//            "value" => "1",
//        )));
        $this->add($agreement);


        // ٍEmail
        $email = new TextElement("email");
        $email->setLabel(_("Email"));
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // Phone
        $phone = new TextElement("phone");
        $phone->setLabel(_("Phone"));
        $phone->setAttribute("class", "form-control");
        if (intval(Settings::Get()->requestuserphoneonregister) == 1) {
            $phone->addValidator(new PresenceOf(array(
            )));
        }
        $this->add($phone);


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
