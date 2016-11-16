<?php

define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}
$Actions = true;
if ($TDMCore->arConfig["MODULE_DB_SERVER"] == "localhost") {
	$TDMCore->arConfig["MODULE_DB_SERVER"] = "127.0.0.1";
}
if (!(extension_loaded("pdo_mysql"))) {
	ErAdd("PHP extension \"pdo_mysql\" is not loading!", 1);
	$Actions = false;
}
else {
	$ops = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");
}
if ($_POST["create_tables"] == "Y" && $TDMCore->isDBCon && $Actions) {
	$FileName = $_SERVER["DOCUMENT_ROOT"] . "/" . TDM_ROOT_DIR . "/admin/db.sql";
	if (!($FHandle = @fopen($FileName, "r"))) {
		ErAdd("\"/" . TDM_ROOT_DIR . "/admin/db.sql\" - not readable", 2);
	}
	else {
		$db = new PDO("mysql:host=" . $TDMCore->arConfig["MODULE_DB_SERVER"] . ";dbname=" . $TDMCore->arConfig["MODULE_DB_NAME"], $TDMCore->arConfig["MODULE_DB_LOGIN"], $TDMCore->arConfig["MODULE_DB_PASS"], $ops);
		$sql = file_get_contents($FileName);
		$qr = $db->exec($sql);
		$arErr = $db->errorInfo();
		if (0 < $arErr[0]) {
			ErAdd($arErr[2], 1);
		}
		NtAdd("QUERY SEND \"CREATE TABLES\"");
	}
}
if ($_POST["send_query"] == "Y" && $_POST["sqlquery"] != "" && $TDMCore->isDBCon && ErCheck()) {
	$db = new PDO("mysql:host=" . $TDMCore->arConfig["MODULE_DB_SERVER"] . ";dbname=" . $TDMCore->arConfig["MODULE_DB_NAME"], $TDMCore->arConfig["MODULE_DB_LOGIN"], $TDMCore->arConfig["MODULE_DB_PASS"], $ops);
	$qr = $db->exec($_POST["sqlquery"]);
	$arErr = $db->errorInfo();
	if (0 < $arErr[0]) {
		ErAdd($arErr[2], 1);
	}
}
echo("<head><title>TDM :: ");
echo(Lng("Database_service", 1, 0));
echo("</title></head>\n<div class=\"apanel_cont\">");
require_once("apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t");
jsLinkJqueryUi();
echo("\t<h1>");
echo(Lng("Database_service"));
echo("</h1>\n\t<hr>\n\t");
ErShow();
echo("\t<table class=\"simtab\">\n\t\t");
$arTables = array();
if ($TDMCore->isDBCon) {
	$rsSQL = mysql_query("SHOW TABLES");
	if (0 < mysql_num_rows($rsSQL)) {
		while ($arRow = mysql_fetch_array($rsSQL, MYSQL_NUM)) {
			$arCols = array();
			$Table = $arRow[0];
			if ($Table == $_REQUEST["delem"] && $_POST["delete"] == "Y") {
				mysql_query("DROP TABLE IF EXISTS `" . $Table . "`;");
				continue;
			}
	/*	if(mysql_num_rows($rsSQL)>0){
				while($arRow = mysql_fetch_array($rsSQL, MYSQL_NUM)){
					$arCols = Array();
					$Table = $arRow[0];
					if($Table==$_REQUEST['delem'] AND $_POST['delete']=="Y"){
						mysql_query("DROP TABLE IF EXISTS `".$Table."`;");
						continue;
					}*/
	
        


		$rsCntSQL = mysql_query("SELECT COUNT(*) FROM " . $Table);
			$arCnt = mysql_fetch_row($rsCntSQL);
			echo("<tr><td>" . $arCnt[0] . "</td><td><b>" . $Table . "</b><br><span class=\"secontext\">");
			$rsFields = mysql_list_fields($TDMCore->arConfig["MODULE_DB_NAME"], $Table, $TDMCore->rsSQL);
			$ColsNum = mysql_num_fields($rsFields);
			$i = 0;
			while ($i < $ColsNum) {
				$arCols[] = mysql_field_name($rsFields, $i);
				++$i;
			}
			$strCols = implode(", ", $arCols);
			echo($strCols);
			echo("</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<a href=\"javascript:void(0);\" onclick=\"");
			jsDelConfirm($Table);
			echo("\" ><img src=\"images/trash.gif\" width=\"16\" height=\"16\" title=\"");
			echo(Lng("Delete", 1, 0));
			echo("\"></a>\n\t\t\t\t\t</td>\n\t\t\t\t\t</tr>\n\t\t\t\t\t");
		}
	}
	else {
		echo("\t\t\t\t<td>\n\t\t\t\t\t<b>No tables selected in DataBase:</b> <br>\n\t\t\t\t\t");
		echo($TDMCore->arConfig["MODULE_DB_SERVER"]);
		echo("<br>\n\t\t\t\t\t");
		echo($TDMCore->arConfig["MODULE_DB_NAME"]);
		echo("<br>\n\t\t\t\t\t");
		echo($TDMCore->arConfig["MODULE_DB_LOGIN"]);
		echo("<br>\n\t\t\t\t\t");
		echo($TDMCore->arConfig["MODULE_DB_PASS"]);
		echo("<br>\n\t\t\t\t</td>\n\t\t\t");
	}
}
else {
	echo("\t\t\t<td>\n\t\t\t\t<b>No DataBase connection:</b> <br>\n\t\t\t\t");
	echo($TDMCore->arConfig["MODULE_DB_SERVER"]);
	echo("<br>\n\t\t\t\t");
	echo($TDMCore->arConfig["MODULE_DB_NAME"]);
	echo("<br>\n\t\t\t\t");
	echo($TDMCore->arConfig["MODULE_DB_LOGIN"]);
	echo("<br>\n\t\t\t\t");
	echo($TDMCore->arConfig["MODULE_DB_PASS"]);
	echo("<br>\n\t\t\t</td>\n\t\t");
}
echo("\t</table>\n\t<br>\n\t<br><br>\n\t");
if ($TDMCore->isDBCon && $Actions) {
	echo("\t\t<form name=\"qform\" id=\"qform\" action=\"\" method=\"post\">\n\t\t\t<input type=\"hidden\" name=\"send_query\" value=\"Y\"/>\n\t\t\t<textarea name=\"sqlquery\" class=\"subinput\" style=\"margin:0px 0px 20px 0px; width:1080px; height:200px;\">");
	echo($_POST["sqlquery"]);
	echo("</textarea>\n\t\t\t<br>\n\t\t\t<input type=\"submit\" value=\"Send query\" class=\"abutton\" /> \n\t\t</form>\n\t");
}
echo("\t");
if ($TDMCore->isDBCon && $Actions) {
	echo("\t\t<form name=\"dform\" id=\"dform\" action=\"\" method=\"post\" style=\"float:right; margin:-52px 20px 0px 0px;\">\n\t\t\t<input type=\"hidden\" name=\"create_tables\" value=\"Y\"/>\n\t\t\t<input type=\"submit\" value=\"Create tables\" class=\"abutton\" /> \n\t\t</form>\n\t");
}
echo("</div>");

