<?php

define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}
if ($_GET["l"] != "" && in_array($_GET["l"], $TDMCore->arLangs)) {
	$_SESSION["TDM_LANGEDIT_CODE"] = $_GET["l"];
	$_SESSION["TDM_LANGEDIT_TYPE"] = 0;
}
if ($_POST["swlang"] == "Y") {
	if ($_POST["elang"] != "") {
		$_SESSION["TDM_LANGEDIT_CODE"] = $_POST["elang"];
	}
	if ($_POST["etype"] != "") {
		$_SESSION["TDM_LANGEDIT_TYPE"] = $_POST["etype"];
	}
}
if ($_SESSION["TDM_LANGEDIT_CODE"] == "") {
	$_SESSION["TDM_LANGEDIT_CODE"] = TDM_LANG;
}
if ($_SESSION["TDM_LANGEDIT_TYPE"] == "") {
	$_SESSION["TDM_LANGEDIT_TYPE"] = 0;
}
$CLng = $_SESSION["TDM_LANGEDIT_CODE"];
$CType = $_SESSION["TDM_LANGEDIT_TYPE"];
$FLet = "A";
$resDB = new TDMQuery();
if ($_SESSION["TDM_LANGEDIT_FLAT"] == "") {
	$_SESSION["TDM_LANGEDIT_FLAT"] = "cd_value";
}
if ($_POST["FLET_FIELD"] != "") {
	$_SESSION["TDM_LANGEDIT_FLAT"] = $_POST["FLET_FIELD"];
}
if ($_POST["addnew"] == "Y") {
	$FLet = TDMStrToUp(substr($_POST[$_SESSION["TDM_LANGEDIT_FLAT"]], 0, 1));
	if (trim($_POST["cd_value"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Symbolic_code"), 1);
	}
	if (trim($_POST["en_VALUE"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Language") . " En", 1);
	}
	if (trim($_POST["ln_VALUE"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Language") . " " . UWord($CLng), 1);
	}
	if (ErCheck()) {
		$NewCode = str_replace(" ", "_", trim($_POST["cd_value"]));
		$resDB->Select("TDM_LANGS", array(), array("LANG" => "en", "CODE" => $NewCode));
		if ($arRes = $resDB->Fetch()) {
			ErAdd(Lng("Symbolic_code") . " \"" . $NewCode . "\" " . Lng("is_already_exist", 2), 1);
		}
		if (ErCheck()) {
			$resDB->MultiInsert("TDM_LANGS", array(array("LANG" => "en", "CODE" => $NewCode, "VALUE" => $_POST["en_VALUE"], "TYPE" => $CType), array("LANG" => $CLng, "CODE" => $NewCode, "VALUE" => $_POST["ln_VALUE"], "TYPE" => $CType)));
			if (ErCheck()) {
				NtAdd(Lng("Record_added"));
				$_POST["addnew"] = "N";
				$_POST["cd_value"] = "";
				$_POST["en_VALUE"] = "";
				$_POST["ln_VALUE"] = "";
			}
		}
	}
}
if ($_POST["editlang"] == "Y") {
	$FLet = TDMStrToUp(substr($_POST[$_SESSION["TDM_LANGEDIT_FLAT"]], 0, 1));
	if (trim($_POST["cd_value"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Symbolic_code"), 1);
	}
	if (trim($_POST["en_value"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Language") . " En", 1);
	}
	if (trim($_POST["ln_value"]) == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Language") . " " . UWord($CLng), 1);
	}
	if (ErCheck()) {
		$resDB->Update("TDM_LANGS", array("LANG" => "en", "CODE" => $_POST["cd_value"], "VALUE" => $_POST["en_value"], "TYPE" => $CType), array(), array("VALUE"));
		$resDB->Update("TDM_LANGS", array("LANG" => $CLng, "CODE" => $_POST["cd_value"], "VALUE" => $_POST["ln_value"], "TYPE" => $CType), array(), array("VALUE"));
	}
}
if ($_POST["delete"] == "Y" && $_POST["delem"] != "") {
	$DResCnt = $resDB->Delete("TDM_LANGS", array("CODE" => $_POST["delem"], "SYSTEM" => 0));
	if (0 < $DResCnt) {
		NtAdd(Lng("Records_deleted") . ": " . $DResCnt);
		$_POST["delete"] = "N";
		$_POST["delem"] = "";
	}
}
if ($_GET["action"] == "setallsystem") {
	$resDB->Update2("TDM_LANGS", array("SYSTEM" => 1), array(), true);
	NtAdd("All records are set as SYSTEM");
}
$arLangs = array();
$resDB->Select("TDM_LANGS", array("CODE" => "ASC"), array("LANG" => array("en", $CLng), "TYPE" => $CType));
while ($arRes = $resDB->Fetch()) {
	$arLangs[$arRes["CODE"]][$arRes["LANG"]] = array("VALUE" => $arRes["VALUE"], "SYSTEM" => $arRes["SYSTEM"]);
}
echo("<head><title>TDM :: ");
echo(Lng("Localization", 0, false));
echo("</title></head>\n<div class=\"apanel_cont\">");
require_once("apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t");
jsLinkJqueryUi();
echo("\t");
jsLinkFormStyler();
echo("\t<script>AddFSlyler('input, checkbox, radio, select');</script>\n\t\n\t<script>\n\t\tAddTips(true);\n\t\tvar IsEditActive=false;\n\t\t\$(document).ready(function(){\n\t\t\t\n\t\t\t\$(\"#elang\").on(\"change\", function(){ SendSwForm() });\n\t\t\t\$(\"#etype\").on(\"change\", function(){ SendSwForm() });\n\t\t\n\t\t\t\$('.EditBtn').on('click', function() {\n\t\t\t\tif(!IsEditActive){\n\t\t\t\t\tIsEditActive=true;\n\t\t\t\t\tvar BtTD = \$(this).closest('td');\n\t\t\t\t\tvar LnTD = \$(this).closest('td').prev('td');\n\t\t\t\t\tvar EnTD = LnTD.closest('td').prev('td');\n\t\t\t\t\tvar Code = EnTD.closest('td').prev('td').text();\n\t\t\t\t\tvar HidCode = '<input type=\"hidden\" name=\"cd_value\" value=\"'+Code+'\"/>';\n\t\t\t\t\t\$(EnTD).html('<textarea name=\"en_value\" style=\"width:420px; height:180px\" maxlenght=\"512\">'+EnTD.text()+'</textarea>'+HidCode);\n\t\t\t\t\tvar LnValue = LnTD.text(); \n\t\t\t\t\tif(LnValue=='Empty'){LnValue='';}\n\t\t\t\t\t\$(LnTD).html('<textarea name=\"ln_value\" style=\"width:420px; height:180px\" maxlenght=\"512\">'+LnValue+'</textarea>');\n\t\t\t\t\t\$(BtTD).html('<a href=\"javascript:void(0)\" class=\"SaveBtn\" onclick=\"\$(\\'#langsform\\').attr(\\'action\\', \\'#'+Code+'\\').submit();\"></a>');\n\t\t\t\t\treturn false;\n\t\t\t\t}\n\t\t\t});\n\t\t\t\n\t\t});\n\t\tfunction SendSwForm(){\n\t\t\tif(!IsEditActive){\n\t\t\t\t\$(\"#elang_h\").val(\$(\"#elang option:selected\").text());\n\t\t\t\t\$(\"#etype_h\").val(\$(\"#etype option:selected\").val());\n\t\t\t\t\$(\"#swform\").submit();\n\t\t\t}\n\t\t}\n\t\tfunction ShowNewAddForm(){\n\t\t\t\$('#adddiv').show('slow'); \n\t\t\t\$('#topaddbut').hide();\n\t\t\t\$('.tdnote').hide(!\$('.tdnote').length);\n\t\t}\n\t</script>\n\t\n\t");
if ($_POST["addnew"] != "Y") {
	echo("\t\t<div class=\"flrig bluebut\" id=\"topaddbut\" onclick=\"ShowNewAddForm()\">");
	echo(Lng("Add_new", 0, 0));
	echo("</div>\n\t");
}
echo("\t<h1>");
echo(Lng("Localization"));
echo(": <span class=\"codetext\">");
echo(UWord($CLng));
echo("</span></h1>\n\t<div class=\"tclear\"></div>\n\t<hr>\n\t");
ErShow();
echo("\t\n\t<div id=\"adddiv\" ");
if ($_POST["addnew"] != "Y") {
	echo("style=\"display:none;\"");
}
echo(" >\n\t\t<form action=\"\" id=\"addform\" method=\"post\">\n\t\t<input type=\"hidden\" name=\"addnew\" value=\"Y\"/>\n\t\t<table class=\"formtab\"><tr>\n\t\t\t<td></td>\n\t\t\t<td class=\"tiptext\">");
echo(Lng("All_fields_are_required"));
echo(":</td></tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Symbolic_code"));
echo(": </td>\n\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"cd_value\" value=\"");
echo($_POST["cd_value"]);
echo("\" maxlength=\"32\" style=\"width:300px;\" /> </td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Language"));
echo(" <b>En</b>: </td>\n\t\t\t<td class=\"fvalues\"><textarea class=\"styler\" name=\"en_VALUE\" maxlength=\"512\" style=\"width:800px; height:80px; resize:vertical;\">");
echo($_POST["en_VALUE"]);
echo("</textarea></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Language"));
echo(" <b>");
echo(UWord($CLng));
echo("</b>: </td>\n\t\t\t<td class=\"fvalues\"><textarea class=\"styler\" name=\"ln_VALUE\" maxlength=\"512\" style=\"width:800px; height:80px; resize:vertical;\">");
echo($_POST["ln_VALUE"]);
echo("</textarea></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Group"));
echo(": </td><td class=\"ftext\">\n\t\t\t\t");
if ($CType == 0) {
	echo(Lng("Linguistic_phrases"));
}
else {
	if ($CType == 1) {
		echo(Lng("Descriptions_&_tips"));
	}
}
echo("\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\"></td>\n\t\t\t<td class=\"fvalues\"><div class=\"bluebut\" onclick=\"\$('#addform').submit();\">");
echo(Lng("Add_new", 0, 0));
echo("</div></td>\n\t\t</table>\n\t\t<div class=\"tclear\"></div>\n\t\t</form>\n\t\t<hr>\n\t</div>\n\t\n\t<form action=\"\" id=\"swform\" method=\"post\">\n\t\t<input type=\"hidden\" name=\"swlang\" value=\"Y\"/>\n\t\t<input type=\"hidden\" name=\"elang\" id=\"elang_h\" value=\"\"/>\n\t\t<input type=\"hidden\" name=\"etype\" id=\"etype_h\" value=\"\"/>\n\t</form>\n\t\n\t<form action=\"\" id=\"flform\" method=\"post\" style=\"float:left; margin:3px 10px 0px 0px;\">\n\t\t<select name=\"FLET_FIELD\" class=\"styled\" style=\"width:95px;\" onchange=\"\$('#flform').submit();\">\n\t\t\t");
$arFLET_FIELDS = array("cd_value" => "Code", "en_value" => "En", "ln_value" => UWord($CLng));
FShowSelectOptionsK($arFLET_FIELDS, $_SESSION["TDM_LANGEDIT_FLAT"]);
echo("\t\t</select> &#8594; \n\t</form>\n\t<div class=\"letfilter\"></div>\n\t\n\t<form action=\"\" id=\"langsform\" method=\"post\">\n\t<input type=\"hidden\" name=\"editlang\" value=\"Y\"/>\n\t<table class=\"etab\" width=\"100%\">\n\t\t<tr class=\"head\">\n\t\t\t<td>");
echo(Lng("Symbolic_code"));
echo(":</td>\n\t\t\t<td>");
echo(Lng("English_phrase"));
echo(":</td>\n\t\t\t<td style=\"padding:3px 0px 0px 10px;\">\n\t\t\t\t<select name=\"elang\" id=\"elang\" style=\"width:90px; padding-left:10px;\">\n\t\t\t\t");
foreach ($TDMCore->arLangs as $ID => $LCode) {
	if ($LCode == "en") {
		continue;
	}
	if ($LCode == $CLng) {
		$IsSel = "selected";
	}
	else {
		$IsSel = "";
	}
	echo("\t\n\t\t\t\t\t<option value=\"");
	echo($LCode);
	echo("\" ");
	echo($IsSel);
	echo(" >");
	echo($LCode);
	echo("</option>\n\t\t\t\t");
}
echo("\t\t\t\t</select> &#8594; \n\t\t\t\t<select name=\"etype\" id=\"etype\" style=\"width:180px; padding-left:10px;\">\n\t\t\t\t\t<option value=\"0\" >");
echo(Lng("Linguistic_phrases"));
echo("</option>\n\t\t\t\t\t<option value=\"1\" ");
if ($_SESSION["TDM_LANGEDIT_TYPE"] == 1) {
	echo("selected");
}
echo(" >");
echo(Lng("Descriptions_&_tips"));
echo("</option>\n\t\t\t\t</select>\n\t\t\t</td>\n\t\t\t<td></td>\n\t\t</tr>\n\t\t");
if (0 < count($arLangs)) {
	echo("\t\t\t");
	foreach ($arLangs as $Code => $arValues) {
		if ($arValues[$CLng]["VALUE"] == "") {
			$LngValue = "<span class=\"empty\">Empty</span>";
		}
		else {
			$LngValue = $arValues[$CLng]["VALUE"];
		}
		if ($arValues[$CLng]["SYSTEM"] == 1) {
			$CanDel = "N";
		}
		else {
			$CanDel = "Y";
		}
		echo("\t\t\t\t<tr class=\"rows\" id=\"");
		echo($Code);
		echo("\">\n\t\t\t\t\t<td width=\"21%\" class=\"cd_value\">");
		echo($Code);
		echo("</td>\n\t\t\t\t\t<td width=\"39%\" class=\"en_value\">");
		echo($arValues["en"]["VALUE"]);
		echo("</td>\n\t\t\t\t\t<td width=\"39%\" class=\"ln_value\">");
		echo($LngValue);
		echo("</td>\n\t\t\t\t\t<td width=\"1%\" class=\"nowrp\">\n\t\t\t\t\t\t<a href=\"javascript:void(0)\" class=\"EditBtn\"></a>\n\t\t\t\t\t\t");
		if ($CanDel == "Y") {
			echo("\t\t\t\t\t\t\t<a href=\"javascript:void(0)\" onclick=\"");
			jsDelConfirm($Code);
			echo("\" class=\"TrashBtn\"></a>\n\t\t\t\t\t\t");
		}
		echo("\t\t\t\t\t</td>\n\t\t\t\t</tr>\n\t\t\t");
	}
	echo("\t\t");
}
else {
	echo("\t\t\t<tr class=\"rows\"><td colspan=\"4\"><br>");
	echo(Lng("No_records"));
	echo("...<br><br></td></tr>\n\t\t");
}
echo("\t</table>\n\t\n\t</form>\n\t\n\t");
if ($_SESSION["TDM_LANGEDIT_TYPE"] == 1) {
	echo("\t\t<br>\n\t\t<span class=\"tiptext\">* ");
	echo(Tip("Tips_available_for_administrator"));
	echo("</span>\n\t\t<br><br>\n\t");
}
echo("\t\n</div>\n\n\n\n\n<script type=\"text/javascript\">\n\t\$(document).ready(function () {\n\t\tvar _contentRows = \$('.rows'); _count = 0; var symbol = [];\n\t\t_contentRows.each(function (i){\n\t\t\tvar _cellText = \$(this).children('.");
echo($_SESSION["TDM_LANGEDIT_FLAT"]);
echo("').eq(0).text().substr(0,1).toUpperCase();\n\t\t\tif(\$.inArray(_cellText,symbol)==-1) { symbol.push(_cellText); }\n\t\t\t_count += 1;\n\t\t});\n\t\t\n\t\tvar arr = symbol.sort();\n\t\tfor(var k=0;k<arr.length;k++){\n\t\t\t\$('.letfilter').append('<a href=\"javascript:void(0)\" id=\"FLet'+arr[k]+'\">'+arr[k]+'</a>');\n\t\t}\n\t\t\$('.letfilter').append('<a href=\"javascript:void(0)\" >");
echo(Lng("All", 1, 0));
echo("</a>');\n\t\tvar _alphabets = \$('.letfilter > a');\n\t\t\n\t\t_alphabets.click(\n\t\t\tfunction () {\n\t\t\t\tvar _letter = \$(this), _text = \$(this).text(), _count = 0;\n\n\t\t\t\t_alphabets.removeClass(\"active\");\n\t\t\t\t_letter.addClass(\"active\");\n\t\t\t\t\n\t\t\t\t_contentRows.hide();\n\t\t\t\t_contentRows.each(function (i) {\n\t\t\t\t\tif(_text=='");
echo(Lng("All", 1, 0));
echo("') {\n\t\t\t\t\t\t_count += 1;\n\t\t\t\t\t\t\$(this).fadeIn(400);\n\t\t\t\t\t}else {\n\t\t\t\t\t\tvar _cellText = \$(this).children('.");
echo($_SESSION["TDM_LANGEDIT_FLAT"]);
echo("').eq(0).text().toUpperCase();\n\t\t\t\t\t\tif (RegExp('^' + _text).test(_cellText)) {\n\t\t\t\t\t\t\t_count += 1;\n\t\t\t\t\t\t\t\$(this).fadeIn(400);\n\t\t\t\t\t\t}\n\t\t\t\t\t}\n\t\t\t\t});\n\t\t});\n\t\t\n\t\t\n\t\t\$( \"#FLet");
echo($FLet);
echo("\" ).trigger( \"click\" );\n\t});\n</script>");

