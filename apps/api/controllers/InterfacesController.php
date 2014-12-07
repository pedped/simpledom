<?php

namespace Simpledom\Api\Controllers;

class InterfacesController extends ControllerBase {

    public function indexAction() {


        // get request key
        $requestKey = $_POST["request"];

        // define result parameter
        $result = null;

        // get result based on request
        switch ($requestKey) {
            case "getphones":
                $result = $this->getPhones();
                break;
            case "getpost":
                // remote server need user post
                $result = $this->getPost();
                break;
            default :
                die("invalid request");
                break;
        }

        // echo the result
        echo json_encode($result);
    }

    public function getPhones() {
        // detect key
        $key = strtolower($_POST["smskey"]);
        $code = isset($_POST["usercode"]) && strval($_POST["usercode"]) > 0 ? $_POST["usercode"] : null;

        // find array based on sms key
        switch ($key) {
            case "student" :
                // remote server need students number
                return $this->getStudentNumber($code);
            case "teacher" :
                // remote server need teacher number
                return $this->getTeacherNumber($code);
        }
    }

    /**
     * find user post based on phone number
     * @return array Array list of user post
     */
    public function getPost() {
        // fetch user number
        $phoneNumber = $_POST["phonenumber"];

        // here you should check for user post
        if ($phoneNumber == "09378231418") {
            return array("teacher", "boss");
        } else if ($phoneNumber == "09399477290") {
            return array("student");
        }
    }

    public function getStudentNumber($code = null) {
        return array(
            "9399477290"
        );
    }

    public function getTeacherNumber($code = null) {
        return array(
            "9378231418",
            "9335150042"
        );
    }

}
