<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class ProfileEditForm extends AtaForm {

    public function initialize() {



        // First Name
        $firstname = new Text("firstname");
        $firstname->setLabel(_("First Name"));
        $firstname->setAttribute("class", "form-control");
        $firstname->addValidator(new PresenceOf(array(
        )));
        $firstname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $firstname->setDefault($this->session->get("fname"));
        $this->add($firstname);



        // Last Name
        $lastname = new Text("lastname");
        $lastname->setLabel(_("Last Name"));
        $lastname->setAttribute("class", "form-control");
        $lastname->addValidator(new PresenceOf(array(
        )));
        $lastname->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $lastname->setDefault($this->session->get("lname"));
        $this->add($lastname);


        // Gender
        $gender = new Select("gender", array(
            '1' => 'Male',
            '0' => 'Female'
        ));
        $gender->setLabel(_("Gender"));
        $gender->setAttribute("class", "form-control");
        $gender->setDefault($this->session->get("gender"));
        $this->add($gender);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
