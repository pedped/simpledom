<?php

/**
 */
class MapPickElement extends BaseElement {

    private $language = "en";
    private $markTitle = "Title";
    private $markDescription = "Description";
    private $zoom = 10;
    private $lathitude = 25;
    private $longtude = 25;

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        // we have to add the javascript and css for the item
        $this->setScriptnames(array(
            "js/jquery-map/jquery-map.js"
        ));

        $this->setExternalScriptNames(array(
            "http://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.7&language=en"
        ));
    }

    public function getLathitude() {
        return $this->lathitude;
    }

    public function getLongtude() {
        return $this->longtude;
    }

    public function setLathitude($lathitude) {
        $this->lathitude = $lathitude;
    }

    public function setLongtude($longtude) {
        $this->longtude = $longtude;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language = "en") {
        $this->language = $language;
    }

    public function getMarkTitle() {
        return $this->markTitle;
    }

    public function getMarkDescription() {
        return $this->markDescription;
    }

    public function setMarkTitle($markTitle) {
        $this->markTitle = $markTitle;
    }

    public function setMarkDescription($markDescription) {
        $this->markDescription = $markDescription;
    }

    public function getZoom() {
        return $this->zoom;
    }

    public function setZoom($zoom) {
        $this->zoom = $zoom;
    }

    public function render($attributes = null) {

        $name = $this->getName();
        $html = "
            <input type='hidden' name='$name" . "_latitude' id='$name" . "_latitude' value='$this->lathitude' />
            <input type='hidden' name='$name" . "_longitude' id='$name" . "_longitude' value='$this->longtude' />
            <div id='$name' style='width:100%;height:500px;'>
                
            </div>
            <script>
                $('#$name').locationpicker(
                    {
                        zoom: $this->zoom,
                        location: {
                            latitude: $this->lathitude,
                            longitude: $this->longtude
                        },
                        radius: 0,
                        locationName: '$this->markTitle',
                        enableAutocomplete: true,
                        inputBinding: {
                            latitudeInput: $('#$name" . "_latitude'),
                            longitudeInput: $('#$name" . "_longitude'),
                        },
                        onchanged: function(currentLocation, radius, isMarkerDropped) {
                            $('#$name" . "_latitude').val(currentLocation.latitude);
                            $('#$name" . "_longitude').val(currentLocation.longitude);
                        }
                    });
            </script>
            


            ";
        return $html;
    }

}
