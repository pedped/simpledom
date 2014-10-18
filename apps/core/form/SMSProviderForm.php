<?php

namespace Simpledom\Core;

use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextAreaElement;
use TextElement;

class SMSProviderForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Name
        $name = new TextElement('name');
        $name->setLabel('Name');
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);


        // Description
        $description = new TextAreaElement('description');
        $description->setLabel('Description');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // Infos
        $infos = new \TextAreaElement('infos');
        $infos->setLabel('Infos');
        //$infos->setAttribute('placeholder', 'Enter your Infos');
        $infos->setAttribute('class', 'form-control');
        $infos->addValidator(new PresenceOf(array(
        )));
        $this->add($infos);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Website URL
        $websitename = new TextElement('websitename');
        $websitename->setLabel('Website URL');
        //$websitename->setAttribute('placeholder', 'Enter your Website URL');
        $websitename->setAttribute('class', 'form-control');
        $websitename->addValidator(new PresenceOf(array(
        )));
        $this->add($websitename);


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
