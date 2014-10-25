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
        $melkpurposeid = new SelectElement('melkpurposeid', MelkPurpose::find(), array(
            "using" => array("id", "name")
        ));
        $melkpurposeid->setLabel('Purpose ID');
        //$melkpurposeid->setAttribute('placeholder', 'Enter your Purpose ID');
        $melkpurposeid->setAttribute('class', 'form-control');
        $melkpurposeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkpurposeid);


        // Type ID
        $melktypeid = new SelectElement('melktypeid', MelkType::find(), array(
            "using" => array("id", "name")
        ));
        $melktypeid->setLabel('Type ID');
        //$melktypeid->setAttribute('placeholder', 'Enter your Type ID');
        $melktypeid->setAttribute('class', 'form-control');
        $melktypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melktypeid);


        // Bedroom Start
        $bedroom_start = new SelectElement('bedroom_start');
        $bedroom_start->setLabel('Bedroom Start');
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
        $bedroom_end->setLabel('Bedroom End');
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
        $receivedcount->setLabel('Received Count');
        //$receivedcount->setAttribute('placeholder', 'Enter your Received Count');
        $receivedcount->setAttribute('class', 'form-control');
        $receivedcount->addValidator(new PresenceOf(array(
        )));
        $this->add($receivedcount);


        // Status
        $status = new SelectElement('status');
        $status->setLabel('Status');
        $status->setOptions(array(
            "1" => "Enable",
            "0" => "Disable",
        ));
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // Rent Price Start
        $rent_price_start = new TextElement('rent_price_start');
        $rent_price_start->setLabel('Rent Price Start');
        //$rent_price_start->setAttribute('placeholder', 'Enter your Rent Price Start');
        $rent_price_start->setAttribute('class', 'form-control');
        $this->add($rent_price_start);


        // Rent Price End
        $rent_price_end = new TextElement('rent_price_end');
        $rent_price_end->setLabel('Rent Price End');
        //$rent_price_end->setAttribute('placeholder', 'Enter your Rent Price End');
        $rent_price_end->setAttribute('class', 'form-control');
        $this->add($rent_price_end);


        // Rahn Start
        $rent_pricerahn_start = new TextElement('rent_pricerahn_start');
        $rent_pricerahn_start->setLabel('Rahn Start');
        //$rent_pricerahn_start->setAttribute('placeholder', 'Enter your Rahn Start');
        $rent_pricerahn_start->setAttribute('class', 'form-control');
        $this->add($rent_pricerahn_start);


        // Rahn End
        $rent_pricerahn_end = new TextElement('rent_pricerahn_end');
        $rent_pricerahn_end->setLabel('Rahn End');
        //$rent_pricerahn_end->setAttribute('placeholder', 'Enter your Rahn End');
        $rent_pricerahn_end->setAttribute('class', 'form-control');
        $this->add($rent_pricerahn_end);


        // Sale Start
        $sale_price_start = new TextElement('sale_price_start');
        $sale_price_start->setLabel('Sale Start');
        //$sale_price_start->setAttribute('placeholder', 'Enter your Sale Start');
        $sale_price_start->setAttribute('class', 'form-control');
        $this->add($sale_price_start);


        // Sale End
        $sale_price_end = new TextElement('sale_price_end');
        $sale_price_end->setLabel('Sale End');
        //$sale_price_end->setAttribute('placeholder', 'Enter your Sale End');
        $sale_price_end->setAttribute('class', 'form-control');
        $this->add($sale_price_end);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // City ID
        $cityid = new SelectElement('cityid', City::find(), array(
            "using" => array("id", "name")
        ));
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
