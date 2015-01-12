<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CartForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Type
        $type = new TextElement('type');
        $type->setLabel('Type');
        //$type->setAttribute('placeholder', 'Enter your Type');
        $type->setAttribute('class', 'form-control');
        $type->addValidator(new PresenceOf(array(
        )));
        $this->add($type);


        // Value
        $value = new TextElement('value');
        $value->setLabel('Value');
        //$value->setAttribute('placeholder', 'Enter your Value');
        $value->setAttribute('class', 'form-control');
        $value->addValidator(new PresenceOf(array(
        )));
        $this->add($value);


        // Serial
        $serial = new TextAreaElement('serial');
        $serial->setLabel('Serial');
        //$serial->setAttribute('placeholder', 'Enter your Serial');
        $serial->setAttribute('class', 'form-control');
        $serial->addValidator(new PresenceOf(array(
        )));
        $this->add($serial);


        // Used
        $used = new EnableDisableElement('used');
        $used->setLabel('Used');
        //$used->setAttribute('placeholder', 'Enter your Used');
        $used->setAttribute('class', 'form-control');
        $used->addValidator(new PresenceOf(array(
        )));
        $this->add($used);


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
