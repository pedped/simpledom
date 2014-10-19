<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextElement;

class UserPhoneForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $userid->addValidator(new StringLength(array(
            'min' => 5
        )));
        $this->add($userid);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('Phone');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Verify Code
        $verifycode = new TextElement('verifycode');
        $verifycode->setLabel('Verify Code');
        //$verifycode->setAttribute('placeholder', 'Enter your Verify Code');
        $verifycode->setAttribute('class', 'form-control');
        $verifycode->addValidator(new PresenceOf(array(
        )));
        $this->add($verifycode);


        // Verified
        $verified = new EnableDisableElement('verified');
        $verified->setLabel('Verified');
        //$verified->setAttribute('placeholder', 'Enter your Verified');
        $verified->setAttribute('class', 'form-control');
        $verified->addValidator(new PresenceOf(array(
        )));
        $this->add($verified);


        // Last SMS Sent Date
        $lastsmsdate = new TextElement('lastsmsdate');
        $lastsmsdate->setLabel('Last SMS Sent Date');
        //$lastsmsdate->setAttribute('placeholder', 'Enter your Last SMS Sent Date');
        $lastsmsdate->setAttribute('class', 'form-control');
        $lastsmsdate->addValidator(new PresenceOf(array(
        )));
        $this->add($lastsmsdate);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
