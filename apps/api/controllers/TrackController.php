<?php

namespace Simpledom\Api\Controllers;

use BaseTrack;
use BaseUser;

class TrackController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function listAction() {
        $results = array();
        foreach (BaseTrack::find() as $value) {
            $results[] = $value->getPublicResponse();
        }
        return $this->getResponse($results);
    }

}
