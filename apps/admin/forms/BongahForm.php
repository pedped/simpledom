<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahForm extends AtaForm {

    public function initialize() {


        // Title
        $title = new TextElement('title');
        $title->setLabel('نام مشاور املاک');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Shomare Peygiri
        $peygiri = new TextElement('peygiri');
        $peygiri->setLabel("شماره پیگیری");
        //$peygiri->setAttribute('placeholder', 'Enter your Shomare Peygiri');
        $peygiri->setAttribute('class', 'form-control');
        $peygiri->addValidator(new PresenceOf(array(
        )));
        $this->add($peygiri);


        // First Name
        $fname = new TextElement('fname');
        $fname->setLabel('نام');
        //$fname->setAttribute('placeholder', 'Enter your First Name');
        $fname->setAttribute('class', 'form-control');
        $fname->addValidator(new PresenceOf(array(
        )));
        $this->add($fname);


        // Last Name
        $lname = new TextElement('lname');
        $lname->setLabel('نام خانوادگی');
        //$lname->setAttribute('placeholder', 'Enter your Last Name');
        $lname->setAttribute('class', 'form-control');
        $lname->addValidator(new PresenceOf(array(
        )));
        $this->add($lname);


        // Address
        $address = new TextElement('address');
        $address->setLabel('آدرس');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // State ID
        $stateid = new SelectElement('stateid', State::find(), array("using" => array("id", "name")));
        $stateid->setLabel('استان');
        //$stateid->setAttribute('placeholder', 'Enter your City');
        $stateid->setAttribute('class', 'form-control');
        $stateid->addValidator(new PresenceOf(array(
        )));
        $this->add($stateid);

        // City
        $cityid = new SelectElement('cityid', City::find(), array("using" => array("id", "name")));
        $cityid->setLabel('شهر');
        //$cityid->setAttribute('placeholder', 'Enter your City');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Latitude
        $latitude = new MapPickElement('map');
        $latitude->setLabel("موقعیت روی نقشه");
        //$latitude->setAttribute('placeholder', 'Enter your Latitude');
        $latitude->setAttribute('class', 'form-control');
        $this->add($latitude);


        // Locations Can Support
        $locationscansupport = new CityAreaSelector('locationscansupport');
        $locationscansupport->setCityID('$("#cityid").val()');
        $locationscansupport->setLabel('مناطق قابل پوشش');
        //$locationscansupport->setAttribute('placeholder', 'Enter your Locations Can Support');
        $locationscansupport->setAttribute('class', 'form-control');
        $locationscansupport->addValidator(new PresenceOf(array(
        )));
        $this->add($locationscansupport);


        // Mobile
        $mobile = new TextElement('mobile');
        $mobile->setLabel('شماره موبایل');
        //$mobile->setAttribute('placeholder', 'Enter your Mobile');
        $mobile->setAttribute('class', 'form-control');
        $mobile->addValidator(new PresenceOf(array(
        )));
        $this->add($mobile);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('شماره تماس');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);

        // Enable
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('وضعیت');
        $enable->setOptions(array(
            "-1" => "در انتظار تایید",
            "0" => "غیر فعال",
            "1" => "فعال",
        ));
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);

        // Featured
        $featured = new EnableDisableElement('featured');
        $featured->setLabel('ویژه');
        //$featured->setAttribute('placeholder', 'Enter your Featured');
        $featured->setAttribute('class', 'form-control');
        $featured->addValidator(new PresenceOf(array(
        )));
        $this->add($featured);


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
