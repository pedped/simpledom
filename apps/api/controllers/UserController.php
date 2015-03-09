<?php

namespace Simpledom\Api\Controllers;

use Advertise;
use BaseUser;
use Simpledom\Core\Classes\FileManager;
use stdClass;
use UserNotification;

class UserController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function saveprofileinfoAction() {
        $usertype = $this->request->getPost("usertype");
        $phonenumber = $this->request->getPost("phonenumber");

        $this->user->usertype = $usertype;
        $this->user->userphone = $phonenumber;
        $this->user->save();

        // try to add image if exist
        // save images
        if ($this->request->hasFiles()) {
            // valid request, load the files
            foreach ($this->request->getUploadedFiles() as $file) {
                $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                $this->user->imagelink = $image->link;
                $this->user->save();
            }
        }

        return $this->getResponse($this->user->getPublicResponse());
    }

    public function addadvertiseAction() {

        $androiddeviceid = $_POST["androiddeviceid"];
        $currentview = $_POST["currentview"];
        $garantee = $_POST["garantee"];
        $moreacc = $_POST["moreacc"];
        $price = $_POST["price"];
        $visittime = $_POST["visittime"];
        $repaired = $_POST["repaired"];
        $categoryid = $_POST["categoryid"];
        $haveholder = $_POST["haveholder"];
        $description = $_POST["description"];
        $cityid = $_POST["cityid"];


        $imageID = null;

        // try to add image if exist
        // save images
        if ($this->request->hasFiles()) {
            // valid request, load the files
            foreach ($this->request->getUploadedFiles() as $file) {
                $image = FileManager::HandleImageUpload($this->errors, $file, $outputname, $realtiveloaction);
                $imageID = $image->id;
            }
        }

        // add advertise
        $advertise = new Advertise();
        if (isset($imageID)) {
            $advertise->imageid = $imageID;
        }
        $advertise->userid = $this->user->userid;
        $advertise->categoryid = $categoryid;
        $advertise->deviceid = $androiddeviceid;
        $advertise->currentview = $currentview;
        $advertise->garantee = $garantee;
        $advertise->moreacc = $moreacc;
        $advertise->price = $price;
        $advertise->repaired = $repaired;
        $advertise->visittime = $visittime;
        $advertise->haveholder = $haveholder;
        $advertise->description = $description;
        $advertise->cityid = $cityid;

        if (!$advertise->create()) {
            $this->errors[] = $advertise->getMessagesAsLines();
            return $this->getResponse(false);
        } else {

            // try to save images

            $result = new stdClass();
            $result->advertiseid = $advertise->id;
            $result->categoryid = $advertise->categoryid;
            $result->advertise = $advertise->getPublicResponse();
            return $this->getResponse($result);
        }
    }

    public function myadsAction() {

        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        // categors 
        $advertise = Advertise::find(
                        array(
                            "userid = :userid:",
                            "limit" => "$start , $limit",
                            "bind" => array(
                                "userid" => $this->user->userid
        )));

        $results = array();
        foreach ($advertise as $category) {
            $results[] = $category->getPublicResponse();
        }
        return $this->getResponse($results);
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
