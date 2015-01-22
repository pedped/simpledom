<?php

namespace Simpledom\Api\Controllers;

use BaseUser;
use UserNotification;

class UserController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function getnotificationAction() {

        // get last visit
        $lastvisit = $this->request->getPost("lastvisit");

        // check for last visit
        if (!isset($lastvisit) || strlen($lastvisit) == 0) {
            // return $this->getResponse(false);
            $lastvisit = 0;
        }

        // get new notfications
        $notification = UserNotification::findFirst(array("releasedate >= :releasedate: AND enable = 1 AND visited  = '0'", "order" => "id DESC", "bind" => array("releasedate" => $lastvisit)));
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
