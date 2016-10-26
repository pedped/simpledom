<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class WarehouseForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);



        // Latitude
        $map = new MapPickElement('map');
        $map->setLongtude("52.5837");
        $map->setLathitude("29.5918");
        $map->setLabel("موقعیت روی نقشه");
        //$latitude->setAttribute('placeholder', 'Enter your Latitude');
        $map->setAttribute('class', 'form-control');
        $this->add($map);

//        // Longitude
//        $longitude = new TextElement('longitude');
//        $longitude->setLabel('Longitude');
//        //$longitude->setAttribute('placeholder', 'Enter your Longitude');
//        $longitude->setAttribute('class', 'form-control');
//        $longitude->addValidator(new PresenceOf(array(
//        )));
//        $this->add($longitude);
//
//
//        // Latitude
//        $latitude = new TextElement('latitude');
//        $latitude->setLabel('Latitude');
//        //$latitude->setAttribute('placeholder', 'Enter your Latitude');
//        $latitude->setAttribute('class', 'form-control');
//        $latitude->addValidator(new PresenceOf(array(
//        )));
//        $this->add($latitude);
        // Address
        $address = new TextAreaElement('address');
        $address->setLabel('آدرس');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


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


        // Status
        $status = new EnableDisableElement('status');
        $status->setLabel('وضعیت');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
