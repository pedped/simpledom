<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class SellerImageForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Seller ID
        $seller_id = new TextElement('seller_id');
        $seller_id->setLabel('Seller ID');
        //$seller_id->setAttribute('placeholder', 'Enter your Seller ID');
        $seller_id->setAttribute('class', 'form-control');
        $seller_id->addValidator(new PresenceOf(array(
        )));
        $this->add($seller_id);


        // Image ID
        $imageid = new TextElement('imageid');
        $imageid->setLabel('Image ID');
        //$imageid->setAttribute('placeholder', 'Enter your Image ID');
        $imageid->setAttribute('class', 'form-control');
        $imageid->addValidator(new PresenceOf(array(
        )));
        $this->add($imageid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Status
        $status = new TextElement('status');
        $status->setLabel('Status');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
