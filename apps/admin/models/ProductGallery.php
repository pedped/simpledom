<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class ProductGallery extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'product_gallery';
    }

    /**
     * ID
     * @FieldName('ID')
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return ProductGallery
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Product ID
     * @FieldName('Product ID')
     * @var string
     */
    public $product_id;

    /**
     * Set Product ID
     * @param type $product_id
     * @return ProductGallery
     */
    public function setProduct_id($product_id) {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * Image ID
     * @FieldName('Image ID')
     * @var string
     */
    public $imageid;

    /**
     * Set Image ID
     * @param type $imageid
     * @return ProductGallery
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
        return $this;
    }

    /**
     * return the image object
     * @return BaseImage
     */
    public function getImage() {
        return Image::findFirst($this->imageid);
    }

    /**
     * return the image link
     * @return String imagelink
     */
    public function getImageLink() {
        return $this->getImage()->link;
    }

    public $default;

    /**
     *
     * @param type $parameters
     * @return ProductGallery
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->default = 0;
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->ProductID = $this->product_id;
        $result->ImageID = $this->imageid;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}





    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'product_id' => 'product_id',
            'imageid' => 'imageid',
            'default' => 'default',
        );
    }

    /**
     * add new image to the gallery
     * @param int $productid
     * @param Image $image
     */
    public static function Add($productid, $image) {
        $productGallery = new ProductGallery();
        $productGallery->imageid = $image->id;
        $productGallery->product_id = $productid;
        if ($productGallery->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
