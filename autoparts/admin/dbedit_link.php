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
if ($_GET["BKEY1"] != "" && $_GET["AKEY1"] != "" && $_GET["BKEY2"] != "" && $_GET["AKEY2"] != "" && $_GET["CODE"] != "") {
	$arFilter = array("BKEY1" => $_GET["BKEY1"], "AKEY1" => $_GET["AKEY1"], "BKEY2" => $_GET["BKEY2"], "AKEY2" => $_GET["AKEY2"], "CODE" => $_GET["CODE"]);
	if ($_POST["checkme"] != "Y") {
		$rsSRows->Select("TDM_LINKS", array(), $arFilter, array("LIMIT" => 1));
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
	$_POST["SIDE"] = intval($_POST["SIDE"]);
	if (strlen($_POST["BKEY1"]) <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Manufacturer"), 1) . " 1";
	}
	if (strlen($_POST["AKEY1"]) <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Number"), 1) . " 1";
	}
	if (strlen($_POST["BKEY2"]) <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Manufacturer"), 1) . " 2";
	}
	if (strlen($_POST["AKEY2"]) <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Number"), 1) . " 2";
	}
	if (strlen($_POST["CODE"]) <= 0) {
		$_POST["CODE"] = "main";
	}
	if (ErCheck()) {
		$rsRes = new TDMQuery();
		$BKEY1 = TDMSingleKey($_POST["BKEY1"], true);
		$AKEY1 = TDMSingleKey($_POST["AKEY1"]);
		$BKEY2 = TDMSingleKey($_POST["BKEY2"], true);
		$AKEY2 = TDMSingleKey($_POST["AKEY2"]);
		$arRow = array("PKEY1" => $BKEY1 . $AKEY1, "BKEY1" => $BKEY1, "AKEY1" => $AKEY1, "SIDE" => $_POST["SIDE"], "PKEY2" => $BKEY2 . $AKEY2, "BKEY2" => $BKEY2, "AKEY2" => $AKEY2, "CODE" => $_POST["CODE"]);
		if ($_REQUEST["ID"] == "NEW") {
			$rsRes->Insert("TDM_LINKS", $arRow);
		}
		else {
			$rsRes->Update2("TDM_LINKS", $arRow, $arFilter);
		}
		TDMRedirect("admin/dbedit_link.php?BKEY1=" . $arRow["BKEY1"] . "&AKEY1=" . $arRow["AKEY1"] . "&BKEY2=" . $arRow["BKEY2"] . "&AKEY2=" . $arRow["AKEY2"] . "&CODE=" . $arRow["CODE"] . "&EDITED=Y");
	}
}
else {
	if ($_GET["BKEY"] != "") {
		$_POST["BKEY1"] = $_GET["BKEY"];
	}
	if ($_GET["AKEY"] != "") {
		$_POST["AKEY1"] = $_GET["AKEY"];
	}
}
echo("<link rel=\"stylesheet\" href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/styles.css\" type=\"text/css\">\n");
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
	echo(Lng("Manufacturer", 1));
	echo(" 1: </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"BKEY1\" value=\"");
	echo($_POST["BKEY1"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Number", 1));
	echo(" 1: </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"AKEY1\" value=\"");
	echo($_POST["AKEY1"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Crosses_direction", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"SIDE\" class=\"styler\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK(array(0 => Lng("WS_link_both", 1, 0), 1 => Lng("WS_link_right", 1, 0), 2 => Lng("WS_link_left", 1, 0)), $_POST["SIDE"]);
	echo("\t\t\t\t\t</select>\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Manufacturer", 1));
	echo(" 2: </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"BKEY2\" value=\"");
	echo($_POST["BKEY2"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Number", 1));
	echo(" 2: </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"AKEY2\" value=\"");
	echo($_POST["AKEY2"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Code", 1));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"CODE\" value=\"");
	echo($_POST["CODE"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" />\n\t\t\t\t</td>\n\t\t\t</tr>\n\t\t\t\n\t\t\t<tr><td></td><td><br>\n\t\t\t\t<input type=\"submit\" value=\"");
	echo(Lng("Apply", 1, 0));
	echo("\" class=\"abutton\"/> \n\t\t\t\t<input type=\"button\" value=\"");
	echo(Lng("Close", 1, 0));
	echo("\" onClick=\"window.location.href=document.URL;\" class=\"abutton grbut\" style=\"margin-left:10px;\"/><br>\n\t\t\t</td></tr>\n\t\t\t");
}
echo("\t\t</table>\n\t</form>\n\t\n</div>\n\n\t<script>\n\t\t\$(function(){\n\t\t\tcbox_submit();\n\t\t});\n\t\tfunction cbox_submit(){\n\t\t\t\$(\"#nform\").submit(function() {\n\t\t\t\t\$.post(\$(this).attr(\"action\"), \$(this).serialize(), function(data){\n\t\t\t\t\t\$.colorbox({html:data });\n\t\t\t\t},\n\t\t\t\t'html');\n\t\t\t\treturn false;\n\t\t\t});\n\t\t}\t\n\t</script>");

