<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;

class Seller extends AtaModel {

    const STATUS_PENDING = 0;
    const TYPE_OMDEFOROSH = "1";

    public function getSource() {
        return 'seller';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Seller
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
     * @return Seller
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Parent Seller
     * @var string
     */
    public $parent_seller;

    /**
     * Set Parent Seller
     * @param type $parent_seller
     * @return Seller
     */
    public function setParent_seller($parent_seller) {
        $this->parent_seller = $parent_seller;
        return $this;
    }

    /**
     * Type
     * @var string
     */
    public $type;

    /**
     * Set Type
     * @param type $type
     * @return Seller
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $tite
     * @return Seller
     */
    public function setTite($tite) {
        $this->title = $tite;
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
     * @return Seller
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * City ID
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return Seller
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Latitude
     * @var string
     */
    public $latitude;

    /**
     * Set Latitude
     * @param type $latitude
     * @return Seller
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Longitude
     * @var string
     */
    public $longitude;

    /**
     * Set Longitude
     * @param type $longitude
     * @return Seller
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Address
     * @var string
     */
    public $address;

    /**
     * Set Address
     * @param type $address
     * @return Seller
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * Phone
     * @var string
     */
    public $phone;

    /**
     * Set Phone
     * @param type $phone
     * @return Seller
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Postal Code
     * @var string
     */
    public $postal_code;

    /**
     * Set Postal Code
     * @param type $postal_code
     * @return Seller
     */
    public function setPostal_code($postal_code) {
        $this->postal_code = $postal_code;
        return $this;
    }

    /**
     * Business Code
     * @var string
     */
    public $business_code;

    /**
     * Set Business Code
     * @param type $business_code
     * @return Seller
     */
    public function setBusiness_code($business_code) {
        $this->business_code = $business_code;
        return $this;
    }

    /**
     * Fax
     * @var string
     */
    public $fax;

    /**
     * Set Fax
     * @param type $fax
     * @return Seller
     */
    public function setFax($fax) {
        $this->fax = $fax;
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
     * @return Seller
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
        return $this;
    }

    /**
     * Location Can Send
     * @var string
     */
    public $location_can_send;

    /**
     * Set Location Can Send
     * @param type $location_can_send
     * @return Seller
     */
    public function setLocation_can_send($location_can_send) {
        $this->location_can_send = $location_can_send;
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
     * @return Seller
     */
    public function setStatus($status) {
        $this->status = $status;
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
     * @return Seller
     */
    public function setDate($date) {
        $this->date = $date;
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
     * @return Seller
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->status = Seller::STATUS_PENDING;
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        $item = new stdClass();
        $item->id = $this->id;
        $item->address = $this->address;
        $item->businesscode = $this->business_code;
        $item->cityid = $this->cityid;
        $item->cityname = $this->getCityName();
        $item->date = $this->date;
        $item->description = $this->description;
        $item->fax = $this->fax;
        $item->latitude = $this->latitude;
        $item->locationcansend = $this->location_can_send;
        $item->longitude = $this->longitude;
        $item->phone = $this->phone;
        $item->title = $this->title;
        $item->typename = $this->getTypeName();


        // load images
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
            $item->image = BaseImage::findFirst((int) Config::GetDefaultSellerImageID())->link;
            $item->imagearray = array();
        }

        return $item;
    }

    /**
     * 
     * @return Resultset
     */
    public function getImages() {
        return SellerImage::find(array("seller_id = :seller_id:", "bind" => array("seller_id" => $this->id)));
    }

    /**
     * get product image
     * @return SellerImage|Null
     */
    public function getFirstImage() {
        $sellerImage = SellerImage::findFirst(array("seller_id = :seller_id:", "bind" => array("seller_id" => $this->id)));

        if ($sellerImage == FALSE) {
            // we do not have image for this product
            return null;
        } else {
            return $sellerImage;
        }
    }

    public function getTypeName() {
        switch ($this->type) {
            case Seller::TYPE_OMDEFOROSH;
                return "عمده فروش";
            default:
                return "فروشنده";
        }
    }

    public function getCityName() {
        return City::findFirst(array("id = :id:", "bind" => array("id" => $this->cityid)))->name;
    }

}
