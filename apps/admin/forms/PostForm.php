<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class PostForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Organ ID
        $organid = new SelectElement('organid', Organ::find(), array(
            "using" => array("id", "name")
        ));
        $organid->setLabel('Organ ID');
        //$organid->setAttribute('placeholder', 'Enter your Organ ID');
        $organid->setAttribute('class', 'form-control');
        $organid->addValidator(new PresenceOf(array(
        )));
        $this->add($organid);


        // Name
        $name = new TextElement('name');
        $name->setLabel('Name');
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);


        // Key
        $key = new TextElement('key');
        $key->setLabel('Key');
        //$key->setAttribute('placeholder', 'Enter your Key');
        $key->setAttribute('class', 'form-control');
        $key->addValidator(new PresenceOf(array(
        )));
        $this->add($key);


        // SMS Key
        $smskey = new TextElement('smskey');
        $smskey->setLabel('SMS Key');
        //$smskey->setAttribute('placeholder', 'Enter your SMS Key');
        $smskey->setAttribute('class', 'form-control');
        $smskey->addValidator(new PresenceOf(array(
        )));
        $this->add($smskey);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
