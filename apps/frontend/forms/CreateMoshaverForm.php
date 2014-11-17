<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CreateMoshaverForm extends AtaForm {

    public function initialize() {



        // City ID
        $cityid = new SelectElement('cityid', City::find(array("order" => "name ASC")), array(
            "using" => array("id", "name")
        ));
        $cityid->setLabel('شهر');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Address
        $address = new TextAreaElement('address');
        $address->setLabel('آدرس');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('شماره تماس موبایل');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);



        // Moshaver Type
        $moshavertypeid = new SelectElement('moshavertypeid', MoshaverType::find(), array(
            "using" => array("id", "name")
        ));
        $moshavertypeid->setLabel('عضویت در گروه مشاوران');
        //$moshavertypeid->setAttribute('placeholder', 'Enter your Moshaver Type');
        $moshavertypeid->setAttribute('class', 'form-control');
        $moshavertypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($moshavertypeid);


        // Degree Type
        $degreetypeid = new SelectElement('degreetypeid', MoshaverDegree::find(), array(
            "using" => array("id", "name")
        ));
        $degreetypeid->setLabel('آخرین مدرک دریافتی');
        //$degreetypeid->setAttribute('placeholder', 'Enter your Degree Type');
        $degreetypeid->setAttribute('class', 'form-control');
        $degreetypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($degreetypeid);


        // Info
        $info = new TextAreaElement('info');
        $info->setLabel('اطلاعات کلی در مورد شما');
        //$info->setAttribute('placeholder', 'Enter your Info');
        $info->setAttribute('class', 'form-control');
        $info->addValidator(new PresenceOf(array(
        )));
        $this->add($info);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('value', 'ارسال');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
