<?php
define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}

$rsSRows = new TDMQuery();
if ($_SESSION["TDM_DBEDIT_TABLE"] == "") {
	$_SESSION["TDM_DBEDIT_TABLE"] = "TDM_PRICES";
}
if ($_SESSION["TDM_DBEDIT_ONPAGE"] <= 0) {
	$_SESSION["TDM_DBEDIT_ONPAGE"] = 50;
}
if ($_SESSION["TDM_DBEDIT_SORT"] == "") {
	$_SESSION["TDM_DBEDIT_SORT"] = "DATE";
}
if ($_SESSION["TDM_DBEDIT_ORDER"] == "") {
	$_SESSION["TDM_DBEDIT_ORDER"] = "DESC";
}
if ($_REQUEST["selecttable"] == "Y" && $TDMCore->isDBCon) {
	if ($_REQUEST["table"] != $_SESSION["TDM_DBEDIT_TABLE"]) {
		if ($_REQUEST["table"] == "TDM_PRICES") {
			$_SESSION["TDM_DBEDIT_SORT"] = "DATE";
		}
		if ($_REQUEST["table"] == "TDM_LINKS") {
			$_SESSION["TDM_DBEDIT_SORT"] = "CODE";
		}
		$_SESSION["TDM_DBEDIT_ORDER"] = "DESC";
		$_SESSION["TDM_DBEDIT_VALUE1"] = "";
		$_SESSION["TDM_DBEDIT_VALUE2"] = "";
		$_SESSION["TDM_DBEDIT_FILTER1"] = "";
		$_SESSION["TDM_DBEDIT_FILTER2"] = "";
		$_SESSION["TDM_DBEDIT_TABLE"] = $_REQUEST["table"];
	}
	if ($_GET["LINK"] != "") {
		$_SESSION["TDM_DBEDIT_FILTER1"] = "AKEY1";
		$_SESSION["TDM_DBEDIT_VALUE1"] = $_GET["LINK"];
	}
	if ($_GET["PRICE"] != "") {
		$_SESSION["TDM_DBEDIT_FILTER1"] = "AKEY";
		$_SESSION["TDM_DBEDIT_VALUE1"] = $_GET["PRICE"];
	}
	header("Location: /" . TDM_ROOT_DIR . "/admin/dbedit.php");
	exit();
}
if ($_REQUEST["filtersets"] == "Y" && $TDMCore->isDBCon) {
	$_SESSION["TDM_DBEDIT_FILTER1"] = $_POST["filter_1"];
	$_SESSION["TDM_DBEDIT_FILTER2"] = $_POST["filter_2"];
	$_SESSION["TDM_DBEDIT_VALUE1"] = trim($_POST["filter_value_1"]);
	$_SESSION["TDM_DBEDIT_VALUE2"] = trim($_POST["filter_value_2"]);
	if ($_SESSION["TDM_DBEDIT_FILTER1"] == "ARTICLE") {
		$_SESSION["TDM_DBEDIT_FILTER1"] = "AKEY";
		$_SESSION["TDM_DBEDIT_VALUE1"] = TDMSingleKey($_SESSION["TDM_DBEDIT_VALUE1"]);
	}
	if ($_SESSION["TDM_DBEDIT_FILTER2"] == "ARTICLE") {
		$_SESSION["TDM_DBEDIT_FILTER2"] = "AKEY";
		$_SESSION["TDM_DBEDIT_VALUE2"] = TDMSingleKey($_SESSION["TDM_DBEDIT_VALUE2"]);
	}
	if ($_SESSION["TDM_DBEDIT_FILTER1"] == "BRAND") {
		$_SESSION["TDM_DBEDIT_FILTER1"] = "BKEY";
		$_SESSION["TDM_DBEDIT_VALUE1"] = TDMSingleKey($_SESSION["TDM_DBEDIT_VALUE1"], true);
	}
	if ($_SESSION["TDM_DBEDIT_FILTER2"] == "BRAND") {
		$_SESSION["TDM_DBEDIT_FILTER2"] = "BKEY";
		$_SESSION["TDM_DBEDIT_VALUE2"] = TDMSingleKey($_SESSION["TDM_DBEDIT_VALUE2"], true);
	}
}
if (0 < intval($_REQUEST["page"])) {
	$PAGE_NUM = intval($_REQUEST["page"]);
}
else {
	$PAGE_NUM = 1;
}
if ($_POST["sort"] != "") {
	$_SESSION["TDM_DBEDIT_SORT"] = $_POST["sort"];
}
if ($_POST["order"] != "") {
	$_SESSION["TDM_DBEDIT_ORDER"] = $_POST["order"];
}
if (0 < $_POST["onpage"]) {
	$_SESSION["TDM_DBEDIT_ONPAGE"] = $_POST["onpage"];
}
$arOrder = array($_SESSION["TDM_DBEDIT_SORT"] => $_SESSION["TDM_DBEDIT_ORDER"]);
if ($_SESSION["TDM_DBEDIT_VALUE1"] != "") {
	$arFilter[$_SESSION["TDM_DBEDIT_FILTER1"] . " LIKE"] = "%" . $_SESSION["TDM_DBEDIT_VALUE1"] . "%";
}
if ($_SESSION["TDM_DBEDIT_VALUE2"] != "") {
	$arFilter[$_SESSION["TDM_DBEDIT_FILTER2"]] = $_SESSION["TDM_DBEDIT_VALUE2"];
}
if ($arFilter["DATE LIKE"] != "") {
	$arFilter["DATE"] = $arFilter["DATE LIKE"];
	unset($arFilter["DATE LIKE"]);
}
if ($arFilter["DATE"] != "") {
	list($day, $month, $year) = explode(".", $arFilter["DATE"]);
	$arFilter["DATE>"] = mktime(0, 0, 0, $month, $day, $year);
	unset($arFilter["DATE"]);
}
$arParams = array("ITEMS_COUNT" => $_SESSION["TDM_DBEDIT_ONPAGE"], "PAGE_NUM" => $PAGE_NUM);
if ($_POST["delem"] == "delete_records") {
	$resDB = new TDMQuery();
	$resDB->Select($_SESSION["TDM_DBEDIT_TABLE"], array(), $arFilter, array("DELETE" => "Y"));
	if (0 < $resDB->RowsCount) {
		NtAdd(Lng("Records_deleted") . ": " . $resDB->RowsCount);
		$_POST["action"] = "";
	}
}
$arRows = array();
if ($_SESSION["TDM_DBEDIT_TABLE"] == "TDM_PRICES") {
	$AddBut = "price";
	$arColumns = array("ARTICLE" => array("VALUE" => Lng("Number"), "TITLE" => Lng("Number", 1, 0)), "BRAND" => array("VALUE" => Lng("Brand"), "TITLE" => Lng("Manufacturer", 1, 0)), "PRICE" => array("VALUE" => Lng("Price"), "TITLE" => Lng("Price", 1, 0)), "CURRENCY" => array("VALUE" => "<img src='images/currency.png' width='16' height='16' alt=''>", "TITLE" => Lng("Currency", 1, 0)), "AVAILABLE" => array("VALUE" => "<img src='images/avail.png' width='16' height='16' alt=''>", "TITLE" => Lng("Avail.", 1, 0)), "ALT_NAME" => array("VALUE" => Lng("Name"), "TITLE" => Lng("Name", 1, 0)), "SUPPLIER" => array("VALUE" => "<img src='images/truck.png' width='16' height='16' alt=''>", "TITLE" => Lng("Supplier", 1, 0)), "STOCK" => array("VALUE" => "<img src='images/stock.png' width='16' height='16' alt=''>", "TITLE" => Lng("Stock", 1, 0)), "DAY" => array("VALUE" => "<img src='images/clock.png' width='16' height='16' alt=''>", "TITLE" => Lng("Dtime", 1, 0)), "OPTIONS" => array("VALUE" => Lng("Options"), "TITLE" => Lng("Options", 1, 0)), "CODE" => array("VALUE" => "<img src='images/key.png' width='16' height='16' alt=''>", "TITLE" => Lng("Code", 1, 0)), "DATE" => array("VALUE" => Lng("Date"), "TITLE" => Lng("Date", 1, 0)));
	$rsSRows->Select("TDM_PRICES", $arOrder, $arFilter, $arParams);
	while ($arRow = $rsSRows->Fetch()) {
		$arRow["TYPE_ID"] = $arRow["TYPE"];
		$arRow["TYPE"] = $TDMCore->arPriceType[$arRow["TYPE"]];
		$arRow["ARTICLE"] = "<a href=\"/" . TDM_ROOT_DIR . "/search/" . $arRow["AKEY"] . "/" . BrandNameEncode($arRow["BRAND"]) . "\">" . $arRow["ARTICLE"] . "</a>";
		if (0 < $arRow["DATE"]) {
			$arRow["DATE"] = date("d.m.y", $arRow["DATE"]);
		}
		$arOptions = TDMFormatOptions($arRow["OPTIONS"]);
		$arRow["OPTIONS"] = $arOptions["VIEW"];
		if (isset($_POST["delem"]) && $_POST["delem"] == $arRow["BKEY"] . $arRow["AKEY"] . $arRow["TYPE_ID"] . $arRow["DAY"] . $arRow["SUPPLIER"] . $arRow["STOCK"]) {
			$rsDel = new TDMQuery();
			$DResCnt = $rsDel->Delete("TDM_PRICES", array("BKEY" => $arRow["BKEY"], "AKEY" => $arRow["AKEY"], "TYPE" => $arRow["TYPE_ID"], "DAY" => $arRow["DAY"], "SUPPLIER" => $arRow["SUPPLIER"], "STOCK" => $arRow["STOCK"]));
			NtAdd(Lng("Record_deleted") . ": <b>" . $arRow["BRAND"] . "</b> " . $arRow["ARTICLE"] . " - <b>" . $arRow["PRICE"] . "</b> " . $arRow["CURRENCY"] . " - " . $arRow["TYPE"] . " (" . $arRow["SUPPLIER"] . ")");
			continue;
		}
		$arRows[] = $arRow;
	}
}
else {
	if ($_SESSION["TDM_DBEDIT_TABLE"] == "TDM_LINKS") {
		$AddBut = "link";
		$arColumns = array("BKEY1" => array("VALUE" => Lng("Brand") . " 1", "TITLE" => Lng("Brand", 1, 0) . " 1"), "AKEY1" => array("VALUE" => Lng("Cross_number") . " 1", "TITLE" => Lng("Cross_number", 1, 0) . " 1"), "SIDE" => array("VALUE" => "<img src='images/two_way.png' width='16' height='16' alt=''>", "TITLE" => Lng("Crosses_direction", 1, 0)), "BKEY2" => array("VALUE" => Lng("Brand") . " 2", "TITLE" => Lng("Brand", 1, 0) . " 2"), "AKEY2" => array("VALUE" => Lng("Cross_number") . " 2", "TITLE" => Lng("Cross_number", 1, 0) . " 2"), "CODE" => array("VALUE" => "<img src='images/key.png' width='16' height='16' alt=''>", "TITLE" => Lng("Code", 1, 0)));
		$rsSRows->Select("TDM_LINKS", $arOrder, $arFilter, $arParams);
		while ($arRow = $rsSRows->Fetch()) {
			$arRow["BRA1"] = $arRow["BKEY1"];
			$arRow["BRA2"] = $arRow["BKEY2"];
			$arRow["ART1"] = "<a href=\"/" . TDM_ROOT_DIR . "/search/" . $arRow["AKEY1"] . "/" . $arRow["BKEY1"] . "\">" . $arRow["AKEY1"] . "</a>";
			$arRow["ART2"] = "<a href=\"/" . TDM_ROOT_DIR . "/search/" . $arRow["AKEY2"] . "/" . $arRow["BKEY2"] . "\">" . $arRow["AKEY2"] . "</a>";
			if ($arRow["SIDE"] == 1) {
				$Side = "WS_link_right";
			}
			else {
				if ($arRow["SIDE"] == 2) {
					$Side = "WS_link_left";
				}
				else {
					$Side = "WS_link_both";
				}
			}
			$arRow["SIDE"] = "<img src=\"images/sarr" . $arRow["SIDE"] . ".png\" width=\"16\" height=\"16\" class=\"ttip\" title=\"" . Lng($Side, 1, 0) . "\"/>";
			if (isset($_POST["delem"]) && $_POST["delem"] == $arRow["BKEY1"] . $arRow["AKEY1"] . $arRow["BKEY2"] . $arRow["AKEY2"] . $arRow["CODE"]) {
				$rsDel = new TDMQuery();
				$DResCnt = $rsDel->Delete("TDM_LINKS", array("BKEY1" => $arRow["BKEY1"], "AKEY1" => $arRow["AKEY1"], "BKEY2" => $arRow["BKEY2"], "AKEY2" => $arRow["AKEY2"], "CODE" => $arRow["CODE"]));
				NtAdd(Lng("Record_deleted") . ": <b>" . $arRow["BKEY1"] . "</b> " . $arRow["AKEY1"] . " - <b>" . $arRow["BKEY2"] . "</b> " . $arRow["AKEY2"]);
				continue;
			}
			$arRows[] = $arRow;
		}
	}
	else {
		if ($_SESSION["TDM_DBEDIT_TABLE"] == "TDM_RULES") {
			$AddBut = "rule";
			$arColumns = array("R_SORT" => array("VALUE" => "<img src='images/sort.gif' width='16' height='16' alt=''>", "TITLE" => Lng("Sort", 1, 0)), "R_FIELD" => array("VALUE" => Lng("Field", 1, 0), "TITLE" => Lng("Field", 1, 0)), "R_FROM" => array("VALUE" => Lng("From this", 1, 0), "TITLE" => Lng("From this", 1, 0)), "R_TO" => array("VALUE" => Lng("To this", 1, 0), "TITLE" => Lng("To this", 1, 0)), "R_REGSENS" => array("VALUE" => "<img src='images/regsen.png' width='16' height='16' alt=''>", "TITLE" => Lng("Case-sensitive", 1, 0)), "R_MODE" => array("VALUE" => "<img src='images/mode_a.png' width='16' height='16' alt=''>", "TITLE" => Lng("After replacement complete search", 1, 0)));
			while ($arRow = $rsSRows->Fetch()) {
				if ($_REQUEST["del"] == $arRow["ID"]) {
					TDConvRule::Delete($arRow["ID"]);
					header("Location: /" . TDM_ROOT_DIR . "/admin/dbedit/?mess_delrow=" . $arRow["ID"]);
					exit();
				}
				$arRows[] = $arRow;
			}
		}
	}
}
$arPgn["TOTAL_ITEMS"] = $rsSRows->DBCount;
$arPgn["TOTAL_PAGES"] = $rsSRows->PagesCount;
$arPgn["ITEMS_ON_PAGE"] = $arParams["ITEMS_COUNT"];
$arPgn["PAGES_LINK"] = "/" . TDM_ROOT_DIR . "/admin/dbedit.php?";
$arPgn["CURRENT_PAGE"] = $PAGE_NUM;
echo("<head><title>TDM :: ");
echo(Tip("DB_Editor"));
echo("</title></head>\n<div class=\"apanel_cont\">");
require_once("apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t<link rel=\"stylesheet\" href=\"/");
echo(TDM_ROOT_DIR);
echo("/media/js/colorbox/cmain.css\" />\n\t<script type=\"text/javascript\" language=\"javascript\" src=\"/");
echo(TDM_ROOT_DIR);
echo("/media/js/colorbox/colorbox.js\"></script>\n\t");
jsLinkJqueryUi();
echo("\t");
jsLinkFormStyler();
echo("\t<script>\n\t\tAddFSlyler('input, select, textarea, checkbox, radio');\n\t\t\$(document).ready(function(){\n\t\t\t\$(\".popup\").colorbox({rel:false, current:'', preloading:false, arrowKey:false, scrolling:false, overlayClose:false});\n\t\t\t\$('.ttip').tooltip({ position:{my:\"left+25 top+20\"}, track:true});\n\t\t});\n\t\t\$(\"#cboxPrevious\").hide();\n\t\t\$(\"#cboxNext\").hide();\n\t\t\n\t</script>\n\t<a href=\"dbedit_");
echo($AddBut);
echo(".php?ID=NEW\" class=\"flrig bluebut popup\">");
echo(Lng("Add_new", 0, 0));
echo("</a>\n\t<div style=\"position:absolute; left:400px; top:24px;\">\n\t\t<form method=\"post\" action=\"\" id=\"tablef\">\n\t\t<input type=\"hidden\" name=\"selecttable\" value=\"Y\"/>\n\t\t");
echo(Lng("Table"));
echo(": \n\t\t<select name=\"table\" style=\"width:120px;\" OnChange=\"\$('#tablef').submit();\">\n\t\t\t<option value=\"TDM_PRICES\">");
echo(Lng("Prices", 1, 0));
echo("</option>\n\t\t\t<option value=\"TDM_LINKS\" ");
if ($_SESSION["TDM_DBEDIT_TABLE"] == "TDM_LINKS") {
	echo("selected");
}
echo(" >");
echo(Lng("Crosses", 1, 0));
echo("</option>\n\t\t\t");
echo("\t\t</select>\n\t\t</form>\n\t</div>\n\t<h1>");
echo(Tip("DB_Editor"));
echo("</h1>\n\t<hr>\n\t");
ErShow();
echo("\t\n\t<div class=\"delall\">\n\t\t");
echo(Lng("Total_records"));
echo(": <b>");
echo($arPgn["TOTAL_ITEMS"]);
echo("</b><br>\n\t\t<a href=\"javascript:void(0);\" class=\"imlink\" onclick=\"");
jsDelConfirm("delete_records", Tip("Delete_this_records") . ": <b>" . $arPgn["TOTAL_ITEMS"] . "</b>");
echo("\">");
echo(Tip("Delete_this_records"));
echo("</a>\n\t</div>\n\t\t\n\t<form method=\"post\" action=\"\" name=\"eform\" id=\"eform\">\n\t\t<input type=\"hidden\" name=\"filtersets\" value=\"Y\"/>\n\t\t<table class=\"sfiltab\"><tr>\n\t\t\t<td><select name=\"filter_1\" style=\"width:160px;\">\n\t\t\t\t\t");
foreach ($arColumns as $Code => $arValues) {
	if ($Code == "DATE") {
		continue;
	}
	if ($_SESSION["TDM_DBEDIT_FILTER1"] == $Code) {
		$Filt1Sel = "selected";
	}
	else {
		$Filt1Sel = "";
	}
	echo("<option value=\"" . $Code . "\" " . $Filt1Sel . ">" . $arValues["TITLE"] . "</option>");
}
echo("\t\t\t\t</select>\n\t\t\t</td>\n\t\t\t<td style=\"padding:0px 5px 0px 10px;\">");
echo(Lng("Contains"));
echo(":</td>\n\t\t\t<td><input type=\"text\" class=\"styler\" name=\"filter_value_1\" value=\"");
echo($_SESSION["TDM_DBEDIT_VALUE1"]);
echo("\" /></td>\n\t\t\t<td rowspan=\"2\">\n\t\t\t\t<div class=\"filter_button\" onclick=\"\$('#eform').submit();\"/>");
echo(Lng("Apply_filter", 1, 0));
echo("</div>\n\t\t\t</td>\n\t\t</tr><tr>\n\t\t\t<td><select name=\"filter_2\" style=\"width:160px;\">\n\t\t\t\t\t");
foreach ($arColumns as $Code => $arValues) {
	if ($Code == "DATE") {
		continue;
	}
	if ($_SESSION["TDM_DBEDIT_FILTER2"] == $Code) {
		$Filt2Sel = "selected";
	}
	else {
		$Filt2Sel = "";
	}
	echo("<option value=\"" . $Code . "\" " . $Filt2Sel . ">" . $arValues["TITLE"] . "</option>");
}
echo("\t\t\t\t</select>\n\t\t\t</td>\n\t\t\t<td style=\"padding:0px 5px 0px 10px;\">");
echo(Lng("Equally"));
echo(":</td>\n\t\t\t<td><input type=\"text\" class=\"styler\" name=\"filter_value_2\" value=\"");
echo($_SESSION["TDM_DBEDIT_VALUE2"]);
echo("\" /></td>\n\t\t</tr>\n\t\t");
echo("\t\t</table>\n\t</form>\n\t\t\n\t<hr>\n\t\t\n\t\t\n\t\t\n\t\t");
if (1 < $arPgn["TOTAL_PAGES"]) {
	TDMShowPagination($arPgn, array("PAGE_TEXT" => "Y", "PAGES_DIAPAZON" => 6));
}
if (0 < $arPgn["TOTAL_ITEMS"]) {
	echo("\t\t\t<div class=\"tfrig\" style=\"padding:5px 0px 15px 0px;\">\n\t\t\t\t<form action=\"\" id=\"onpagef\" method=\"post\">\n\t\t\t\t");
	echo(Tip("Records_per_page"));
	echo(": \n\t\t\t\t");
	$arOnPages = array(20, 30, 50, 100, 200, 300, 500, 800, 1000);
	echo("\t\t\t\t<select name=\"onpage\" style=\"width:90px;\" OnChange=\"\$('#onpagef').submit();\">\n\t\t\t\t\t");
	FShowSelectOptions($arOnPages, $_SESSION["TDM_DBEDIT_ONPAGE"]);
	echo("\t\t\t\t</select>\n\t\t\t\t</form>\n\t\t\t</div>\n\t\t");
}
echo("\t\t<div class=\"tdcler\"></div><div class=\"tclear\"></div>\n\t\t\n\t\t<form action=\"\" id=\"sortf\" method=\"post\">\n\t\t\t<input type=\"hidden\" name=\"sort\" id=\"hfsort\"value=\"\"/>\n\t\t\t<input type=\"hidden\" name=\"order\" id=\"hforder\" value=\"\"/>\n\t\t</form>\n\t\t\n\t\t<table class=\"etab\" style=\"font-family:Arial;\"><tr class=\"head\">\n\t\t");
if (0 < count($arColumns)) {
	foreach ($arColumns as $Code => $arValues) {
		if ($_SESSION["TDM_DBEDIT_ORDER"] == "ASC") {
			$SortOrder = "&#9650;";
			$ToOrder = "DESC";
		}
		else {
			$SortOrder = "&#9660;";
			$ToOrder = "ASC";
		}
		if ($_SESSION["TDM_DBEDIT_SORT"] == $Code) {
			$SortClass = "active";
		}
		else {
			$SortClass = "";
			$ToOrder = "DESC";
			$SortOrder = "&#9660;";
		}
		echo("\t\t\t\t<td class=\"ttip\" title=\"");
		echo($arValues["TITLE"]);
		echo("\">");
		echo($arValues["VALUE"]);
		echo(" \n\t\t\t\t\t<a href=\"javascript:void(0);\" class=\"");
		echo($SortClass);
		echo("\" title=\"");
		echo(Lng("Sort", 1, 0));
		echo("\" onclick=\"\$('#hfsort').val('");
		echo($Code);
		echo("'); \$('#hforder').val('");
		echo($ToOrder);
		echo("'); \$('#sortf').submit();\">");
		echo($SortOrder);
		echo("</a>\n\t\t\t\t</td>\n\t\t\t");
	}
}
echo("<td></td></tr>");
if (0 < $arPgn["TOTAL_ITEMS"]) {
	foreach ($arRows as $arRow) {
		if ($_SESSION["TDM_DBEDIT_TABLE"] == "TDM_PRICES") {
			$EdtUID = "dbedit_price.php?BKEY=" . $arRow["BKEY"] . "&AKEY=" . $arRow["AKEY"] . "&TYPE=" . $arRow["TYPE_ID"] . "&DAY=" . urlencode($arRow["DAY"]) . "&SUPPLIER=" . urlencode($arRow["SUPPLIER"]) . "&STOCK=" . urlencode($arRow["STOCK"]);
			$DelUID = $arRow["BKEY"] . $arRow["AKEY"] . $arRow["TYPE_ID"] . $arRow["DAY"] . $arRow["SUPPLIER"] . $arRow["STOCK"];
		}
		else {
			if ($_SESSION["TDM_DBEDIT_TABLE"] == "TDM_LINKS") {
				$EdtUID = "dbedit_link.php?BKEY1=" . $arRow["BKEY1"] . "&AKEY1=" . $arRow["AKEY1"] . "&BKEY2=" . $arRow["BKEY2"] . "&AKEY2=" . $arRow["AKEY2"] . "&CODE=" . urlencode($arRow["CODE"]);
				$DelUID = $arRow["BKEY1"] . $arRow["AKEY1"] . $arRow["BKEY2"] . $arRow["AKEY2"] . $arRow["CODE"];
			}
		}
		echo("<tr class=\"rows\">");
		foreach ($arColumns as $Code => $arValues) {
			echo("<td>" . $arRow[$Code] . "</td>");
		}
		echo("\t\t\t\t<td style=\"white-space:nowrap;\"><a href=\"/");
		echo(TDM_ROOT_DIR);
		echo("/admin/");
		echo($EdtUID);
		echo("\" class=\"popup\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" title=\"");
		echo(Lng("Edit", 1, 0));
		echo("\"></a>\n\t\t\t\t\t<a href=\"javascript:void(0);\" onclick=\"");
		jsDelConfirm($DelUID);
		echo("\" ><img src=\"images/trash.gif\" width=\"16\" height=\"16\" title=\"");
		echo(Lng("Delete", 1, 0));
		echo("\"></a></td>\n\t\t\t\t</tr>\n");
	}
}
else {
	echo("<tr><td colspan=\"100\"><br><center>No search result<br><br></center></td></tr>");
}
echo("\t\t</table>\n\t\t\n\t\t");
if (1 < $arPgn["TOTAL_PAGES"]) {
	TDMShowPagination($arPgn, array("PAGE_TEXT" => "Y", "PAGES_DIAPAZON" => 6));
}
echo("\t<div class=\"tclear\"></div>\n</div>");

