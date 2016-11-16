<?php
define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../../tdmcore/init.php");

if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}

$arASupps = array();
$resDB = new TDMQuery();
$resDB->Select("TDM_IM_SUPPLIERS", array(), array());
while ($arSupp = $resDB->Fetch()) {
	if ($_POST["delete"] == "Y" && $_POST["delem"] == "DELSUP" . $arSupp["ID"]) {
		$DResCnt = $resDB->Delete("TDM_IM_SUPPLIERS", array("ID" => $arSupp["ID"]));
		if (0 < $DResCnt) {
			$resDB->Delete("TDM_IM_COLUMNS", array("SUPID" => $arSupp["ID"]));
			TDMRedirect("admin/import/");
		}
	}
	if (!($_REQUEST["ID"] == $arSupp["ID"])) {
		continue;
	}
	$CID = $arSupp["ID"];
	$arCSupp = $arSupp;
	$_POST["CODE"] = $arSupp["CODE"];
	if (!($_POST["edit"] != "Y")) {
		continue;
	}
	foreach ($arSupp as $Key => $Value) {
		$_POST[$Key] = $Value;
	}
}
if ($_POST["delete"] == "Y") {
	$rsCSp = new TDMQuery();
	if ($_POST["delem"] == "EMPTY_PRICES") {
		$rsCSp->Delete("TDM_PRICES", array("CODE" => $arCSupp["CODE"]));
		$Clr1 = "redcolor";
	}
	if ($_POST["delem"] == "EMPTY_LINKS") {
		$rsCSp->Delete("TDM_LINKS", array("CODE" => $arCSupp["CODE"]));
		$Clr2 = "redcolor";
	}
}
if (0 < $arCSupp["ID"]) {
	$rsCSp = new TDMQuery();
	$rsCSp->SimpleSelect("SELECT COUNT(*) FROM TDM_PRICES WHERE CODE=\"" . $arCSupp["CODE"] . "\" ");
	if ($arDB = $rsCSp->Fetch()) {
		$PricesCount = $arDB["COUNT(*)"];
	}
	$rsCSp->SimpleSelect("SELECT COUNT(*) FROM TDM_LINKS WHERE CODE=\"" . $arCSupp["CODE"] . "\" ");
	if ($arDB = $rsCSp->Fetch()) {
		$LinksCount = $arDB["COUNT(*)"];
	}
}
if ($_POST["edit"] == "Y") {
	if (0 < $_FILES["getfile"]["size"]) {
		if (is_uploaded_file($_FILES["getfile"]["tmp_name"])) {
			if (preg_match("/\\.(csv)/", $_FILES["getfile"]["name"]) || preg_match("/\\.(txt)/", $_FILES["getfile"]["name"]) || preg_match("/\\.(xls)/", $_FILES["getfile"]["name"]) || preg_match("/\\.(xlsx)/", $_FILES["getfile"]["name"]) || preg_match("/\\.(rar)/", $_FILES["getfile"]["name"]) || preg_match("/\\.(zip)/", $_FILES["getfile"]["name"])) {
				$UPFP = $_SERVER["DOCUMENT_ROOT"] . "/" . TDM_ROOT_DIR . "/admin/import/downloads/";
				if (!(move_uploaded_file($_FILES["getfile"]["tmp_name"], $UPFP . $_FILES["getfile"]["name"]))) {
					ErAdd("No permission to upload file in to " . $UPFP);
				}
				else {
					NtAdd("File uploaded: \"" . $_FILES["getfile"]["name"] . "\"");
					$_POST["FILE_PATH"] = "/" . TDM_ROOT_DIR . "/admin/import/downloads/" . $_FILES["getfile"]["name"];
				}
			}
			else {
				ErAdd("Uploaded file should be in format: CSV, XLS, XLSX, TXT (zip, rar)");
			}
		}
		else {
			ErAdd("No file was uploaded");
		}
	}
	$_POST["ARTBRA_SIDE"] = intval($_POST["ARTBRA_SIDE"]);
	$_POST["PRICE_TYPE"] = intval($_POST["PRICE_TYPE"]);
	$_POST["PRICE_EXTRA"] = intval($_POST["PRICE_EXTRA"]);
	$_POST["PRICE_ADD"] = floatval($_POST["PRICE_ADD"]);
	$_POST["MIN_AVAIL"] = intval($_POST["MIN_AVAIL"]);
	$_POST["MAX_DAY"] = intval($_POST["MAX_DAY"]);
	$_POST["DAY_ADD"] = intval($_POST["DAY_ADD"]);
	$_POST["CONSIDER_HOT"] = intval($_POST["CONSIDER_HOT"]);
	$_POST["DELETE_ON_START"] = intval($_POST["DELETE_ON_START"]);
	$_POST["DEF_BRAND"] = substr($_POST["DEF_BRAND"], 0, 32);
	$_POST["FILE_PATH"] = substr(trim($_POST["FILE_PATH"]), 0, 128);
	$_POST["FILE_NAME"] = substr(trim($_POST["FILE_NAME"]), 0, 32);
	$_POST["FILE_PASSW"] = substr(trim($_POST["FILE_PASSW"]), 0, 32);
	$_POST["START_FROM"] = intval($_POST["START_FROM"]);
	$_POST["STOP_BEFORE"] = intval($_POST["STOP_BEFORE"]);
	$_POST["CURRENCY"] = substr($_POST["CURRENCY"], 0, 3);
	$_POST["DEF_AVAILABLE"] = intval($_POST["DEF_AVAILABLE"]);
	$_POST["DEF_STOCK"] = substr($_POST["DEF_STOCK"], 0, 16);
	if (strlen($_POST["NAME"]) < 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Name"), 1);
	}
	if ($CID <= 0 && strlen($_POST["CODE"]) < 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Code"), 1);
	}
	if (strlen($_POST["COLUMN_SEP"]) < 1) {
		$_POST["COLUMN_SEP"] = ";";
	}
	if (strlen($_POST["FILE_PATH"]) < 5) {
		ErAdd(Lng("A_required_field") . " - " . Lng("File_path"), 1);
	}
	if (ErCheck() && $CID <= 0) {
		$resDB->Select("TDM_IM_SUPPLIERS", array(), array("CODE" => $_POST["CODE"]));
		if ($arRes = $resDB->Fetch()) {
			ErAdd(Lng("Code") . " \"" . $_POST["CODE"] . "\" " . Lng("is_already_exist", 2), 1);
		}
	}
	if (ErCheck()) {
		if ($_POST["STOP_BEFORE"] < $_POST["START_FROM"]) {
			$_POST["START_FROM"] = $_POST["STOP_BEFORE"];
		}
		if ($_POST["STOP_BEFORE"] < $_POST["START_FROM"]) {
			$_POST["STOP_BEFORE"] = $_POST["START_FROM"];
		}
		$arFields = array("NAME" => trim($_POST["NAME"]), "COLUMN_SEP" => $_POST["COLUMN_SEP"], "ARTBRA_SEP" => $_POST["ARTBRA_SEP"], "ARTBRA_SIDE" => $_POST["ARTBRA_SIDE"], "ENCODE" => $_POST["ENCODE"], "FILE_PATH" => $_POST["FILE_PATH"], "FILE_NAME" => $_POST["FILE_NAME"], "FILE_PASSW" => $_POST["FILE_PASSW"], "START_FROM" => $_POST["START_FROM"], "STOP_BEFORE" => $_POST["STOP_BEFORE"], "PRICE_EXTRA" => $_POST["PRICE_EXTRA"], "CONSIDER_HOT" => $_POST["CONSIDER_HOT"], "DELETE_ON_START" => $_POST["DELETE_ON_START"], "PRICE_ADD" => $_POST["PRICE_ADD"], "PRICE_TYPE" => $_POST["PRICE_TYPE"], "MIN_AVAIL" => $_POST["MIN_AVAIL"], "MAX_DAY" => $_POST["MAX_DAY"], "DEF_BRAND" => $_POST["DEF_BRAND"], "DEF_CURRENCY" => $_POST["DEF_CURRENCY"], "DAY_ADD" => $_POST["DAY_ADD"], "DEF_AVAILABLE" => $_POST["DEF_AVAILABLE"], "DEF_STOCK" => $_POST["DEF_STOCK"]);
		if (0 < $CID) {
			$IRes = $resDB->Update2("TDM_IM_SUPPLIERS", $arFields, array("ID" => $CID));
			if ($IRes) {
				NtAdd(Lng("Record_updated") . ": " . $_POST["NAME"]);
			}
			if (isset($_POST["NUM"]) && 0 < count($_POST["NUM"]) && isset($_POST["FIELD"]) && 0 < count($_POST["FIELD"])) {
				$_POST["NUM"] = array_unique($_POST["NUM"], SORT_REGULAR);
				$_POST["FIELD"] = array_unique($_POST["FIELD"], SORT_REGULAR);
				foreach ($_POST["NUM"] as $ID => $NUM) {
					if (!(0 < $NUM && $_POST["FIELD"][$ID] != "")) {
						continue;
					}
					$resDB->Update2("TDM_IM_COLUMNS", array("NUM" => $NUM, "FIELD" => $_POST["FIELD"][$ID]), array("ID" => $ID));
				}
			}
			if (isset($_POST["NEW_NUM"]) && 0 < count($_POST["NEW_NUM"]) && isset($_POST["NEW_FIELD"]) && 0 < count($_POST["NEW_FIELD"])) {
				$_POST["NEW_NUM"] = array_unique($_POST["NEW_NUM"], SORT_REGULAR);
				$_POST["NEW_FIELD"] = array_unique($_POST["NEW_FIELD"], SORT_REGULAR);
				foreach ($_POST["NEW_NUM"] as $Key => $NUM) {
					if (!(0 < $NUM && $_POST["NEW_FIELD"][$Key] != "")) {
						continue;
					}
					$resDB->Insert("TDM_IM_COLUMNS", array("SUPID" => $CID, "NUM" => $NUM, "FIELD" => $_POST["NEW_FIELD"][$Key]));
				}
			}
		}
		else {
			$arFields["CODE"] = StrForURL(trim($_POST["CODE"]));
			$NewID = $resDB->Insert("TDM_IM_SUPPLIERS", $arFields);
			if ($NewID) {
				if (isset($_POST["NEW_NUM"]) && 0 < count($_POST["NEW_NUM"]) && isset($_POST["NEW_FIELD"]) && 0 < count($_POST["NEW_FIELD"])) {
					$_POST["NEW_NUM"] = array_unique($_POST["NEW_NUM"], SORT_REGULAR);
					$_POST["NEW_FIELD"] = array_unique($_POST["NEW_FIELD"], SORT_REGULAR);
					foreach ($_POST["NEW_NUM"] as $Key => $NUM) {
						if (!(0 < $NUM && $_POST["NEW_FIELD"][$Key] != "")) {
							continue;
						}
						$resDB->Insert("TDM_IM_COLUMNS", array("SUPID" => $NewID, "NUM" => $NUM, "FIELD" => $_POST["NEW_FIELD"][$Key]));
					}
				}
				TDMRedirect("admin/import/?ID=" . $NewID);
			}
		}
	}
}
$resDB->Select("TDM_IM_SUPPLIERS", array(), array());
while ($arSupps = $resDB->Fetch()) {
	$arASupps[] = $arSupps;
}
if ($_REQUEST["ID"] == "NEW" || 0 < $CID) {
	$DoEdit = "Y";
	$arCols = array();
	$arCurs = array();
	foreach ($TDMCore->arCurs as $Cur => $arCur) {
		$arCurs[] = $Cur;
	}
	if (count($arCurs) <= 0) {
		$arCurs[] = "USD";
	}
	$arNums[0] = "";
	$i = 1;
	while ($i < 26) {
		$arNums[] = $i;
		++$i;
	}
	$arFields = array("" => "", "ARTICLE_BRAND" => Lng("Article", 1, 0) . " & " . Lng("Brand", 1, 0), "ARTICLE" => Lng("Article", 1, 0), "BRAND" => Lng("Brand", 1, 0), "PRICE" => Lng("Price", 1, 0), "ALT_NAME" => Lng("Name", 1, 0), "CURRENCY" => Lng("Currency", 1, 0), "DAY" => Lng("Dtime", 1, 0), "AVAILABLE" => Lng("Availability", 1, 0), "STOCK" => Lng("Stock", 1, 0), "PERCENTGIVE" => Lng("PRICE_OPTION_PERCENTGIVE", 1, 0), "SET" => Lng("PRICE_OPTION_SET", 1, 0), "WEIGHT" => Lng("Weight_gr", 1, 0), "USED" => Lng("PRICE_OPTION_USED", 1, 0), "RESTORED" => Lng("PRICE_OPTION_RESTORED", 1, 0), "DAMAGED" => Lng("PRICE_OPTION_DAMAGED", 1, 0), "NORETURN" => Lng("PRICE_OPTION_NORETURN", 1, 0), "MINIMUM" => Lng("PRICE_OPTION_MINIMUM", 1, 0), "LITERS" => Lng("PRICE_OPTION_LITERS", 1, 0), "COPY" => Lng("PRICE_OPTION_COPY", 1, 0), "HOT" => Lng("PRICE_OPTION_HOT", 1, 0));
	if (0 < $CID) {
		$resDB->Select("TDM_IM_COLUMNS", array("NUM" => "ASC"), array("SUPID" => $CID));
		while ($arRes = $resDB->Fetch()) {
			if ($_POST["delem"] == "DELCOL" . $arRes["ID"]) {
				$rsDelDB = new TDMQuery();
				$DResCnt = $rsDelDB->Delete("TDM_IM_COLUMNS", array("ID" => $arRes["ID"]));
				if (!(0 < $DResCnt)) {
					continue;
				}
				NtAdd(Lng("Record_deleted") . ": " . $arRes["NUM"] . " - " . $arRes["FIELD"]);
				$_POST["delete"] = "N";
				$_POST["delem"] = "";
				continue;
			}
			$arCols[] = $arRes;
		}
	}
}
echo("<head><title>TDMod :: ");
echo(Lng("Import_master"));
echo("</title></head>\n<div class=\"apanel_cont\">");
require_once(TDM_PATH . "/admin/apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t");
jsLinkJqueryUi();
echo("\t");
jsLinkFormStyler();
echo("\t<script>\n\t\tAddFSlyler('input, checkbox, radio, select, button');\n\t\t\$(document).ready(function(){\n\t\t\t\$('.ttip').tooltip({ track:true, content:function(){return \$(this).prop('title');} });\n\t\t});\n\t</script>\n\t<h1>");
echo(Lng("Import_master"));
echo("</h1><div class=\"tclear\"></div>\n\t<hr>\n\t<table class=\"colstab\"><tr><td>\n\t<div class=\"imsupdiv\">\n\t\t<div class=\"suptitleb\">");
echo(Lng("Suppliers"));
echo(": <a href=\"?ID=NEW\" class=\"newsuplb\" title=\"");
echo(Lng("Add_new", 1, 0));
echo("\"></a></div>\n\t\t");
foreach ($arASupps as $arASup) {
	++$SpCnt;
	echo("\t\t\t<a href=\"run.php?ID=");
	echo($arASup["ID"]);
	echo("\" class=\"imstart\" title=\"Start import\"></a>\n\t\t\t<a href=\"?ID=");
	echo($arASup["ID"]);
	echo("\" class=\"supplier name\">");
	echo($arASup["ID"]);
	echo(". <b>");
	echo($arASup["NAME"]);
	echo("</b></a>\n\t\t\t<div onclick=\"");
	jsDelConfirm("DELSUP" . $arASup["ID"], Lng("Really_delete_record", 0, 0) . ": " . $arASup["NAME"]);
	echo("\" class=\"trashws\"></div>\n\t\t");
}
echo("\t\t");
if ($SpCnt <= 0) {
	echo("\t\t\t<a href=\"?ID=NEW\" class=\"supplier name\" style=\"font-family:Arial; padding-left:34px!important;\">&#9658; ");
	echo(Lng("Add_new"));
	echo(" ");
	echo(Tip("Price_of_supplier"));
	echo("</a>\n\t\t");
}
echo("\t\t<a href=\"analogs.php\" class=\"supplier name\" style=\"font-family:Arial; padding-left:34px!important;\">&#9658; <b>");
echo(Tip("Import_analogs_records"));
echo("</b></a>\n\t</div>\n\t<br>\n\t<br>\n\t\n\t");
if (0 < $arCSupp["ID"]) {
	echo("\t\t<div class=\"informlay\">\n\t\t\t<div class=\"informhead\"><b>");
	echo($arCSupp["NAME"]);
	echo("</b><br>");
	echo(Tip("Supplier_DB_records"));
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
	echo("\" class=\"trashbut\"></div>\n\t\t\t\t</td></tr>\n\t\t\t</table>\n\t\t</div>\n\t\t<br><br>\n\t\t");
	if ($TDMCore->arSettings["CRON_KEY"] != "") {
		echo("\t\t\t<div class=\"informlay\">\n\t\t\t\t<div class=\"informhead\"><b>CRON</b> auto import script file:</div>\n\t\t\t\t<table class=\"informtab\"><tr><td style=\"padding:10px;\">\n\t\t\t\t/");
		echo(TDM_ROOT_DIR);
		echo("/import/");
		echo($TDMCore->arSettings["CRON_KEY"]);
		echo("/");
		echo($arCSupp["ID"]);
		echo(".php\n\t\t\t\t</table>\n\t\t\t</div>\n\t\t");
	}
	echo("\t");
}
echo("\n\t</td><td width=\"90%\">\n\t\t");
if ($DoEdit == "Y") {
	echo("\t\t<form action=\"\" id=\"editform\" method=\"post\" enctype=\"multipart/form-data\">\n\t\t\t<input type=\"hidden\" name=\"edit\" value=\"Y\"/>\n\t\t\t<table class=\"formtab\">\n\t\t\t\t<tr><td class=\"fname\"></td><td class=\"ftext\">\n\t\t\t\t\t<b>");
	if ($_REQUEST["ID"] == "NEW") {
		echo(Lng("Add_new"));
	}
	else {
		echo(Lng("Edit"));
	}
	echo(" ");
	echo(Tip("Price_of_supplier"));
	echo("</b>\n\t\t\t\t\t<div class=\"tclear\"></div>\n\t\t\t\t\t");
	ErShow();
	echo("\t\t\t\t</td></tr><tr>\n\t\t\t\t<td class=\"fname\">*");
	echo(Lng("Name"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"NAME\" value=\"");
	echo($_POST["NAME"]);
	echo("\" maxlength=\"32\" style=\"width:250px;\" /></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">*");
	echo(Lng("Code"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"CODE\" id=\"codefield\" value=\"");
	echo($_POST["CODE"]);
	echo("\" onkeyup=\"this.value=this.value.replace(/[^a-zA-Z0-9]/g,'');\" ");
	if (0 < $CID) {
		echo("disabled");
	}
	echo(" maxlength=\"32\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Lng("Any_name"));
	echo(" (Eng.)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Column_separator"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"COLUMN_SEP\" value=\"");
	echo($_POST["COLUMN_SEP"]);
	echo("\" maxlength=\"3\" style=\"width:70px;\" />  <span class=\"tiptext\">");
	echo(Tip("Default_in_CSV"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Encode"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"ENCODE\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	FShowSelectOptions(array("CP1251", "UTF-8"), $_POST["ENCODE"]);
	echo("\t\t\t\t\t</select> <span class=\"tiptext\">of CSV file</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("File_path"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" id=\"filepath\" name=\"FILE_PATH\" value=\"");
	echo($_POST["FILE_PATH"]);
	echo("\" maxlength=\"256\" style=\"width:440px; margin-bottom:8px;\" /> \n\t\t\t\t\t<a href=\"javascript:void(0)\" class=\"flmang ttip\" OnClick=\"\$('#ftree').toggle('normal');\" title=\"File manager\"></a> \n\t\t\t\t\t<a href=\"javascript:void(0)\" class=\"tdmhelp ttip\" OnClick=\"\$('#fphelp').toggle('normal');\" title=\"");
	echo(Lng("Help", 1, 0));
	echo("\"></a>\n\t\t\t\t\t<div style=\"padding:0px 20px 0px 20px; display:none;\" id=\"fphelp\">\n\t\t\t\t\t\t<strong class=\"tiptext\">CSV, XLS, XLSX, TXT (zip, rar)</strong><br><br>\n\t\t\t\t\t\t<span class=\"tiptext\">");
	echo(Tip("Descr_IM_file_path"));
	echo("</span><hr>\n\t\t\t\t\t</div><br>\n\t\t\t\t\t\n\t\t\t\t\t<script src=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/images/jqft/jft.js\" type=\"text/javascript\"></script>\n\t\t\t\t\t<link href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/images/jqft/jft.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n\t\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\t\$(document).ready( function() {\n\t\t\t\t\t\t\t\$('#ftree').fileTree({ root: '/', script: '/");
	echo(TDM_ROOT_DIR);
	echo("/admin/images/jqft/ft-prices.php', folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, multiFolder: false }, function(file) { \n\t\t\t\t\t\t\t\t\$('#filepath').val(file);\n\t\t\t\t\t\t\t\t\$('#ftree').toggle('normal');\n\t\t\t\t\t\t\t});\n\t\t\t\t\t\t});\n\t\t\t\t\t</script>\n\t\t\t\t\t<div id=\"ftree\" class=\"ft-box\" style=\"display:none; width:480px;\"></div>\n\t\t\t\t\t\n\t\t\t\t\t<a href=\"javascript:void(0)\" style=\"font-family:arial;\" OnClick=\"\$('#uplink').toggle(); \$('#updiv').toggle(); \$('#tiplimit').toggle(); \$('#getfile').click(); \" id=\"uplink\">&#9658; ");
	echo(Tip("Upload_new_file"));
	echo("</a><br>\n\t\t\t\t\t<div class=\"tiptext\" style=\"padding:2px 0px 0px 16px;\" id=\"tiplimit\">\n\t\t\t\t\t\t");
	echo(Tip("Your_server_uploads_limit"));
	echo(": \n\t\t\t\t\t\t\t");
	if (TDM_LANG == "ru") {
		$phpnet = "ru";
	}
	else {
		$phpnet = "en";
	}
	echo("\t\t\t\t\t\t\t<a href=\"http://php.net/manual/");
	echo($phpnet);
	echo("/ini.core.php#ini.upload-max-filesize\" target=\"_blank\" class=\"ttip\" title=\"upload_max_filesize\">");
	echo((int)ini_get("upload_max_filesize"));
	echo("Mb</a> / \n\t\t\t\t\t\t\t<a href=\"http://php.net/manual/");
	echo($phpnet);
	echo("/ini.core.php#ini.post-max-size\" target=\"_blank\" class=\"ttip\" title=\"post_max_size\">");
	echo((int)ini_get("post_max_size"));
	echo("Mb</a> / \n\t\t\t\t\t\t\t<a href=\"http://php.net/manual/");
	echo($phpnet);
	echo("/ini.core.php#ini.memory-limit\" target=\"_blank\" class=\"ttip\" title=\"memory_limit\">");
	echo((int)ini_get("memory_limit"));
	echo("Mb</a>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div style=\"display:none;\" id=\"updiv\"><input type=\"file\" name=\"getfile\" id=\"getfile\" accept=\".csv, .txt, .xls, .xlsx, .zip, .rar\"></div>\n\t\t\t\t\t<script> \$(\"#getfile\").change(function(){ \$(\"#editform\").submit(); }); </script>\n\t\t\t\t</td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("File_name"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"FILE_NAME\" value=\"");
	echo($_POST["FILE_NAME"]);
	echo("\" maxlength=\"32\" style=\"width:280px;\" /> <span class=\"tiptext\">");
	echo(Tip("If_price_in_format_zip"));
	echo("</span>\n\t\t\t\t</td></tr>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Archive_password"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"FILE_PASSW\" value=\"");
	echo($_POST["FILE_PASSW"]);
	echo("\" maxlength=\"32\" style=\"width:280px;\" /> <span class=\"tiptext\">");
	echo(Tip("If_price_in_format_zip"));
	echo("</span>\n\t\t\t\t</td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Start_from_line"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"START_FROM\" value=\"");
	echo($_POST["START_FROM"]);
	echo("\" maxlength=\"12\" style=\"width:80px;\" /> ");
	echo(Lng("to_the"));
	echo(" \n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"STOP_BEFORE\" value=\"");
	echo($_POST["STOP_BEFORE"]);
	echo("\" maxlength=\"12\" style=\"width:80px;\" />\n\t\t\t\t\t<span class=\"tiptext\">");
	echo(Tip("If_price_includes_headings"));
	echo("</span>\n\t\t\t\t</td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Delete_old_prices"));
	echo(": </td>\n\t\t\t\t<td class=\"ftext\"><input type=\"checkbox\" name=\"DELETE_ON_START\" value=\"1\" ");
	if ($_POST["DELETE_ON_START"] == 1) {
		echo(" checked ");
	}
	echo(" > <span class=\"tiptext\">");
	echo(Tip("Before_import_start_delete"));
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Separator_brand_article"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"ARTBRA_SEP\" value=\"");
	echo($_POST["ARTBRA_SEP"]);
	echo("\" maxlength=\"3\" style=\"width:70px;\" /> <span class=\"tiptext\">");
	echo(Tip("If_brand_&_article_located"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Article_is_located"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"ARTBRA_SIDE\" style=\"width:150px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK(array(1 => Lng("SLeft", 1, 0), 2 => Lng("SRight", 1, 0)), $_POST["ARTBRA_SIDE"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Tip("Columns_relations"));
	echo(" CSV:");
	if (2 < count($arCols)) {
		echo("<br><br><a href=\"run.php?ID=");
		echo($CID);
		echo("&TEST=Y\" target=\"_blank\" class=\"imtest\"><b>TEST it</b>");
	}
	echo("\t\t\t\t</td>\n\t\t\t\t<td class=\"fvalues\" >\n\t\t\t\t\t<div id=\"cols\">\n\t\t\t\t\t\t");
	if (0 < count($arCols)) {
		$Wn = 1;
		foreach ($arCols as $arCol) {
			echo("\t\t\t\t\t\t\t\t<select name=\"NUM[");
			echo($arCol["ID"]);
			echo("]\" style=\"width:76px;\">\n\t\t\t\t\t\t\t\t\t");
			FShowSelectOptions($arNums, $arCol["NUM"]);
			echo("\t\t\t\t\t\t\t\t</select><span style=\"font-family:Arial; font-size:22px; color:#6B6B6B;\">&#8680;</span><select name=\"FIELD[");
			echo($arCol["ID"]);
			echo("]\" style=\"width:240px;\">\n\t\t\t\t\t\t\t\t\t");
			FShowSelectOptionsK($arFields, $arCol["FIELD"]);
			echo("\t\t\t\t\t\t\t\t</select> \n\t\t\t\t\t\t\t\t<div onclick=\"");
			jsDelConfirm("DELCOL" . $arCol["ID"], Lng("Really_delete_record", 0, 0) . ": " . $arFields[$arCol["FIELD"]]);
			echo("\" class=\"trashbut\" style=\"display:inline-block; margin-left:5px;\"></div>\n\t\t\t\t\t\t\t\t<div class=\"tclear\"></div>\n\t\t\t\t\t\t\t");
		}
	}
	else {
		$Wn = 4;
	}
	echo("\t\t\t\t\t\t<select name=\"NEW_NUM[]\" style=\"width:76px;\" id=\"newnum\">\n\t\t\t\t\t\t\t");
	FShowSelectOptions($arNums, "");
	echo("\t\t\t\t\t\t</select><span style=\"font-family:Arial; font-size:22px; color:#6B6B6B;\" id=\"newarr\">&#8680;</span><select name=\"NEW_FIELD[]\" style=\"width:240px;\" id=\"newfield\">\n\t\t\t\t\t\t\t");
	FShowSelectOptionsK($arFields, "");
	echo("\t\t\t\t\t\t</select>\n\t\t\t\t\t\t<div class=\"tclear\" id=\"newln\"></div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<input type=\"button\" class=\"styler\" name=\"addcolumn\" id=\"AddCol\" value=\"");
	echo(Lng("Add_new", 1, 0));
	echo("\" style=\"margin-top:10px;\"/> \n\t\t\t\t\t<script>\$(function(){\n\t\t\t\t\t\t\$('#AddCol').click(function(){\n\t\t\t\t\t\t\t\$('select#newnum').clone().attr('id','').appendTo('#cols').styler();\n\t\t\t\t\t\t\t\$('#newarr').clone().appendTo('#cols');\n\t\t\t\t\t\t\t\$('select#newfield').clone().attr('id','').appendTo('#cols').styler();\n\t\t\t\t\t\t\t\$('#newln').clone().appendTo('#cols');\n\t\t\t\t\t\t\treturn false;\n\t\t\t\t\t\t});\n\t\t\t\t\t});</script>\n\t\t\t\t\t<span class=\"tiptext\" style=\"color:#A33702;\">");
	echo(Tip("Required_three_columns"));
	echo("</span>\n\t\t\t\t</tr>\n\t\t\t\t\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Add_price_extra"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PRICE_EXTRA\" value=\"");
	echo($_POST["PRICE_EXTRA"]);
	echo("\" maxlength=\"6\" style=\"width:45px;\" />% <span class=\"tiptext\">(+/-)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Hot_prices_without_discount"));
	echo(": </td>\n\t\t\t\t<td class=\"ftext\"><input type=\"checkbox\" name=\"CONSIDER_HOT\" value=\"1\" ");
	if ($_POST["CONSIDER_HOT"] == 1) {
		echo(" checked ");
	}
	echo(" > <span class=\"tiptext\">");
	echo(Tip("If_price_includes_option_hot"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Add_to_price"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"PRICE_ADD\" value=\"");
	echo($_POST["PRICE_ADD"]);
	echo("\" maxlength=\"12\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Tip("Add_fixed_amount"));
	echo(" (+/-)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Price_type"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"PRICE_TYPE\" style=\"width:200px;\">\n\t\t\t\t\t\t");
	FShowSelectOptionsK($TDMCore->arPriceType, $_POST["PRICE_TYPE"]);
	echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Add_days"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DAY_ADD\" value=\"");
	echo($_POST["DAY_ADD"]);
	echo("\" maxlength=\"2\" style=\"width:50px;\" /> <span class=\"tiptext\">");
	echo(Tip("Add_days_webservices"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
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
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t<tr><td class=\"fname\">");
	echo(Lng("Currency"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"DEF_CURRENCY\" style=\"width:100px;\">\n\t\t\t\t\t\t");
	FShowSelectOptions($arCurs, $_POST["DEF_CURRENCY"]);
	echo("\t\t\t\t\t</select> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Brand"));
	echo(" (");
	echo(Lng("Manufacturer"));
	echo("): </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DEF_BRAND\" value=\"");
	echo($_POST["DEF_BRAND"]);
	echo("\" maxlength=\"32\" style=\"width:200px;\" /> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Stock"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DEF_STOCK\" value=\"");
	echo($_POST["DEF_STOCK"]);
	echo("\" maxlength=\"32\" style=\"width:100px;\" /> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
	echo(Lng("Availability"));
	echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"DEF_AVAILABLE\" value=\"");
	echo($_POST["DEF_AVAILABLE"]);
	echo("\" maxlength=\"4\" style=\"width:40px;\" /> <span class=\"tiptext\">");
	echo(Tip("As_default"));
	echo("</span></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t\n\t\t\t\t<td class=\"fname\"></td>\n\t\t\t\t<td class=\"fvalues\"><div class=\"bt-save\" onclick=\"\$('#editform').submit();\">");
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
	echo("\t\t\t<iframe src=\"http://tecdoc-module.com/docs/import_");
	echo($DesLng);
	echo(".html\" frameborder=\"0\" width=\"100%\" height=\"770\" hspace=\"0\" marginheight=\"0\" vspace=\"0\" align=\"left\"></iframe>\n\t\t");
}
echo("\t</table>\n</div>");

