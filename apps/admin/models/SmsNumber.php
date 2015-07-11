<?php

class SmsNumber extends BaseSmsNumber {

    public function getProviderName() {
        return SMSProvider::findFirst(array("id = :id:", "bind" => array("id" => $this->providerid)))->name;
    }

}
