<?php

use Simpledom\Core\AtaModel;
use Simpledom\Core\Classes\Helper;

class LoginRequest extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'loginrequest';
    }

    /**
     * ID
     * @FieldName('ID')
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return LoginRequest
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Device Model
     * @FieldName('Device Model')
     * @var string
     */
    public $devicemodel;

    /**
     * Set Device Model
     * @param type $devicemodel
     * @return LoginRequest
     */
    public function setDevicemodel($devicemodel) {
        $this->devicemodel = $devicemodel;
        return $this;
    }

    /**
     * Device ID
     * @FieldName('Device ID')
     * @var string
     */
    public $deviceid;

    /**
     * Set Device ID
     * @param type $deviceid
     * @return LoginRequest
     */
    public function setDeviceid($deviceid) {
        $this->deviceid = $deviceid;
        return $this;
    }

    /**
     * Android Version Code
     * @FieldName('Android Version Code')
     * @var string
     */
    public $androidversioncode;

    /**
     * Set Android Version Code
     * @param type $androidversioncode
     * @return LoginRequest
     */
    public function setAndroidversioncode($androidversioncode) {
        $this->androidversioncode = $androidversioncode;
        return $this;
    }

    /**
     * Phone Number
     * @FieldName('Phone Number')
     * @var string
     */
    public $phonenumber;
    public $disabled;

    /**
     * Set Phone Number
     * @param type $phonenumber
     * @return LoginRequest
     */
    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;
        return $this;
    }

    /**
     * Android Version Name
     * @FieldName('Android Version Name')
     * @var string
     */
    public $androidversionname;

    /**
     * Set Android Version Name
     * @param type $androidversionname
     * @return LoginRequest
     */
    public function setAndroidversionname($androidversionname) {
        $this->androidversionname = $androidversionname;
        return $this;
    }

    /**
     * IP
     * @FieldName('IP')
     * @var string
     */
    public $ip;

    /**
     * Set IP
     * @param type $ip
     * @return LoginRequest
     */
    public function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Token
     * @FieldName('Token')
     * @var string
     */
    public $token;

    /**
     * Set Token
     * @param type $token
     * @return LoginRequest
     */
    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    /**
     * Date
     * @FieldName('Date')
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return LoginRequest
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return LoginRequest
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->disabled = 0;
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse($user = null, array $items = null) {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->DeviceModel = $this->devicemodel;
        $result->DeviceID = $this->deviceid;
        $result->AndroidVersionCode = $this->androidversioncode;
        $result->PhoneNumber = $this->phonenumber;
        $result->AndroidVersionName = $this->androidversionname;
        $result->IP = $this->ip;
        $result->Token = $this->token;
        $result->Date = $this->date;


        return $result;
    }

//public function validation()
//{
//return $this->validationHasFailed() != true;
//}


    public function columnMap() {
// Keys are the real names in the table and
// the values their names in the application
        return array('id' => 'id',
            'devicemodel' => 'devicemodel',
            'deviceid' => 'deviceid',
            'androidversioncode' => 'androidversioncode',
            'phonenumber' => 'phonenumber',
            'androidversionname' => 'androidversionname',
            'ip' => 'ip',
            'token' => 'token',
            'date' => 'date',
            'disabled' => 'disabled',
        );
    }

    /**
     * generate Token for phone validation, this function will check for user limit
     * @param type $errors
     * @param type $phone
     * @param type $androidversioncode
     * @param type $androidversionname
     * @param type $deviceid
     * @param type $devicemodel
     * @param type $ip
     * @return boolean
     */
    public static function GenerateToken(&$errors, $phone, $androidversioncode, $androidversionname, $deviceid, $devicemodel, $ip) {
//        // check if user is not reached limitation
//        if (!Limitation::OnUserEvent($errors, LIMIT_LOGINWITHPHONENUMBER, "phone_" . $phone)) {
//            // user has reached the limitation
//            return false;
//        }

        // we have to disable other requests
        $lr = new LoginRequest();
        $lr->rawQuery("UPDATE LoginRequest SET disabled = 1 WHERE phonenumber = :phone:", array(
            "phone" => $phone
        ));

        // now we have to create new login request
        $loginRequest = new LoginRequest();
        $loginRequest->androidversioncode = $androidversioncode;
        $loginRequest->androidversionname = $androidversionname;
        $loginRequest->deviceid = $deviceid;
        $loginRequest->devicemodel = $devicemodel;
        $loginRequest->ip = $ip;
        $loginRequest->phonenumber = $phone;

        // now we have to create 4 digit phone number
        $loginRequest->token = Helper::GenerateRandomNumber(4);

        // create model
        if (!$loginRequest->create()) {
            $errors[] = $loginRequest->getMessagesAsLines();
            return false;
        }

        // successfully created, we have to send back token
        return $loginRequest->token;
    }

    public static function ValidateToken(&$errors, $phone, $token) {

        // check for limitation first
//        if (!Limitation::OnUserEvent($errors, LIMIT_CHECKPHONETOKEN, "phone_" . $phone . "_" . $token)) {
//            // user has reached the limitation,
//            // user tries many code, we have to disale phone token
//            // we have to get last item of user token and check with that
//            $loginRequest = LoginRequest::findFirst(array("phonenumber = :phone:",
//                        "bind" => array(
//                            "phone" => $phone,
//                        ),
//                        "order" => "id DESC"
//            ));
//
//            // check if login request exist
//            $loginRequest->disabled = 1;
//            $loginRequest->save();
//            $errors[] = _("Try to login again");
//            return false;
//        //}

        // validate inputs
        if (!Validating::ValidatePhoneConfirmCode($errors, $token)) {
            // invalid inputs
            return false;
        }

        // we have to get last item of user token and check with that
        $loginRequest = LoginRequest::findFirst(array("phonenumber = :phone: AND token = :token: AND disabled = 0",
                    "bind" => array(
                        "phone" => $phone,
                        "token" => $token,
                    ),
                    "order" => "id DESC"
        ));

        // check if login request exist
        if ($loginRequest == FALSE) {
            $errors[] = _("Sorry, But we did not find valid phone number with this confirm code");
            return false;
        } else {

            // we have foudn valid confirm code, we have to disable this login request for future request
            $loginRequest->disabled = 1;
            $loginRequest->save();

            // retun valid token
            return true;
        }
    }

}
