<?php

namespace Simpledom\Api\Controllers;

use Simpledom\Core\Classes\FileManager;

class FileController extends ControllerBase {

    public function uploadAction() {
        
    }

    public function uploadimageAction() {

        // save images
        $resuls = array();
        if ($this->request->hasFiles()) {
            // valid request, load the files
            foreach ($this->request->getUploadedFiles() as $file) {
                $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                if ($image) {
                    $resuls[] = $image->getPublicResponse();
                }
            }

            // return success result
            return $this->getResponse($resuls);
        }

        // invalid request or we have problem
        return $this->getResponse(false);
    }

}
