<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use SelectElement;
use SmsNumber;
use TextAreaElement;

class SendSMSForm extends AtaForm {

    public function initialize() {

        // Phone
        $phone = new TextAreaElement('phones');
        $phone->setLabel('Phone');
        $phone->setAttribute('placeholder', 'Enter comma to send more than one phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Message
        $message = new TextAreaElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


        // From Number
        $fromnumber = new SelectElement('fromnumber', SmsNumber::find(), array(
            "using" => array("id", "number")
        ));
        $fromnumber->setLabel('From Number');
        $fromnumber->setAttribute('class', 'form-control');
        $fromnumber->addValidator(new PresenceOf(array(
        )));
        $this->add($fromnumber);


        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
