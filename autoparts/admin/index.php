<?php

define("TDM_PROLOG_INCLUDED", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] == "Y") {
	define("TDM_ADMIN_SIDE", true);
}
if ($_REQUEST["logout"] == "Y") {
	$_SESSION["TDM_ISADMIN"] = "N";
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}
if ($_POST["authme"] == "Y" && $_SESSION["TDM_ISADMIN"] != "Y" && 0 < strlen($_POST["kpass"])) {
	if ($_POST["kpass"] == $TDMCore->arConfig["MODULE_ADMIN_PASSW"]) {
		$_SESSION["TDM_ISADMIN"] = "Y";
		header("Location: /" . TDM_ROOT_DIR . "/admin/");
		exit();
	}
	else {
		$ERROR = "Wrong password...";
	}
}
{define('TDM_ADMIN_SIDE',true);}
if($_REQUEST['logout']=="Y"){$_SESSION['TDM_ISADMIN']="N"; header('Location: /'.TDM_ROOT_DIR.'/admin/'); die();}
if($_POST['authme']=="Y" AND $_SESSION['TDM_ISADMIN']!="Y" AND strlen($_POST['kpass'])>0){
	if($_POST['kpass']==$TDMCore->arConfig['MODULE_ADMIN_PASSW']){
		$_SESSION['TDM_ISADMIN'] = "Y";
		header('Location: /'.TDM_ROOT_DIR.'/admin/'); die();
	}else{
		$ERROR = "Wrong password...";
	}
}
echo("<head><title>TDMod :: Admin panel</title></head>\n");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	echo("\t<div class=\"tdm_acontent\">\n\t\t<link rel=\"stylesheet\" href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/styles.css\" type=\"text/css\">\n\t\t<link rel=\"stylesheet\" href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/adminside.css\" type=\"text/css\">\n\t\t<link rel=\"stylesheet\" href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/styles.css\" type=\"text/css\">\n\t\t<h1>");
	echo(Lng("Please_login"));
	echo(":</h1><div class=\"tclear\"></div>\n\t\t");
	if ($ERROR != "") {
		echo("<div class=\"tderror\">");
		echo($ERROR);
		echo("</div>");
	}
	echo("\t\t<form name=\"aform\" id=\"aform\" action=\"\" method=\"post\">\n\t\t\t<input type=\"hidden\" name=\"authme\" value=\"Y\"/>\n\t\t\t<input type=\"password\" name=\"kpass\" value=\"11112\" size=\"20\" class=\"keyinp\" maxlength=\"30\"/>\n\t\t\t<div class=\"goinp\"><input type=\"submit\" value=\"Login\" class=\"abutton\"/></div>\n\t\t</form>\n\t\t<a href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/\" class=\"nolink\">");
	echo(Lng("Return_to_module_catalog"));
	echo(" &#9658;</a>\n\t</div>\n");
}
else {
	echo("\t<script>function UpdFSubm(){\$('#uform').submit();}</script>\n\t<script>function LoginForm(Login){\$('#login').val(Login); \$('#aform').submit();}</script>\n\t<div class=\"apanel_cont\">");
	require_once("apanel.php");
	echo("</div>\n\t<div class=\"tdm_acontent\">\n\t\t<h1>");
	echo(Tip("Tecdoc_module"));
	echo(" :: v");
	echo("</h1>\n\t\t<hr>\n\t\t<table width=\"100%\"><tr><td width=\"1%\" style=\"vertical-align:top;\">\n\t\t\t<div class=\"servinfo\">\n\t\t\t\t<table width=\"100%\">\n\t\t\t\t\t<tr><td colspan=\"2\" class=\"sihead\">Server configuration:</td></tr>\n\t\t\t\t\t<tr><td>PHP version:</td><td>");
	echo(phpversion());
	echo("</td></tr>\n\t\t\t\t\t<tr><td>PHP write permissions:</td><td>");
	if (is_writable("index.php")) {
		echo("Ok");
	}
	else {
		echo("<span>No permissions</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t");
	echo("\t\t\t\t\t<tr><td colspan=\"2\" class=\"sihead\">PHP loaded extensions:</td></tr>\n\t\t\t\t\t<tr><td>mbstring:</td><td>");
	if (extension_loaded("mbstring")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t<tr><td>iconv:</td><td>");
	if (extension_loaded("iconv")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t<tr><td>sockets:</td><td>");
	if (extension_loaded("sockets")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t<tr><td>soap:</td><td>");
	if (extension_loaded("soap")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t<tr><td>curl:</td><td>");
	if (extension_loaded("curl")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t<tr><td>pdo_mysql:</td><td>");
	if (extension_loaded("pdo_mysql")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t<tr><td>rar:</td><td>");
	if (extension_loaded("rar")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t\t<tr><td>zip:</td><td>");
	if (extension_loaded("zip")) {
		echo("Loaded");
	}
	else {
		echo("<span>Not loaded</span>");
	}
	echo("</td></tr>\n\t\t\t\t</table>\n\t\t\t</div>\n\t\t\t</td><td style=\"vertical-align:top;\">\n\t\t\t\t<form name=\"uform\" id=\"uform\" action=\"\" method=\"post\"><input type=\"hidden\" name=\"DOWNLOAD\" value=\"Y\"></form>\n\t\t\t\t<form name=\"aform\" id=\"aform\" action=\"http://tecdoc-module.com/personal/\" target=\"_blank\" method=\"post\"><input type=\"hidden\" id=\"login\" name=\"LOGIN\" value=\"\"></form>\n\t\t\t\t");
	
	//require_once("admpanel1.php");
	echo("\t\t\t</td></tr>\n\t\t</table>\n\t\t\n\t\t\n\t</div>\n");
}

