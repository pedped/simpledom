<?php

use Simpledom\Core\Classes\SMSProviderInterface;

class AfeSMSProvider extends SmsProviderSystem implements SMSProviderInterface {

    public function getDelivered($referneceCode) {
        
    }

    public function getProviderName() {
        
    }

    public function getStatus($id) {
        
    }

    public function getRemain($includeCurrency = true) {
        $parameters = array();
        $parameters['username'] = $this->parameters["username"];
        $parameters['password'] = $this->parameters["password"];
        $value = $_POST['t1'];
        $url = 'http://www.afe.ir/WebService/webservice.asmx?wsdl';
        $method = 'GetRemainingCredit';
        $param = array('Username' => $parameters['username'], 'Password' => $parameters['password']);
        define($security, 1);
        $request = new AfeConnection($url, $method, $param);
        $message = $request->connect();
        $request->__destruct();
        unset($value, $url, $method, $param, $request);
        return $message . " ریال";
    }

    public static function isDelivered($referneceCode) {
        
    }

    public function Send($phones, $message, $fromnumber) {

        $parameters = array();
        $parameters['username'] = $this->parameters["username"];
        $parameters['password'] = $this->parameters["password"];

        // turn off the WSDL cache
        $value = $_POST['t1'];
        $url = 'http://www.afe.ir/WebService/V4/BoxService.asmx?wsdl';
        $method = 'SendMessage';
        $param = array('Username' => $parameters['username'], 'Password' => $parameters['password'], 'Number' => $fromnumber, 'Mobile' => $phones, 'Message' => $message, 'Type' => 1);
        define($security, 1);
        $request = new AfeConnection($url, $method, $param);
        $message = $request->connect();
        $request->__destruct();
        unset($value, $url, $method, $param, $request);
    }

}
