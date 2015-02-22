<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ProductForm extends AtaForm {

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


        // Category ID
        $categoryid = new TextElement('categoryid');
        $categoryid->setLabel('Category ID');
        //$categoryid->setAttribute('placeholder', 'Enter your Category ID');
        $categoryid->setAttribute('class', 'form-control');
        $categoryid->addValidator(new PresenceOf(array(
        )));
        $this->add($categoryid);


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


        // Made By
        $country_who_made = new EnableDisableElement('country_who_made');
        $country_who_made->setLabel('Made By');
        //$country_who_made->setAttribute('placeholder', 'Enter your Made By');
        $country_who_made->setAttribute('class', 'form-control');
        $this->add($country_who_made);


        // Send Point
        $send_point = new TextElement('send_point');
        $send_point->setLabel('Send Point');
        //$send_point->setAttribute('placeholder', 'Enter your Send Point');
        $send_point->setAttribute('class', 'form-control');
        $this->add($send_point);


        // Price
        $price = new TextElement('price');
        $price->setLabel('Price');
        //$price->setAttribute('placeholder', 'Enter your Price');
        $price->setAttribute('class', 'form-control');
        $price->addValidator(new PresenceOf(array(
        )));
        $this->add($price);


        // Sale Price
        $sale_price = new TextElement('sale_price');
        $sale_price->setLabel('Sale Price');
        //$sale_price->setAttribute('placeholder', 'Enter your Sale Price');
        $sale_price->setAttribute('class', 'form-control');
        $this->add($sale_price);


        // Price Currency
        $currency = new TextElement('currency');
        $currency->setLabel('Price Currency');
        //$currency->setAttribute('placeholder', 'Enter your Price Currency');
        $currency->setAttribute('class', 'form-control');
        $currency->addValidator(new PresenceOf(array(
        )));
        $this->add($currency);


        // Minimum Request Count
        $min_request_count = new TextElement('min_request_count');
        $min_request_count->setLabel('Minimum Request Count');
        //$min_request_count->setAttribute('placeholder', 'Enter your Minimum Request Count');
        $min_request_count->setAttribute('class', 'form-control');
        $this->add($min_request_count);


        // Barcode Number
        $barcodenumber = new TextElement('barcodenumber');
        $barcodenumber->setLabel('Barcode Number');
        //$barcodenumber->setAttribute('placeholder', 'Enter your Barcode Number');
        $barcodenumber->setAttribute('class', 'form-control');
        $this->add($barcodenumber);


        // Color
        $color = new TextElement('color');
        $color->setLabel('Color');
        //$color->setAttribute('placeholder', 'Enter your Color');
        $color->setAttribute('class', 'form-control');
        $this->add($color);


        // UUID
        $uuid = new TextElement('uuid');
        $uuid->setLabel('UUID');
        //$uuid->setAttribute('placeholder', 'Enter your UUID');
        $uuid->setAttribute('class', 'form-control');
        $uuid->addValidator(new PresenceOf(array(
        )));
        $this->add($uuid);


        // Offline Add
        $offlineadd = new TextElement('offlineadd');
        $offlineadd->setLabel('Offline Add');
        //$offlineadd->setAttribute('placeholder', 'Enter your Offline Add');
        $offlineadd->setAttribute('class', 'form-control');
        $offlineadd->addValidator(new PresenceOf(array(
        )));
        $this->add($offlineadd);


        // Token
        $token = new TextElement('token');
        $token->setLabel('Token');
        //$token->setAttribute('placeholder', 'Enter your Token');
        $token->setAttribute('class', 'form-control');
        $token->addValidator(new PresenceOf(array(
        )));
        $this->add($token);


        // Featured
        $featured = new TextElement('featured');
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
        $date->addValidator(new PresenceOf(array(
        )));
        $this->add($date);


        // Order Request Instruction
        $order_request_instruction = new TextElement('order_request_instruction');
        $order_request_instruction->setLabel('Order Request Instruction');
        //$order_request_instruction->setAttribute('placeholder', 'Enter your Order Request Instruction');
        $order_request_instruction->setAttribute('class', 'form-control');
        $this->add($order_request_instruction);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
