<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;

class Product extends AtaModel {

    const STATUS_ENABLE = "1";

    public function getSource() {
        return 'product';
    }

    /**
     * ID
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
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return Product
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return Product
     */
    public function setCategoryid($categoryid) {
        $this->categoryid = $categoryid;
        return $this;
    }

    /**
     * Title
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
     * Description
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
     * Made By
     * @var string
     */
    public $country_who_made;

    /**
     * Set Made By
     * @param type $country_who_made
     * @return Product
     */
    public function setCountry_who_made($country_who_made) {
        $this->country_who_made = $country_who_made;
        return $this;
    }

    /**
     * Send Point
     * @var string
     */
    public $send_point;

    /**
     * Set Send Point
     * @param type $send_point
     * @return Product
     */
    public function setSend_point($send_point) {
        $this->send_point = $send_point;
        return $this;
    }

    /**
     * Price
     * @var string
     */
    public $price;

    /**
     * Set Price
     * @param type $price
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * Sale Price
     * @var string
     */
    public $sale_price;

    /**
     * Set Sale Price
     * @param type $sale_price
     * @return Product
     */
    public function setSale_price($sale_price) {
        $this->sale_price = $sale_price;
        return $this;
    }

    /**
     * Price Currency
     * @var string
     */
    public $currency;

    /**
     * Set Price Currency
     * @param type $currency
     * @return Product
     */
    public function setcurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Minimum Request Count
     * @var string
     */
    public $min_request_count;

    /**
     * Set Minimum Request Count
     * @param type $min_request_count
     * @return Product
     */
    public function setMin_request_count($min_request_count) {
        $this->min_request_count = $min_request_count;
        return $this;
    }

    /**
     * Barcode Number
     * @var string
     */
    public $barcodenumber;

    /**
     * Set Barcode Number
     * @param type $barcodenumber
     * @return Product
     */
    public function setBarcodenumber($barcodenumber) {
        $this->barcodenumber = $barcodenumber;
        return $this;
    }

    /**
     * Color
     * @var string
     */
    public $color;

    /**
     * Set Color
     * @param type $color
     * @return Product
     */
    public function setColor($color) {
        $this->color = $color;
        return $this;
    }

    /**
     * UUID
     * @var string
     */
    public $uuid;

    /**
     * Set UUID
     * @param type $uuid
     * @return Product
     */
    public function setUuid($uuid) {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * Offline Add
     * @var string
     */
    public $offlineadd;

    /**
     * Set Offline Add
     * @param type $offlineadd
     * @return Product
     */
    public function setOfflineadd($offlineadd) {
        $this->offlineadd = $offlineadd;
        return $this;
    }

    /**
     * Token
     * @var string
     */
    public $token;

    /**
     * Set Token
     * @param type $token
     * @return Product
     */
    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    /**
     * Featured
     * @var string
     */
    public $featured;

    /**
     * Set Featured
     * @param type $featured
     * @return Product
     */
    public function setFeatured($featured) {
        $this->featured = $featured;
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
     * @return Product
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Order Request Instruction
     * @var string
     */
    public $order_request_instruction;
    private $status;

    /**
     * Set Order Request Instruction
     * @param type $order_request_instruction
     * @return Product
     */
    public function setOrder_request_instruction($order_request_instruction) {
        $this->order_request_instruction = $order_request_instruction;
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
     * @return Product
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->token = $this->generateRandomString(32);
        $this->featured = "0";
        $this->status = Product::STATUS_ENABLE;
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {

        // store information
        $item = new stdClass();

        $item->id = $this->id;
        $item->barcodenumber = $this->barcodenumber;
        $item->categoryid = $this->categoryid;
        $item->madeby = $this->country_who_made;
        $item->madebytitle = $this->country_who_made;
        $item->currency = $this->currency;
        $item->date = $this->date;
        $item->description = $this->description;
        $item->featured = $this->featured;
        $item->minrequest = $this->min_request_count;
        $item->offlineadd = $this->offlineadd;
        $item->requestinstruction = $this->order_request_instruction;

        $item->price = $this->price;
        $item->sale_price = $this->sale_price;

        $item->send_point = $this->send_point;
        $item->title = $this->title;
        $item->token = $this->token;
        $item->userid = $this->userid;
        $item->uuid = $this->uuid;

        $item->pricehuman = $this->getHumanPrice();
        $item->salepricehuman = $this->getHumanPrice();

        // get category title
        $item->categorytitle = $this->getCategory()->title;

        // load images
        $images = $this->getImages();
        if ($images->count() > 0) {
            // load images
            $item->image = $this->getFirstImage()->getImageLink();

            // Add image array
            $imageArrays = array();
            foreach ($images as $image) {
                $imageArrays[] = $image->getImageLink();
            }

            // load image arrays
            $item->imagearray = $imageArrays;
        } else {
            $item->image = BaseImage::findFirst((int) Config::GetDefaultProductImageID())->link;
            $item->imagearray = array();
        }

        return $item;
    }

    /**
     * 
     * @return Resultset
     */
    public function getImages() {
        return ProductImage::find(array("product_id = :productid:", "bind" => array("productid" => $this->id)));
    }

    /**
     * return item category
     * @return Category
     */
    public function getCategory() {
        return Category::findFirst(array("id = :id:", "bind" => array("id" => $this->categoryid)));
    }

    public function getHumanPrice() {
        return $this->price . " " . $this->currency;
    }

    public function getHumanSalePrice() {
        return $this->sale_price . " " . $this->currency;
    }

    /**
     * get product image
     * @return ProductImage|Null
     */
    public function getFirstImage() {
        $productImage = ProductImage::findFirst(array("product_id = :product_id:", "bind" => array("product_id" => $this->id)));

        if ($productImage == FALSE) {
            // we do not have image for this product
            return null;
        } else {
            return $productImage;
        }
    }

    /**
     * get product image
     * @return ProductImage
     */
    public function getFirstImageLink() {
        $productImage = $this->getFirstImage();

        if ($productImage == FALSE) {
            // we do not have image for this product
            return Config::GetDefaultCategoryProductImage($this->categoryid);
        } else {
            return BaseImage::findFirst(array("id = :id:", "bind" => array("id" => $productImage->imageid)))->link;
        }
    }

    /**
     * Find Seller of this product
     * @return Seller
     */
    public function getSeller() {
        return Seller::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->userid)));
    }

}
