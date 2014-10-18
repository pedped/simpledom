<?php

use Simpledom\Core\AtaModel;

class BaseSMSProvider extends AtaModel {

    public function getSource() {
        return 'smsprovider';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseSMSProvider
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
     * @return BaseSMSProvider
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
     * @return BaseSMSProvider
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Infos
     * @var string
     */
    public $infos;

    /**
     * Set Infos
     * @param type $infos
     * @return BaseSMSProvider
     */
    public function setInfos($infos) {
        $this->infos = $infos;
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
     * @return BaseSMSProvider
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Website URL
     * @var string
     */
    public $websitename;

    /**
     * Set Website URL
     * @param type $websitename
     * @return BaseSMSProvider
     */
    public function setWebsitename($websitename) {
        $this->websitename = $websitename;
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
     * @return BaseSMSProvider
     */
    public function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
