<?php

use Simpledom\Core\AtaModel;

class BasePage extends AtaModel {

    public function getSource() {
        return 'page';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BasePage
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
     * @return BasePage
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
     * @return BasePage
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Text
     * @var string
     */
    public $text;

    /**
     * Set Text
     * @param type $text
     * @return BasePage
     */
    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    /**
     * Metadata Tags
     * @var string
     */
    public $metakey;

    /**
     * Set Metadata Tags
     * @param type $metakey
     * @return BasePage
     */
    public function setMetakey($metakey) {
        $this->metakey = $metakey;
        return $this;
    }

    /**
     * Metadata Description
     * @var string
     */
    public $metadata;

    /**
     * Set Metadata Description
     * @param type $metadata
     * @return BasePage
     */
    public function setMetadata($metadata) {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * Show In Header
     * @var string
     */
    public $showinhead;

    /**
     * Set Show In Header
     * @param type $showinhead
     * @return BasePage
     */
    public function setShowinhead($showinhead) {
        $this->showinhead = $showinhead;
        return $this;
    }

    /**
     * Footer Text
     * @var string
     */
    public $footer;

    /**
     * Set Footer Text
     * @param type $footer
     * @return BasePage
     */
    public function setFooter($footer) {
        $this->footer = $footer;
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
     * @return BasePage
     */
    public function setDate($date) {
        $this->date = $date;
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
