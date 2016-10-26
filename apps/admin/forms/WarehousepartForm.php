<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class WarehousepartForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('کد');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Warehouse Section ID
        $warehousesectionid = new TextElement('warehousesectionid');
        $warehousesectionid->setLabel('برش انبار');
        //$warehousesectionid->setAttribute('placeholder', 'Enter your Warehouse Section ID');
        $warehousesectionid->setAttribute('class', 'form-control');
        $warehousesectionid->addValidator(new PresenceOf(array(
        )));
        $this->add($warehousesectionid);


        // Status
        $status = new EnableDisableElement('status');
        $status->setLabel('وضعیت');
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
