<?php

use Simpledom\Core\AtaModel;

class ProductImage extends AtaModel {

    const STATUS_AVAIABLE = "1";

    public function getSource() {
        return 'product_image';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return ProductImage
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Product ID
     * @var string
     */
    public $product_id;

    /**
     * Set Product ID
     * @param type $product_id
     * @return ProductImage
     */
    public function setProduct_id($product_id) {
        $this->product_id = $product_id;
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
     * @return ProductImage
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return ProductImage
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Status
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return ProductImage
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
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
     * @return ProductImage
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->status = ProductImage::STATUS_AVAIABLE;
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
