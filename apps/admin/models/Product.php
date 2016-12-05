<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;

class Product extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'product';
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
     * @return Product
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
     * @return Product
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return Product
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Category ID
     * @FieldName('Category ID')
     * @var string
     */
    public $categoryid;

    /**
     * Set Category ID
     * @param type $categoryid
     * @return Product
     */
    public function setCategoryid($categoryid) {
        $this->categoryid = $categoryid;
        return $this;
    }

    /**
     * Timestamp
     * @FieldName('Timestamp')
     * @var string
     */
    public $timestamp;

    /**
     * Set Timestamp
     * @param type $timestamp
     * @return Product
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Description
     * @FieldName('Description')
     * @var string
     */
    public $description;

    /**
     * Set Description
     * @param type $description
     * @return Product
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Voice Path
     * @FieldName('Voice Path')
     * @var string
     */
    public $voicepath;

    /**
     * Set Voice Path
     * @param type $voicepath
     * @return Product
     */
    public function setVoicepath($voicepath) {
        $this->voicepath = $voicepath;
        return $this;
    }

    /**
     * Barcode
     * @FieldName('Barcode')
     * @var string
     */
    public $barcode;

    /**
     * Set Barcode
     * @param type $barcode
     * @return Product
     */
    public function setBarcode($barcode) {
        $this->barcode = $barcode;
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
     * @return Product
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Height
     * @FieldName('Height')
     * @var string
     */
    public $height;

    /**
     * Set Height
     * @param type $height
     * @return Product
     */
    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }

    /**
     * Weight
     * @FieldName('Weight')
     * @var string
     */
    public $weight;

    /**
     * Set Weight
     * @param type $weight
     * @return Product
     */
    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Depth
     * @FieldName('Depth')
     * @var string
     */
    public $depth;

    /**
     * Set Depth
     * @param type $depth
     * @return Product
     */
    public function setDepth($depth) {
        $this->depth = $depth;
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
     * @return Product
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->flag_homepage = 0;
        $this->flag_special = 0;
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->Date = $this->date;
        $result->Title = $this->title;
        $result->CategoryID = $this->categoryid;
        $result->Timestamp = $this->timestamp;
        $result->Description = $this->description;
        $result->VoicePath = $this->voicepath;
        $result->Barcode = $this->barcode;
        $result->Status = $this->status;
        $result->Height = $this->height;
        $result->Weight = $this->weight;
        $result->Depth = $this->depth;
        $result->TotalOrders = 0;
        $result->IsFavorite = 0;
        $result->Timestamp = 0;
        $result->Subtitle = $this->subtitle;
        $result->FlagHomepage = isset($this->flag_homepage) ? $this->flag_homepage : 0;
        $result->FlagSpecial = isset($this->flag_special) ? $this->flag_special : 0;
        $result->Specifications = $this->LoadSpecfifications();


        // get the last price
        $result->FinalPrice = $this->GetFinalPrice();
        $result->InitialPrice = $this->GetInitialPrice();

        // Load Images
        $images = ProductGallery::find(array("product_id = :productid:", "bind" => array("productid" => $this->id)));
        $imagesArray = array();
        foreach ($images as $image) {
            $imagesArray[] = $image->getImageLink();
        }
        if (count($imagesArray) > 0) {
            $result->ImageLink = $imagesArray[0];
        } else {
            $result->ImageLink = Config::getPublicUrl() . "\img\default_product_icon.png";
        }

        $result->FullImageList = $imagesArray;

        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}




    public $subtitle;
    public $flag_special;
    public $flag_homepage;

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'date' => 'date',
            'title' => 'title',
            'categoryid' => 'categoryid',
            'timestamp' => 'timestamp',
            'description' => 'description',
            'voicepath' => 'voicepath',
            'barcode' => 'barcode',
            'status' => 'status',
            'height' => 'height',
            'weight' => 'weight',
            'depth' => 'depth',
            'subtitle' => 'subtitle',
            'flag_special' => 'flag_special',
            'flag_homepage' => 'flag_homepage',
        );
    }

    /**
     * Add new image to product
     * @param Image $image
     * @return bool
     */
    public function AddImage($image) {
        return ProductGallery::Add($this->id, $image);
    }

    public function getRemainingCount() {
        return DBServer::Stock_GetRemainingCount($this->id);
    }

    public function getOrdersCount() {
        return 0;
    }

    public function getProblemsCount() {
        return 0;
    }

    public function getCategoryName() {
        return Category::findFirst($this->categoryid)->title;
    }

    public static function GetList() {
        $products = Product::find();
        $result = array();
        foreach ($products as $product) {
            $result[] = $product->getPublicResponse();
        }
        return $result;
    }

    public function GetInitialPrice() {
        $stock = Stock::findFirst(array("productid = :productid: AND remain > 0", "bind" => array("productid" => $this->id), "order" => "id DESC"));
        if ($stock != FALSE) {
            $saleprice = $stock->sellprice;
            return doubleval($saleprice);
        } else {
            return 0;
        }
    }

    public function GetFinalPrice() {


        $stock = Stock::findFirst(array("productid = :productid: AND remain > 0", "bind" => array("productid" => $this->id), "order" => "id DESC"));
        if ($stock != FALSE) {
            $saleprice = $stock->sellprice;

            // we have to check for the price list in sql server
            $promotion = DBServer::Product_GetPromotionOnProduct($this->id);
//            var_dump(isset($promotion->Percent) && doubleval($promotion->Percent) > 0);
//            die();
            if (isset($promotion)) {
                // we have to calc price with last promotion
                $finalprice = $saleprice;
                if (isset($promotion->Percent) && doubleval($promotion->Percent) > 0) {
                    $finalprice = $saleprice - ($saleprice * ($promotion->Percent / 100 ));
                }

                if (isset($promotion->Fee) && doubleval($promotion->Fee) > 0) {
                    $finalprice = $finalprice - $promotion->Fee;
                }
                return $finalprice;
            } else {
                // we have not this item
                return doubleval($saleprice);
            }
        } else {
            return 0;
        }
    }

    public function LoadSpecfifications() {
        $items = array();
        $specifications = ProductSpecification::find(array("productid = :productid:", "bind" => array("productid" => $this->id)));

        foreach ($specifications as $item) {
            $k = new stdClass();
            $k->Title = $item->title;
            $k->Value = $item->value;
            $k->OrderID = $item->orderid;
            $items[] = $k;
        }

        return $items;
    }

}
