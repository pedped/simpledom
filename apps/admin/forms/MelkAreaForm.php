<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class MelkAreaForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Melk ID
        $melkid = new TextElement('melkid');
        $melkid->setLabel('Melk ID');
        //$melkid->setAttribute('placeholder', 'Enter your Melk ID');
        $melkid->setAttribute('class', 'form-control');
        $melkid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkid);


        // Area ID
        $areaid = new TextElement('areaid');
        $areaid->setLabel('Area ID');
        //$areaid->setAttribute('placeholder', 'Enter your Area ID');
        $areaid->setAttribute('class', 'form-control');
        $areaid->addValidator(new PresenceOf(array(
        )));
        $this->add($areaid);


        // City ID
        $cityid = new TextElement('cityid');
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // By User ID
        $byuserid = new TextElement('byuserid');
        $byuserid->setLabel('By User ID');
        //$byuserid->setAttribute('placeholder', 'Enter your By User ID');
        $byuserid->setAttribute('class', 'form-control');
        $byuserid->addValidator(new PresenceOf(array(
        )));
        $this->add($byuserid);


        // IP
        $ip = new TextElement('ip');
        $ip->setLabel('IP');
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
        )));
        $this->add($ip);


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
