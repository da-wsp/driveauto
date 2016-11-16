<?php
	define("TDM_PROLOG_INCLUDED", true);
	define("TDM_ADMIN_SIDE", true);
	require_once("../tdmcore/init.php");
	if ($_SESSION["TDM_ISADMIN"] != "Y" || $_REQUEST["to"] == "") {
		header("Location: /" . TDM_ROOT_DIR . "/admin/");
		exit();
	}
	
	echo("<head><title>TDM :: ");
	echo(Lng("Edit"));
	echo(" ");
	echo(Lng("Component", 2));
	echo("</title></head>\n<div class=\"apanel_cont\">");
	require_once("apanel.php");
	echo("</div>\n");
	jsLinkJqueryUi();
	jsLinkFormStyler();
	echo("<div class=\"tdm_acontent\">\n\t");
	global $CompCode;
	switch ($_REQUEST["to"]) {
		case "manufacturers":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = "Manufacturers list";
			break;
		
		case "models":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Models_list", 1, 0);
			break;
		
		case "types":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Type_of_engine", 1, 0);
			break;
		
		case "sections":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Sections_of_parts", 1, 0);
			break;
		
		case "subsections":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Subsections_of_parts", 1, 0) . " (SID: " . $_REQUEST["sec_id"] . ")";
			break;
		
		case "sectionparts":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Parts_of_section", 1, 0);
			break;
		
		case "searchparts":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Search_by_parts_number", 1, 0);
			break;
		
		case "analogparts":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Analogs_of_brand_number", 1, 0);
		
	}
	echo("\t<h1>");
	echo(Lng("Edit"));
	echo(" ");
	echo(Lng("Component", 2));
	echo(" ");
	echo($Mrk);
	echo(" ");
	echo($CompName);
	echo("</h1>\n\t<hr>\n\t<form action=\"\" id=\"setsform\" method=\"post\">\n\t<input type=\"hidden\" name=\"editme\" value=\"Y\"/>\n\t");
	
	ErShow();
	/////////////////////////////////////
	//require_once(TDM_PATH . "/admin/downloads/exec.php");
	global $TDMCore;

	global $arComSets;
	$arComSets = TDMGetSets($CompCode);
	require_once("coms_manufacturers.php");
	
	echo("\t");
	ErShow();
	echo("\t<hr>\n\t<input type=\"submit\" value=\"");
	echo(Lng("Save", 1, false));
	echo(" ");
	echo(Lng("Settings", 2, false));
	echo("\" class=\"abutton\"/>\n\t</form>\n\t<form id=\"addform\" method=\"POST\"><input type=\"hidden\" name=\"ADDFIELD\" id=\"ADDFIELD\" value=\"\"></form>\n\t<script>\n\t\tfunction AddFormPost(value){\n\t\t\t\$('#ADDFIELD').val(value); \$('#addform').submit();\n\t\t}\n\t</script>\n</div>");


