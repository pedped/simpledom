<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class AccountForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Title
        $title = new TextElement('title');
        $title->setLabel('عنوان');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Price
        $price = new TextElement('price');
        $price->setLabel('قیمت به ریال');
        //$price->setAttribute('placeholder', 'Enter your Price');
        $price->setAttribute('class', 'form-control');
        $price->addValidator(new PresenceOf(array(
        )));
        $this->add($price);


        // Credit
        $credit = new TextElement('credit');
        $credit->setLabel('اعتبار');
        //$credit->setAttribute('placeholder', 'Enter your Credit');
        $credit->setAttribute('class', 'form-control');
        $credit->addValidator(new PresenceOf(array(
        )));
        $this->add($credit);


        // Date
        $date = new TextElement('date');
        $date->setLabel('تاریخ');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Enable
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('فعال');
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
