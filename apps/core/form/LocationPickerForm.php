<?php

use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

/**
 * elements in this form
 * 
 *  - stateid
 *  - cityid
 *  - areaid
 *  - map
 *  - areas
 * 
 * when you extent this form, you have to call  <b>parent::initialize();</b>
 */
class LocationPickerForm extends AtaForm {

    private $stateElement;
    private $cityElement;
    private $mapPickElement;
    private $cityAreaSelector;

    public function getStateElement() {
        return $this->stateElement;
    }

    public function getCityElement() {
        return $this->cityElement;
    }

    public function getMapPickElement() {
        return $this->mapPickElement;
    }

    public function getCityAreaSelector() {
        return $this->cityAreaSelector;
    }

    public function initialize() {
        parent::initialize();

        // State ID
        $this->stateElement = new StateSelectorElement('stateid', State::find(), array("using" => array("id", "name")));
        $this->stateElement->setLabel('استان');
        //$stateid->setAttribute('placeholder', 'Enter your City');
        $this->stateElement->setAttribute('class', 'form-control');
        $this->stateElement->addValidator(new PresenceOf(array(
        )));
        $this->add($this->stateElement);

        // City
        $this->cityElement = new SelectElement('cityid', City::find(), array("using" => array("id", "name")));
        $this->cityElement->setLabel('شهر');
        //$cityid->setAttribute('placeholder', 'Enter your City');
        $this->cityElement->setAttribute('class', 'form-control');
        $this->cityElement->addValidator(new PresenceOf(array(
        )));
        $this->add($this->cityElement);


        // Latitude
        $this->mapPickElement = new MapPickElement('map');
        $this->mapPickElement->setLabel("موقعیت روی نقشه");
        //$latitude->setAttribute('placeholder', 'Enter your Latitude');
        $this->mapPickElement->setAttribute('class', 'form-control');
        $this->add($this->mapPickElement);


        // Locations Can Support
        $this->cityAreaSelector = new CityAreaSelector('areas');
        $this->cityAreaSelector->setCityID('$("#cityid").val()');
        $this->cityAreaSelector->setLabel('منطقه مورد نظر');
        //$locationscansupport->setAttribute('placeholder', 'Enter your Locations Can Support');
        $this->cityAreaSelector->setAttribute('class', 'form-control');

        $this->add($this->cityAreaSelector);
    }

    public function render($name, $attributes = null) {
        $html = parent::render($name, $attributes);
        return $html;
    }

}
