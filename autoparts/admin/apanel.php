<?php

if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}
if ($_SESSION["TDM_ISADMIN"] == "Y") {
	define("TDM_ADMIN_PANEL", "Y");
	echo("\t<link rel=\"stylesheet\" href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/styles.css\" type=\"text/css\">\n\t<script src=\"/");
	echo(TDM_ROOT_DIR);
	echo("/media/js/jquery-1.11.0.min.js\"></script>\n\t<script src=\"/");
	echo(TDM_ROOT_DIR);
	echo("/media/js/jquery-migrate-1.2.1.min.js\"></script>\n\t<script src=\"/");
	echo(TDM_ROOT_DIR);
	echo("/media/js/tdmfuncs.js\"></script>\n\t<link rel=\"stylesheet\" href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/styles.css\" type=\"text/css\">\n\t<script src=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/functions.js\"></script>\n\t<div class=\"admin_panel\" id=\"ap\">\n\t\t<a href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/\" class=\"apbut tdcatalog\" title=\"");
	echo(Lng("Catalog", 1, false));
	echo("\"></a>\n\t\t<script type=\"text/javascript\">\n\t\t\t\$( \"#ap\" ).load(\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/print.php?action=admpanel&com=");
	
	echo($_REQUEST["com"]);
	echo("&brand=");
	echo($_REQUEST["brand"]);
	echo("&sec_id=");
	echo($_REQUEST["sec_id"]);
	echo("&admside=");
	if (defined("TDM_ADMIN_SIDE")) {
		echo("Y");
	}
	echo("&hseom=");
	if (defined("TDM_HAVE_SEOMETA")) {
		echo("Y");
	}
	echo("&ccahce=");
	if (defined("TDM_CCACHE_INCLUDED")) {
		echo("Y");
	}
	echo("\", function( response, status, xhr ) {\n\t\t\t\tif ( status == \"error\" ){\n\t\t\t\t\tvar msg = \"Sorry but there was an error: \";\n\t\t\t\t\t\$( \"#error\" ).html( msg + xhr.status + \" \" + xhr.statusText );\n\t\t\t\t}\n\t\t\t});\n\t\t</script>\n\t\t<a href=\"/");
	echo(TDM_ROOT_DIR);
	echo("/admin/?logout=Y\" class=\"apbut apr exit\" title=\"");
	echo(Lng("Logout", 1, false));
	echo("\"></a>\n\t\t<div class=\"tclear\"></div>\n\t</div>\n\t");
	if (!(defined("TDM_ADMIN_SIDE"))) {
		echo("\t\t<div class=\"sublay\" id=\"metalay\">\n\t\t\t<form action=\"\" method=\"post\">\n\t\t\t<input type=\"hidden\" name=\"tdm_set_meta\" value=\"Y\">\n\t\t\t<input type=\"hidden\" name=\"recache\" value=\"Y\">\n\t\t\t<table class=\"sublaytab\">\n\t\t\t\t<tr><td></td><td><span class=\"tiptext\">");
		echo(Tip("With_form_create_unique_SEO"));
		echo("</span></td></tr>\n\t\t\t\t<tr><td>Title: </td><td><input type=\"text\" name=\"TITLE\" value=\"");
		if (defined("TDM_TITLE")) {
			echo(TDM_TITLE);
		}
		echo("\" class=\"subinput\" placeholder=\"");
		echo(Tip("if_seometa_not_set", 0, 0));
		echo("\"></td></tr>\n\t\t\t\t<tr><td>Keywords: </td><td><input type=\"text\" name=\"KEYWORDS\" value=\"");
		if (defined("TDM_KEYWORDS")) {
			echo(TDM_KEYWORDS);
		}
		echo("\" class=\"subinput\" placeholder=\"");
		echo(Tip("if_seometa_not_set", 0, 0));
		echo("\"></td></tr>\n\t\t\t\t<tr><td>Description: </td><td><input type=\"text\" name=\"DESCRIPTION\" value=\"");
		if (defined("TDM_DESCRIPTION")) {
			echo(TDM_DESCRIPTION);
		}
		echo("\" class=\"subinput\" placeholder=\"");
		echo(Tip("if_seometa_not_set", 0, 0));
		echo("\"></td></tr>\n\t\t\t\t<tr><td><nobr>");
		echo(Lng("Title"));
		echo(" H1: </nobr></td><td><input type=\"text\" name=\"H1\" value=\"");
		if (defined("TDM_H1")) {
			echo(TDM_H1);
		}
		echo("\" class=\"subinput\" placeholder=\"");
		echo(Tip("if_seometa_not_set", 0, 0));
		echo("\"></td></tr>\n\t\t\t\t<tr><td><nobr>");
		echo(Tip("Top_SEO_text"));
		echo(": </nobr></td><td><textarea name=\"TOPTEXT\" class=\"subinput sbinp\">");
		if (defined("TDM_TOPTEXT")) {
			echo(TDM_TOPTEXT);
		}
		echo("</textarea>\n\t\t\t\t<tr><td><nobr>");
		echo(Tip("Bottom_SEO_text"));
		echo(": </nobr></td><td><textarea name=\"BOTTEXT\" class=\"subinput sbinp\">");
		if (defined("TDM_BOTTEXT")) {
			echo(TDM_BOTTEXT);
		}
		echo("</textarea></td></tr>\n\t\t\t\t<tr><td></td><td>\n\t\t\t\t\t<input type=\"submit\" value=\"");
		echo(Lng("Save"));
		echo("\" class=\"abutton\"/> \n\t\t\t\t\t");
		if (defined("TDM_HAVE_SEOMETA")) {
			echo("\t\t\t\t\t\t<input type=\"submit\" name=\"set_delete\" value=\"");
			echo(Tip("Delete_this_Meta_record"));
			echo("\" class=\"abutton smbut smgrey flrig\"/>\n\t\t\t\t\t");
		}
		echo("\t\t\t\t</td></tr>\n\t\t\t</table>\n\t\t\t</form>\n\t\t</div>\n\t\t");
		if ($_POST["tdm_set_meta"] == "Y") {
			echo("<script>\$('#metalay').show();</script>");
		}
		echo("\t");
	}
	else {
		echo("\t\t<link rel=\"stylesheet\" href=\"/");
		echo(TDM_ROOT_DIR);
		echo("/admin/adminside.css\" type=\"text/css\">\n\t");
	}
}

