<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Stock extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'stock';
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
     * @return Stock
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return Stock
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Buy Price
     * @FieldName('Buy Price')
     * @var string
     */
    public $buyprice;

    /**
     * Set Buy Price
     * @param type $buyprice
     * @return Stock
     */
    public function setBuyprice($buyprice) {
        $this->buyprice = $buyprice;
        return $this;
    }

    /**
     * Sell Price
     * @FieldName('Sell Price')
     * @var string
     */
    public $sellprice;

    /**
     * Set Sell Price
     * @param type $sellprice
     * @return Stock
     */
    public function setSellprice($sellprice) {
        $this->sellprice = $sellprice;
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
     * @return Stock
     */
    public function setProductid($productid) {
        $this->productid = $productid;
        return $this;
    }

    /**
     * Total
     * @FieldName('Total')
     * @var string
     */
    public $total;

    /**
     * Set Total
     * @param type $total
     * @return Stock
     */
    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }

    /**
     * Expire Date
     * @FieldName('Expire Date')
     * @var string
     */
    public $expiredate;

    /**
     * Set Expire Date
     * @param type $expiredate
     * @return Stock
     */
    public function setExpiredate($expiredate) {
        $this->expiredate = $expiredate;
        return $this;
    }

    /**
     * Warehouse Part ID
     * @FieldName('Warehouse Part ID')
     * @var string
     */
    public $warehousepartid;

    /**
     * Set Warehouse Part ID
     * @param type $warehousepartid
     * @return Stock
     */
    public function setWarehousepartid($warehousepartid) {
        $this->warehousepartid = $warehousepartid;
        return $this;
    }

    public function getDate() {
        return Jalali::date("Y/m/d H:i:s", $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Stock
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->remain = $this->total;
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->Date = $this->date;
        $result->BuyPrice = $this->buyprice;
        $result->SellPrice = $this->sellprice;
        $result->ProductID = $this->productid;
        $result->Total = $this->total;
        $result->ExpireDate = $this->expiredate;
        $result->WarehousePartID = $this->warehousepartid;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}





    public $remain;

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'date' => 'date',
            'buyprice' => 'buyprice',
            'sellprice' => 'sellprice',
            'productid' => 'productid',
            'total' => 'total',
            'expiredate' => 'expiredate',
            'warehousepartid' => 'warehousepartid',
            'remain' => 'remain',
        );
    }

}
