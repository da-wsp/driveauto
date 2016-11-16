<?php
    define("TDM_PROLOG_INCLUDED", true);
	define("TDM_ADMIN_SIDE", true);
	require_once("../../tdmcore/init.php");
	if ($_SESSION["TDM_ISADMIN"] != "Y") {
		header("Location: /" . TDM_ROOT_DIR . "/admin/");
		exit();
	}

	
set_time_limit(3600);

ini_set("memory_limit", "512M");
$arNums[0] = "";
$i = 1;
while ($i < 16) {
	$arNums[] = $i;
	++$i;
}
$arSFields = array("" => "", "BKEY1" => Lng("Brand", 1, 0) . " 1", "AKEY1" => Lng("Article", 1, 0) . " 1", "BKEY2" => Lng("Brand", 1, 0) . " 2", "AKEY2" => Lng("Article", 1, 0) . " 2");
$arKinksSide = array(0 => Lng("WS_link_both", 1, 0), 1 => Lng("WS_link_right", 1, 0), 2 => Lng("WS_link_left", 1, 0));
echo("<head><title>TDMod :: ");
echo(Tip("Import_analogs_records"));
echo("</title></head>\n<div class=\"apanel_cont\">");
require_once(TDM_PATH . "/admin/apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t");
jsLinkJqueryUi();
echo("\t");
jsLinkFormStyler();
echo("\t<script>\n\t\tAddFSlyler('input, checkbox, radio, select, button');\n\t\t\$(document).ready(function(){\n\t\t\t\$('.ttip').tooltip({ track:true, content:function(){return \$(this).prop('title');} });\n\t\t});\n\t</script>\n\t<h1>");
echo(Tip("Import_analogs_records"));
echo("</h1><div class=\"tclear\"></div>\n\t<hr>\n\t");
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
	else {
		if (strlen($_POST["COLUMN_SEP"]) < 1) {
			$_POST["COLUMN_SEP"] = ";";
		}
		if (strlen($_POST["CODE"]) < 3) {
			ErAdd(Lng("A_required_field") . " - " . Lng("Code"), 1);
		}
		if (strlen($_POST["FILE_PATH"]) < 5) {
			ErAdd(Lng("A_required_field") . " - " . Lng("File_path"), 1);
		}
		$_POST["START_FROM"] = intval($_POST["START_FROM"]);
		$_POST["STOP_BEFORE"] = intval($_POST["STOP_BEFORE"]);
		$arFtoN = array();
		if (isset($_POST["NUM"]) && 0 < count($_POST["NUM"]) && isset($_POST["FIELD"]) && 0 < count($_POST["FIELD"])) {
			$_POST["NUM"] = array_unique($_POST["NUM"], SORT_REGULAR);
			$_POST["FIELD"] = array_unique($_POST["FIELD"], SORT_REGULAR);
			foreach ($_POST["NUM"] as $Key => $NUM) {
				if (!(0 < $NUM && $_POST["FIELD"][$Key] != "")) {
					continue;
				}
				$arFtoN[$_POST["FIELD"][$Key]] = $NUM - 1;
			}
		}
		if (count($arFtoN) < 4) {
			ErAdd(Lng("A_required_field") . " - " . Tip("Columns_relations"), 1);
		}
		if (ErCheck()) {
			$arFPURL = parse_url($_POST["FILE_PATH"]);
			$FPExt = TDMStrToLow(pathinfo($arFPURL["path"], PATHINFO_EXTENSION));
			if (substr($_POST["FILE_PATH"], 0, 1) == "/") {
				$_POST["FILE_PATH"] = $_SERVER["DOCUMENT_ROOT"] . $_POST["FILE_PATH"];
			}
			$_POST["FILE_PATH"] = str_replace("//", "/", $_POST["FILE_PATH"]);
			if (file_exists($_POST["FILE_PATH"])) {
				echo("<div class=\"imlog\"><br>File " . $_POST["FILE_PATH"] . " <b>exist on local</b> server</div>");
			}
			else {
				ErAdd("File not exist on local server <b>" . $_POST["FILE_PATH"] . "</b>", 2);
			}
			if ($FPExt == "csv" || $FPExt == "txt") {
				echo("<div class=\"imlog\">" . $_POST["FILE_PATH"] . " file size <b>" . round(filesize($_POST["FILE_PATH"]) / 1024 / 1024, 2) . " Mb</b></div>");
			}
			else {
				ErAdd("Unsupported file extension <b>" . $FPExt . "</b>", 2);
			}
		}
		if (ErCheck()) {
			if ($_POST["STOP_BEFORE"] < $_POST["START_FROM"]) {
				$_POST["START_FROM"] = $_POST["STOP_BEFORE"];
			}
			if ($_POST["STOP_BEFORE"] < $_POST["START_FROM"]) {
				$_POST["STOP_BEFORE"] = $_POST["START_FROM"];
			}
			if ($arCFile = file($_POST["FILE_PATH"])) {
				$CSVcount = count($arCFile);
				if ($_POST["START_FROM"] < 2) {
					$_POST["START_FROM"] = 0;
				}
				else {
					--$_POST["START_FROM"];
				}
				if ($_POST["START_FROM"] < $CSVcount) {
					if ($CSVcount < $_POST["STOP_BEFORE"] || $_POST["STOP_BEFORE"] == 0) {
						$_POST["STOP_BEFORE"] = $CSVcount;
					}
					echo("<div class=\"imlog\"><b>" . $CSVcount . "</b> records in CSV file " . $_POST["FILE_PATH"] . "</div>");
					$arInsDupl = array("PKEY1", "BKEY1", "AKEY1", "PKEY2", "BKEY2", "AKEY2", "SIDE", "CODE");
					foreach ($arCFile as $Line => $strLine) {
						if ($START <= 0 && $Line < $_POST["START_FROM"]) {
							continue;
						}
						if (0 < $START && $Line <= $START) {
							continue;
						}
						if ($_POST["STOP_BEFORE"] < $Line) {
							$SUCCESS = "Y";
							break;
						}
						if ($_GET["TEST"] != "Y") {
							++$LnNum;
						}
						define("TDM_ISEP", $_POST["COLUMN_SEP"]);
						$arCSVrow = explode(TDM_ISEP, $strLine);
						$arFields = array();
						foreach ($arFtoN as $FIELD => $NUM) {
							$VALUE = str_replace("\"", "", trim($arCSVrow[$NUM]));
							$VALUE = str_replace("'", "", $VALUE);
							$arFields[$FIELD] = $VALUE;
						}
						if ($_POST["ENCODE"] != "UTF-8") {
							if ($arFields["BKEY1"] != "") {
								$arFields["BKEY1"] = iconv($_POST["ENCODE"], "UTF-8//TRANSLIT", $arFields["BKEY1"]);
							}
							if ($arFields["AKEY1"] != "") {
								$arFields["AKEY1"] = iconv($_POST["ENCODE"], "UTF-8//TRANSLIT", $arFields["AKEY1"]);
							}
							if ($arFields["BKEY2"] != "") {
								$arFields["BKEY2"] = iconv($_POST["ENCODE"], "UTF-8//TRANSLIT", $arFields["BKEY2"]);
							}
							if ($arFields["AKEY2"] != "") {
								$arFields["AKEY2"] = iconv($_POST["ENCODE"], "UTF-8//TRANSLIT", $arFields["AKEY2"]);
							}
						}
						$arFields["BKEY1"] = TDMSingleKey($arFields["BKEY1"], true);
						$arFields["AKEY1"] = TDMSingleKey($arFields["AKEY1"]);
						$arFields["PKEY1"] = $arFields["BKEY1"] . $arFields["AKEY1"];
						$arFields["BKEY2"] = TDMSingleKey($arFields["BKEY2"], true);
						$arFields["AKEY2"] = TDMSingleKey($arFields["AKEY2"]);
						$arFields["PKEY2"] = $arFields["BKEY2"] . $arFields["AKEY2"];
						$arFields["SIDE"] = intval($_POST["LINKS_SIDE"]);
						$arFields["CODE"] = $_POST["CODE"];
						if ($arFields["BKEY1"] == "") {
							++$arStat["Ignored BRAND 1"];
							++$IGNORED;
							continue;
						}
						if ($arFields["AKEY1"] == "") {
							++$arStat["Ignored ARTICLE 1"];
							++$IGNORED;
							continue;
						}
						if ($arFields["BKEY2"] == "") {
							++$arStat["Ignored BRAND 2"];
							++$IGNORED;
							continue;
						}
						if ($arFields["AKEY2"] == "") {
							++$arStat["Ignored ARTICLE 2"];
							++$IGNORED;
							continue;
						}
						$arUKeys = array();
						$arUValue = array();
						$arUDuplc = array();
						foreach ($arFields as $key => $value) {
							$arUKeys[] = $key;
							$arUValue[] = "'" . mysql_real_escape_string($value) . "'";
						}
						$qKeys = implode(",", $arUKeys);
						$qValues = implode(",", $arUValue);
						foreach ($arInsDupl as $DKey) {
							$arUDuplc[] = $DKey . "='" . mysql_real_escape_string($arFields[$DKey]) . "'";
						}
						$qDuplc = implode(",", $arUDuplc);
						$SQL = "INSERT INTO TDM_LINKS \n(" . $qKeys . ") \nVALUES \n(" . $qValues . ") \nON DUPLICATE KEY UPDATE \n" . $qDuplc;
						$arFields["N"] = $Line;
						if ($_POST["TEST"] != "Y") {
							mysql_query($SQL);
							if (mysql_error() != "") {
								echo("<div class=\"imlog\"><pre>" . $SQL . "</pre></div>");
								ErAdd("MySQL Error: " . mysql_error());
								break;
							}
							if (count($arViewFs) < 20) {
								$arViewFs[] = $arFields;
							}
						}
						else {
							$arViewFs[] = $arFields;
							if (50 < $Line) {
								break;
							}
						}
						++$INSERTED;
					}
					if ($_POST["TEST"] != "Y") {
						echo("<div class=\"imlog\">Import finish. <b>" . intval($INSERTED) . "</b> records inserted/updated</div>");
						echo("<div class=\"imlog\">Ignored rows cont = <b>" . intval($IGNORED) . "</b><br><br></div>");
					}
					else {
						echo("<div class=\"imlog\"><b>Test parsing completed</b><br><br></div>");
					}
				}
				else {
					ErAdd("CSV file: active lines count - <b>0</b>", 2);
				}
			}
			else {
				ErAdd("Function false <b>file('" . $_POST["FILE_PATH"] . "')</b> ", 2);
			}
		}
	}
	if (0 < count($arViewFs)) {
		$arColumns = array("BKEY1" => array("VALUE" => $arSFields["BKEY1"]), "AKEY1" => array("VALUE" => $arSFields["AKEY1"]), "SIDE" => array("VALUE" => "", "TITLE" => Lng("Crosses_direction", 1, 0)), "BKEY2" => array("VALUE" => $arSFields["BKEY2"]), "AKEY2" => array("VALUE" => $arSFields["AKEY2"]), "CODE" => array("VALUE" => Lng("Code", 1, 0)));
		echo("\t\t\t<br>\n\t\t\t<b>Sample parsing result:</b><br>\n\t\t\t<br>\n\t\t\t<table class=\"etab\"><tr class=\"head\">\n\t\t\t<td class=\"ttip\" title=\"Position\">#</td>\n\t\t\t");
		foreach ($arColumns as $Code => $arValues) {
			echo("\t\t\t\t<td class=\"ttip\" title=\"");
			echo($arValues["TITLE"]);
			echo("\">");
			echo($arValues["VALUE"]);
			echo("</td>\n\t\t\t");
		}
		echo("</tr>\n\t\t\t");
		foreach ($arViewFs as $arVF) {
			if ($arVF["SIDE"] == 1) {
				$Side = "WS_link_right";
			}
			else {
				if ($arVF["SIDE"] == 2) {
					$Side = "WS_link_left";
				}
				else {
					$Side = "WS_link_both";
				}
			}
			echo("\t\t\t\t<tr class=\"rows\">\n\t\t\t\t<td>");
			echo($arVF["N"] + 1);
			echo("</td>\n\t\t\t\t<td>");
			echo($arVF["BKEY1"]);
			echo("</td>\n\t\t\t\t<td>");
			echo($arVF["AKEY1"]);
			echo("</td>\n\t\t\t\t<td><img src=\"../images/sarr");
			echo($arVF["SIDE"]);
			echo(".png\" width=\"16\" height=\"16\" class=\"ttip\" title=\"");
			echo(Lng($Side, 1, 0));
			echo("\"/></td>\n\t\t\t\t<td>");
			echo($arVF["BKEY2"]);
			echo("</td>\n\t\t\t\t<td>");
			echo($arVF["AKEY2"]);
			echo("</td>\n\t\t\t\t<td>");
			echo($arVF["CODE"]);
			echo("</td>\n\t\t\t\t</tr>\n\t\t\t");
		}
		echo("\t\t\t</table>\n\t\t\t<hr><br><br>");
	}
}
else {
	$_POST["CODE"] = "main";
}
echo("\t");
ErShow();
echo("\t\t<form action=\"\" id=\"editform\" method=\"post\" enctype=\"multipart/form-data\">\n\t\t\t<input type=\"hidden\" name=\"edit\" value=\"Y\"/>\n\t\t\t<input type=\"hidden\" name=\"TEST\" id=\"test\" value=\"\"/>\n\t\t\t<table class=\"formtab\">\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">*");
echo(Lng("Code"));
echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"CODE\" id=\"codefield\" value=\"");
echo($_POST["CODE"]);
echo("\" onkeyup=\"this.value=this.value.replace(/[^a-zA-Z0-9]/g,'');\" maxlength=\"32\" style=\"width:100px;\" /> <span class=\"tiptext\">");
echo(Lng("Any_name"));
echo(" (Eng.)</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">*");
echo(Lng("Column_separator"));
echo(": </td>\n\t\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"COLUMN_SEP\" value=\"");
echo($_POST["COLUMN_SEP"]);
echo("\" maxlength=\"3\" style=\"width:70px;\" />  <span class=\"tiptext\">");
echo(Tip("Default_in_CSV"));
echo("</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
echo(Lng("Encode"));
echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"ENCODE\" style=\"width:150px;\">\n\t\t\t\t\t\t");
FShowSelectOptions(array("CP1251", "UTF-8"), $_POST["ENCODE"]);
echo("\t\t\t\t\t</select> <span class=\"tiptext\">of CSV file</span></td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">*");
echo(Lng("File_path"));
echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" id=\"filepath\" name=\"FILE_PATH\" value=\"");
echo($_POST["FILE_PATH"]);
echo("\" maxlength=\"256\" style=\"width:480px; margin-bottom:8px;\" /> \n\t\t\t\t\t<a href=\"javascript:void(0)\" class=\"flmang ttip\" OnClick=\"\$('#ftree').toggle('normal');\" title=\"File manager\"></a> \n\t\t\t\t\t<a href=\"javascript:void(0)\" class=\"tdmhelp ttip\" OnClick=\"\$('#fphelp').toggle('normal');\" title=\"");
echo(Lng("Help", 1, 0));
echo("\"></a>\n\t\t\t\t\t<div style=\"padding:0px 20px 0px 20px; display:none;\" id=\"fphelp\">\n\t\t\t\t\t\t<strong class=\"tiptext\">CSV, TXT</strong><br><br>\n\t\t\t\t\t\t<span class=\"tiptext\">");
echo(Tip("Descr_IMA_file_path"));
echo("</span>\n\t\t\t\t\t</div><br>\n\t\t\t\t\t<script src=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/images/jqft/jft.js\" type=\"text/javascript\"></script>\n\t\t\t\t\t<link href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/images/jqft/jft.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n\t\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\t\$(document).ready( function() {\n\t\t\t\t\t\t\t\$('#ftree').fileTree({ root: '/', script: '/");
echo(TDM_ROOT_DIR);
echo("/admin/images/jqft/ft-analogs.php', folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, multiFolder: false }, function(file) { \n\t\t\t\t\t\t\t\t\$('#filepath').val(file);\n\t\t\t\t\t\t\t\t\$('#ftree').toggle('normal');\n\t\t\t\t\t\t\t});\n\t\t\t\t\t\t});\n\t\t\t\t\t</script>\n\t\t\t\t\t<div id=\"ftree\" class=\"ft-box\" style=\"display:none; width:480px;\"></div>\n\t\t\t\t\t\n\t\t\t\t\t<a href=\"javascript:void(0)\" style=\"font-family:arial;\" OnClick=\"\$('#uplink').toggle(); \$('#updiv').toggle(); \$('#tiplimit').toggle(); \$('#getfile').click(); \" id=\"uplink\">&#9658; ");
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
echo("Mb</a>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div style=\"display:none;\" id=\"updiv\"><input type=\"file\" name=\"getfile\" id=\"getfile\" accept=\".csv, .txt\"></div>\n\t\t\t\t\t<script> \$(\"#getfile\").change(function(){ \$(\"#editform\").submit(); }); </script>\n\t\t\t\t</td>\n\t\t\t\t</tr><tr>\n\t\t\t\t<td class=\"fname\">");
echo(Lng("Start_from_line"));
echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"START_FROM\" value=\"");
echo($_POST["START_FROM"]);
echo("\" maxlength=\"12\" style=\"width:80px;\" /> ");
echo(Lng("to_the"));
echo(" \n\t\t\t\t\t<input class=\"styler\" type=\"text\" name=\"STOP_BEFORE\" value=\"");
echo($_POST["STOP_BEFORE"]);
echo("\" maxlength=\"12\" style=\"width:80px;\" />\n\t\t\t\t\t<span class=\"tiptext\">");
echo(Tip("If_price_includes_headings"));
echo("</span>\n\t\t\t\t</td>\n\t\t\t\t</tr>\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
echo(Lng("Crosses_direction"));
echo(": </td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<select name=\"LINKS_SIDE\" style=\"width:150px;\">\n\t\t\t\t\t\t");
FShowSelectOptionsK($arKinksSide, $_POST["LINKS_SIDE"]);
echo("\t\t\t\t\t</select></td>\n\t\t\t\t</tr>\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t\n\t\t\t\t<tr>\n\t\t\t\t<td class=\"fname\">");
echo(Tip("Columns_relations"));
echo(" CSV:</td>\n\t\t\t\t<td class=\"fvalues\" >\n\t\t\t\t\t");
if (0 < count($_POST["NUM"])) {
	foreach ($_POST["NUM"] as $Key => $NUM) {
		echo("\t\t\t\t\t\t\t\t<select name=\"NUM[");
		echo($Key);
		echo("]\" style=\"width:76px;\">\n\t\t\t\t\t\t\t\t\t");
		FShowSelectOptions($arNums, $NUM);
		echo("\t\t\t\t\t\t\t\t</select><span style=\"font-family:Arial; font-size:22px; color:#6B6B6B;\">&#8680;</span><select name=\"FIELD[");
		echo($Key);
		echo("]\" style=\"width:240px;\">\n\t\t\t\t\t\t\t\t\t");
		FShowSelectOptionsK($arSFields, $_POST["FIELD"][$Key]);
		echo("\t\t\t\t\t\t\t\t</select> \n\t\t\t\t\t\t\t\t<div class=\"tclear\"></div>\n\t\t\t\t\t\t");
	}
}
echo("\t\t\t\t\t<div id=\"cols\">\n\t\t\t\t\t\t<select name=\"NUM[]\" style=\"width:76px;\" id=\"newnum\">\n\t\t\t\t\t\t\t");
FShowSelectOptions($arNums, "");
echo("\t\t\t\t\t\t</select><span style=\"font-family:Arial; font-size:22px; color:#6B6B6B;\" id=\"newarr\">&#8680;</span><select name=\"FIELD[]\" style=\"width:240px;\" id=\"newfield\">\n\t\t\t\t\t\t\t");
FShowSelectOptionsK($arSFields, "");
echo("\t\t\t\t\t\t</select>\n\t\t\t\t\t\t<div class=\"tclear\" id=\"newln\"></div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<input type=\"button\" class=\"styler\" name=\"addcolumn\" id=\"AddCol\" value=\"");
echo(Lng("Add_new", 1, 0));
echo("\" style=\"margin-top:10px;\"/> \n\t\t\t\t\t<script>\$(function(){\n\t\t\t\t\t\t\$('#AddCol').click(function(){\n\t\t\t\t\t\t\t\$('select#newnum').clone().attr('id','').appendTo('#cols').styler();\n\t\t\t\t\t\t\t\$('#newarr').clone().appendTo('#cols');\n\t\t\t\t\t\t\t\$('select#newfield').clone().attr('id','').appendTo('#cols').styler();\n\t\t\t\t\t\t\t\$('#newln').clone().appendTo('#cols');\n\t\t\t\t\t\t\treturn false;\n\t\t\t\t\t\t});\n\t\t\t\t\t});</script>\n\t\t\t\t</tr>\n\t\t\t\t\n\t\t\t\t<tr><td colspan=\"2\"><hr></td></tr>\n\t\t\t\t\n\t\t\t\t<td class=\"fname\"></td>\n\t\t\t\t<td class=\"fvalues\">\n\t\t\t\t\t<table width=\"100%\"><tr><td width=\"99%\">\n\t\t\t\t\t\t<div class=\"bt-save\" onclick=\"\$('#test').val('Y'); \$('#editform').submit();\">Test it</div>\n\t\t\t\t\t</td><td width=\"1%\">\n\t\t\t\t\t\t<div class=\"bt-download\" onclick=\"\$('#editform').submit();\">Start import</div>\n\t\t\t\t\t</table>\n\t\t\t\t</td></tr>\n\t\t\t</table>\n\t\t\t<div class=\"tclear\"></div>\n\t\t</form>\n\t\n\t\n\t\n\t\t\n</div>\n");

