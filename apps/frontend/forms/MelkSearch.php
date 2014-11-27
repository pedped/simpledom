<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class MelkSearch extends AtaForm {

    public function initialize() {



        $largePriceOptions = array();
        $largePriceOptions[-1] = "یک مورد را انتخاب نمایید";
        for ($index = 10; $index < 100; $index = $index + 10) {
            $largePriceOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 100; $index < 300; $index = $index + 25) {
            $largePriceOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 300; $index < 500; $index = $index + 50) {
            $largePriceOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 500; $index < 1000; $index = $index + 100) {
            $largePriceOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 1; $index < 20.5; $index = $index + 0.5) {
            $largePriceOptions[$index * 1000] = "$index میلیارد تومان";
        }
        $largePriceOptions[20.5 * 1000] = "بیشتر";



        $smallPricingOptions = array();
        $smallPricingOptions[-1] = "یک مورد را انتخاب نمایید";
        for ($index = 50; $index < 1000; $index = $index + 50) {
            $smallPricingOptions[($index / 1000) . ""] = "$index هزار تومان";
        }
        for ($index = 1; $index < 5; $index = $index + 0.25) {
            $smallPricingOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 5; $index < 20; $index = $index + 1) {
            $smallPricingOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 20; $index < 50; $index = $index + 5) {
            $smallPricingOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 50; $index < 100; $index = $index + 10) {
            $smallPricingOptions[$index] = "$index میلیون تومان";
        }
        for ($index = 100; $index < 500; $index = $index + 50) {
            $smallPricingOptions[$index] = "$index میلیون تومان";
        }
        $smallPricingOptions[800000] = "بیشتر";


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
        $melkpurposeid = new SelectElement('melkpurposeid');
        $melkpurposeid->setLabel('منظور');
        $melkpurposeid->setOptions(array(
            "1" => "خرید",
            "2" => "رهن و اجاره",
        ));
        //$melkpurposeid->setAttribute('placeholder', 'Enter your Purpose');
        $melkpurposeid->setAttribute('class', 'form-control');
        $melkpurposeid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkpurposeid);

        // Sale Price
        $sale_price_start = new SelectElement('sale_price_start');
        $sale_price_start->setLabel('حداقل قیمت');
        $sale_price_start->setOptions($largePriceOptions);
        //$sale_price->setAttribute('placeholder', 'Enter your Sale Price');
        $sale_price_start->setAttribute('class', 'form-control');
        $sale_price_start->addValidator(new PresenceOf(array(
        )));
        $this->add($sale_price_start);


        $sale_price_end = new SelectElement('sale_price_end');
        $sale_price_end->setLabel('حداکثر قیمت');
        $sale_price_end->setOptions($largePriceOptions);
        //$sale_price->setAttribute('placeholder', 'Enter your Sale Price');
        $sale_price_end->setAttribute('class', 'form-control');
        $sale_price_end->setAttribute('size', '1');
        $sale_price_end->addValidator(new PresenceOf(array(
        )));
        $this->add($sale_price_end);



        // Ejare
        $rent_price_start = new SelectElement('rent_price_start');
        $rent_price_start->setOptions($smallPricingOptions);
        $rent_price_start->setLabel('حداقل اجاره ماهیانه');
        //$rent_price->setAttribute('placeholder', 'Enter your Ejare');
        $rent_price_start->setAttribute('class', 'form-control');
        $rent_price_start->addValidator(new PresenceOf(array(
        )));
        $this->add($rent_price_start);

        $rent_price_end = new SelectElement('rent_price_end');
        $rent_price_end->setOptions($smallPricingOptions);
        $rent_price_end->setLabel('حداکثر اجاره ماهیانه');
        //$rent_price->setAttribute('placeholder', 'Enter your Ejare');
        $rent_price_end->setAttribute('class', 'form-control');
        $rent_price_end->addValidator(new PresenceOf(array(
        )));
        $this->add($rent_price_end);
        $rent_price_start->setDefault(-1);
        $rent_price_end->setDefault(-1);




        // Rahn
        $rent_pricerahn_start = new SelectElement('rent_pricerahn_start');
        $rent_pricerahn_start->setLabel("حداقل رهن");
        $rent_pricerahn_start->setOptions($largePriceOptions);
        //$rent_pricerahn->setAttribute('placeholder', 'Enter your Rahn');
        $rent_pricerahn_start->setAttribute('class', 'form-control');
        $rent_pricerahn_start->addValidator(new PresenceOf(array(
        )));
        $this->add($rent_pricerahn_start);


        $rent_pricerahn_end = new SelectElement('rent_pricerahn_end');
        $rent_pricerahn_end->setLabel("حداکثر رهن");
        $rent_pricerahn_end->setOptions($largePriceOptions);
        //$rent_pricerahn->setAttribute('placeholder', 'Enter your Rahn');
        $rent_pricerahn_end->setAttribute('class', 'form-control');
        $rent_pricerahn_end->addValidator(new PresenceOf(array(
        )));
        $this->add($rent_pricerahn_end);

        // Bedrooms
        $bedroom_start = new SelectElement('bedroom_start');
        $bedroom_start->setLabel('حداقل تعداد اتاق خواب');
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



        //$bedroom->setAttribute('placeholder', 'Enter your Bedrooms');
        $bedroom_start->setAttribute('class', 'form-control');
        $bedroom_start->addValidator(new PresenceOf(array(
        )));
        $this->add($bedroom_start);


        // Bedrooms
        $bedroom_end = new SelectElement('bedroom_end');
        $bedroom_end->setLabel('حداکثر تعداد اتاق خواب');
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
            "11" => "بیشتر",
        ));
        $bedroom_end->setAttribute('class', 'form-control');
        $bedroom_end->addValidator(new PresenceOf(array(
        )));
        $this->add($bedroom_end);


        // Sale Range
        $salerange = new RangeSlider('sale_range');
        $salerange->setMin(0);
        $salerange->setMax(500);
        $salerange->setCurrentMinValue(0);
        $salerange->setCurrentMaxValue(500);
        $salerange->setBetweenRangeTitle("تا");
        $salerange->setLabel('بازه قیمت');
        $salerange->setOnSlide("
                $('#sale_range_range_start_info').text(getIranianPrice(endValue));
                $('#sale_range_range_end_info').text(getIranianPrice(startValue));
            ");
        $this->add($salerange);

        // Bedroom Range
        $bedroomrange = new RangeSlider('bedroom_range');
        $bedroomrange->setLabel('تعداد اتاق');
        $bedroomrange->setMin(0);
        $bedroomrange->setMax(10);
        $bedroomrange->setCurrentMinValue(0);
        $bedroomrange->setCurrentMaxValue(10);
        $bedroomrange->setOnSlide("
                $('#bedroom_range_range_end_info').text(startValue);
                $('#bedroom_range_range_start_info').text(endValue);
                $('#bedroom_range_range_end_info').text( startValue +  ' ' + 'خواب');
            ");
        $bedroomrange->setBetweenRangeTitle("تا");
        $this->add($bedroomrange);

        // Ejare Range
        $ejarerange = new RangeSlider('ejare_range');
        $ejarerange->setMin(0);
        $ejarerange->setMax(500);
        $ejarerange->setCurrentMinValue(0);
        $ejarerange->setCurrentMaxValue(500);
        $ejarerange->setBetweenRangeTitle("تا");
        $ejarerange->setLabel('بازه اجاره');
        $ejarerange->setOnSlide("
                $('#ejare_range_range_start_info').text(getIranianPrice(endValue));
                $('#ejare_range_range_end_info').text(getIranianPrice(startValue));
            ");
        $this->add($ejarerange);

        // Rahn Range
        $rahnrange = new RangeSlider('rahn_range');
        $rahnrange->setMin(0);
        $rahnrange->setMax(1000);
        $rahnrange->setCurrentMinValue(0);
        $rahnrange->setCurrentMaxValue(1000);
        $rahnrange->setBetweenRangeTitle("تا");
        $rahnrange->setLabel('بازه رهن');
        $rahnrange->setOnSlide("
                $('#rahn_range_range_start_info').text(getIranianPrice(endValue));
                $('#rahn_range_range_end_info').text(getIranianPrice(startValue));
            ");
        $this->add($rahnrange);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", "جستجو");
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
