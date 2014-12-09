<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahImageForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Bongah ID
        $bongahid = new TextElement('bongahid');
        $bongahid->setLabel('Bongah ID');
        //$bongahid->setAttribute('placeholder', 'Enter your Bongah ID');
        $bongahid->setAttribute('class', 'form-control');
        $bongahid->addValidator(new PresenceOf(array(
        )));
        $this->add($bongahid);


        // Image ID
        $imageid = new TextElement('imageid');
        $imageid->setLabel('Image ID');
        //$imageid->setAttribute('placeholder', 'Enter your Image ID');
        $imageid->setAttribute('class', 'form-control');
        $imageid->addValidator(new PresenceOf(array(
        )));
        $this->add($imageid);


        // Delete
        $delete = new EnableDisableElement('delete');
        $delete->setLabel('Delete');
        //$delete->setAttribute('placeholder', 'Enter your Delete');
        $delete->setAttribute('class', 'form-control');
        $this->add($delete);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
