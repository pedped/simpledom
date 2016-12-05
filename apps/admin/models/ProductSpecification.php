<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class ProductSpecification extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'product_specification';
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
     * @return ProductSpecification
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
    public $productid;

    /**
     * Set Product ID
     * @param type $productid
     * @return ProductSpecification
     */
    public function setProductid($productid) {
        $this->productid = $productid;
        return $this;
    }

    /**
     * Title
     * @FieldName('Title')
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $title
     * @return ProductSpecification
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Value
     * @FieldName('Value')
     * @var string
     */
    public $value;

    /**
     * Set Value
     * @param type $value
     * @return ProductSpecification
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * Order ID
     * @FieldName('Order ID')
     * @var string
     */
    public $orderid;

    /**
     * Set Order ID
     * @param type $orderid
     * @return ProductSpecification
     */
    public function setOrderid($orderid) {
        $this->orderid = $orderid;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return ProductSpecification
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->ProductID = $this->productid;
        $result->Title = $this->title;
        $result->Value = $this->value;
        $result->OrderID = $this->orderid;


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
            'productid' => 'productid',
            'title' => 'title',
            'value' => 'value',
            'orderid' => 'orderid',
        );
    }

}
