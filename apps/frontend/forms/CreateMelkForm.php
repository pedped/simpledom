<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CreateMelkForm extends AtaForm {

    public function initialize() {

        // Type
        $melktypeid = new SelectElement('melktypeid', MelkType::find(), array(
            'using' => array('id', 'name')
        ));
        $melktypeid->setLabel('نوع ملک');
        //$melktypeid->setAttribute('placeholder', 'Enter your Type');
        $melktypeid->setAttribute('class', 'form-control');
        $melktypeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melktypeid);


        // Purpose
        $melkpurposeid = new SelectElement('melkpurposeid', MelkPurpose::find(), array(
            'using' => array('id', 'name')
        ));
        $melkpurposeid->setLabel('منظور');
        //$melkpurposeid->setAttribute('placeholder', 'Enter your Purpose');
        $melkpurposeid->setAttribute('class', 'form-control');
        $melkpurposeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkpurposeid);



        // Home Size
        $home_size = new TextElement('home_size');
        $home_size->setLabel('زیربنا');
        //$home_size->setAttribute('placeholder', 'Enter your Home Size');
        $home_size->setAttribute('class', 'form-control');
        $this->add($home_size);


        // Lot Size
        $lot_size = new TextElement('lot_size');
        $lot_size->setLabel('متراژ زمین');
        //$lot_size->setAttribute('placeholder', 'Enter your Lot Size');
        $lot_size->setAttribute('class', 'form-control');
        $this->add($lot_size);


        // Sale Price
        $sale_price = new TextElement('sale_price');
        $sale_price->setLabel('قیمت فروش');
        //$sale_price->setAttribute('placeholder', 'Enter your Sale Price');
        $sale_price->setAttribute('class', 'form-control');
        $this->add($sale_price);



        // Ejare
        $rent_price = new TextElement('rent_price');
        $rent_price->setLabel('قیمت اجاره');
        //$rent_price->setAttribute('placeholder', 'Enter your Ejare');
        $rent_price->setAttribute('class', 'form-control');
        $this->add($rent_price);


        // Rahn
        $rent_pricerahn = new TextElement('rent_pricerahn');
        $rent_pricerahn->setLabel('قیمت رهن');
        //$rent_pricerahn->setAttribute('placeholder', 'Enter your Rahn');
        $rent_pricerahn->setAttribute('class', 'form-control');
        $this->add($rent_pricerahn);


        // Bedrooms
        $bedroom = new SelectElement('bedroom');
        $bedroom->setLabel('تعداد اتاق');
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
        $bath->setLabel('تعداد حمام و دستشویی');
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
        $stateid->setLabel('استان');
        //$stateid->setAttribute('placeholder', 'Enter your State ID');
        $stateid->setAttribute('class', 'form-control');
        $stateid->addValidator(new PresenceOf(array(
        )));
        $this->add($stateid);


        // City ID
        $cityid = new SelectElement('cityid', City::find(), array(
            'using' => array('id', 'name')
        ));
        $cityid->setLabel('شهر');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $cityid->addValidator(new PresenceOf(array(
        )));
        $this->add($cityid);


        // Address
        $address = new TextElement('address');
        $address->setLabel('خیابان اصلی');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // Private Phone
        $private_phone = new TextElement('private_phone');
        $private_phone->setLabel('تلفن تماس');
        //$private_phone->setAttribute('placeholder', 'Enter your Private Phone');
        $private_phone->setAttribute('class', 'form-control');
        $private_phone->addValidator(new PresenceOf(array(
        )));
        $this->add($private_phone);

        // Private Mobile
        $private_mobile = new TextElement('private_mobile');
        $private_mobile->setLabel('شماره موبایل');
        //$private_mobile->setAttribute('placeholder', 'Enter your Private Mobile');
        $private_mobile->setAttribute('class', 'form-control');
        $private_mobile->addValidator(new PresenceOf(array(
        )));
        $this->add($private_mobile);

        // Private Address
        $private_address = new TextAreaElement('private_address');
        $private_address->setLabel('آدرس دقیق ملک');
        //$private_address->setAttribute('placeholder', 'Enter your Private Address');
        $private_address->setAttribute('class', 'form-control');
        $private_address->addValidator(new PresenceOf(array(
        )));
        $this->add($private_address);


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

        $img7 = new FileElement('img7');
        $img7->setLabel('تصویر1');
        $this->add($img7);

        $img8 = new FileElement('img8');
        $img8->setLabel('تصویر1');
        $this->add($img8);


        $img9 = new FileElement('img9');
        $img9->setLabel('تصویر1');
        $this->add($img9);


        $img10 = new FileElement('img10');
        $img10->setLabel('تصویر1');
        $this->add($img10);


        $img11 = new FileElement('img11');
        $img11->setLabel('تصویر1');
        $this->add($img11);


        $img12 = new FileElement('img12');
        $img12->setLabel('تصویر1');
        $this->add($img12);

        // Location ON Map
        $map = new MapPickElement('map');
        $map->setLabel('موقعیت روی نقشه');
        $map->setLathitude("29.5");
        $map->setLongtude("52.6");
        $this->add($map);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-success btn-lg');
        $this->add($submit);
    }

}
