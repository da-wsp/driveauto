<?php

define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}


$arWSrvs = array();
$resDB = new TDMQuery();
$resDB->Select("TDM_WS", array(), array());
while ($arWebServ = $resDB->Fetch()) {
	if ($_POST["delete"] == "Y" && $_POST["delem"] == $arWebServ["ID"]) {
		$DResCnt = $resDB->Delete("TDM_WS", array("ID" => $_POST["delem"]));
		if (0 < $DResCnt) {
			NtAdd(Lng("Record_deleted") . ": " . $_POST["delem"]);
			$_POST["delem"] = "";
			$_POST["delete"] = "";
			$rsDDBWS = new TDMQuery();
			$rsDDBWS->Delete("TDM_WS_TIME", array("WSID" => $arWebServ["ID"]));
		}
		TDMRedirect("admin/ws.php");
	}
	if (!($_REQUEST["ID"] == $arWebServ["ID"])) {
		continue;
	}
	$CID = $arWebServ["ID"];
	$CurWS = $arWebServ;
	$_POST["PRICE_CODE"] = $arWebServ["PRICE_CODE"];
	if (!($_POST["edit"] != "Y")) {
		continue;
	}
	foreach ($arWebServ as $Key => $Value) {
		$_POST[$Key] = $Value;
	}
}
if ($_POST["delete"] == "Y") {
	$rsCWS = new TDMQuery();
	if ($_POST["delem"] == "EMPTY_PRICES") {
		$rsCWS->Delete("TDM_PRICES", array("CODE" => $CurWS["PRICE_CODE"]));
		$Clr1 = "redcolor";
	}
	if ($_POST["delem"] == "EMPTY_LINKS") {
		$rsCWS->Delete("TDM_LINKS", array("CODE" => $CurWS["PRICE_CODE"]));
		$Clr2 = "redcolor";
	}
	if ($_POST["delem"] == "EMPTY_BYPKEY") {
		$rsCWS->Delete("TDM_WS_TIME", array("WSID" => $CurWS["ID"], "SID" => ""));
		$Clr4 = "redcolor";
	}
	if ($_POST["delem"] == "EMPTY_BYSEC") {
		$rsCWS->Delete("TDM_WS_TIME", array("WSID" => $CurWS["ID"], "SID!" => 0));
		$Clr3 = "redcolor";
	}
}
if (0 < $CurWS["ID"]) {
	$rsCWS = new TDMQuery();
	$rsCWS->SimpleSelect("SELECT COUNT(*) FROM TDM_PRICES WHERE CODE=\"" . $CurWS["PRICE_CODE"] . "\" ");
	if ($arDB = $rsCWS->Fetch()) {
		$PricesCount = $arDB["COUNT(*)"];
	}
	$rsCWS->SimpleSelect("SELECT COUNT(*) FROM TDM_LINKS WHERE CODE=\"" . $CurWS["PRICE_CODE"] . "\" ");
	if ($arDB = $rsCWS->Fetch()) {
		$LinksCount = $arDB["COUNT(*)"];
	}
	$rsCWS->SimpleSelect("SELECT COUNT(*) FROM TDM_WS_TIME WHERE WSID=\"" . $CurWS["ID"] . "\" AND SID>0 ");
	if ($arDB = $rsCWS->Fetch()) {
		$CachedSectionsCount = $arDB["COUNT(*)"];
	}
	$rsCWS->SimpleSelect("SELECT COUNT(*) FROM TDM_WS_TIME WHERE WSID=\"" . $CurWS["ID"] . "\" AND SID=\"\" ");
	if ($arDB = $rsCWS->Fetch()) {
		$CachedPKEYCount = $arDB["COUNT(*)"];
	}
}
if ($_POST["edit"] == "Y") {
	$_POST["ACTIVE"] = intval($_POST["ACTIVE"]);
	$_POST["CACHE"] = intval($_POST["CACHE"]);
	$_POST["LINKS_TAKE"] = intval($_POST["LINKS_TAKE"]);
	$_POST["NAME"] = substr(trim($_POST["NAME"]), 0, 32);
	$_POST["PRICE_CODE"] = substr(trim($_POST["PRICE_CODE"]), 0, 32);
	$_POST["REFRESH_TIME"] = intval($_POST["REFRESH_TIME"]);
	$_POST["QUERY_LIMIT"] = intval($_POST["QUERY_LIMIT"]);
	$_POST["LINKS_SIDE"] = intval($_POST["LINKS_SIDE"]);
	$_POST["CURRENCY"] = substr($_POST["CURRENCY"], 0, 3);
	$_POST["PRICE_EXTRA"] = intval($_POST["PRICE_EXTRA"]);
	$_POST["PRICE_ADD"] = floatval($_POST["PRICE_ADD"]);
	$_POST["TYPE"] = intval($_POST["TYPE"]);
	$_POST["DAY_ADD"] = intval($_POST["DAY_ADD"]);
	if ($_POST["MIN_AVAIL"] != "") {
		$_POST["MIN_AVAIL"] = intval($_POST["MIN_AVAIL"]);
	}
	if ($_POST["MAX_DAY"] != "") {
		$_POST["MAX_DAY"] = intval($_POST["MAX_DAY"]);
	}
	if (strlen($_POST["NAME"]) < 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Name"), 1);
	}
	if ($CID <= 0 && strlen($_POST["PRICE_CODE"]) < 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Code"), 1);
	}
	if (strlen($_POST["SCRIPT"]) < 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Handler"), 1);
	}
	if (trim($_POST["LOGIN"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Login"), 1);
	}
	if (trim($_POST["PASSW"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Password"), 1);
	}
	if ($_POST["QUERY_LIMIT"] <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Query_limit"), 1);
	}
	if (ErCheck() && $CID <= 0) {
		$resDB->Select("TDM_WS", array(), array("PRICE_CODE" => $_POST["PRICE_CODE"]));
		if ($arRes = $resDB->Fetch()) {
			ErAdd(Lng("Code") . " \"" . $_POST["PRICE_CODE"] . "\" " . Lng("is_already_exist", 2), 1);
		}
	}
	if (ErCheck()) {
		$arFields = array("NAME" => $_POST["NAME"], "ACTIVE" => $_POST["ACTIVE"], "SCRIPT" => $_POST["SCRIPT"], "CACHE" => $_POST["CACHE"], "CLIENT_ID" => $_POST["CLIENT_ID"], "LOGIN" => $_POST["LOGIN"], "PASSW" => $_POST["PASSW"], "QUERY_LIMIT" => $_POST["QUERY_LIMIT"], "CURRENCY" => $_POST["CURRENCY"], "TYPE" => $_POST["TYPE"], "DAY_ADD" => $_POST["DAY_ADD"], "PRICE_ADD" => $_POST["PRICE_ADD"], "PRICE_EXTRA" => $_POST["PRICE_EXTRA"], "MIN_AVAIL" => $_POST["MIN_AVAIL"], "MAX_DAY" => $_POST["MAX_DAY"], "LINKS_TAKE" => $_POST["LINKS_TAKE"], "LINKS_SIDE" => $_POST["LINKS_SIDE"], "REFRESH_TIME" => $_POST["REFRESH_TIME"]);
		if (0 < $CID) {
			$IRes = $resDB->Update2("TDM_WS", $arFields, array("ID" => $CID));
			if ($IRes) {
				NtAdd(Lng("Record_updated") . ": " . $_POST["NAME"]);
			}
		}
		else {
			$arFields["PRICE_CODE"] = StrForURL($_POST["PRICE_CODE"]);
			$NewID = $resDB->Insert("TDM_WS", $arFields);
			if ($NewID) {
				TDMRedirect("admin/ws.php?ID=" . $NewID);
			}
		}
	}
}
$resDB->Select("TDM_WS", array(), array());
while ($arWebServ = $resDB->Fetch()) {
	$arWSrvs[] = $arWebServ;
}
if ($_REQUEST["ID"] == "NEW" || 0 < $CID) {
	$DoEdit = "Y";
	$arScripts = array();
	if ($WSDir = opendir(TDM_PATH . "/tdmcore/webservices/")) {
		while (false !== ($SFile = readdir($WSDir))) {
			if (!($SFile != "." && $SFile != "..")) {
				continue;
			}
			if (!(0 < strpos($SFile, ".php"))) {
				continue;
			}
			$KSFile = str_replace(".php", "", $SFile);
			$arScripts[$KSFile] = $KSFile;
		}
		closedir($WSDir);
	}
	$arCurs = array();
	foreach ($TDMCore->arCurs as $Cur => $arCur) {
		$arCurs[] = $Cur;
	}
	if (count($arCurs) <= 0) {
		$arCurs[] = "USD";
	}
	if (TDM_LANG == "ru") {
		$hour = "\xd1\x87\xd0\xb0\xd1\x81";
		$houra = "\xd1\x87\xd0\xb0\xd1\x81\xd0\xb0";
		$hours = "\xd1\x87\xd0\xb0\xd1\x81\xd0\xbe\xd0\xb2";
		$day = "\xd0\xb4\xd0\xb5\xd0\xbd\xd1\x8c";
		$daya = "\xd0\xb4\xd0\xbd\xd1\x8f";
		$days = "\xd0\xb4\xd0\xbd\xd0\xb5\xd0\xb9";
	}
	else {
		$hour = "hour";
		$houra = "hours";
		$hours = "hours";
		$day = "day";
		$daya = "days";
		$days = "days";
	}
	$arRefreshHours = array(1 => "1 " . $hour, 2 => "2 " . $houra, 3 => "3 " . $houra, 4 => "4 " . $houra, 6 => "6 " . $hours, 8 => "8 " . $hours, 12 => "12 " . $hours, 24 => "1 " . $day, 48 => "2 " . $daya, 72 => "3 " . $daya, 96 => "4 " . $daya, 120 => "5 " . $days, 144 => "6 " . $days, 168 => "7 " . $days, 336 => "14 " . $days, 672 => "28 " . $days);
	$arKinksSide = array(0 => Lng("WS_link_both", 1, 0), 1 => Lng("WS_link_right", 1, 0), 2 => Lng("WS_link_left", 1, 0));
}
if (!(extension_loaded("sockets"))) {
	ErAdd("PHP extension \"sockets\" is not loading!", 1);
}
echo("<head><title>TDM :: ");
echo(Lng("Webservices", 1, 0));
echo("</title></head>\n<div class=\"apanel_cont\">");
require_once("apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t");
jsLinkJqueryUi();
echo("\t");
jsLinkFormStyler();
echo("\t<script>AddFSlyler('input, checkbox, radio, select');</script>\n\n\t<h1>");
echo(Lng("Webservices"));
echo("</h1>\n\t<div class=\"tclear\"></div>\n\t<hr>\n\t<table class=\"colstab\"><tr><td>\n\t<div class=\"imsupdiv\">\n\t\t<div class=\"suptitleg\">");
echo(Lng("Suppliers"));
echo(": <a href=\"?ID=NEW\" class=\"newsuplg\" title=\"");
echo(Lng("Add_new", 1, 0));
echo("\"></a></div>\n\t\t");
foreach ($arWSrvs as $arWS) {
	echo("\t\t\t<a href=\"?ID=");
	echo($arWS["ID"]);
	echo("\" class=\"supplier colored");
	echo($arWS["ACTIVE"]);
	echo("\">\n\t\t\t\t<div class=\"status");
	echo($arWS["ACTIVE"]);
	echo("\"></div>\n\t\t\t\t");
	echo($arWS["NAME"]);
	echo("\t\t\t</a>\n\t\t\t");
	if ($arWS["ACTIVE"] == 0) {
		echo("<div onclick=\"");
		jsDelConfirm($arWS["ID"], Lng("Really_delete_record", 0, 0) . ": " . $arWS["NAME"]);
		echo("\" class=\"trashws\"></div>");
	}
	echo("\t\t");
}
echo("\t</div>\n\t<br>\n\t<br>\n\t");
if (0 < $CurWS["ID"]) {
	echo("\t\t<div class=\"informlay\">\n\t\t\t<div class=\"informhead\">");
	echo(Tip("Webservice_DB_records"));
	echo(":</div>\n\t\t\t<table class=\"informtab\">\n\t\t\t\t<tr><td class=\"tarig\">Prices: </td><td class=\"");
	echo($Clr1);
	echo("\">");
	echo($PricesCount);
	echo("</td><td>\n\t\t\t\t\t<div onclick=\"");
	jsDelConfirm("EMPTY_PRICES", Tip("Really_clear_all_DB_records"));
	echo("\" class=\"trashbut\"></div>\n\t\t\t\t</td></tr>\n\t\t\t\t<tr><td class=\"tarig\">Links: </td><td class=\"");
	echo($Clr2);
	echo("\">");
	echo($LinksCount);
	echo("</td><td>\n\t\t\t\t\t<div onclick=\"");
	jsDelConfirm("EMPTY_LINKS", Tip("Really_clear_all_DB_records"));
	echo("\" class=\"trashbut\"></div>\n\t\t\t\t</td></tr> \n\t\t\t\t<tr><td class=\"tarig\">Cached by Sections: </td><td class=\"");
	echo($Clr3);
	echo("\">");
	echo($CachedSectionsCount);
	echo("</td><td>\n\t\t\t\t\t<div onclick=\"");
	jsDelConfirm("EMPTY_BYSEC", Tip("Really_clear_all_DB_records"));
	echo("\" class=\"trashbut\"></div>\n\t\t\t\t</td></tr>\n\t\t\t\t<tr><td class=\"tarig\">Cached by Articles: </td><td class=\"");
	echo($Clr4);
	echo("\">");
	echo($CachedPKEYCount);
	echo("</td><td>\n\t\t\t\t\t<div onclick=\"");
	jsDelConfirm("EMPTY_BYPKEY", Tip("Really_clear_all_DB_records"));
	echo("\" class=\"trashbut\"></div>\n\t\t\t\t</td></tr>\n\t\t\t</table>\n\t\t</div>\n\t\t<br>\n\t\t<br>\n\t\t");
	if (file_exists(TDM_PATH . "/admin/wsdata/" . $arWS["ID"] . ".php")) {
		echo("\t\t\t<div class=\"informlay\">\n\t\t\t\t<div class=\"informhead\">Last <b>Sockets</b> query data:</div>\n\t\t\t\t<table class=\"informtab\" style=\"font-size:10px;\">\n\t\t\t\t\t");
		require_once("wsdata/" . $arWS["ID"] . ".php");
		echo("\t\t\t\t\t<tr><td class=\"tarig\"><b>TIME:</b></td><td>");
		echo($arWSData["TIME"]);
		echo("</td></tr>\n\t\t\t\t\t<tr><td class=\"tarig\"><b>SID:</b></td><td>");
		echo($arWSData["SID"]);
		echo("</td></tr>\n\t\t\t\t\t<tr><td class=\"tarig\"><b>PKEY:</b></td><td>");
		echo($arWSData["PKEY"]);
		echo("</td></tr>\n\t\t\t\t\t");
		foreach ($arWSData["PARTS"] as $BRAND => $arArts) {
			++$BCnt;
			if (20 < $BCnt) {
				$Hide = "style=\"display:none;\"";
			}
			echo("\t\t\t\t\t\t<tr ");
			echo($Hide);
			echo(" ><td class=\"tarig\">");
			echo($BRAND);
			echo(":</td><td>");
			echo(implode(", ", $arArts));
			echo("</td></tr>\n\t\t\t\t\t");
		}
		echo("\t\t\t\t</table>\n\t\t\t</div>\n\t\t");
	}
	echo("\t");
}
echo("\t\n\t</td><td width=\"90%\">\n\t\t");
if ($DoEdit == "Y") {
	echo("\t\t<form action=\"\" id=\"editform\" method=\"post\">\n\t\t\t<input type=\"hidden\" name=\"edit\" value=\"Y\"/>\n\t\t\t<table class=\"formtab\">\n\t\t\t\t<tr><td class=\"fname\"></td><td class=\"ftext\">\n\t\t\t\t\t<b>");
	if ($_REQUEST["ID"] == "NEW") {
		echo(Lng("Add_new"));
	}
	else {
		echo(Lng("Edit"));
	}
	echo(" ");
	echo(Lng("Webservice"));
	echo("</b>\n\t\t\t\t\t<div class=\"tclear\"></div>\n\t\t\t\t\t");
	ErShow();
	echo("\t\t\t\t</td></tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Active"));
	echo(": </td>\n\t\t\t\t<td class=\"ftext\"><input type=\"checkbox\" name=\"ACTIVE\" value=\"1\" ");
	if ($_POST["ACTIVE"] == 1) {
		echo(" checked ");
	}
	echo(" > </td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Name"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"NAME\" value=\"");
	echo($_POST["NAME"]);
	echo("\" maxlength=\"32\" style=\"width:250px;\" /></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Code"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PRICE_CODE\" value=\"");
	echo($_POST["PRICE_CODE"]);
	echo("\" ");
	if (0 < $CID) {
		echo("disabled");
	}
	echo(" maxlength=\"32\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Lng("Any_name"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Handler"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"SCRIPT\" style=\"width:250px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK($arScripts, $_POST["SCRIPT"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">Client ID: </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"CLIENT_ID\" value=\"");
	echo($_POST["CLIENT_ID"]);
	echo("\" maxlength=\"32\" style=\"width:250px;\" />  <span class=\"tiptext\">");
	echo(Tip("Webservices_login"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Login"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"LOGIN\" value=\"");
	echo($_POST["LOGIN"]);
	echo("\" maxlength=\"32\" style=\"width:250px;\" />  <span class=\"tiptext\">");
	echo(Tip("Webservices_login"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Password"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PASSW\" value=\"");
	echo($_POST["PASSW"]);
	echo("\" maxlength=\"32\" style=\"width:250px;\" /></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Cache_prices"));
	echo(": </td>\n\t\t\t\t<td class=\"ftext\"><input type=\"checkbox\" name=\"CACHE\" value=\"1\" ");
	if ($_POST["CACHE"] == 1) {
		echo(" checked ");
	}
	echo(" > </td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Term_caching"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"REFRESH_TIME\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK($arRefreshHours, $_POST["REFRESH_TIME"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Query_limit"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"QUERY_LIMIT\" value=\"");
	echo($_POST["QUERY_LIMIT"]);
	echo("\" maxlength=\"4\" style=\"width:50px;\" /></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Take_links"));
	echo(": </td>\n\t\t\t\t<td class=\"ftext\"><input type=\"checkbox\" name=\"LINKS_TAKE\" value=\"1\" ");
	if ($_POST["LINKS_TAKE"] == 1) {
		echo(" checked ");
	}
	echo(" > </td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Crosses_direction"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"LINKS_SIDE\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK($arKinksSide, $_POST["LINKS_SIDE"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Currency"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"CURRENCY\" style=\"width:100px;\">\n\t\t\t\t\t\t");
	FShowSelectOptions($arCurs, $_POST["CURRENCY"]);
	echo("\t\t\t\t\t</select> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Add_price_extra"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PRICE_EXTRA\" value=\"");
	echo($_POST["PRICE_EXTRA"]);
	echo("\" maxlength=\"6\" style=\"width:45px;\" />% <span class=\"tiptext\">(+/-)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Add_to_price"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PRICE_ADD\" value=\"");
	echo($_POST["PRICE_ADD"]);
	echo("\" maxlength=\"12\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Tip("Add_fixed_amount"));
	echo(" (+/-)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Price_type"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"TYPE\" style=\"width:200px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK($TDMCore->arPriceType, $_POST["TYPE"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Add_days"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DAY_ADD\" value=\"");
	echo($_POST["DAY_ADD"]);
	echo("\" maxlength=\"2\" style=\"width:50px;\" /> <span class=\"tiptext\">");
	echo(Tip("Add_days_webservices"));
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Min_avail"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"MIN_AVAIL\" value=\"");
	echo($_POST["MIN_AVAIL"]);
	echo("\" maxlength=\"4\" style=\"width:50px;\" /> <span class=\"tiptext\">");
	echo(Tip("Min_avail_limit"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Max_days"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"MAX_DAY\" value=\"");
	echo($_POST["MAX_DAY"]);
	echo("\" maxlength=\"4\" style=\"width:50px;\" /> <span class=\"tiptext\">");
	echo(Tip("Max_days_limit"));
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr><td class=\"fname\"></td>\n\t\t\t\t<td class=\"fvalues\"><div class=\"bluebut\" onclick=\"\$('#editform').submit();\">");
	echo(Lng("Save", 0, 0));
	echo("</div></td></tr>\n\t\t\t</table>\n\t\t\t<div class=\"tclear\"></div>\n\t\t</form>\n\t\t");
}
else {
	if (TDM_LANG == "ru") {
		$DesLng = "ru";
	}
	else {
		$DesLng = "en";
	}
	echo("\n\t\t\t<iframe src=\"http://tecdoc-module.com/docs/ws_");
	echo($DesLng);
	echo(".html\" frameborder=\"0\" width=\"100%\" height=\"850\" hspace=\"0\" marginheight=\"0\" vspace=\"0\" align=\"left\"></iframe>\n\t\t");
}
echo("\t</table>\n</div>");

