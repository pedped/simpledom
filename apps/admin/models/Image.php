<?php

class Image extends BaseImage {

    public function initialize() {
        
    }

    public function getSource() {
        return 'image';
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
     * @return Image
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Path
     * @FieldName('Path')
     * @var string
     */
    public $path;

    /**
     * Set Path
     * @param type $path
     * @return Image
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    /**
     * Link
     * @FieldName('Link')
     * @var string
     */
    public $link;

    /**
     * Set Link
     * @param type $link
     * @return Image
     */
    public function setLink($link) {
        $this->link = $link;
        return $this;
    }

    /**
     * Type
     * @FieldName('Type')
     * @var string
     */
    public $type;

    /**
     * Set Type
     * @param type $type
     * @return Image
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Width
     * @FieldName('Width')
     * @var string
     */
    public $width;

    /**
     * Set Width
     * @param type $width
     * @return Image
     */
    public function setWidth($width) {
        $this->width = $width;
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
     * @return Image
     */
    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }

    /**
     * Mime Type
     * @FieldName('Mime Type')
     * @var string
     */
    public $mimetype;

    /**
     * Set Mime Type
     * @param type $mimetype
     * @return Image
     */
    public function setMimetype($mimetype) {
        $this->mimetype = $mimetype;
        return $this;
    }

    /**
     * File Size
     * @FieldName('File Size')
     * @var string
     */
    public $filesize;

    /**
     * Set File Size
     * @param type $filesize
     * @return Image
     */
    public function setFilesize($filesize) {
        $this->filesize = $filesize;
        return $this;
    }

    /**
     * Album ID
     * @FieldName('Album ID')
     * @var string
     */
    public $albumid;

    /**
     * Set Album ID
     * @param type $albumid
     * @return Image
     */
    public function setAlbumid($albumid) {
        $this->albumid = $albumid;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return Image
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse($user = null, array $items = null) {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->Path = $this->path;
        $result->Link = $this->link;
        $result->Type = $this->type;
        $result->Width = $this->width;
        $result->Height = $this->height;
        $result->MimeType = $this->mimetype;
        $result->FileSize = $this->filesize;
        $result->AlbumID = $this->albumid;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}


    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('image_id' => 'id',
            'image_path' => 'path',
            'image_link' => 'link',
            'image_type' => 'type',
            'image_width' => 'width',
            'image_height' => 'height',
            'image_mimetype' => 'mimetype',
            'image_filesize' => 'filesize',
            'image_albumid' => 'albumid',
        );
    }

    /**
     * Find ImageLink By Image ID
     * @param int $imageid
     * @return String image link
     */
    public static function findImageLink($imageid) {
        return self::findFirst(array("id = :id:", "bind" => array("id" => $imageid)))->link;
    }

}
