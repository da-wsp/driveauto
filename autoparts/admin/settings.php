<?php

define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}
global $TDMCore;

function ShowInputSEO($LngCode, $LABLE, $arSETS) {
	$arTypes = array("H1" => "H1", "TITLE" => "Title", "DESCRIPTION" => "Description", "KEYWORDS" => "Keywords");
	echo("<tr><td colspan=\"2\"><hr></td></tr><tr><td></td><td class=\"tbold\">" . Lng($LngCode, 1) . ":</td></tr>");
	foreach ($arTypes as $Key => $Type) {
		echo("<tr><td class=\"fname\">" . $Type . ": </td><td class=\"fvalues\">");
		echo("<input class=\"styler\" type=\"text\" id=\"" . $LABLE . $Key . "\" name=\"" . $LABLE . "_" . $Key . "\" value=\"" . $_POST[$LABLE . "_" . $Key] . "\" maxlength=\"128\" style=\"width:550px;\" /> ");
		if (0 < count($arSETS)) {
			echo("<i class=\"gtx1 fnta\">&#9668;</i>");
			foreach ($arSETS as $SET) {
				echo("<a href=\"javascript:void(0)\" OnClick=\"AddToVal('" . $LABLE . $Key . "','" . $SET . "')\">" . $SET . "</a>, ");
			}
		}
		echo("</td></tr>");
	}
}

