<?php

namespace Simpledom\Api\Controllers;

use BaseUser;
use UserNotification;

class UserController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function getnotificationAction() {
        
        // get new notfications
        $notification = UserNotification::findFirst(array("userid = :userid: AND enable = 1 AND visited = '0'", "order" => "id ASC", "bind" => array("userid" => $this->user->userid)));
        if (!$notification) {
            // there is no new notification
            return $this->getResponse(false);
        } else {
            // set viisted
            $notification->visited = "1";
            $notification->visitdate = time();
            $notification->visitip = $_SERVER["REMOTE_ADDR"];
            $notification->save();
        }

        // send notification
        return $this->getResponse($notification->getPublicResponse());
    }

}
