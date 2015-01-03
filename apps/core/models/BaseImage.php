<?php

use Simpledom\Core\AtaModel;

class BaseImage extends AtaModel {

    public function getSource() {
        return 'image';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Path
     * @var string
     */
    public $path;

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Mime Type
     * @var string
     */
    public $mimetype;

    /**
     * File Size
     * @var string
     */
    public $filesize;

    /**
     * Link
     * @var string
     */
    public $link;

    /**
     * Validations and business logic
     */
    public function validation() {
        /**
         *                         $this->validate(
         *                                 new Email(
         *                                 array(
         *                             'field' => 'email',
         *                             'required' => true,
         *                                 )
         *                                 )
         * *                         );
         *                         if ($this->validationHasFailed() == true) {
         *                             return false;
         *                         }
         */
        return true;
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        //$this->delete = 0;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function getPublicResponse() {
        $result = new stdClass();
        $result->id = $this->id;
        $result->link = $this->link;
        $result->filesize = $this->filesize;
        return $result;
    }

    public function getImageElement($width = "256px", $height = 'auto') {
        return "<img src='$this->link' style='width: $width;height : $height' class='img' />";
    }

    /**
     * 
     * @return string human readble file size
     */
    public function getHumanSize() {
        return Simpledom\Core\Classes\Helper::convertSizeToHumanReadable($this->filesize);
    }

}
