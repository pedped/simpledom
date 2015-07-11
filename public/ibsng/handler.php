<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("interface/IBSng/inc/init.php");

require_once(IBSINC . "user.php");
require_once(IBSINC . "perm.php");
require_once(IBSINC . "user_face.php");
require_once(IBSINC . "admin_face.php");
require_once(IBSINC . "group_face.php");
require_once("interface/IBSng/admin/plugins/edit_funcs.php");

//needAuthType(ADMIN_AUTH_TYPE);
?>