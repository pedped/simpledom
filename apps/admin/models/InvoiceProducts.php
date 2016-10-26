<?php

use Simpledom\Core\AtaModel;

class InvoiceProducts extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'invoice_products';
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
     * @return InvoiceProducts
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Invoice ID
     * @FieldName('Invoice ID')
     * @var string
     */
    public $invoiceid;

    /**
     * Set Invoice ID
     * @param type $invoiceid
     * @return InvoiceProducts
     */
    public function setInvoiceid($invoiceid) {
        $this->invoiceid = $invoiceid;
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
     * @return InvoiceProducts
     */
    public function setProductid($productid) {
        $this->productid = $productid;
        return $this;
    }

    /**
     * Date
     * @FieldName('Date')
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return InvoiceProducts
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Count
     * @FieldName('Count')
     * @var string
     */
    public $count;

    /**
     * Set Count
     * @param type $count
     * @return InvoiceProducts
     */
    public function setCount($count) {
        $this->count = $count;
        return $this;
    }

    /**
     * Message
     * @FieldName('Message')
     * @var string
     */
    public $message;

    /**
     * Set Message
     * @param type $message
     * @return InvoiceProducts
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return InvoiceProducts
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getCategoryName() {
        return $this->getProduct()->getCategoryName();
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->InvoiceID = $this->invoiceid;
        $result->ProductID = $this->productid;
        $result->Date = $this->date;
        $result->Count = $this->count;
        $result->Message = $this->message;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}

    /**
     * get product
     * @return Product
     */
    public function getProduct() {
        return Product::findFirst(array("id = :id:", "bind" => array("id" => $this->productid)));
    }

    public function getProductTitle() {
        return $this->getProduct()->title;
    }

    public function getProductStatus() {
        return $this->getProduct()->status;
    }

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'invoiceid' => 'invoiceid',
            'productid' => 'productid',
            'date' => 'date',
            'count' => 'count',
            'message' => 'message',
        );
    }

}
