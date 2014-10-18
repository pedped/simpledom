<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use TextElement;
use UserOrder;

class UserOrderForm extends AtaForm {

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


        // Type
        $type = new TextElement('type');
        $type->setLabel('Type');
        //$type->setAttribute('placeholder', 'Enter your Type');
        $type->setAttribute('class', 'form-control');
        $type->addValidator(new PresenceOf(array(
        )));
//        $type->addValidator(new InclusionIn(array(
//            'domain' => array_keys(UserOrder::$TypeValues)
//        )));
        $this->add($type);


        // Item ID
        $itemid = new TextElement('itemid');
        $itemid->setLabel('Item ID');
        //$itemid->setAttribute('placeholder', 'Enter your Item ID');
        $itemid->setAttribute('class', 'form-control');
        $itemid->addValidator(new PresenceOf(array(
        )));
        $this->add($itemid);


        // Payment Product Type
        $paymenttype = new TextElement('paymenttype');
        $paymenttype->setLabel('Payment Product Type');
        //$paymenttype->setAttribute('placeholder', 'Enter your Payment Product Type');
        $paymenttype->setAttribute('class', 'form-control');
//        $paymenttype->addValidator(new InclusionIn(array(
//            'domain' => array_keys(UserOrder::$PaymentProductTypeValues)
//        )));
        $this->add($paymenttype);


        // Payment Item ID
        $paymentitemid = new TextElement('paymentitemid');
        $paymentitemid->setLabel('Payment Item ID');
        //$paymentitemid->setAttribute('placeholder', 'Enter your Payment Item ID');
        $paymentitemid->setAttribute('class', 'form-control');
        $this->add($paymentitemid);


        // price
        $price = new TextElement('price');
        $price->setLabel('price');
        //$price->setAttribute('placeholder', 'Enter your price');
        $price->setAttribute('class', 'form-control');
        $this->add($price);


        // Price Currency
        $pricecurrency = new TextElement('pricecurrency');
        $pricecurrency->setLabel('Price Currency');
        //$pricecurrency->setAttribute('placeholder', 'Enter your Price Currency');
        $pricecurrency->setAttribute('class', 'form-control');
        $this->add($pricecurrency);


        // date
        $date = new TextElement('date');
        $date->setLabel('date');
        //$date->setAttribute('placeholder', 'Enter your date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
