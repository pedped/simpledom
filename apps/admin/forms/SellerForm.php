<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class SellerForm extends AtaForm {

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


        // Parent Seller
        $parent_seller = new TextElement('parent_seller');
        $parent_seller->setLabel('Parent Seller');
        //$parent_seller->setAttribute('placeholder', 'Enter your Parent Seller');
        $parent_seller->setAttribute('class', 'form-control');
        $parent_seller->addValidator(new PresenceOf(array(
        )));
        $this->add($parent_seller);


        // Type
        $type = new TextElement('type');
        $type->setLabel('Type');
        //$type->setAttribute('placeholder', 'Enter your Type');
        $type->setAttribute('class', 'form-control');
        $type->addValidator(new PresenceOf(array(
        )));
        $this->add($type);


        // Title
        $tite = new TextElement('title');
        $tite->setLabel('Title');
        //$tite->setAttribute('placeholder', 'Enter your Title');
        $tite->setAttribute('class', 'form-control');
        $tite->addValidator(new PresenceOf(array(
        )));
        $this->add($tite);


        // Description
        $description = new TextElement('description');
        $description->setLabel('Description');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $this->add($description);


        // City ID
        $cityid = new TextElement('cityid');
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
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


        // Address
        $address = new TextElement('address');
        $address->setLabel('Address');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('Phone');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Postal Code
        $postal_code = new TextElement('postal_code');
        $postal_code->setLabel('Postal Code');
        //$postal_code->setAttribute('placeholder', 'Enter your Postal Code');
        $postal_code->setAttribute('class', 'form-control');
        $this->add($postal_code);


        // Business Code
        $business_code = new TextElement('business_code');
        $business_code->setLabel('Business Code');
        //$business_code->setAttribute('placeholder', 'Enter your Business Code');
        $business_code->setAttribute('class', 'form-control');
        $this->add($business_code);


        // Fax
        $fax = new TextElement('fax');
        $fax->setLabel('Fax');
        //$fax->setAttribute('placeholder', 'Enter your Fax');
        $fax->setAttribute('class', 'form-control');
        $this->add($fax);


        // Image ID
        $imageid = new TextElement('imageid');
        $imageid->setLabel('Image ID');
        //$imageid->setAttribute('placeholder', 'Enter your Image ID');
        $imageid->setAttribute('class', 'form-control');
        $this->add($imageid);


        // Location Can Send
        $location_can_send = new TextElement('location_can_send');
        $location_can_send->setLabel('Location Can Send');
        //$location_can_send->setAttribute('placeholder', 'Enter your Location Can Send');
        $location_can_send->setAttribute('class', 'form-control');
        $this->add($location_can_send);


        // Status
        $status = new TextElement('status');
        $status->setLabel('Status');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


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
