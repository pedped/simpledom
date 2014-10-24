<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use TextElement;

class SentsmsForm extends AtaForm {

    public function initialize() {

        // ID
        $id = new TextElement('id');
        $id->setLabel(_('ID'));
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel(_('Phone'));
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Message
        $message = new TextElement('message');
        $message->setLabel(_('Message'));
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


        // From Number
        $fromnumber = new TextElement('fromnumber');
        $fromnumber->setLabel(_('From Number'));
        //$fromnumber->setAttribute('placeholder', 'Enter your From Number');
        $fromnumber->setAttribute('class', 'form-control');
        $fromnumber->addValidator(new PresenceOf(array(
        )));
        $this->add($fromnumber);


        // IP
        $ip = new TextElement('ip');
        $ip->setLabel(_('IP'));
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
        )));
        $this->add($ip);


        // Provider
        $provider = new TextElement('provider');
        $provider->setLabel(_('Provider'));
        //$provider->setAttribute('placeholder', 'Enter your Provider');
        $provider->setAttribute('class', 'form-control');
        $provider->addValidator(new PresenceOf(array(
        )));
        $this->add($provider);


        // Date
        $date = new TextElement('date');
        $date->setLabel(_('Date'));
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Result
        $result = new TextElement('result');
        $result->setLabel(_('Result'));
        //$result->setAttribute('placeholder', 'Enter your Result');
        $result->setAttribute('class', 'form-control');
        $this->add($result);


        // Reference Code
        $refcode = new TextElement('refcode');
        $refcode->setLabel(_('Reference Code'));
        //$refcode->setAttribute('placeholder', 'Enter your Reference Code');
        $refcode->setAttribute('class', 'form-control');
        $this->add($refcode);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
