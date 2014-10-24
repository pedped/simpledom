<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class MelkInfoForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Melk ID
        $melkid = new TextElement('melkid');
        $melkid->setLabel('Melk ID');
        //$melkid->setAttribute('placeholder', 'Enter your Melk ID');
        $melkid->setAttribute('class', 'form-control');
        $melkid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkid);


        // Address
        $address = new TextElement('address');
        $address->setLabel('Address');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


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


        // Facilities
        $facilities = new TextElement('facilities');
        $facilities->setLabel('Facilities');
        //$facilities->setAttribute('placeholder', 'Enter your Facilities');
        $facilities->setAttribute('class', 'form-control');
        $facilities->addValidator(new PresenceOf(array(
        )));
        $this->add($facilities);


        // Total View
        $total_view = new TextElement('total_view');
        $total_view->setLabel('Total View');
        //$total_view->setAttribute('placeholder', 'Enter your Total View');
        $total_view->setAttribute('class', 'form-control');
        $total_view->addValidator(new PresenceOf(array(
        )));
        $this->add($total_view);


        // Search Meta Information
        $search_meta = new TextElement('search_meta');
        $search_meta->setLabel('Search Meta Information');
        //$search_meta->setAttribute('placeholder', 'Enter your Search Meta Information');
        $search_meta->setAttribute('class', 'form-control');
        $search_meta->addValidator(new PresenceOf(array(
        )));
        $this->add($search_meta);


        // Private Phone
        $private_phone = new TextElement('private_phone');
        $private_phone->setLabel('Private Phone');
        //$private_phone->setAttribute('placeholder', 'Enter your Private Phone');
        $private_phone->setAttribute('class', 'form-control');
        $private_phone->addValidator(new PresenceOf(array(
        )));
        $this->add($private_phone);


        // Private Mobile
        $private_mobile = new TextElement('private_mobile');
        $private_mobile->setLabel('Private Mobile');
        //$private_mobile->setAttribute('placeholder', 'Enter your Private Mobile');
        $private_mobile->setAttribute('class', 'form-control');
        $private_mobile->addValidator(new PresenceOf(array(
        )));
        $this->add($private_mobile);


        // Private Address
        $private_address = new TextElement('private_address');
        $private_address->setLabel('Private Address');
        //$private_address->setAttribute('placeholder', 'Enter your Private Address');
        $private_address->setAttribute('class', 'form-control');
        $private_address->addValidator(new PresenceOf(array(
        )));
        $this->add($private_address);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
