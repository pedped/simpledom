<?php

use Simpledom\Core\AtaModel;

class BongahImage extends AtaModel {

    public function getSource() {
        return 'bongah_image';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BongahImage
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Bongah ID
     * @var string
     */
    public $bongahid;

    /**
     * Set Bongah ID
     * @param type $bongahid
     * @return BongahImage
     */
    public function setBongahid($bongahid) {
        $this->bongahid = $bongahid;
        return $this;
    }

    /**
     * Image ID
     * @var string
     */
    public $imageid;

    /**
     * Set Image ID
     * @param type $imageid
     * @return BongahImage
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
        return $this;
    }

    /**
     * Delete
     * @var string
     */
    public $delete;

    /**
     * Set Delete
     * @param type $delete
     * @return BongahImage
     */
    public function setDelete($delete) {
        $this->delete = $delete;
        return $this;
    }

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
     *
     * @param type $parameters
     * @return BongahImage
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->delete = "0";
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
