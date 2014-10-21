<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextAreaElement;

class ViewUserForm extends AtaForm {

    public function initialize() {



        // First Name
        $firstname = new Text("firstname");
        $firstname->setLabel("First Name");
        $firstname->setAttribute("placeholder", "Enter your First Name");
        $firstname->setAttribute("class", "form-control");
        $firstname->addValidator(new PresenceOf(array(
        )));
        $firstname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($firstname);



        // Last Name
        $lastname = new Text("lastname");
        $lastname->setLabel("Last Name");
        $lastname->setAttribute("placeholder", "Enter your Last Name");
        $lastname->setAttribute("class", "form-control");
        $lastname->addValidator(new PresenceOf(array(
        )));
        $lastname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($lastname);


        // Gender
        $gender = new Select("gender", array(
            '1' => 'Male',
            '0' => 'Female'
        ));
        $gender->setLabel("Gender");
        $gender->setAttribute("class", "form-control");
        $this->add($gender);


        // Active
        $active = new EnableDisableElement("active");
        $active->setLabel("Active");
        $active->setAttribute("class", "form-control");
        $this->add($active);

        // Verify
        $verify = new EnableDisableElement("verify");
        $verify->setLabel("Verified");
        $verify->setAttribute("class", "form-control");
        $this->add($verify);


        // Disable Message
        $disablemessage = new TextAreaElement("disablemessage");
        $disablemessage->setLabel("Disabled Account Message");
        $disablemessage->setAttribute("placeholder", "When you make user offline, you may use offline message for the user");
        $disablemessage->setAttribute("class", "form-control");
        $this->add($disablemessage);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
