<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use BaseUserLog;

class UserlogsControllerBase extends ControllerBase {

    public function listAction($page = 1, $userid = 0) {

        $this->setTitle("User Logs");

        // valid userid
        $userid = (int) $userid;

        // load the users
        $logs = null;
        if ($userid > 0) {
            $logs = BaseUserLog::find(
                            array(
                                "userid = '$userid'",
                                "order" => "date DESC"
            ));
        } else {
            $logs = BaseUserLog::find(
                            array(
                                "order" => "date DESC"
            ));
        }

        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $logs,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->logs = $paginator->getPaginate();
    }

    public function viewAction($id) {
        // set title
        $this->setTitle("View Userlog Item");

        // set user log
        $this->view->userLog = BaseUserLog::findFirst($id);
    }

    protected function ValidateAccess($id) {
        
    }

}
