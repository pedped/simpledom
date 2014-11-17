<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class MoshaverForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // City ID
        $cityid = new TextElement('cityid');
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Address
        $address = new TextAreaElement('address');
        $address->setLabel('Address');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('Phone');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Verified
        $verified = new EnableDisableElement('verified');
        $verified->setLabel('Verified');
        //$verified->setAttribute('placeholder', 'Enter your Verified');
        $verified->setAttribute('class', 'form-control');
        $verified->addValidator(new PresenceOf(array(
        )));
        $this->add($verified);


        // Moshaver Type
        $moshavertypeid = new SelectElement('moshavertypeid', MoshaverType::find(), array(
            "using" => array("id", "name")
        ));
        $moshavertypeid->setLabel('Moshaver Type');
        //$moshavertypeid->setAttribute('placeholder', 'Enter your Moshaver Type');
        $moshavertypeid->setAttribute('class', 'form-control');
        $moshavertypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($moshavertypeid);


        // Degree Type
        $degreetypeid = new SelectElement('degreetypeid', MoshaverDegree::find(), array(
            "using" => array("id", "name")
        ));
        $degreetypeid->setLabel('Degree Type');
        //$degreetypeid->setAttribute('placeholder', 'Enter your Degree Type');
        $degreetypeid->setAttribute('class', 'form-control');
        $degreetypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($degreetypeid);


        // Info
        $info = new TextElement('info');
        $info->setLabel('Info');
        //$info->setAttribute('placeholder', 'Enter your Info');
        $info->setAttribute('class', 'form-control');
        $info->addValidator(new PresenceOf(array(
        )));
        $this->add($info);


        // Status
        $status = new SelectElement('status', array(
            "-1" => "غیر فعال",
            "0" => "در انتظار تایید",
            "1" => "تایید و فعال شده",
        ));
        $status->setLabel('Status');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $this->add($status);


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
