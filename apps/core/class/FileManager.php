<?php

namespace Simpledom\Core\Classes;

use BaseImage;
use BaseSystemLog;
use Phalcon\Http\Request\File;

class FileManager {

    /**
     * 
     * @param type $errors
     * @param File $file
     * @param type $outputFileName
     * @param string $realtiveloaction
     * @return boolean|BaseImage
     */
    public static function HandleImageUpload(&$errors, $file, &$outputFileName, &$realtiveloaction) {
        //var_dump($file, Config::GetImagePath());
        // check if the file is image file
        if ($file->getType() != "application/octet-stream" && $file->getType() != "image/jpeg" && $file->getType() != "image/jpg" && $file->getType() != "image/bmp" && $file->getType() != "image/png" && $file->getType() != "image/gif") {
            // the file type s not valid
            $errors[] = "This file type is invalid : " . $file->getType();
            return;
        }


        // check if the file size for max file upload limit is not reached
        if ($file->getSize() > Config::getMaxUserImageFileSizeUploadLimit()) {
            $errors[] = "The file size is very huge, please use lower file size";
            return;
        }

        $ext = explode(".", $file->getName());
        $ext = $ext[count($ext) - 1];
        if ($ext != "jpg" && $ext != "jpeg" && $ext != "gif" && $ext != "png") {
            $errors[] = "invalid file format";
            return;
        }
        
        // TODO , we have to resize image and safe for safe image upload

        // File size is valid, we have to move the file to safe place
        $filename = Config::generateRandomString(32) . "." . $ext;

        // add file name to output file name
        $outputFileName = $filename;
        $realtiveloaction = "userupload/image/" . $outputFileName;

        // now we have to move the file to the right place
        $path = Config::GetImagePath() . "/" . $filename;
        if ($file->moveTo($path)) {
            $image = new BaseImage();
            $image->filesize = filesize($path);
            $image->mimetype = $file->getType();
            $image->path = $path;
            $image->link = Config::getPublicUrl() . $realtiveloaction;
            $image->create();
            return $image;
        } else {
            BaseSystemLog::init($item)->setIP($_SERVER["SERVER_ADDR"])->setTitle("Upload Error")->setMessage("Unable to move uploaded file to $path")->create();
            return false;
        }
    }

}
