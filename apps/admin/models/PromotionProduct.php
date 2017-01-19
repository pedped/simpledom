<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class PromotionProduct extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'promotion_product';
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
     * @return PromotionProduct
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
     * @return PromotionProduct
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * By User ID
     * @FieldName('By User ID')
     * @var string
     */
    public $byuserid;

    /**
     * Set By User ID
     * @param type $byuserid
     * @return PromotionProduct
     */
    public function setByuserid($byuserid) {
        $this->byuserid = $byuserid;
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
     * @return PromotionProduct
     */
    public function setProductid($productid) {
        $this->productid = $productid;
        return $this;
    }

    /**
     * Promotion ID
     * @FieldName('Promotion ID')
     * @var string
     */
    public $promotionid;

    /**
     * Set Promotion ID
     * @param type $promotionid
     * @return PromotionProduct
     */
    public function setPromotionid($promotionid) {
        $this->promotionid = $promotionid;
        return $this;
    }

    /**
     * Total Order Per User
     * @FieldName('Total Order Per User')
     * @var string
     */
    public $totalorderperuser;

    /**
     * Set Total Order Per User
     * @param type $totalorderperuser
     * @return PromotionProduct
     */
    public function setTotalorderperuser($totalorderperuser) {
        $this->totalorderperuser = $totalorderperuser;
        return $this;
    }

    /**
     * Total Order
     * @FieldName('Total Order')
     * @var string
     */
    public $totalorder;

    /**
     * Set Total Order
     * @param type $totalorder
     * @return PromotionProduct
     */
    public function setTotalorder($totalorder) {
        $this->totalorder = $totalorder;
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
     * @return PromotionProduct
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Percent
     * @FieldName('Percent')
     * @var string
     */
    public $percent;

    /**
     * Set Percent
     * @param type $percent
     * @return PromotionProduct
     */
    public function setPercent($percent) {
        $this->percent = $percent;
        return $this;
    }

    /**
     * Fee
     * @FieldName('Fee')
     * @var string
     */
    public $fee;

    /**
     * Set Fee
     * @param type $fee
     * @return PromotionProduct
     */
    public function setFee($fee) {
        $this->fee = $fee;
        return $this;
    }

    /**
     * Status
     * @FieldName('Status')
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return PromotionProduct
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
     *
     * @param type $parameters
     * @return PromotionProduct
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

    public function getPublicResponse($user = null, array $items = null) {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->Date = $this->date;
        $result->ByUserID = $this->byuserid;
        $result->ProductID = $this->productid;
        $result->PromotionID = $this->promotionid;
        $result->TotalOrderPerUser = $this->totalorderperuser;
        $result->TotalOrder = $this->totalorder;
        $result->Title = $this->title;
        $result->Percent = $this->percent;
        $result->Fee = $this->fee;
        $result->Status = $this->status;


        return $result;
    }

    public function getProductName() {
        return Product::findFirst(array("id = :id:", "bind" => array("id" => $this->productid)))->title;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}


    public function getStatusWithLabelBox() {
        switch ($this->status) {
            case PROMOTION_PRODUCT_STATUS_ACTIVE:
                return "<span class='label label-primary'>" . "فعال" . "</span>";
            case PROMOTION_PRODUCT_STATUS_SUSSPEND:
                return "<span class='label label-warning'>" . "معلق" . "</span>";
            case PROMOTION_PRODUCT_STATUS_FINISHED:
                return "<span class='label label-success'>" . "پایان یافته" . "</span>";
            default:
                break;
        }
    }

    public function getStatus() {
        switch ($this->status) {
            case PROMOTION_PRODUCT_STATUS_ACTIVE:
                return "فعال";
            case PROMOTION_PRODUCT_STATUS_SUSSPEND:
                return "معلق";
            case PROMOTION_PRODUCT_STATUS_FINISHED:
                return "پایان یافته";
            default:
                break;
        }
    }

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'date' => 'date',
            'byuserid' => 'byuserid',
            'productid' => 'productid',
            'promotionid' => 'promotionid',
            'totalorderperuser' => 'totalorderperuser',
            'totalorder' => 'totalorder',
            'title' => 'title',
            'percent' => 'percent',
            'fee' => 'fee',
            'status' => 'status',
        );
    }

}
