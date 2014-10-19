<?php

abstract class SmsProviderSystem {

    abstract function getProviderName();

    abstract function getDelivered($referneceCode);

    abstract function getStatus($id);

    abstract function Send($phones, $message, $fromnumber);

    /**
     * Hold the Provider Items
     * @var Array 
     */
    protected $parameters;

    /**
     * Init the SMS Manager By Informations
     * @param type $infos
     * @return \SmsProviderSystem
     */
    public function init($infos) {
        $items = explode("\r\n", $infos);
        foreach ($items as $item) {
            $info = explode(":=", $item);
            $this->parameters[$info[0]] = $info[1];
        }
        return $this;
    }

}
