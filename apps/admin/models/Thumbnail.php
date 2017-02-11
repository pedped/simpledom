<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Config;

class Thumbnail extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'thumbnail';
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
     * @return Thumbnail
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Original Image ID
     * @FieldName('Original Image ID')
     * @var string
     */
    public $originalimageid;

    /**
     * Set Original Image ID
     * @param type $originalimageid
     * @return Thumbnail
     */
    public function setOriginalimageid($originalimageid) {
        $this->originalimageid = $originalimageid;
        return $this;
    }

    /**
     * Scale ID
     * @FieldName('Scale ID')
     * @var string
     */
    public $scaleid;

    /**
     * Set Scale ID
     * @param type $scaleid
     * @return Thumbnail
     */
    public function setScaleid($scaleid) {
        $this->scaleid = $scaleid;
        return $this;
    }

    /**
     * Output Image ID
     * @FieldName('Output Image ID')
     * @var string
     */
    public $outputimageid;

    /**
     * Set Output Image ID
     * @param type $outputimageid
     * @return Thumbnail
     */
    public function setOutputimageid($outputimageid) {
        $this->outputimageid = $outputimageid;
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
     * @return Thumbnail
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
     *
     * @param type $parameters
     * @return Thumbnail
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
        $result->OriginalImageID = $this->originalimageid;
        $result->ScaleID = $this->scaleid;
        $result->OutputImageID = $this->outputimageid;
        $result->Date = $this->date;


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}





    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'originalimageid' => 'originalimageid',
            'scaleid' => 'scaleid',
            'outputimageid' => 'outputimageid',
            'date' => 'date',
        );
    }

    public static function GetThumbnail($imageid, $outputsize = 256) {

        // first, check if we have such item before
        $thu = Thumbnail::findFirst(array("originalimageid = :originalimageid: AND scaleid = :scale:", "bind" => array(
                        "originalimageid" => $imageid,
                        "scale" => $outputsize,
        )));
        if ($thu != FALSE) {
            // image already exist
            $image = Image::findFirst(array("id = :id:", "bind" => array("id" => $thu->outputimageid)));

            $result = new stdClass();
            $result->ImageLink = $image->link;
            $result->ImageID = $image->id;
            return $result;
        } else {

            // find the image
            $imageItem = Image::findFirst(array("id = :id:", "bind" => array("id" => $imageid)));
//        $imageResource = imagecreatefrompng($imageItem->path);
//        imagescale($imageResource, $scale);
            // File and new size
            $percent = 1;
            $filename = $imageItem->path;
            list($width, $height) = getimagesize($filename);
            if ($width > $height) {
                $percent = $outputsize / $width;
            } else {
                $percent = $outputsize / $height;
            }


            // Get new sizes

            $newwidth = $width * $percent;
            $newheight = $height * $percent;

            // Load
            $thumb = imagecreatetruecolor($newwidth, $newheight);

            $source = self::createJPGFile($filename);

            // Resize
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            // Output
            // Save the image as 'simpletext.jpg'
            // File size is valid, we have to move the file to safe place
            $filename = Config::generateRandomString(16) . ".jpg";
            $outputpath = Config::GetImagePath() . "/" . $filename;
            imagejpeg($thumb, $outputpath , 60);

            // Free up memory
            imagedestroy($thumb);


            $realtiveloaction = "userupload/image/" . $filename;

            // now we have to move the file to the right place
            $image = new Image();
            $image->filesize = filesize($outputpath);
            $image->mimetype = "jpeg";
            $image->path = $outputpath;
            $image->link = Config::getPublicUrl() . $realtiveloaction;
            if ($image->create()) {
                $thumbnailModel = new Thumbnail();
                $thumbnailModel->originalimageid = $imageid;
                $thumbnailModel->outputimageid = $image->id;
                $thumbnailModel->scaleid = $outputsize;
                $thumbnailModel->create();

                $result = new stdClass();
                $result->ImageLink = $image->link;
                $result->ImageID = $image->id;
                return $result;
            } else {
                $result = new stdClass();
                $result->ImageLink = "";
                $result->ImageID = 0;
                return $result;
            }
        }
    }

    public static function createJPGFile($input_file) {

        $ext = explode(".", $input_file);
        $ext = $ext[count($ext) - 1];
        if ($ext == "jpg" || $ext == "jpeg") {
            return imagecreatefromjpeg($input_file);
        } else {
            $input = imagecreatefrompng($input_file);
            list($width, $height) = getimagesize($input_file);
            $output = imagecreatetruecolor($width, $height);
            $white = imagecolorallocate($output, 255, 255, 255);
            imagefilledrectangle($output, 0, 0, $width, $height, $white);
            imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
            return $output;
        }
    }

}
