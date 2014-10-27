<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahForm extends AtaForm {

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


        // Shomare Peygiri
        $peygiri = new TextElement('peygiri');
        $peygiri->setLabel('Shomare Peygiri');
        //$peygiri->setAttribute('placeholder', 'Enter your Shomare Peygiri');
        $peygiri->setAttribute('class', 'form-control');
        $peygiri->addValidator(new PresenceOf(array(
        )));
        $this->add($peygiri);


        // First Name
        $fname = new TextElement('fname');
        $fname->setLabel('First Name');
        //$fname->setAttribute('placeholder', 'Enter your First Name');
        $fname->setAttribute('class', 'form-control');
        $fname->addValidator(new PresenceOf(array(
        )));
        $this->add($fname);


        // Last Name
        $lname = new TextElement('lname');
        $lname->setLabel('Last Name');
        //$lname->setAttribute('placeholder', 'Enter your Last Name');
        $lname->setAttribute('class', 'form-control');
        $lname->addValidator(new PresenceOf(array(
        )));
        $this->add($lname);


        // Address
        $address = new TextElement('address');
        $address->setLabel('Address');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // City
        $cityid = new TextElement('cityid');
        $cityid->setLabel('City');
        //$cityid->setAttribute('placeholder', 'Enter your City');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Latitude
        $latitude = new TextElement('latitude');
        $latitude->setLabel('Latitude');
        //$latitude->setAttribute('placeholder', 'Enter your Latitude');
        $latitude->setAttribute('class', 'form-control');
        $latitude->addValidator(new PresenceOf(array(
        )));
        $this->add($latitude);


        // Longitude
        $longitude = new TextElement('longitude');
        $longitude->setLabel('Longitude');
        //$longitude->setAttribute('placeholder', 'Enter your Longitude');
        $longitude->setAttribute('class', 'form-control');
        $longitude->addValidator(new PresenceOf(array(
        )));
        $this->add($longitude);


        // Locations Can Support
        $locationscansupport = new TextElement('locationscansupport');
        $locationscansupport->setLabel('Locations Can Support');
        //$locationscansupport->setAttribute('placeholder', 'Enter your Locations Can Support');
        $locationscansupport->setAttribute('class', 'form-control');
        $locationscansupport->addValidator(new PresenceOf(array(
        )));
        $this->add($locationscansupport);


        // Mobile
        $mobile = new TextElement('mobile');
        $mobile->setLabel('Mobile');
        //$mobile->setAttribute('placeholder', 'Enter your Mobile');
        $mobile->setAttribute('class', 'form-control');
        $mobile->addValidator(new PresenceOf(array(
        )));
        $this->add($mobile);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('Phone');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Enable
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('Enable');
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);


        // Featured
        $featured = new EnableDisableElement('featured');
        $featured->setLabel('Featured');
        //$featured->setAttribute('placeholder', 'Enter your Featured');
        $featured->setAttribute('class', 'form-control');
        $featured->addValidator(new PresenceOf(array(
        )));
        $this->add($featured);


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
