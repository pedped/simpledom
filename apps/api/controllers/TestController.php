<?php

namespace Simpledom\Api\Controllers;

use BaseImage;
use stdClass;

class TestController extends ControllerBase {

    /**
     * @mobile
     */
    public function randomdataAction() {
        $start = $this->request->getPost("start");
        $limit = $this->request->getPost("limit");


        $result = array();
        for ($i = $start; $i < $limit + $start; $i++) {
            $item = new stdClass();
            $item->id = $i;
            $item->number = $i;
            $item->name = $this->user->fname;
            $item->image = BaseImage::findFirst(rand(11, 13))->link;
            $result[] = $item;
        }
        
        return $this->getResponse($result);
    }

}
