<?php

use Simpledom\Core\AtaModel;

class MoshaverType extends AtaModel {

    public function getSource() {
        return 'moshaver_type';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MoshaverType
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Set Name
     * @param type $name
     * @return MoshaverType
     */
    public function setName($name) {
        $this->name = $name;
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
     * @return MoshaverType
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Enable
     * @var string
     */
    public $enable;

    /**
     * Set Enable
     * @param type $enable
     * @return MoshaverType
     */
    public function setEnable($enable) {
        $this->enable = $enable;
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
     * @return MoshaverType
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
     * @return MoshaverType
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
