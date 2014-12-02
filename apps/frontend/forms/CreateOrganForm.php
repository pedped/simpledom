<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CreateOrganForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('شناسه');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Name
        $name = new TextElement('name');
        $name->setLabel('نام');
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);





        // Address
        $address = new TextElement('address');
        $address->setLabel('آدرس');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);

        // SMS Number
        $smsNumber = new SelectElement('smsnumberid', SmsNumber::find(), array(
            "using" => array("id", "number")
        ));
        
        $smsNumber->setLabel('شماره پیامک');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $smsNumber->setAttribute('class', 'form-control');
        $this->add($smsNumber);


        // State ID
        $stateid = new SelectElement('stateid', State::find(), array("using" => array("id", "name")));
        $stateid->setLabel('استان');
        //$stateid->setAttribute('placeholder', 'Enter your State ID');
        $stateid->setAttribute('class', 'form-control');
        $stateid->addValidator(new PresenceOf(array(
        )));
        $this->add($stateid);


        // City ID
        $cityid = new SelectElement('cityid' , City::find() , array(
            "using" => array("id" , "name")
        ));
        $cityid->setLabel('شهر');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Description
        $description = new TextElement('description');
        $description->setLabel('توضیحات');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // Phone Number
        $phonenumber = new TextElement('phonenumber');
        $phonenumber->setLabel('شماره تلفن');
        //$phonenumber->setAttribute('placeholder', 'Enter your Phone Number');
        $phonenumber->setAttribute('class', 'form-control');
        $phonenumber->addValidator(new PresenceOf(array(
        )));
        $this->add($phonenumber);


        // SMS Credit
        $smscredit = new TextElement('smscredit');
        $smscredit->setLabel('اعتبار پیامک');
        //$smscredit->setAttribute('placeholder', 'Enter your SMS Credit');
        $smscredit->setAttribute('class', 'form-control');
        $smscredit->addValidator(new PresenceOf(array(
        )));
        $this->add($smscredit);


        // Interface URL
        $interfaceurl = new TextElement('interfaceurl');
        $interfaceurl->setLabel(' درگاهURL');
        //$interfaceurl->setAttribute('placeholder', 'Enter your Interface URL');
        $interfaceurl->setAttribute('class', 'form-control');
        $this->add($interfaceurl);


        // Use Interface
        $useinterface = new EnableDisableElement('useinterface');
        $useinterface->setLabel('استقاده از اینترفیس');
        //$useinterface->setAttribute('placeholder', 'Enter your Use Interface');
        $useinterface->addValidator(new PresenceOf(array(
        )));
        $this->add($useinterface);


        // Status
        $status = new TextElement('status');
        $status->setLabel('وضعیت');
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
        $date->setLabel('تاریخ');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary btn-block');
        $submit->setAttribute('value', 'تایید');
        $this->add($submit);
    }

}
