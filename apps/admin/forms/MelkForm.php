<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class MelkForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Valid Date
        $validdate = new TextElement('validdate');
        $validdate->setLabel('Valid Date');
        //$validdate->setAttribute('placeholder', 'Enter your Valid Date');
        $validdate->setAttribute('class', 'form-control');
        $validdate->addValidator(new PresenceOf(array(
        )));
        $this->add($validdate);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Type
        $melktypeid = new SelectElement('melktypeid', MelkType::find(), array(
            'using' => array('id', 'name')
        ));
        $melktypeid->setLabel('Type');
        //$melktypeid->setAttribute('placeholder', 'Enter your Type');
        $melktypeid->setAttribute('class', 'form-control');
        $melktypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melktypeid);


        // Purpose
        $melkpurposeid = new SelectElement('melkpurposeid', MelkPurpose::find(), array(
            'using' => array('id', 'name')
        ));
        $melkpurposeid->setLabel('Purpose');
        //$melkpurposeid->setAttribute('placeholder', 'Enter your Purpose');
        $melkpurposeid->setAttribute('class', 'form-control');
        $melkpurposeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkpurposeid);


        // Condition
        $melkconditionid = new SelectElement('melkconditionid', MelkCondition::find(), array(
            'using' => array('id', 'name')
        ));
        $melkconditionid->setLabel('Condition');
        //$melkconditionid->setAttribute('placeholder', 'Enter your Condition');
        $melkconditionid->setAttribute('class', 'form-control');
        $melkconditionid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkconditionid);


        // Home Size
        $home_size = new TextElement('home_size');
        $home_size->setLabel('Home Size');
        //$home_size->setAttribute('placeholder', 'Enter your Home Size');
        $home_size->setAttribute('class', 'form-control');
        $home_size->addValidator(new PresenceOf(array(
        )));
        $this->add($home_size);


        // Lot Size
        $lot_size = new TextElement('lot_size');
        $lot_size->setLabel('Lot Size');
        //$lot_size->setAttribute('placeholder', 'Enter your Lot Size');
        $lot_size->setAttribute('class', 'form-control');
        $lot_size->addValidator(new PresenceOf(array(
        )));
        $this->add($lot_size);


        // Sale Price
        $sale_price = new TextElement('sale_price');
        $sale_price->setLabel('Sale Price');
        //$sale_price->setAttribute('placeholder', 'Enter your Sale Price');
        $sale_price->setAttribute('class', 'form-control');
        $sale_price->addValidator(new PresenceOf(array(
        )));
        $this->add($sale_price);


        // Price Per Unit
        $price_per_unit = new TextElement('price_per_unit');
        $price_per_unit->setLabel('Price Per Unit');
        //$price_per_unit->setAttribute('placeholder', 'Enter your Price Per Unit');
        $price_per_unit->setAttribute('class', 'form-control');
        $price_per_unit->addValidator(new PresenceOf(array(
        )));
        $this->add($price_per_unit);


        // Ejare
        $rent_price = new TextElement('rent_price');
        $rent_price->setLabel('Ejare');
        //$rent_price->setAttribute('placeholder', 'Enter your Ejare');
        $rent_price->setAttribute('class', 'form-control');
        $rent_price->addValidator(new PresenceOf(array(
        )));
        $this->add($rent_price);


        // Rahn
        $rent_pricerahn = new TextElement('rent_pricerahn');
        $rent_pricerahn->setLabel('Rahn');
        //$rent_pricerahn->setAttribute('placeholder', 'Enter your Rahn');
        $rent_pricerahn->setAttribute('class', 'form-control');
        $rent_pricerahn->addValidator(new PresenceOf(array(
        )));
        $this->add($rent_pricerahn);


        // Bedrooms
        $bedroom = new SelectElement('bedroom');
        $bedroom->setLabel('Bedrooms');
        $bedroom->setOptions(array(
            "0" => "0",
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
            "11" => "بیشتر",
        ));
        //$bedroom->setAttribute('placeholder', 'Enter your Bedrooms');
        $bedroom->setAttribute('class', 'form-control');
        $bedroom->addValidator(new PresenceOf(array(
        )));
        $this->add($bedroom);


        // Bath
        $bath = new SelectElement('bath');
        $bath->setLabel('Bath');
        $bath->setOptions(array(
            "0" => "0",
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
            "11" => "بیشتر",
        ));
        //$bath->setAttribute('placeholder', 'Enter your Bath');
        $bath->setAttribute('class', 'form-control');
        $bath->addValidator(new PresenceOf(array(
        )));
        $this->add($bath);


        // State ID
        $stateid = new SelectElement('stateid', State::find(), array(
            'using' => array('id', 'name')
        ));
        $stateid->setLabel('State ID');
        //$stateid->setAttribute('placeholder', 'Enter your State ID');
        $stateid->setAttribute('class', 'form-control');
        $stateid->addValidator(new PresenceOf(array(
        )));
        $this->add($stateid);


        // City ID
        $cityid = new SelectElement('cityid', City::find(), array(
            'using' => array('id', 'name')
        ));
        $cityid->setLabel('City ID');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Create By
        $createby = new SelectElement('createby', MelkCreatedBy::find(), array(
            'using' => array('id', 'name')
        ));
        $createby->setLabel('Create By');
        //$createby->setAttribute('placeholder', 'Enter your Create By');
        $createby->setAttribute('class', 'form-control');
        $createby->addValidator(new PresenceOf(array(
        )));
        $this->add($createby);


        // Featured
        $featured = new SelectElement('featured');
        $featured->setOptions(array(
            "1" => "بله",
            "0" => "خیر",
        ));
        $featured->setLabel('Featured');
        //$featured->setAttribute('placeholder', 'Enter your Featured');
        $featured->setAttribute('class', 'form-control');
        $featured->addValidator(new PresenceOf(array(
        )));
        $this->add($featured);


        // Approved
        $approved = new SelectElement('approved');
        $approved->setLabel('Approved');
        $approved->setOptions(array(
            "1" => "بله",
            "0" => "خیر",
        ));
        //$approved->setAttribute('placeholder', 'Enter your Approved');
        $approved->setAttribute('class', 'form-control');
        $approved->addValidator(new PresenceOf(array(
        )));
        $this->add($approved);


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