if ($_POST["editmain"] == "Y") {
	unset($_POST["editmain"]);
	$arChBox = array("SHOW_STAT", "SHOW_SEARCHFORM", "OPTION_SET", "OPTION_WEIGHT", "OPTION_USED", "OPTION_RESTORED", "OPTION_NORETURN", "OPTION_DAMAGED", "OPTION_COPY", "OPTION_HOT", "OPTION_PERCENTGIVE", "OPTION_MINIMUM", "OPTION_LITERS");
	if (isset($_POST["TECDOC_FILES_PREFIX"]) && trim($_POST["TECDOC_FILES_PREFIX"]) != "") {
		$arHpr = array("http://", "http:/", "http:", "http//", "http/", "ttp://", "tp://", "p://", "://");
		foreach ($arHpr as $Hpr) {
			$_POST["TECDOC_FILES_PREFIX"] = str_replace($Hpr, "", $_POST["TECDOC_FILES_PREFIX"]);
		}
	}
	foreach ($arChBox as $ChBox) {
		$_POST[$ChBox] = intval($_POST[$ChBox]);
	}
	$resDB = new TDMQuery();
	foreach ($_POST as $Key => $Value) {
		$resDB->Update2("TDM_SETTINGS", array("VALUE" => trim($Value)), array("ITEM" => "module", "FIELD" => $Key));
	}
	NtAdd(Lng("Settings_saved"));
	$resDB->Select("TDM_SETTINGS", array(), array("ITEM" => "module"), array("SELECT" => array("FIELD", "VALUE")));
	while ($arRes = $resDB->Fetch()) {
		$TDMCore->arSettings[$arRes["FIELD"]] = $arRes["VALUE"];
	}
	$TDMCore->arConfig["TECDOC_DB_SERVER"] = $TDMCore->arSettings["TECDOC_DB_SERVER"];
	$TDMCore->arConfig["TECDOC_DB_LOGIN"] = $TDMCore->arSettings["TECDOC_DB_LOGIN"];
	$TDMCore->arConfig["TECDOC_DB_PASS"] = $TDMCore->arSettings["TECDOC_DB_PASS"];
	$TDMCore->arConfig["TECDOC_DB_NAME"] = $TDMCore->arSettings["TECDOC_DB_NAME"];
}
$arMSets = $TDMCore->arSettings;
if ($_POST["editmeta"] == "Y") {
	unset($_POST["editmeta"]);
	$resDB = new TDMQuery();
	foreach ($_POST as $Key => $Value) {
		$resDB->Update2("TDM_SETTINGS", array("VALUE" => trim($Value)), array("ITEM" => "seometa", "FIELD" => $Key));
	}
	NtAdd(Lng("Settings_saved"));
}
if ($_POST["editprice"] == "Y") {
	unset($_POST["editprice"]);
	$resDB = new TDMQuery();
	foreach ($_POST as $Key => $Value) {
		$resDB->Update2("TDM_SETTINGS", array("VALUE" => trim($Value)), array("ITEM" => "pricetype", "FIELD" => $Key));
	}
	TDMRedirect("admin/settings.php?edited=Y#prices");
}
if ($_REQUEST["edited"] == "Y") {
	NtAdd(Lng("Settings_saved"));
}
$arMSets = $TDMCore->arSettings;
$arPView = $TDMCore->arPriceView;
$arPDiscount = $TDMCore->arPriceDiscount;
$arPGID = $TDMCore->arPriceGID;
$resDB = new TDMQuery();
$resDB->Select("TDM_SETTINGS", array(), array("ITEM" => "seometa"));
while ($arRes = $resDB->Fetch()) {
	$_POST[$arRes["FIELD"]] = $arRes["VALUE"];
}
$resDB->Select("TDM_SETTINGS", array(), array("ITEM" => "pricetype"), array("SELECT" => array("FIELD", "VALUE")));
while ($arRes = $resDB->Fetch()) {
	if (!(substr($arRes["FIELD"], 0, 10) == "PRICE_TYPE")) {
		continue;
	}
	$arPType[str_replace("PRICE_TYPE_", "", $arRes["FIELD"])] = $arRes["VALUE"];
	continue;
}
foreach ($TDMCore->arCurs as $Cur => $arCur) {
	$arCurs[] = $Cur;
}
if (count($arCurs) <= 0) {
	$arCurs[] = "USD";
}
echo("<head><title>TDM :: ");
echo(Lng("Module_settings", 1, false));
echo("</title></head>\r\n<div class=\"apanel_cont\">");
require_once("apanel.php");
echo("</div>\r\n<div class=\"tdm_acontent\">\r\n\t");
jsLinkJqueryUi();
echo("\t");
jsLinkFormStyler();
echo("\t<script>AddFSlyler('input, checkbox, select, radio');</script>\r\n\t<script>\$(function() {\$( \"#tabs\" ).tabs();});</script>\r\n\t<script>function AddToVal(ID,VAL){\$('#'+ID).val(\$('#'+ID).val()+' '+VAL)};</script>\r\n\t\r\n\t<h1>");
echo(Lng("Module_settings", 1, false));
echo("</h1>\r\n\t<hr>\r\n\t");
ErShow();
echo("\t<div id=\"tabs\">\r\n\t\t<ul>\r\n\t\t\t<li><a href=\"#main\">");
echo(Tip("Main_settings", 0));
echo("</a></li>\r\n\t\t\t<li><a href=\"#meta\">Components META</a></li>\r\n\t\t\t<li><a href=\"#prices\">");
echo(Lng("Price_type", 1, 0));
echo("</a></li>\r\n\t\t</ul>\r\n\t\t<div id=\"main\">\r\n\t\t\t\r\n\t\t\t<form action=\"\" id=\"setsform\" method=\"post\">\r\n\t\t\t<input type=\"hidden\" name=\"editmain\" value=\"Y\"/>\r\n\t\t\t<table class=\"formtab\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Enable_caching", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<select name=\"USE_CACHE\" style=\"width:100px;\">\r\n\t\t\t\t\t\t\t");
$arCacheV = array(0 => Lng("Off_", 1, 0), 1 => Lng("On_", 1, 0));
FShowSelectOptionsK($arCacheV, $arMSets["USE_CACHE"]);
echo("\t\t\t\t\t\t</select> \r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Default_lang", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<select name=\"DEFAULT_LANG\" style=\"width:100px;\">\r\n\t\t\t\t\t\t\t");
FShowSelectOptions($TDMCore->arLangs, $arMSets["DEFAULT_LANG"]);
echo("\t\t\t\t\t\t</select> \r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Default_currency", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<select name=\"DEFAULT_CURRENCY\" style=\"width:100px;\">\r\n\t\t\t\t\t\t\t");
FShowSelectOptions($arCurs, $arMSets["DEFAULT_CURRENCY"]);
echo("\t\t\t\t\t\t</select> \r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Models_starting_with", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<select name=\"MODELS_FROM\" style=\"width:100px;\">\r\n\t\t\t\t\t\t\t");
FShowSelectOptions(array(2010, 2005, 2000, 1995, 1990, 1985, 1980, 1975, 1970, 1965, 1960), $arMSets["MODELS_FROM"]);
echo("\t\t\t\t\t\t</select> <span class=\"tiptext\">");
echo(Lng("Year_construction", 1));
echo("</span>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Current_CMS", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<select name=\"CMS_INTEGRATION\" style=\"width:200px;\">\r\n\t\t\t\t\t\t\t");
FShowSelectOptions(array("NoCMS", "OpenCart", "Bitrix", "Joomla", "PrestaShop", "Drupal", "WordPress", "Magento", "Webasyst", "ApexCMS", "ModX"), $arMSets["CMS_INTEGRATION"]);
echo("\t\t\t\t\t\t</select> \r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Admin_panel_position", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<select name=\"APANEL_POSITION\" style=\"width:150px;\">\r\n\t\t\t\t\t\t\t");
FShowSelectOptions(array("Top", "Bottom"), $arMSets["APANEL_POSITION"]);
echo("\t\t\t\t\t\t</select> \r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Show_query_statistic", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"ftext\">\r\n\t\t\t\t\t\t<input type=\"checkbox\" name=\"SHOW_STAT\" value=\"1\" ");
if ($arMSets["SHOW_STAT"] == 1) {
	echo(" checked ");
}
echo(" > \r\n\t\t\t\t\t\t<span class=\"tiptext\">");
echo(Tip("visible_only_to_administrator"));
echo("</span>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr><tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Show_search_form", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"ftext\">\r\n\t\t\t\t\t\t<input type=\"checkbox\" name=\"SHOW_SEARCHFORM\" value=\"1\" ");
if ($arMSets["SHOW_SEARCHFORM"] == 1) {
	echo(" checked ");
}
echo(" > \r\n\t\t\t\t\t\t<span class=\"tiptext\">");
echo(Tip("Search_form_example"));
echo("</span>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td class=\"fname\">Cron access key: </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t");
if ($arMSets["CRON_KEY"] == "") {
	$arMSets["CRON_KEY"] = rand(100000, 999999);
}
echo("\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"CRON_KEY\" value=\"");
echo($arMSets["CRON_KEY"]);
echo("\" maxlength=\"12\" style=\"width:120px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\r\n\t\t\t\t<tr><td></td><td class=\"tbold\">");
echo(Lng("TecDoc_DB"));
echo(":<br><br></td></tr>\r\n\t\t\t\t<tr><td class=\"fname\">");
echo(Lng("Server", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"TECDOC_DB_SERVER\" value=\"");
echo($arMSets["TECDOC_DB_SERVER"]);
echo("\" maxlength=\"128\" style=\"width:300px;\" /> \r\n\t\t\t\t\t\t");
if ($arMSets["TECDOC_DB_SERVER"] != "" && $arMSets["TECDOC_DB_NAME"] != "" && $arMSets["TECDOC_DB_LOGIN"] != "" && $arMSets["TECDOC_DB_PASS"] != "") {
	$TDMCore->DBSelect("TECDOC");
	if ($TDMCore->isDBCon) {
		echo("<b style=\"color:#00AD45;\">Connected!</b>");
	}
	else {
		echo("<b style=\"color:#AD2600;\">No connection!</b>");
	}
}
echo("\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td class=\"fname\">");
echo(Lng("DB_name", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"TECDOC_DB_NAME\" value=\"");
echo($arMSets["TECDOC_DB_NAME"]);
echo("\" maxlength=\"128\" style=\"width:300px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td class=\"fname\">");
echo(Lng("Login", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"TECDOC_DB_LOGIN\" value=\"");
echo($arMSets["TECDOC_DB_LOGIN"]);
echo("\" maxlength=\"128\" style=\"width:300px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td class=\"fname\">");
echo(Lng("Password", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"TECDOC_DB_PASS\" value=\"");
echo($arMSets["TECDOC_DB_PASS"]);
echo("\" maxlength=\"128\" style=\"width:300px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td class=\"fname\">");
echo(Lng("Files_prefix", 1));
echo(": </td>\r\n\t\t\t\t\t<td class=\"fvalues\">\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"TECDOC_FILES_PREFIX\" value=\"");
echo($arMSets["TECDOC_FILES_PREFIX"]);
echo("\" maxlength=\"512\" style=\"width:400px;\" /> <br>\r\n\t\t\t\t\t\t<span class=\"tiptext\">");
echo(Tip("Full_path_to_images_folder"));
echo(": yoursite.ru/files/</span>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=\"fname\">");
echo(Lng("Price_options", 1));
echo(":<br><span class=\"tiptext\">");
echo(Tip("visible_in_public_side"));
echo("</span> </td>\r\n\t\t\t\t\t<td class=\"ftext\">\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_SET\">2 ");
echo(Lng("Pcs", 0, 0));
echo("</div></div> \r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_SET\" value=\"1\" ");
if ($arMSets["OPTION_SET"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_SET"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_WEIGHT\">1.8");
echo(Lng("Kg"));
echo("</div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_WEIGHT\" value=\"1\" ");
if ($arMSets["OPTION_WEIGHT"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("Weight_gr"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_PERCENTGIVE\">25%</div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_PERCENTGIVE\" value=\"1\" ");
if ($arMSets["OPTION_PERCENTGIVE"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_PERCENTGIVE"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_MINIMUM\">min.2</div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_MINIMUM\" value=\"1\" ");
if ($arMSets["OPTION_MINIMUM"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_MINIMUM"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_LITERS\">5");
echo(Lng("L."));
echo("</div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_LITERS\" value=\"1\" ");
if ($arMSets["OPTION_LITERS"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_LITERS"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_USED\">");
echo(Lng("PRICE_OPTION_USED"));
echo("</div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_USED\" value=\"1\" ");
if ($arMSets["OPTION_USED"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_USED"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_RESTORED\"></div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_RESTORED\" value=\"1\" ");
if ($arMSets["OPTION_RESTORED"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_RESTORED"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_DAMAGED\"></div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_DAMAGED\" value=\"1\" ");
if ($arMSets["OPTION_DAMAGED"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_DAMAGED"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_NORETURN\"></div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_NORETURN\" value=\"1\" ");
if ($arMSets["OPTION_NORETURN"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_NORETURN"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_COPY\"></div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_COPY\" value=\"1\" ");
if ($arMSets["OPTION_COPY"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_COPY"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t\t<div class=\"optsets\"><div class=\"option_HOT\"></div></div>\r\n\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"OPTION_HOT\" value=\"1\" ");
if ($arMSets["OPTION_HOT"] == 1) {
	echo(" checked ");
}
echo(" > ");
echo(Lng("PRICE_OPTION_HOT"));
echo("\t\t\t\t\t\t\t<div class=\"tclear\"></div>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t<hr>\r\n\t\t\t\r\n\t\t\t\r\n\t\t\t\r\n\t\t\t<input type=\"submit\" value=\"");
echo(Lng("Save", 1, false));
echo(" ");
echo(Lng("Settings", 2, false));
echo("\" class=\"abutton\"/>\r\n\t\t\t</form>\r\n\t\t\r\n\t\t</div>\r\n\t\t<div id=\"meta\">\r\n\t\t\t\r\n\t\t\t<form action=\"\" id=\"setsform\" method=\"post\">\r\n\t\t\t<input type=\"hidden\" name=\"editmeta\" value=\"Y\"/>\r\n\t\t\t<table class=\"formtab\">\r\n\t\t\t\t<tr><td></td><td class=\"tiptext\">");
echo(Tip("Settings_default_seometa"));
echo("<br><br></td></tr>\r\n\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Select_manufacturer", "MANUFACTURERS", array("BRANDS_LIST"));
echo("\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Models_list", "MODELS", array("BRAND", "MODELS_LIST"));
echo("\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Type_of_engine", "TYPES", array("BRAND", "MODEL", "DATE"));
echo("\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Sections_of_parts", "SECTIONS", array("BRAND", "MODEL", "DATE", "TYPE"));
echo("\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Subsections_of_parts", "SUBSECTIONS", array("BRAND", "MODEL", "DATE", "TYPE", "SECTION"));
echo("\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Parts_of_section", "SECTIONPARTS", array("BRAND", "MODEL", "DATE", "TYPE", "SECTION", "SUBSECTION", "PARTS_LIST"));
echo("\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Search_by_parts_number", "SEARCHPARTS", array("SEARCH_NUMBER", "PARTS_LIST"));
echo("\t\t\t\t\r\n\t\t\t\t");
ShowInputSEO("Analogs_of_brand_number", "ANALOGPARTS", array("SEARCH_NUMBER", "SEARCH_BRAND", "PARTS_LIST"));
echo("\t\t\t</table>\r\n\t\t\t<hr>\r\n\t\t\t<input type=\"submit\" value=\"");
echo(Lng("Save", 1, false));
echo(" ");
echo(Lng("Settings", 2, false));
echo("\" class=\"abutton\"/>\r\n\t\t\t</form>\r\n\t\t</div>\r\n\t\t\r\n\t\t<div id=\"prices\">\r\n\t\t\t<form action=\"\" id=\"setsform\" method=\"post\">\r\n\t\t\t<input type=\"hidden\" name=\"editprice\" value=\"Y\"/>\r\n\t\t\t<table class=\"formtab\">\r\n\t\t\t\t<tr><td class=\"fname\">1: </td>\r\n\t\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" value=\"");
echo(Lng($arPType[1], 1, false));
echo("\" maxlength=\"32\" style=\"width:180px; font-weight:bold;\" disabled=\"disabled\"/> ");
echo(Tip("Basic_type_of_price"));
echo(" <br>\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"PRICE_GID_1\" value=\"");
echo($arPGID[1]);
echo("\" maxlength=\"3\" style=\"width:55px;\"/> ");
echo(Tip("Group_ID_of_CMS"));
echo("\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\r\n\t\t\t\t");
$Num = 2;
while ($Num <= 5) {
	if ($Num == 2) {
		$PTName = Lng($arPType[$Num], 1, false);
	}
	else {
		$PTName = $arPType[$Num];
	}
	echo("\t\t\t\t\t<tr><td class=\"fname\">");
	echo($Num);
	echo(": </td>\r\n\t\t\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" name=\"PRICE_TYPE_");
	echo($Num);
	echo("\" type=\"text\" value=\"");
	echo($PTName);
	echo("\" maxlength=\"32\" style=\"width:180px; font-weight:bold;\" ");
	if ($Num == 2) {
		echo("disabled=\"disabled\"");
	}
	echo(" /></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr><td class=\"fname\"></td><td class=\"fvalues\" style=\"line-height:28px;\">\r\n\t\t\t\t\t\t<input type=\"radio\" name=\"PRICE_VIEW_");
	echo($Num);
	echo("\" value=\"1\" ");
	if ($arPView[$Num] < 2) {
		echo("checked");
	}
	echo(" > ");
	echo(Tip("Show_users_in_this_group"));
	echo("<br>\r\n\t\t\t\t\t\t<input type=\"radio\" name=\"PRICE_VIEW_");
	echo($Num);
	echo("\" value=\"2\" ");
	if (1 < $arPView[$Num]) {
		echo("checked");
	}
	echo(" > ");
	echo(Tip("Apply_discount_of_base_price"));
	echo(": <br>\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"PRICE_DISCOUNT_");
	echo($Num);
	echo("\" value=\"");
	echo($arPDiscount[$Num]);
	echo("\" maxlength=\"4\" style=\"width:55px; color:#ff0000;\"/>% ");
	echo(Tip("discount_margin_of_base_price"));
	echo(" (-/+)<br>\r\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"PRICE_GID_");
	echo($Num);
	echo("\" value=\"");
	echo($arPGID[$Num]);
	echo("\" maxlength=\"3\" style=\"width:55px;\"/> ");
	echo(Tip("Group_ID_of_CMS"));
	echo("\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\r\n\t\t\t\t");
	++$Num;
}
echo("\t\t\t</table>\r\n\t\t\t<input type=\"submit\" value=\"");
echo(Lng("Save", 1, false));
echo(" ");
echo(Lng("Settings", 2, false));
echo("\" class=\"abutton\"/>\r\n\t\t\t</form>\r\n\t\t</div>\r\n\t\t\r\n\t\t\r\n\t</div>\r\n\t\t\r\n\t\r\n</div>\r\n\r\n");

