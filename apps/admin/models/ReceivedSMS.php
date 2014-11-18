<?php

class ReceivedSMS extends BaseReceivedSMS {

    public function getMessage() {
        return nl2br($this->message);
    }

}
