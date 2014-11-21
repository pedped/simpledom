<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class MoshaverSettingsForm extends AtaForm {

    public function initialize() {



        // State ID
        $stateid = new SelectElement('stateid', State::find(), array(
            "using" => array("id", "name")
        ));
        $stateid->setLabel('استان');
        //$stateid->setAttribute('placeholder', 'Enter your City ID');
        $stateid->setAttribute('class', 'form-control');
        $stateid->addValidator(new PresenceOf(array(
        )));
        $this->add($stateid);

        // City ID
        $cityid = new SelectElement('cityid', City::find(), array(
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
        $phone->setLabel('شماره تماس');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);



        // Moshaver Type
        $moshavertypeid = new SelectElement('moshavertypeid', MoshaverType::find(), array(
            "using" => array("id", "name")
        ));
        $moshavertypeid->setLabel('نوع مشاوره');
        //$moshavertypeid->setAttribute('placeholder', 'Enter your Moshaver Type');
        $moshavertypeid->setAttribute('class', 'form-control');
        $moshavertypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($moshavertypeid);


        // Degree Type
        $degreetypeid = new SelectElement('degreetypeid', MoshaverDegree::find(), array(
            "using" => array("id", "name")
        ));
        $degreetypeid->setLabel('آخرین مدرک تحصیلی');
        //$degreetypeid->setAttribute('placeholder', 'Enter your Degree Type');
        $degreetypeid->setAttribute('class', 'form-control');
        $degreetypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($degreetypeid);


        // Info
        $info = new TextAreaElement('info');
        $info->setLabel('اطلاعات');
        //$info->setAttribute('placeholder', 'Enter your Info');
        $info->setAttribute('rows', '8');
        $info->setAttribute('class', 'form-control');
        $info->addValidator(new PresenceOf(array(
        )));
        $this->add($info);


        // Map
        $map = new MapPickElement('map');
        $map->setLabel('موقعیت مطب/ شما بر روی نقشه');
        $map->setInfo("با استفاده از ماوس، موقعیت دقیق خود را بر روی نقشه مشخص نمایید");
        //$map->setAttribute('placeholder', 'Enter your Info');
        $map->setAttribute('class', 'form-control');
        $this->add($map);


        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $submit->setAttribute('value', 'ارسال');
        $this->add($submit);
    }

}
