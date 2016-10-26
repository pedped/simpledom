<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class LoginRequestForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Device Model
        $devicemodel = new TextElement('devicemodel');
        $devicemodel->setLabel('Device Model');
        //$devicemodel->setAttribute('placeholder', 'Enter your Device Model');
        $devicemodel->setAttribute('class', 'form-control');
        $devicemodel->addValidator(new PresenceOf(array()));
        $this->add($devicemodel);


        // Device ID
        $deviceid = new TextElement('deviceid');
        $deviceid->setLabel('Device ID');
        //$deviceid->setAttribute('placeholder', 'Enter your Device ID');
        $deviceid->setAttribute('class', 'form-control');
        $deviceid->addValidator(new PresenceOf(array()));
        $this->add($deviceid);


        // Android Version Code
        $androidversioncode = new TextElement('androidversioncode');
        $androidversioncode->setLabel('Android Version Code');
        //$androidversioncode->setAttribute('placeholder', 'Enter your Android Version Code');
        $androidversioncode->setAttribute('class', 'form-control');
        $androidversioncode->addValidator(new PresenceOf(array()));
        $this->add($androidversioncode);


        // Phone Number
        $phonenumber = new TextElement('phonenumber');
        $phonenumber->setLabel('Phone Number');
        //$phonenumber->setAttribute('placeholder', 'Enter your Phone Number');
        $phonenumber->setAttribute('class', 'form-control');
        $phonenumber->addValidator(new PresenceOf(array()));
        $this->add($phonenumber);


        // Android Version Name
        $androidversionname = new TextElement('androidversionname');
        $androidversionname->setLabel('Android Version Name');
        //$androidversionname->setAttribute('placeholder', 'Enter your Android Version Name');
        $androidversionname->setAttribute('class', 'form-control');
        $androidversionname->addValidator(new PresenceOf(array()));
        $this->add($androidversionname);


        // IP
        $ip = new TextElement('ip');
        $ip->setLabel('IP');
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array()));
        $this->add($ip);


        // Token
        $token = new TextElement('token');
        $token->setLabel('Token');
        //$token->setAttribute('placeholder', 'Enter your Token');
        $token->setAttribute('class', 'form-control');
        $token->addValidator(new PresenceOf(array()));
        $this->add($token);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
