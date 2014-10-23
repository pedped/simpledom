<?php

namespace Simpledom\Core\Classes;

interface SMSProviderInterface {

    static function isDelivered($referneceCode);
}
