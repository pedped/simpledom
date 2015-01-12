<?php

class Elka {

    /**
     * Hold Client Information
     * @var type 
     */
    private $client;
    private $loginid = 0;
    private $loggedIn = false;

    /**
     * indicated wheter user logged in or not
     * @return boolean
     */
    public function getLoginid() {
        return $this->loginid;
    }

    // login information
    private $username = "07116388820";
    private $password = "22800711";
    private $posid = "13663";

    private function login(&$errors) {

        try {
            $client = new SoapClient("http://www.elkapos.com:81/ghasedaknetws.asmx?wsdl");

            // now try to connect
            $loginparams = new stdClass();
            $loginparams->Username = $this->username;
            $loginparams->Pass = $this->password;
            $loginparams->Pos_Id = $this->posid;
            $loginresult = $client->login($loginparams);
            var_dump($loginresult);
            $resultencoded = $loginresult->LoginResult;
            $resultdecoded = explode(";", $resultencoded);
            $result = (explode(",", $resultdecoded[1]));

            // check for login status and login id
            $loginStatus = $result[0];
            $loginID = $result[1];
            // check for login status
            if (strval($loginStatus) == "0") {
                // success login
                $this->loginid = $loginID;
                $this->loggedIn = true;
                return true;
            } else if (strval($loginStatus) == "4") {
                // khata dar system ya anjam amaliyat
                return false;
            } else if (strval($loginStatus) == "10") {
                // khata dar parameter haye vorodi
                return false;
            } else {
                // khata, invalid response code
                return false;
            }
        } catch (Exception $exc) {
            // TODO log problem
            BaseSystemLog::CreateLogError("Problem in loading", "problem in loggin in to elka system : " . $exc->getMessage());
            $errors[] = "سیستم در حال بروزرسانی می باشد ، لطفا چند دقیقه بعد مراجعه فرمایید .";
            return false;
        }
    }

    public function __construct(&$errors) {

        // disable cache
        //$ini = ini_set("soap.wsdl_cache_enabled", "0");
        // check if client is null, try to login to sysrem first
        if (!isset($this->client)) {
            $loginResult = $this->Login($errors);
            if (!$loginResult) {
                // unable to connect to system
                $errors[] = "در حال حاضر امکان ادامه عملیات امکان پذیر نمیباشد";
                return;
            }
        }
    }

    /**
     * Check Elka Credit
     * @return boolean|Double return value on succesfully, or false on unsuccessfully
     */
    public function CheckCredit() {
        $chargeparams = new stdClass();
        $chargeparams->Loginid = $this->loginid;
        $requestResult = $this->client->Inquiry_amount($chargeparams);


        // find result
        $res = $requestResult->RechargeResult;
        $result = explode(";", $res);
        $output = (explode(",", $result[1]));

        // check if request was successfully
        if (strval($output[0]) == "4") {
            // khata dar hangame check kardan
            return false;
        } else if (strval($output[0]) == "10") {
            // kahatarte login in
            return false;
        } else if (strval($output[0]) == "0") {
            // success
            return doubleval($output[1]);
        }

        return false;
    }

    /**
     * Recharge Phone Number
     * @param type $errors
     * @param type $phone
     * @param type $type
     * @param type $value
     * @param type $chargeID
     * @return boolean|int if successfully, retuens elka trans id, otherwise false
     */
    public function Recharge(&$errors, $phone, $type, $value, $chargeID) {

        $chargeparams = new stdClass();
        $chargeparams->Loginid = $this->loggedIn;
        $chargeparams->Tell_Number = $phone;
        $chargeparams->Amount = $value;
        $chargeparams->Service_Type = $type;
        $chargeparams->BrokerId = "13663";
        $chargeparams->B_ExtTrid = $chargeID;
        $result = $this->client->Recharge($chargeparams);
        $res = $result->RechargeResult;

        // check for result
        $result = explode(";", $res);
        $output = (explode(",", $result[1]));

        $status = $output[0];
        $elkaTransID = $output[1];
        $elkaPin = $output[2];

        // check for status
        if (strval($status) == "1") {
            // etebar kafi nist
            return false;
        }if (strval($status) == "2") {
            // shomare mojazi dar system nist
            return false;
        }if (strval($status) == "4") {
            // khata dar system
            return false;
        }if (strval($status) == "5") {
            // tarikhe login, na motabar ast, kar bar bayad dobare login namayad
            $this->login($errors);
            return $this->Recharge($errors, $phone, $type, $value, $chargeID);
        } else if (strval($status) == "6") {
            // dastgah gheyre faaal
            return false;
        } else if (strval($status) == "7") {
            // sharje darkhasti mojod nist va ya dar hale hazer emlak pazir nemibashad
            return false;
        } else if (strval($status) == "8") {
            // anjam amaliyate charge na movafagh bood
            return false;
        } else if (strval($status) == "10") {
            // kahatarte login in
            return false;
        } else if (strval($status) == "12") {
            // pos id na motabar ast
            return false;
        } else if (strval($status) == "0") {
            // success
            return $elkaTransID;
        }

        // invalid response
        return false;
    }

    /**
     * Check Charge Status
     * @param type $errors
     * @param type $transactionID
     * @return boolean|Status, false when we are not able to check, status on success check
     * 8 : Adame Movafgahiyate Charge
     * 13 : Dar Hale Charge
     */
    public function CheckChargeStatus(&$errors, $transactionID) {
        $chargeparams = new stdClass();
        $chargeparams->Loginid = $this->loginid;
        $chargeparams->TransactionID = $transactionID;
        $requestResult = $this->client->ChargeInQuery($chargeparams);


        // find result
        $res = $requestResult->RechargeResult;
        $result = explode(";", $res);
        $output = (explode(",", $result[1]));

        $status = $output[0];
        $transID = $output[1];
        $amount = $output[2];
        $date = $output[3];
        $time = $output[4];

        // check if request was successfully
        if (strval($status) == "4") {
            // khata dar hangame check kardan
            $errors[] = "خطا در هنگام بررسی";
            return false;
        } else if (strval($status) == "8") {
            // namovafagh
            return $status;
        } else if (strval($status) == "13") {
            // dar hale anjam
            return $status;
        } else if (strval($status) == "10") {
            // kahatarte login in
            $errors[] = "خطا در هنگام بررسی";
            return false;
        }

        return false;
    }

    /**
     * Check for status
     * @param type $IrancellORTCI
     * @return boolean If enabled, return true
     */
    public function GetStatus($IrancellORTCI) {

        $requestResult = $this->client->GetStatus();

        // find result
        $res = $requestResult->RechargeResult;
        $result = explode(";", $res);
        $output = (explode(",", $result[1]));

        $status = $output[0];
        $TCI = $output[1];
        $MTN = $output[2];
        $BANK = $output[3];

        // check if request was successfully
        if (strval($status) == "4") {
            // khata dar hangame check kardan
            return false;
        }

        // check for status
        return $IrancellORTCI ? intval($MTN) == 1 : intval($TCI) == 1;
    }

}
