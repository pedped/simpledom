<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class MelkPhoneListnerForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Purpose ID
        $melkpurposeid = new SelectElement('melkpurposeid', array(
            "1" => "خرید",
            "2" => "رهن و اجاره",
        ));
        $melkpurposeid->setLabel('منظور');
        //$melkpurposeid->setAttribute('placeholder', 'Enter your Purpose ID');
        $melkpurposeid->setAttribute('class', 'form-control');
        $melkpurposeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkpurposeid);


        // Type ID
        $melktypeid = new SelectElement('melktypeid', MelkType::find(), array(
            "using" => array("id", "name")
        ));
        $melktypeid->setLabel('نوع ملک');
        //$melktypeid->setAttribute('placeholder', 'Enter your Type ID');
        $melktypeid->setAttribute('class', 'form-control');
        $melktypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melktypeid);


        // Bedroom Start
        $bedroom_start = new SelectElement('bedroom_start');
        $bedroom_start->setLabel('حداقل خواب');
        //$bedroom_start->setAttribute('placeholder', 'Enter your Bedroom Start');
        $bedroom_start->setAttribute('class', 'form-control');
        $bedroom_start->setOptions(array(
            "0" => "یک مورد را انتخاب نمایید",
            "1" => "1",
            "2" => "2",
            "3" => "3",
            "4" => "4",
            "5" => "5",
            "6" => "6",
            "7" => "7",
            "8" => "8",
            "9" => "9",
            "10" => "10",
        ));

        $this->add($bedroom_start);


        // Bedroom End
        $bedroom_end = new SelectElement('bedroom_end');
        $bedroom_end->setLabel('حداکثر خواب');
        //$bedroom_end->setAttribute('placeholder', 'Enter your Bedroom End');
        $bedroom_end->setAttribute('class', 'form-control');
        $bedroom_end->setOptions(array(
            "0" => "یک مورد را انتخاب نمایید",
            "1" => "1",
            "2" => "2",
            "3" => "3",
            "4" => "4",
            "5" => "5",
            "6" => "6",
            "7" => "7",
            "8" => "8",
            "9" => "9",
            "10" => "10",
        ));

        $this->add($bedroom_end);


        // Phone ID
        $phoneid = new TextElement('phoneid');
        $phoneid->setLabel('Phone ID');
        //$phoneid->setAttribute('placeholder', 'Enter your Phone ID');
        $phoneid->setAttribute('class', 'form-control');
        $phoneid->addValidator(new PresenceOf(array(
        )));
        $this->add($phoneid);


        // Received Count
        $receivedcount = new TextElement('receivedcount');
        $receivedcount->setLabel('تعداد پیامک های دریافتی');
        //$receivedcount->setAttribute('placeholder', 'Enter your Received Count');
        $receivedcount->setAttribute('class', 'form-control');
        $receivedcount->addValidator(new PresenceOf(array(
        )));
        $this->add($receivedcount);


        // Status
        $status = new SelectElement('status');
        $status->setLabel('وضعیت');
        $status->setOptions(array(
            "1" => "فعال",
            "0" => "غیر فعال",
        ));
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // Rent Price Start
        $rent_price_start = new TextElement('rent_price_start');
        $rent_price_start->setLabel('حداقل اجاره');
        //$rent_price_start->setAttribute('placeholder', 'Enter your Rent Price Start');
        $rent_price_start->setAttribute('class', 'form-control');
        $this->add($rent_price_start);


        // Rent Price End
        $rent_price_end = new TextElement('rent_price_end');
        $rent_price_end->setLabel('حداکثر اجاره');
        //$rent_price_end->setAttribute('placeholder', 'Enter your Rent Price End');
        $rent_price_end->setAttribute('class', 'form-control');
        $this->add($rent_price_end);


        // Rahn Start
        $rent_pricerahn_start = new TextElement('rent_pricerahn_start');
        $rent_pricerahn_start->setLabel('حداقل رهن');
        //$rent_pricerahn_start->setAttribute('placeholder', 'Enter your Rahn Start');
        $rent_pricerahn_start->setAttribute('class', 'form-control');
        $this->add($rent_pricerahn_start);


        // Rahn End
        $rent_pricerahn_end = new TextElement('rent_pricerahn_end');
        $rent_pricerahn_end->setLabel('حداکثر رهن');
        //$rent_pricerahn_end->setAttribute('placeholder', 'Enter your Rahn End');
        $rent_pricerahn_end->setAttribute('class', 'form-control');
        $this->add($rent_pricerahn_end);


        // Sale Start
        $sale_price_start = new TextElement('sale_price_start');
        $sale_price_start->setLabel('حداقل قیمت');
        //$sale_price_start->setAttribute('placeholder', 'Enter your Sale Start');
        $sale_price_start->setAttribute('class', 'form-control');
        $this->add($sale_price_start);


        // Sale End
        $sale_price_end = new TextElement('sale_price_end');
        $sale_price_end->setLabel('حداکثر قیمت');
        //$sale_price_end->setAttribute('placeholder', 'Enter your Sale End');
        $sale_price_end->setAttribute('class', 'form-control');
        $this->add($sale_price_end);


        // Date
        $date = new TextElement('date');
        $date->setLabel('تاریخ');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


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
        $address = new CityAreaSelector('address');
        $address->setLabel('مناطق درخواستی');
        $address->setCityID("$('#cityid').val()");
        $address->setInfo("نام مناطقی که به دنبال ملک می گردید را وارد نمایید");
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
//        $address->addValidator(new PresenceOf(array(
//        )));
        $this->add($address);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $submit->setAttribute('value', 'ارسال');
        $this->add($submit);
    }

}
