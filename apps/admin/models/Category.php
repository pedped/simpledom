<?php

use Phalcon\Mvc\Model\Resultset;
use Simpledom\Core\AtaModel;

class Category extends AtaModel {

    public function getSource() {
        return 'category';
    }

    /**
     * ID
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
     * Key
     * @var string
     */
    public $key;

    /**
     * Set Key
     * @param type $key
     * @return Category
     */
    public function setKey($key) {
        $this->key = $key;
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
     * @return Category
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
     * @return Category
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Parent ID
     * @var string
     */
    public $parent_id;

    /**
     * Set Parent ID
     * @param type $parent_id
     * @return Category
     */
    public function setParent_id($parent_id) {
        $this->parent_id = $parent_id;
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
     * @return Category
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
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
     * @return Category
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
     * @return Category
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
        if ($this->getImage() != FALSE) {
            return $this->getImage()->link;
        } else {
            return "http://www.placehold.it/64x64/";
        }
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

    public function getPublicResponse() {
        $item = new stdClass();
        $item->id = $this->id;
        $item->title = $this->title;
        $item->key = $this->key;
        $item->description = $this->description;
        $item->image = $this->getImageLink();
        $item->subitems = array();

        // we have to find subcateories and show sub items
        $subCategories = $this->getSubCategoris();
        foreach ($subCategories as $value) {
            $item->subitems[] = $value->getPublicResponse();
        }

        // return resul
        return $item;
    }

    /**
     * find sub category of list
     * @return Resultset
     */
    public function getSubCategoris() {
        return Category::find(array("parent_id = :parent_id: AND status = '1'", "bind" => array("parent_id" => $this->id)));
    }

    public function LoadSubCategoryIDs() {
        $categories = Category::find(array("parent_id = :parentid: AND status = '1' ", "bind" => array("parentid" => $this->id)));
        $results = array();
        foreach ($categories as $category) {
            $results[] = $category->id;
            $this->loadMoreCategories($results, $category->id);
        }
        return $results;
    }

    private function loadMoreCategories(&$currentIDs, $categoryID) {
        $categories = Category::find(array("parent_id = :parentid: AND status = '1' ", "bind" => array("parentid" => $categoryID)));
        foreach ($categories as $category) {
            $currentIDs[] = $category->id;
            $this->loadMoreCategories($currentIDs, $category->id);
        }
    }

}
