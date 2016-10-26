<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class WarehouseSectionForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Warehouse ID
        $warehouseid = new TextElement('warehouseid');
        $warehouseid->setLabel('Warehouse ID');
        //$warehouseid->setAttribute('placeholder', 'Enter your Warehouse ID');
        $warehouseid->setAttribute('class', 'form-control');
        $warehouseid->addValidator(new PresenceOf(array(
        )));
        $this->add($warehouseid);


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
