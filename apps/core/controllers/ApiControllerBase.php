<?php

namespace Simpledom\Admin\BaseControllers;

use BaseUser;
use Phalcon\Mvc\View;

class ApiControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();

        // check if currenct user is not admin user, throw new error
        if (!$this->user->isSuperAdmin()) {
            die("invalid request, you are not super admin of this page");
        }

        // as we do not have any render level, we have to make NoRender for view
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    public function searchuserAction($query, $start = 0, $limit = 10) {

        $data = BaseUser::find(array(
                    "fullname LIKE CONCAT( '%' ,  ?1  , '%' )",
                    "start" => $start,
                    "limit" => "" . intval($start) . ", " . intval($limit),
                    "bind" => array(
                        1 => $query
                    )
        ));
 
        $this->sendResponse($data->toArray());
    }

    protected function ValidateAccess($id) {
        
    }

    /**
     * this function will send data to user as JSON format
     * @param type $data
     */
    public function sendResponse($data) {
        echo json_encode($data);
    }

}
