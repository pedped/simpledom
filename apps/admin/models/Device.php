<?php

use Simpledom\Core\AtaModel;

class Device extends AtaModel {

    public function getSource() {
        return 'device';
    }

    private $imageid;

    /**
     * return the image object
     * @return BaseImage
     */
    public function getImage() {
        return BaseImage::findFirst($this->imageid);
    }

    /**
     * return the image link
     * @return String imagelink
     */
    public function getImageLink() {
        return $this->getImage()->link;
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Device
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Company
     * @var string
     */
    public $company;

    /**
     * Set Company
     * @param type $company
     * @return Device
     */
    public function setCompany($company) {
        $this->company = $company;
        return $this;
    }

    /**
     * Category ID
     * @var string
     */
    public $categoryid;

    /**
     * Set Category ID
     * @param type $categoryid
     * @return Device
     */
    public function setCategoryid($categoryid) {
        $this->categoryid = $categoryid;
        return $this;
    }

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Set Name
     * @param type $name
     * @return Device
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Dimensions
     * @var string
     */
    public $dimensions;

    /**
     * Set Dimensions
     * @param type $dimensions
     * @return Device
     */
    public function setDimensions($dimensions) {
        $this->dimensions = $dimensions;
        return $this;
    }

    /**
     * Weight
     * @var string
     */
    public $weight;

    /**
     * Set Weight
     * @param type $weight
     * @return Device
     */
    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Simcount
     * @var string
     */
    public $simcount;

    /**
     * Set Simcount
     * @param type $simcount
     * @return Device
     */
    public function setSimcount($simcount) {
        $this->simcount = $simcount;
        return $this;
    }

    /**
     * Display
     * @var string
     */
    public $display;

    /**
     * Set Display
     * @param type $display
     * @return Device
     */
    public function setDisplay($display) {
        $this->display = $display;
        return $this;
    }

    /**
     * Resolution
     * @var string
     */
    public $resolution;

    /**
     * Set Resolution
     * @param type $resolution
     * @return Device
     */
    public function setResolution($resolution) {
        $this->resolution = $resolution;
        return $this;
    }

    /**
     * SD Cart Support
     * @var string
     */
    public $sdsupport;

    /**
     * Set SD Cart Support
     * @param type $sdsupport
     * @return Device
     */
    public function setSdsupport($sdsupport) {
        $this->sdsupport = $sdsupport;
        return $this;
    }

    /**
     * OS
     * @var string
     */
    public $os;

    /**
     * Set OS
     * @param type $os
     * @return Device
     */
    public function setOs($os) {
        $this->os = $os;
        return $this;
    }

    /**
     * CPU
     * @var string
     */
    public $cpu;

    /**
     * Set CPU
     * @param type $cpu
     * @return Device
     */
    public function setCpu($cpu) {
        $this->cpu = $cpu;
        return $this;
    }

    /**
     * GPU
     * @var string
     */
    public $gpu;

    /**
     * Set GPU
     * @param type $gpu
     * @return Device
     */
    public function setGpu($gpu) {
        $this->gpu = $gpu;
        return $this;
    }

    /**
     * Internal_memory
     * @var string
     */
    public $internal_memory;

    /**
     * Set Internal_memory
     * @param type $internal_memory
     * @return Device
     */
    public function setInternal_memory($internal_memory) {
        $this->internal_memory = $internal_memory;
        return $this;
    }

    /**
     * Camera
     * @var string
     */
    public $camera;

    /**
     * Set Camera
     * @param type $camera
     * @return Device
     */
    public function setCamera($camera) {
        $this->camera = $camera;
        return $this;
    }

    /**
     * More Info
     * @var string
     */
    public $moreinfo;

    /**
     * Set More Info
     * @param type $moreinfo
     * @return Device
     */
    public function setMoreinfo($moreinfo) {
        $this->moreinfo = $moreinfo;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return Device
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->company = "no";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    public function getCompanyName() {
        return Category::findFirst(array("id = :id:", "bind" => array("id" => $this->categoryid)))->title;
    }

    public function getImageElement() {
        return "<img style='max-width:200px;max-height:200px;text-align: center; ' src='" . $this->getImageLink() . "' />";
    }

}
