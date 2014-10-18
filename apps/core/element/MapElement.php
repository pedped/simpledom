<?php

/**
 * Uses CKEDITOR
 */
class MapElement extends BaseElement {

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
            "js/maplace/maplace-0.1.3.min.js"
        ));

        $this->setExternalScriptNames(array(
            "http://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.7"
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
        $html = "
            <div id='maploader' style='width:100%;height:500px;'>
            </div>
            <script>
                var locations = [  {
                                    lat: $this->lathitude,
                                    lon: $this->longtude,
                                    title: '$this->markTitle',
                                    html: ' $this->markDescription',
                                }];
                new Maplace({
                   
                    locations: locations,
                    map_div: '#maploader',
                    controls_type: 'list',
                    map_options : {
                          zoom : $this->zoom,
                    },
                    controls_title: 'Choose a location:'
                }).Load();
            </script>
            ";
        return $html;
    }

}
