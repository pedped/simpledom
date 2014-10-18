<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use SelectElement;
use Simpledom\Core\AtaForm;
use SMSProvider;
use TextAreaElement;
use TextElement;

class SmsNumberForm extends AtaForm {

    public function initialize() {

        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Number
        $number = new TextElement('number');
        $number->setLabel('Number');
        //$number->setAttribute('placeholder', 'Enter your Number');
        $number->setAttribute('class', 'form-control');
        $number->addValidator(new PresenceOf(array(
        )));
        $number->addValidator(new StringLength(array(
            'min' => 4
        )));
        $this->add($number);


        // Enable
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('Enable');
        $enable->setDefault("1");
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);


        // Sent Count
        $sentcount = new TextElement('sentcount');
        $sentcount->setLabel('Sent Count');
        //$sentcount->setAttribute('placeholder', 'Enter your Sent Count');
        $sentcount->setAttribute('class', 'form-control');
        $this->add($sentcount);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Description
        $description = new TextAreaElement('description');
        $description->setLabel('Description');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // Provider Name
        $providerid = new SelectElement('providerid', SMSProvider::find(), array(
            'using' => array('id', 'name')
        ));
        $providerid->setLabel('Provider Name');
        //$providerid->setAttribute('placeholder', 'Enter your Provider Name');
        $providerid->setAttribute('class', 'form-control');
        $providerid->addValidator(new PresenceOf(array(
        )));
        $this->add($providerid);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
