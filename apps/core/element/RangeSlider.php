<?php

/**
 * 
 * Uses CKEDITOR
 */
class RangeSlider extends BaseElement {

    public $min;
    public $max;
    public $currentMinValue;
    public $currentMaxValue;
    public $betweenRangeTitle = "to";
    public $showRangeInfo = true;
    public $onSlide = "";

    /**
     * Set Minimum Range Of Slider
     * @param type $min
     * @return RangeSlider
     */
    public function setMin($min) {
        $this->min = $min;
        return $this;
    }

    /**
     * Set Maximum Range Of Slider
     * @param type $max
     * @return RangeSlider
     */
    public function setMax($max) {
        $this->max = $max;
        return $this;
    }

    /**
     * Set current start range of slider
     * @param type $currentMinValue
     * @return RangeSlider
     */
    public function setCurrentMinValue($currentMinValue) {
        $this->currentMinValue = $currentMinValue;
        return $this;
    }

    /**
     * Set current end range of slider
     * @param type $currentMaxValue
     * @return RangeSlider
     */
    public function setCurrentMaxValue($currentMaxValue) {
        $this->currentMaxValue = $currentMaxValue;
        return $this;
    }

    /**
     * Set title of between range
     * @param type $betweenRangeTitle
     * @return RangeSlider
     */
    public function setBetweenRangeTitle($betweenRangeTitle) {
        $this->betweenRangeTitle = $betweenRangeTitle;
        return $this;
    }

    /**
     * Enable\Disable show range info
     * @param boolean $showRangeInfo
     * @return RangeSlider
     */
    public function setShowRangeInfo($showRangeInfo) {
        $this->showRangeInfo = $showRangeInfo;
        return $this;
    }

    /**
     * javascript that can be used in on slide function
     * 
     * you have to option to use 
     * <b>startVal</b> and <b>endValue</b>
     * like alert(startValue);
     * @param type $onSlide
     * @return RangeSlider
     */
    public function setOnSlide($onSlide) {
        $this->onSlide = $onSlide;
        return $this;
    }

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        // we have to add the javascript and css for the item
        $this->setScriptnames(array(
            "jquery-ui/jquery-ui.min.js"
        ));

        // set css
        $this->setCssnames(array(
            "jquery-ui/jquery-ui.min.css"
        ));
    }

    public function render($attributes = null) {

        $name = $this->getName();
        $showRangeInfoClass = $this->showRangeInfo ? "" : "hidden";

        $html = "
            <div id='$name'></div>
            <input type='hidden' name='" . $name . "_min' id='" . $name . "_min' value='' />
            <input type='hidden' name='" . $name . "_max' id='" . $name . "_max' value='' />
            <p class='.range-info $showRangeInfoClass'>
                <span id='" . $name . "_range_start_info'></span> $this->betweenRangeTitle <span id='" . $name . "_range_end_info'></span>
            </p>
            
            <script>
            

                function onSliderChange$name(startValue , endValue){
                      
                        $('#" . $name . "_min').val(startValue);
                        $('#" . $name . "_max').val(endValue);
                        $('#" . $name . "_range_start_info').text(startValue);
                        $('#" . $name . "_range_end_info').text(endValue); 

                        $this->onSlide
                }
                  

                $(function() {
                  
                  // init the slider  
                  $('#$name').slider({
                    range: true,
                    min: $this->min,
                    max: $this->max,
                    values: [ $this->currentMinValue, $this->currentMaxValue],
                    slide: function( event, ui ) {
                      onSliderChange$name(ui.values[0] , ui.values[1]);    
                    }
                  });
                  
                  onSliderChange$name($('#$name').slider( 'values', 0 ) , $('#$name').slider( 'values', 1 ));     
                });
            </script>
            ";
        return $html;
    }

}
