<?php

error_reporting(32767 & ~8);
session_set_cookie_params(3600 * 24 * 3, "/");
session_start();
require_once("defines.php");
require_once("classes.php");
require_once("tdquery.php");
require_once("functions.php");
if (defined("TDM_ADMIN_SIDE") && TDM_ADMIN_SIDE) {
	TDMCheckAdmin();
	require_once(TDM_PATH . "/admin/methods.php");
}
if (!(defined("NO_HEADERS_CHARSET"))) {
	header("Content-type: text/html; charset=utf-8");
}
global $arCartPrice;
global $StatTime;
global $arTDMConfig;
global $TDMCore;
$TDMCore = new TDMCore();

