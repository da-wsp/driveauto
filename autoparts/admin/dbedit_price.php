<?php

define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	exit();
}
$rsSRows = new TDMQuery();
$arFields = array();
$FORM_ACTION = $_SERVER["REQUEST_URI"];
$ShowForm = "Y";
if ($_GET["BKEY"] != "" && $_GET["AKEY"] != "" && 0 < $_GET["TYPE"] && isset($_GET["DAY"]) && isset($_GET["SUPPLIER"]) && isset($_GET["STOCK"])) {
	$arFilter = array("BKEY" => $_GET["BKEY"], "AKEY" => $_GET["AKEY"], "TYPE" => $_GET["TYPE"], "DAY" => $_GET["DAY"], "SUPPLIER" => $_GET["SUPPLIER"], "STOCK" => $_GET["STOCK"]);
	if ($_POST["checkme"] != "Y") {
		$rsSRows->Select("TDM_PRICES", array(), $arFilter, array("LIMIT" => 1));
		if (!($arRow = $rsSRows->Fetch())) {
			ErAdd("Invalid item parameters", 2);
			$ShowForm = "N";
		}
		else {
			if ($_GET["EDITED"] == "Y") {
				NtAdd(Lng("Record_updated", 1));
			}
			foreach ($arRow as $Key => $Value) {
				$_POST[$Key] = $Value;
			}
			$arOps = TDMGetPriceOptions($_POST["OPTIONS"]);
		}
	}
}
else {
	if ($_GET["ID"] != "NEW") {
		ErAdd("Item not specified", 2);
		$ShowForm = "N";
	}
}
if ($_POST["checkme"] == "Y") {
	foreach ($_POST as $Key => $Value) {
		$_POST[$Key] = trim($Value);
	}
	$_POST["PRICE"] = floatval($_POST["PRICE"]);
	$_POST["TYPE"] = intval($_POST["TYPE"]);
	if (strlen($_POST["ARTICLE"]) <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Number"), 1);
	}
	if (strlen($_POST["BRAND"]) <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Manufacturer"), 1);
	}
	if ($_POST["PRICE"] <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Price"), 1);
	}
	if (strlen($_POST["CURRENCY"]) != 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Currency"), 1);
	}
	if ($_POST["TYPE"] <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Price_type"), 1);
	}
	if (strlen($_POST["SUPPLIER"]) <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Supplier"), 1);
	}
	if (strlen($_POST["CODE"]) <= 0) {
		$_POST["CODE"] = "main";
	}
	if (ErCheck()) {
		$rsRes = new TDMQuery();
		$arOptions = array("SET" => $_POST["SET"], "WEIGHT" => $_POST["WEIGHT"], "USED" => $_POST["USED"], "RESTORED" => $_POST["RESTORED"], "PRICE_ID" => $_POST["PRICE_ID"], "PERCENTGIVE" => $_POST["PERCENTGIVE"], "DAMAGED" => $_POST["DAMAGED"], "NORETURN" => $_POST["NORETURN"], "COPY" => $_POST["COPY"], "HOT" => $_POST["HOT"], "MINIMUM" => $_POST["MINIMUM"], "LITERS" => $_POST["LITERS"]);
		$arNPrice = array("BKEY" => TDMSingleKey($_POST["BRAND"], true), "AKEY" => TDMSingleKey($_POST["ARTICLE"]), "BRAND" => $_POST["BRAND"], "ARTICLE" => $_POST["ARTICLE"], "ALT_NAME" => $_POST["ALT_NAME"], "PRICE" => $_POST["PRICE"], "TYPE" => $_POST["TYPE"], "CURRENCY" => $_POST["CURRENCY"], "DAY" => $_POST["DAY"], "AVAILABLE" => $_POST["AVAILABLE"], "SUPPLIER" => $_POST["SUPPLIER"], "STOCK" => $_POST["STOCK"], "OPTIONS" => $OPTIONS, "CODE" => $_POST["CODE"]);
		$arNPrice["OPTIONS"] = TDMOptionsImplode($arOptions, $arNPrice);
		$arNPrice["DAY"] = TDMDayNumbers($arNPrice["DAY"]);
		$arNPrice["AVAILABLE"] = TDMOnlyNumbers($arNPrice["AVAILABLE"]);
		if ($_REQUEST["ID"] == "NEW") {
			$arNPrice["DATE"] = TDMSetPriceDate();
			$rsRes->Insert("TDM_PRICES", $arNPrice);
		}
		else {
			$rsRes->Update2("TDM_PRICES", $arNPrice, $arFilter);
		}
		TDMRedirect("admin/dbedit_price.php?BKEY=" . $arNPrice["BKEY"] . "&AKEY=" . $arNPrice["AKEY"] . "&TYPE=" . $arNPrice["TYPE"] . "&DAY=" . $arNPrice["DAY"] . "&SUPPLIER=" . $arNPrice["SUPPLIER"] . "&STOCK=" . $arNPrice["STOCK"] . "&EDITED=Y");
	}
}
else {
	if ($_GET["ARTICLE"] != "") {
		$_POST["ARTICLE"] = $_GET["ARTICLE"];
	}
	if ($_GET["BRAND"] != "") {
		$_POST["BRAND"] = $_GET["BRAND"];
	}
}
echo("<link rel=\"stylesheet\" href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/styles.css\" type=\"text/css\">\n<link rel=\"stylesheet\" href=\"/");
echo(TDM_ROOT_DIR);
echo("/styles.css\" type=\"text/css\">\n");
jsLinkFormStyler();
echo("<script>\n\tAddFSlyler('input, checkbox, select, radio');\n</script>\n<div style=\"width:700px; padding:30px;\">\n\t<form name=\"nform\" id=\"nform\" action=\"");
echo($FORM_ACTION);
echo("\" method=\"post\" >\t\t\n\t\t<input type=\"hidden\" name=\"checkme\" value=\"Y\"/>\n\t\t<table class=\"formtab\" >\n\t\t\t<tr><td></td><td class=\"fvalues\">\n\t\t\t\t<b>");
if ($_REQUEST["ID"] == "NEW") {
	echo(Lng("Add", 1, 0));
}
else {
	echo(Lng("Edit", 1, 0));
}
echo(" ");
echo(Lng("Record", 2, 0));
echo("</b><br><br>\n\t\t\t\t");
ErShow();
echo("\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t");
if ($ShowForm == "Y") {
	echo("\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Number", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"ARTICLE\" value=\"");
	echo($_POST["ARTICLE"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" /> <span class=\"tiptext\">");
	echo($_POST["AKEY"]);
	echo("</span>\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Manufacturer", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"BRAND\" value=\"");
	echo($_POST["BRAND"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" /> <span class=\"tiptext\">");
	echo($_POST["BKEY"]);
	echo("</span>\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Price", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"PRICE\" value=\"");
	echo($_POST["PRICE"]);
	echo("\" maxlength=\"11\" style=\"width:100px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Currency", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"CURRENCY\" class=\"styler\" style=\"width:100px;\">\n\t\t\t\t\t\t");
	foreach ($TDMCore->arCurs as $Cur => $arCur) {
		$arCurs[] = $Cur;
	}
	echo("\t\t\t\t\t\t");
	FShowSelectOptions($arCurs, $_POST["CURRENCY"]);
	echo("\t\t\t\t\t</select> \n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Price_type", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"TYPE\" class=\"styler\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	foreach ($TDMCore->arCurs as $Cur => $arCur) {
		$arCurs[] = $Cur;
	}
	echo("\t\t\t\t\t\t");
	FShowSelectOptionsK($TDMCore->arPriceType, $_POST["TYPE"]);
	echo("\t\t\t\t\t</select>\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Name", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"ALT_NAME\" value=\"");
	echo($_POST["ALT_NAME"]);
	echo("\" maxlength=\"128\" style=\"width:340px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Dtime_delivery", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t");
	if (strpos($arOps["DAY_TEMPLATE"], "#") !== false) {
		$_POST["DAY"] = str_replace("#", $_POST["DAY"], $arOps["DAY_TEMPLATE"]);
	}
	echo("\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"DAY\" value=\"");
	echo($_POST["DAY"]);
	echo("\" maxlength=\"8\" style=\"width:60px;\" /> \n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Availability", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t");
	if (strpos($arOps["AVAILABLE_TEMPLATE"], "#") !== false) {
		$_POST["AVAILABLE"] = str_replace("#", $_POST["AVAILABLE"], $arOps["AVAILABLE_TEMPLATE"]);
	}
	echo("\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"AVAILABLE\" value=\"");
	echo($_POST["AVAILABLE"]);
	echo("\" maxlength=\"8\" style=\"width:60px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Supplier", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"SUPPLIER\" value=\"");
	echo($_POST["SUPPLIER"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Stock", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"STOCK\" value=\"");
	echo($_POST["STOCK"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Options", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\" style=\"line-height:22px;\">\n\t\t\t\t\t<table><tr><td>\n\t\t\t\t\t\t");
	echo("\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"SET\" value=\"");
	echo($arOps["SET"]);
	echo("\" maxlength=\"3\" style=\"width:60px;\" /> <span class=\"\">");
	echo(Lng("PRICE_OPTION_SET"));
	echo("</span><br>\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"WEIGHT\" value=\"");
	echo($arOps["WEIGHT"]);
	echo("\" maxlength=\"9\" style=\"width:60px;\" /> <span class=\"\">");
	echo(Lng("Weight_gr"));
	echo("</span><br>\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"PERCENTGIVE\" value=\"");
	echo($arOps["PERCENTGIVE"]);
	echo("\" maxlength=\"9\" style=\"width:60px;\" /> <span class=\"\">% ");
	echo(Lng("PRICE_OPTION_PERCENTGIVE"));
	echo("</span><br>\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"MINIMUM\" value=\"");
	echo($arOps["MINIMUM"]);
	echo("\" maxlength=\"9\" style=\"width:60px;\" /> <span class=\"\">");
	echo(Lng("PRICE_OPTION_MINIMUM"));
	echo("</span><br>\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"LITERS\" value=\"");
	echo($arOps["LITERS"]);
	echo("\" maxlength=\"9\" style=\"width:60px;\" /> <span class=\"\">");
	echo(Lng("PRICE_OPTION_LITERS"));
	echo("</span><br>\n\t\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"PRICE_ID\" value=\"");
	echo($arOps["PRICE_ID"]);
	echo("\" maxlength=\"9\" style=\"width:60px;\" /> <span class=\"\">");
	echo(Lng("PRICE_OPTION_PRICE_ID"));
	echo("</span><br>\n\t\t\t\t\t\t</td><td style=\"padding-left:20px; line-height:22px;\">\n\t\t\t\t\t\t<div class=\"option_USED\" style=\"width:10px;height:14px;\"></div> <input type=\"checkbox\" name=\"USED\" value=\"1\" ");
	if ($arOps["USED"] == 1) {
		echo(" checked ");
	}
	echo(" > ");
	echo(Lng("PRICE_OPTION_USED"));
	echo("<br>\n\t\t\t\t\t\t<div class=\"option_RESTORED\"></div> <input type=\"checkbox\" name=\"RESTORED\" value=\"1\" ");
	if ($arOps["RESTORED"] == 1) {
		echo(" checked ");
	}
	echo(" > ");
	echo(Lng("PRICE_OPTION_RESTORED"));
	echo("<br>\n\t\t\t\t\t\t<div class=\"option_DAMAGED\"></div> <input type=\"checkbox\" name=\"DAMAGED\" value=\"1\" ");
	if ($arOps["DAMAGED"] == 1) {
		echo(" checked ");
	}
	echo(" > ");
	echo(Lng("PRICE_OPTION_DAMAGED"));
	echo("<br>\n\t\t\t\t\t\t<div class=\"option_NORETURN\"></div> <input type=\"checkbox\" name=\"NORETURN\" value=\"1\" ");
	if ($arOps["NORETURN"] == 1) {
		echo(" checked ");
	}
	echo(" > ");
	echo(Lng("PRICE_OPTION_NORETURN"));
	echo("<br>\n\t\t\t\t\t\t<div class=\"option_COPY\"></div> <input type=\"checkbox\" name=\"COPY\" value=\"1\" ");
	if ($arOps["COPY"] == 1) {
		echo(" checked ");
	}
	echo(" > ");
	echo(Lng("PRICE_OPTION_COPY"));
	echo("<br>\n\t\t\t\t\t\t<div class=\"option_HOT\"></div> <input type=\"checkbox\" name=\"HOT\" value=\"1\" ");
	if ($arOps["HOT"] == 1) {
		echo(" checked ");
	}
	echo(" > ");
	echo(Lng("PRICE_OPTION_HOT"));
	echo("<br>\n\t\t\t\t\t</table>\n\t\t\t\t\t<span class=\"tiptext\">");
	echo($_POST["OPTIONS"]);
	echo("</span>\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Code", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"CODE\" value=\"");
	echo($_POST["CODE"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t");
	echo("\t\t\t\n\t\t\t<tr><td></td><td><br>\n\t\t\t\t<input type=\"submit\" value=\"");
	echo(Lng("Apply", 1, 0));
	echo("\" class=\"abutton\"/> \n\t\t\t\t<input type=\"button\" value=\"");
	echo(Lng("Close", 1, 0));
	echo("\" onClick=\"window.location.href=document.URL;\" class=\"abutton grbut\" style=\"margin-left:10px;\"/><br>\n\t\t\t</td></tr>\n\t\t\t");
}
echo("\t\t</table>\n\t</form>\n\t\n</div>\n\n\t<script>\n\t\t\$(function(){\n\t\t\tcbox_submit();\n\t\t});\n\t\tfunction cbox_submit(){\n\t\t\t\$(\"#nform\").submit(function() {\n\t\t\t\t\$.post(\$(this).attr(\"action\"), \$(this).serialize(), function(data){\n\t\t\t\t\t\$.colorbox({html:data });\n\t\t\t\t},\n\t\t\t\t'html');\n\t\t\t\treturn false;\n\t\t\t});\n\t\t}\t\n\t</script>");

