<?php

namespace Simpledom\Api\Controllers;

use BaseUser;

class BongahController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

}
