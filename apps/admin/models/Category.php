<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Category extends AtaModel {

    public function initialize() {
        $this->addBehavior(new SoftDelete(
                array(
            'field' => 'delete',
            'value' => 1
                )
        ));
    }

    public function getSource() {
        return 'category';
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
     * @return Category
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Parent Category
     * @FieldName('Parent Category')
     * @var string
     */
    public $parentcategory;

    /**
     * Set Parent Category
     * @param type $parentcategory
     * @return Category
     */
    public function setParentcategory($parentcategory) {
        $this->parentcategory = $parentcategory;
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
     * @return Category
     */
    public function setTitle($title) {
        $this->title = $title;
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
     * @return Category
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
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
     * @return Category
     */
    public function setDescription($description) {
        $this->description = $description;
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
     * @return Category
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Active
     * @FieldName('Active')
     * @var string
     */
    public $active;

    /**
     * Set Active
     * @param type $active
     * @return Category
     */
    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    /**
     * Delete
     * @FieldName('Delete')
     * @var string
     */
    public $delete;

    /**
     * Set Delete
     * @param type $delete
     * @return Category
     */
    public function setDelete($delete) {
        $this->delete = $delete;
        return $this;
    }

    public function getDate() {
        return Jalali::date("Y/m/d H:i:s", $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     * return the image object
     * @return BaseImage
     */
    public function getImage() {
        return \Image::findFirst($this->imageid);
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
     * @return Category
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

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->ParentCategory = isset($this->parentcategory) ? $this->parentcategory : "";
        $result->Title = $this->title;
        $result->ImageID = $this->imageid;
        $result->ImageLink = $this->getImageLink();
        $result->Description = $this->description;
        $result->Date = $this->date;
        $result->Active = $this->active;


        // find internal categories
        $internalCategories = array();
        $categries = Category::find(array("parentcategory = :parentcategory: AND active = 1", "bind" => array("parentcategory" => $this->id)));
        foreach ($categries as $category) {
            $internalCategories[] = $category->getPublicResponse();
        }
        $result->SubCategory = $internalCategories;
        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}


    public function getImageElement($width = "64px", $height = 'auto') {
        $imagelink = $this->getImageLink();
        return "<img src='$imagelink' style='width: $width;height : $height' class='img' />";
    }

    public function getParentTitle() {
        if (isset($this->parentcategory) && $this->parentcategory > 0) {
            return Category::findFirst(array("id = :id:", "bind" => array("id" => $this->parentcategory)))->title;
        } else {
            return "-----";
        }
    }

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'parentcategory' => 'parentcategory',
            'title' => 'title',
            'imageid' => 'imageid',
            'description' => 'description',
            'date' => 'date',
            'active' => 'active',
            'delete' => 'delete',
        );
    }

    public static function GetList() {
        $categories = Category::find("parentcategory IS NULL AND active = 1");
        $result = array();
        foreach ($categories as $category) {
            $result[] = $category->getPublicResponse();
        }
        return $result;
    }

    public function getStatus() {
        switch ($this->active) {
            case 1:
                return "<span class='label label-success'>فعال</span>";
            case 0:
                return "<span class='label label-danger'>غیر فعال</span>";
            default :
                return "<هشدار : این وضعیت تعریف نشده>";
        }
    }

}
