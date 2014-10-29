<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CreateBongahForm extends AtaForm {

    public function initialize() {

        // Title
        $title = new TextElement('title');
        $title->setLabel('نام بنگاه');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Shomare Peygiri
        $peygiri = new TextElement('peygiri');
        $peygiri->setLabel('شماره پیگیری بنگاه');
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
        $locationscansupport = new TagEditElement('locationscansupport');
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




        // Image File One
        $img1 = new FileElement('img1');
        $img1->setLabel('تصویر1');
        $this->add($img1);


        $img2 = new FileElement('img2');
        $img2->setLabel('تصویر1');
        $this->add($img2);

        $img3 = new FileElement('img3');
        $img3->setLabel('تصویر1');
        $this->add($img3);

        $img4 = new FileElement('img4');
        $img4->setLabel('تصویر1');
        $this->add($img4);

        $img5 = new FileElement('img5');
        $img5->setLabel('تصویر1');
        $this->add($img5);

        $img6 = new FileElement('img6');
        $img6->setLabel('تصویر1');
        $this->add($img6);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute('value', 'ارسال');
        $submit->setAttribute('class', 'btn btn-success btn-lg');
        $this->add($submit);
    }

}
