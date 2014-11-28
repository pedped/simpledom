<?php

class CityAreaSelector extends TagEditElement {

    protected $cityID = "";

    public function getCityID() {
        return $this->cityID;
    }

    /**
     * Set City ID for the area
     * @param int|String $cityID can be id like <b>25</b> or value like <b>$('#cityid').val()</b>
     * @return CityAreaSelector
     */
    public function setCityID($cityID) {
        $this->cityID = $cityID;
        return $this;
    }

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);
    }

    public function render($attributes = null) {

        // set source
        $this->setAutocompleteSource("function(query , response ){"
                . "console.log(" . $this->getCityID() . ",query.term);\n"
                . "var url  = 'http://amlak.edspace.org/api/area/listwithname/' + " . $this->getCityID() . " + '/' + query.term + '/'\n"
                . "$.ajax({
                        type: 'post',
                        url: url,
                        success: function(output) {
                            console.log(output);
                            response(JSON.parse(output));
                        }
                        ,
                        error: function(a, b, c)
                        {

                        }
                    });\n"
                . "}");

        return parent::render($attributes);
    }

}
