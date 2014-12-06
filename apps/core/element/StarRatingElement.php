<?php

class StarRatingElement extends BaseElement {

    private $stars = 5;
    private $min = 0;
    private $max = 5;
    private $step = 1;
    private $glyphicon = "true";
    private $symbol = 'undefined';
    private $showClear = "true";
    private $showCaption = "true";
    private $defaultCaption = 'undefined';
    private $starCaptions = "{
                                0.5: 'Half Star',
                                1: 'One Star',
                                1.5: 'One & Half Star',
                                2: 'Two Stars',
                                2.5: 'Two & Half Stars',
                                3: 'Three Stars',
                                3.5: 'Three & Half Stars',
                                4: 'Four Stars',
                                4.5: 'Four & Half Stars',
                                5: 'Five Stars'
                            }";
    private $starCaptionClasses = "{
                                    0.5: 'label label-danger',
                                    1: 'label label-danger',
                                    1.5: 'label label-warning',
                                    2: 'label label-warning',
                                    2.5: 'label label-info',
                                    3: 'label label-info',
                                    3.5: 'label label-primary',
                                    4: 'label label-primary',
                                    4.5: 'label label-success',
                                    5: 'label label-success'
                                }";
    private $size = "md";
    private $rtl = "false";

    public function getStars() {
        return $this->stars;
    }

    public function getGlyphicon() {
        return $this->glyphicon;
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function getShowClear() {
        return $this->showClear;
    }

    public function getShowCaption() {
        return $this->showCaption;
    }

    public function getDefaultCaption() {
        return $this->defaultCaption;
    }

    public function getStarCaptions() {
        return $this->starCaptions;
    }

    public function getStarCaptionClasses() {
        return $this->starCaptionClasses;
    }

    public function getMin() {
        return $this->min;
    }

    public function getMax() {
        return $this->max;
    }

    public function getStep() {
        return $this->step;
    }

    public function getSize() {
        return $this->size;
    }

    public function getRtl() {
        return $this->rtl;
    }

    /**
     * boolean whether the rating input is to be oriented RIGHT TO LEFT. Defaults to false.
     * @param boolean $rtl
     * @return StarRatingElement
     */
    public function setRtl($rtl) {
        $this->rtl = "$rtl";
        return $this;
    }

    /**
     * int the number of stars to display. Defaults to 5.
     * @param type $stars
     * @return StarRatingElement
     */
    public function setStars($stars) {
        $this->stars = $stars;
        return $this;
    }

    /**
     * boolean whether to use the glyphicon star symbol. Defaults to true. If set to false, will use the unicode black star symbol.
     * @param boolean $glyphicon
     * @return StarRatingElement
     */
    public function setGlyphicon($glyphicon) {
        $this->glyphicon = "$glyphicon";
        return $this;
    }

    /**
     * string any custom star symbol or unicode character to display. This will override the glyphicon settings above. Note: The symbol is not a CSS class or a html markup. Instead it must be the HTML entity code, which represents the character to be displayed. You can cross check this entity code for glyphicons in your bootstrap.css file (or any custom icon font css) and represent it correctly as a HTML entity.
     * @param type $symbol
     * @return StarRatingElement
     */
    public function setSymbol($symbol) {
        $this->symbol = $symbol;
        return $this;
    }

    /**
     * boolean whether the clear button is to be displayed. Defaults to true.
     * @param boolean $showClear
     * @return StarRatingElement
     */
    public function setShowClear($showClear) {
        $this->showClear = "$showClear";
        return $this;
    }

    /**
     * boolean whether the rating caption is to be displayed. Defaults to true.
     * @param boolean $showCaption
     * @return StarRatingElement
     */
    public function setShowCaption($showCaption) {
        $this->showCaption = "$showCaption";
        return $this;
    }

    /**
     * string the default caption text, which will be displayed when no caption is setup for the rating in the starCaptions array. This variable defaults to {rating} Stars, where the variable {rating} will be replaced with the selected star rating.
     * @param type $defaultCaption
     * @return StarRatingElement
     */
    public function setDefaultCaption($defaultCaption) {
        $this->defaultCaption = $defaultCaption;
        return $this;
    }

    /**
     * array | function the caption titles corresponding to each of the star rating selected. Defaults to
     * {
      0.5: 'Half Star',
      1: 'One Star',
      1.5: 'One & Half Star',
      2: 'Two Stars',
      2.5: 'Two & Half Stars',
      3: 'Three Stars',
      3.5: 'Three & Half Stars',
      4: 'Four Stars',
      4.5: 'Four & Half Stars',
      5: 'Five Stars'
      }
     * @param type $starCaptions
     * @return StarRatingElement
     */
    public function setStarCaptions($starCaptions) {
        $this->starCaptions = $starCaptions;
        return $this;
    }

    /**
     * array | function the caption css classes corresponding to each of the star rating selected. Defaults to
     * {
      0.5: 'label label-danger',
      1: 'label label-danger',
      1.5: 'label label-warning',
      2: 'label label-warning',
      2.5: 'label label-info',
      3: 'label label-info',
      3.5: 'label label-primary',
      4: 'label label-primary',
      4.5: 'label label-success',
      5: 'label label-success'
      }
     * @param type $starCaptionClasses
     * @return StarRatingElement
     */
    public function setStarCaptionClasses($starCaptionClasses) {
        $this->starCaptionClasses = $starCaptionClasses;
        return $this;
    }

    /**
     * float the minimum value for the rating input. Defaults to 1.
     * @param type $min
     * @return StarRatingElement
     */
    public function setMin($min) {
        $this->min = $min;
        return $this;
    }

    /**
     * float the maximum value for the rating input. Defaults to 5.
     * @param type $max
     * @return StarRatingElement
     */
    public function setMax($max) {
        $this->max = $max;
        return $this;
    }

    /**
     * float the step to increment the rating when each star is clicked. Defaults to 0.5.
     * @param type $step
     * @return StarRatingElement
     */
    public function setStep($step) {
        $this->step = $step;
        return $this;
    }

    /**
     * string size of the rating control. One of xl, lg, md, sm, or xs. Defaults to md.
     * @param type $size
     * @return StarRatingElement
     */
    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    public function __construct($name, $attributes = null) {
        parent::__construct($name, $attributes);

        // add javascript and css files
        $this->setScriptnames(array(
            "js/krajee-starrating/js/star-rating.min.js"
        ));
        $this->setCssnames(array(
            "js/krajee-starrating/css/star-rating.min.css"
        ));
    }

    public function render($attributes = null) {

        // get name
        $name = $this->getName();

        // get parameters
        $stars = $this->stars;
        $glyphicon = $this->glyphicon;
        $symbol = $this->symbol;
        $showClear = $this->showClear;
        $showCaption = $this->showCaption;
        $defaultCaption = $this->defaultCaption;
        $starCaptions = $this->starCaptions;
        $starCaptionClasses = $this->starCaptionClasses;
        $min = $this->min;
        $max = $this->max;
        $step = $this->step;
        $size = $this->size;
        $rtl = $this->rtl;


        $html = "<div style='direction: ltr;'><input name='$name' id='$name' type='number' /></div>";
        $html .= "  <script>
                       $('#$name').rating({
                           'stars': $stars,
                           'glyphicon': $glyphicon,
                           'symbol': $symbol,
                           'showClear': $showClear,
                           'showCaption': $showCaption,
                           'defaultCaption': $defaultCaption,
                           'starCaptions': $starCaptions,
                           'starCaptionClasses': $starCaptionClasses,
                           'min': $min,
                           'max': $max,
                           'step': $step,
                           'size': '$size',
                           'rtl': $rtl ,
                           });
                    </script>";
        return $html;
    }

}
