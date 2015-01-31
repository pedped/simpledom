<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class PurchasedBannerForm extends AtaForm {

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


        // Valid Until
        $validuntil = new TextElement('validuntil');
        $validuntil->setLabel('Valid Until');
        //$validuntil->setAttribute('placeholder', 'Enter your Valid Until');
        $validuntil->setAttribute('class', 'form-control');
        $validuntil->addValidator(new PresenceOf(array(
        )));
        $this->add($validuntil);


        // Order ID
        $orderid = new TextElement('orderid');
        $orderid->setLabel('Order ID');
        //$orderid->setAttribute('placeholder', 'Enter your Order ID');
        $orderid->setAttribute('class', 'form-control');
        $orderid->addValidator(new PresenceOf(array(
        )));
        $this->add($orderid);


        // Advert ID
        $advertid = new TextElement('advertid');
        $advertid->setLabel('Advert ID');
        //$advertid->setAttribute('placeholder', 'Enter your Advert ID');
        $advertid->setAttribute('class', 'form-control');
        $advertid->addValidator(new PresenceOf(array(
        )));
        $this->add($advertid);


        // City ID
        $cityid = new TextElement('cityid');
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Image ID
        $imageid = new TextElement('imageid');
        $imageid->setLabel('Image ID');
        //$imageid->setAttribute('placeholder', 'Enter your Image ID');
        $imageid->setAttribute('class', 'form-control');
        $this->add($imageid);


        // Banner Type
        $banner_type = new TextElement('banner_type');
        $banner_type->setLabel('Banner Type');
        //$banner_type->setAttribute('placeholder', 'Enter your Banner Type');
        $banner_type->setAttribute('class', 'form-control');
        $banner_type->addValidator(new PresenceOf(array(
        )));
        $this->add($banner_type);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
