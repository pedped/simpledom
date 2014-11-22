<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class OrganForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Name
        $name = new TextElement('name');
        $name->setLabel('Name');
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);


        // By User
        $byuserid = new TextElement('byuserid');
        $byuserid->setLabel('By User');
        //$byuserid->setAttribute('placeholder', 'Enter your By User');
        $byuserid->setAttribute('class', 'form-control');
        $byuserid->addValidator(new PresenceOf(array(
        )));
        $this->add($byuserid);


        // Address
        $address = new TextElement('address');
        $address->setLabel('Address');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);

        // SMS Number
        $smsNumber = new SelectElement('smsnumberid', SmsNumber::find(), array(
            "using" => array("id", "number")
        ));
        
        $smsNumber->setLabel('SMS Number');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $smsNumber->setAttribute('class', 'form-control');
        $this->add($smsNumber);


        // State ID
        $stateid = new TextElement('stateid');
        $stateid->setLabel('State ID');
        //$stateid->setAttribute('placeholder', 'Enter your State ID');
        $stateid->setAttribute('class', 'form-control');
        $stateid->addValidator(new PresenceOf(array(
        )));
        $this->add($stateid);


        // City ID
        $cityid = new TextElement('cityid');
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Description
        $description = new TextElement('description');
        $description->setLabel('Description');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // Phone Number
        $phonenumber = new TextElement('phonenumber');
        $phonenumber->setLabel('Phone Number');
        //$phonenumber->setAttribute('placeholder', 'Enter your Phone Number');
        $phonenumber->setAttribute('class', 'form-control');
        $phonenumber->addValidator(new PresenceOf(array(
        )));
        $this->add($phonenumber);


        // SMS Credit
        $smscredit = new TextElement('smscredit');
        $smscredit->setLabel('SMS Credit');
        //$smscredit->setAttribute('placeholder', 'Enter your SMS Credit');
        $smscredit->setAttribute('class', 'form-control');
        $smscredit->addValidator(new PresenceOf(array(
        )));
        $this->add($smscredit);


        // Interface URL
        $interfaceurl = new TextElement('interfaceurl');
        $interfaceurl->setLabel('Interface URL');
        //$interfaceurl->setAttribute('placeholder', 'Enter your Interface URL');
        $interfaceurl->setAttribute('class', 'form-control');
        $this->add($interfaceurl);


        // Use Interface
        $useinterface = new EnableDisableElement('useinterface');
        $useinterface->setLabel('Use Interface');
        //$useinterface->setAttribute('placeholder', 'Enter your Use Interface');
        $useinterface->setAttribute('class', 'form-control');
        $useinterface->addValidator(new PresenceOf(array(
        )));
        $this->add($useinterface);


        // Status
        $status = new TextElement('status');
        $status->setLabel('Status');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // Disable Message
        $disablemessage = new TextElement('disablemessage');
        $disablemessage->setLabel('Disable Message');
        //$disablemessage->setAttribute('placeholder', 'Enter your Disable Message');
        $disablemessage->setAttribute('class', 'form-control');
        $this->add($disablemessage);


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
