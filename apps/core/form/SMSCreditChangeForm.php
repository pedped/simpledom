<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;

class SMSCreditChangeForm extends AtaForm {

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
        $this->add($userid);


        // SMS ID
        $smsid = new TextElement('smsid');
        $smsid->setLabel('SMS ID');
        //$smsid->setAttribute('placeholder', 'Enter your SMS ID');
        $smsid->setAttribute('class', 'form-control');
        $this->add($smsid);


        // Value
        $value = new TextElement('value');
        $value->setLabel('Value');
        //$value->setAttribute('placeholder', 'Enter your Value');
        $value->setAttribute('class', 'form-control');
        $value->addValidator(new PresenceOf(array(
        )));
        $this->add($value);


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
