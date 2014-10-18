<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;


class PaymentTypeForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Key
        $key = new TextElement('key');
        $key->setLabel('Key');
        //$key->setAttribute('placeholder', 'Enter your Key');
        $key->setAttribute('class', 'form-control');
        $key->addValidator(new PresenceOf(array(
        )));
        $this->add($key);


        // Name
        $name = new TextElement('name');
        $name->setLabel('Name');
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);


        // Enable
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('Enable');
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
