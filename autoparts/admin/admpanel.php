<?php

echo("<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/\" class=\"apbut tdcatalog\" title=\"");
echo(Lng("Catalog", 1, false));
echo("\"></a>\n");
if ($_REQUEST["admside"] != "Y") {
	echo("\t<a href=\"javascript:void(0);\" onclick=\"\$('#metalay').slideToggle();\" class=\"apbut meta ");
	if ($_REQUEST["hseom"] == "Y") {
		echo("bactive");
	}
	echo("\" title=\"\">SEO-Meta</a>\n");
}

if ($_REQUEST["com"] != "") {
	if ($_REQUEST["brand"] != "") {
		$RLast .= "&brand=" . $_REQUEST["brand"];
	}
	if (0 < $_REQUEST["sec_id"]) {
		$RLast .= "&sec_id=" . $_REQUEST["sec_id"];
	}
	echo("\t<a href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/comsets.php?to=");
	echo($_REQUEST["com"] . $RLast);
	echo("\" target=\"_blank\" class=\"apbut comsets\" title=\"");
	echo(Lng("Edit", 1, false));
	echo(" ");
	echo(Lng("this", 2, false));
	echo(" ");
	echo(Lng("Component", 2, false));
	echo("\">");
	echo(Lng("Component", 1, false));
	echo("</a>\n");
}
if ($_REQUEST["ccahce"] == "Y") {
	echo("\t<form action=\"\" id=\"recache_fomr\" method=\"post\"><input type=\"hidden\" name=\"recache\" value=\"Y\"></form>\n\t<a href=\"javascript:void(0);\" onclick=\"\$('#recache_fomr').submit();\" class=\"apbut recache\" title=\"");
	echo(Tip("Refresh_component_cache"));
	echo("\"></a>\n");
}
echo("<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/?logout=Y\" class=\"apbut apr exit\" title=\"");
echo(Lng("Logout", 1, false));
echo("\"></a>\n<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/dbserv.php\" class=\"apbut apr dbserv\" title=\"");
echo(Lng("Database_service", 1, false));
echo("\"></a>\n<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/\" class=\"apbut apr ainfo\" title=\"");
echo(Tip("Tecdoc_module"));
echo("\"></a>\n<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/settings.php\" class=\"apbut apr setts\" title=\"");
echo(Lng("Module_settings", 1, false));
echo("\"></a>\n<div class=\"submdiv\" id=\"curbut\">\n\t<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/curs.php\" class=\"apbut apr crates\" title=\"");
echo(Lng("Exchange_rates", 1, false));
echo("\">");
echo(TDM_CUR);
echo("</a>\n\t<div class=\"asubmenu\" id=\"cursubmenu\">\n\t\t<div style=\"float:left;\">\n\t\t");
foreach ($TDMCore->arCurs as $Cur => $arCur) {
	echo("\t\t\t<a href=\"javascript:void(0)\" onclick=\"\$('#crv').val('");
	echo($Cur);
	echo("'); \$('#crf').submit();\">");
	echo($Cur);
	echo("</a>\n\t\t");
}
echo("\t\t</div>\n\t\t<div style=\"float:left; border-left:1px solid #D4D4D4;\">\n\t\t\t");
foreach ($TDMCore->arPriceType as $PtID => $PtName) {
	if ($_SESSION["TDM_USER_GROUP"] == $PtID) {
		$Style = "style=\"color:#FFBB00;\"";
	}
	else {
		$Style = "";
	}
	echo("\t\t\t\t<a href=\"javascript:void(0)\" onclick=\"\$('#ctp').val('");
	echo($PtID);
	echo("'); \$('#tpf').submit();\" ");
	echo($Style);
	echo(" >");
	echo($PtName);
	echo("</a>\n\t\t\t");
}
echo("\t\t</div>\n\t</div>\n</div>\n<div class=\"submdiv\" id=\"lngbut\">\n\t<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/langs.php\" class=\"apbut apr langs\" >");
echo(UWord(TDM_LANG));
echo("</a>\n\t<div class=\"asubmenu\" id=\"lngsubmenu\">\n\t\t");
foreach ($TDMCore->arLangs as $Lng) {
	if (in_array($Lng, $TDMCore->arConfig["MODULE_ACTIVE_LNG"])) {
		echo("\t\t\t\t<a href=\"javascript:void(0)\" onclick=\"\$('#lnv').val('");
		echo($Lng);
		echo("'); \$('#lnf').submit();\">");
		echo(UWord($Lng));
		echo("</a>\n\t\t\t");
	}
	echo("\t\t");
}
echo("\t</div>\n</div>\n<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/ws.php\" class=\"apbut apr webserv\" title=\"");
echo(Lng("Webservices", 1, false));
echo("\"></a>\n<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/dbedit.php\" class=\"apbut apr dbedit\" title=\"");
echo(Tip("DB_Editor"));
echo("\">");
echo(Lng("Editor", 1, false));
echo("</a>\n<a href=\"/");
echo(TDM_ROOT_DIR);
echo("/admin/import/\" class=\"apbut apr import\" title=\"");
echo(Lng("Import_master", 1, false));
echo("\">");
echo(Lng("Import", 1, false));
echo("</a>\n<script type=\"text/javascript\">\n\t\$('#lngbut').hover(function(){ \$('#lngsubmenu').show();}, function() { \$('#lngsubmenu').hide(); });\n\t\$('#curbut').hover(function(){ \$('#cursubmenu').show();}, function() { \$('#cursubmenu').hide(); });\n</script><div style=\"display:none;\">\n<form id=\"crf\" method=\"POST\"><input type=\"hidden\" name=\"SET_CUR\" id=\"crv\" value=\"\"></form>\n<form id=\"lnf\" method=\"POST\"><input type=\"hidden\" name=\"SET_LANG\" id=\"lnv\" value=\"\"></form>\n<form id=\"tpf\" method=\"POST\"><input type=\"hidden\" name=\"SET_TYPE\" id=\"ctp\" value=\"\"></form></div>\n<div class=\"tclear\"></div>");

