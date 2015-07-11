<?php

define("DATE_TYPE", "gregorian"); //gregorian or jalali, this can be overide per request/session
define("MONEY_UNIT", "UNITS");
define("DEFAULT_LANGUAGE", "en");


define("IBSNG_VERSION", "A1.24");

define("IBS_ROOT", "/home/admin/web/hotspot.livarfars.ir/public_html/public/ibsng/");
define("INTERFACE_ROOT", IBS_ROOT . "interface/");
define("IMAGES_ROOT", INTERFACE_ROOT . "IBSng/images/");

define("JPGRAPH_ROOT", INTERFACE_ROOT . "jpgraph/");

define("XMLRPCINC", INTERFACE_ROOT . "xmlrpc/");

define("IBSINC", INTERFACE_ROOT . "IBSng/inc/");

define("SMARTY_ROOT", INTERFACE_ROOT . "smarty/");
define("SMARTY_DIR", SMARTY_ROOT . "libs/");

define("XMLRPC_SERVER_IP", IbsngConfig::ServerIPAddress());
define("XMLRPC_SERVER_PORT", IbsngConfig::ServerIPPort());
define("XMLRPC_TIMEOUT", 240);
?>
