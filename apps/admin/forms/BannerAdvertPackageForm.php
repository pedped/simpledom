<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BannerAdvertPackageForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Title
        $title = new TextElement('title');
        $title->setLabel('Title');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Description
        $description = new TextElement('description');
        $description->setLabel('Description');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // City ID
        $cityid = new TextElement('cityid');
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $this->add($cityid);


        // Price
        $price = new TextElement('price');
        $price->setLabel('Price');
        //$price->setAttribute('placeholder', 'Enter your Price');
        $price->setAttribute('class', 'form-control');
        $price->addValidator(new PresenceOf(array(
        )));
        $this->add($price);


        // Enable
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('Enable');
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);


        // Total Days
        $totaldays = new TextElement('totaldays');
        $totaldays->setLabel('Total Days');
        //$totaldays->setAttribute('placeholder', 'Enter your Total Days');
        $totaldays->setAttribute('class', 'form-control');
        $totaldays->addValidator(new PresenceOf(array(
        )));
        $this->add($totaldays);


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
