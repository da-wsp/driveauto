<?php

class ExchangeRatesCBRF {

	public $rates = null;

	public $Conn = "N";

	
	public function __construct($date = null) {
		if (extension_loaded("soap")) {
			try {
				$client = new SoapClient("http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL");
				if (!(isset($date))) {
					$date = date("Y-m-d");
				}
				$curs = $client->GetCursOnDate(array("On_date" => $date));
				$this->rates = new SimpleXMLElement($curs->GetCursOnDateResult->any);
				$this->Conn = "Y";
			}
			catch (Exception $e) {
				$this->Conn = "N";
			}
		}
	}


	public function GetRate($code) {
		if ($this->Conn == "Y") {
			$code1 = (int)$code;
			if ($code1 != 0) {
				$result = $this->rates->xpath("ValuteData/ValuteCursOnDate/Vcode[.=" . $code . "]/parent::*");
			}
			else {
				$result = $this->rates->xpath("ValuteData/ValuteCursOnDate/VchCode[.=\"" . $code . "\"]/parent::*");
			}
			if (!$result) {
				return false;
			}
			$vc = (float)$result[0]->Vcurs;
			$vn = (int)$result[0]->Vnom;
			return $vc / $vn;
		}
	}


	
}
class ExchangeRatesNBU {

	public $exchange_url = "http://bank-ua.com/export/currrate.xml";

	public $xml = null;

	
	public function __construct() {
		return $this->xml = simplexml_load_file($this->exchange_url);
	}


	public function GetRate($NeedCode) {
		if ($this->xml !== false) {
			foreach ($this->xml->children() as $obItem) {
				$CurCode = (string)$obItem->char3;
				if (!($CurCode == $NeedCode)) {
					continue;
				}
				$CurRate = (float)$obItem->rate;
				$CurSize = (float)$obItem->size;
				$CurRate = $CurRate / $CurSize;
				$result = $CurRate;
			}
		}
		return $result;
	}


	
}
class ExchangeRatesNBRB {

	public $exchange_url = "http://www.nbrb.by/Services/XmlExRates.aspx";

	public $xml = null;

	
	public function __construct() {
		return $this->xml = simplexml_load_file($this->exchange_url);
	}


	public function GetRate($NeedCode) {
		if ($this->xml !== false) {
			foreach ($this->xml->children() as $obItem) {
				$CurCode = (string)$obItem->CharCode;
				if (!($CurCode == $NeedCode)) {
					continue;
				}
				$CurRate = (float)$obItem->Rate;
				$CurSize = (float)$obItem->Scale;
				$CurRate = $CurRate / $CurSize;
				$result = $CurRate;
			}
		}
		return $result;
	}


	
}
define("TDM_PROLOG_INCLUDED", true);
define("TDM_ADMIN_SIDE", true);
require_once("../tdmcore/init.php");
if ($_SESSION["TDM_ISADMIN"] != "Y") {
	header("Location: /" . TDM_ROOT_DIR . "/admin/");
	exit();
}
$resDB = new TDMQuery();
if ($_POST["addnew"] == "Y" || $_POST["edit"] == "Y") {
	$_POST["RATE"] = str_replace(",", ".", trim($_POST["RATE"]));
	$RATE = floatval($_POST["RATE"]);
	$TEMPLATE = trim($_POST["TEMPLATE"]);
	$TRUNCATE = intval($_POST["TRUNCATE"]);
	if (strlen($_POST["CODE"]) != 3) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Currency"), 1);
	}
	if ($RATE <= 0) {
		ErAdd(Lng("A_required_field") . " - " . Lng("Rate"), 1);
	}
	if ($TEMPLATE == "") {
		ErAdd(Lng("A_required_field") . " - " . Lng("Template"), 1);
	}
}
if ($_POST["addnew"] == "Y") {
	$resDB->Select("TDM_CURS", array(), array("CODE" => $_POST["CODE"]));
	if ($arRes = $resDB->Fetch()) {
		ErAdd(Lng("Currency") . " \"" . $_POST["CODE"] . "\" " . Lng("is_already_exist", 2), 1);
	}
	if (ErCheck()) {
		$IRes = $resDB->Insert("TDM_CURS", array("CODE" => $_POST["CODE"], "RATE" => $RATE, "TEMPLATE" => $TEMPLATE, "TRUNCATE" => $TRUNCATE));
		if ($IRes) {
			NtAdd(Lng("Record_added") . ": " . $_POST["CODE"]);
			$_POST["addnew"] = "N";
			$_POST["RATE"] = "";
			$_POST["TEMPLATE"] = "";
			$_POST["CODE"] = "";
			$_POST["TRUNCATE"] = "";
		}
	}
}
if ($_POST["edit"] == "Y" && ErCheck()) {
	$resDB->Update2("TDM_CURS", array("RATE" => $RATE, "TEMPLATE" => $TEMPLATE, "TRUNCATE" => $TRUNCATE), array("CODE" => $_POST["CODE"]));
	NtAdd(Lng("Record_updated") . ": " . $_POST["CODE"]);
	$_POST["edit"] = "N";
	$_POST["RATE"] = "";
	$_POST["TEMPLATE"] = "";
	$_POST["CODE"] = "";
	$_POST["TRUNCATE"] = "";
}
if ($_POST["delete"] == "Y" && strlen($_POST["delem"]) == 3) {
	$resDB = new TDMQuery();
	$DResCnt = $resDB->Delete("TDM_CURS", array("CODE" => $_POST["delem"]));
	if (0 < $DResCnt) {
		NtAdd(Lng("Record_deleted") . ": " . $_POST["delem"]);
		$_POST["delete"] = "N";
		$_POST["delem"] = "";
	}
}
$arCurs = array();
$resDB->Select("TDM_CURS", array("RATE" => "DESC"), array());
while ($arRes = $resDB->Fetch()) {
	$arCreated[] = $arRes["CODE"];
	$arCurs[] = $arRes;
	++$Rows;
}
$arNCurs = array("USD", "EUR", "RUB", "BYR", "UAH", "GBP", "LTL", "MDL", "ANG", "RSD", "BGN", "CZK", "DKK", "GEL", "HRK", "HUF", "ILS", "RON", "TRY", "CNY", "JPY");
foreach ($arNCurs as $CrKey => $CrVal) {
	if (!(in_array($CrVal, $arCreated))) {
		continue;
	}
	unset($arNCurs[$CrKey]);
}
$arClip = array(1 => Lng("Price_with_cents", 0, 0), 2 => Lng("Rounded_lower", 0, 0), 3 => Lng("Rounded_nearest", 0, 0), 4 => Lng("Rounded_greater", 0, 0));
echo("<head><title>TDM :: ");
echo(Lng("Exchange_rates", 1, 0));
echo("</title></head>\n<div class=\"apanel_cont\">");
require_once("apanel.php");
echo("</div>\n<div class=\"tdm_acontent\">\n\t");
jsLinkJqueryUi();
echo("\t");
jsLinkFormStyler();
echo("\t<script>\n\t\tAddFSlyler('input, select, textarea, checkbox, radio');\n\t\tfunction ShowEditForm(CODE,RATE,TEMPLATE,TRUNCATE){\n\t\t\t\$('#adddiv').hide();\n\t\t\t\$('#etrunc').val(TRUNCATE);\n\t\t\t\$('select').trigger('refresh'); //For styled select\n\t\t\t\$('#editdiv').show('slow'); \n\t\t\t\$('#topaddbut').hide();\n\t\t\t\$('#ecur').html(CODE);\n\t\t\t\$('#ecode').val(CODE);\n\t\t\t\$('#erate').val(RATE);\n\t\t\t\$('#etempl').val(TEMPLATE);\n\t\t\t\$('.tdnote').hide(!\$('.tdnote').length);\n\t\t}\n\t\tfunction ShowNewAddForm(){\n\t\t\t\$('#adddiv').show('slow'); \n\t\t\t\$('#topaddbut').hide();\n\t\t\t\$('.tdnote').hide(!\$('.tdnote').length);\n\t\t}\n\t</script>\n\t");
if ($_POST["addnew"] != "Y") {
	echo("\t\t<div class=\"flrig bluebut\" id=\"topaddbut\" onclick=\"ShowNewAddForm()\">");
	echo(Lng("Add_new", 0, 0));
	echo("</div>\n\t");
}
echo("\t<h1>");
echo(Lng("Exchange_rates"));
echo("</h1>\n\t<hr>\n\t<div class=\"tiptext\">");
echo(Tip("Set_base_currency_rate"));
echo("</div><br>\n\t");
ErShow();
echo("\n\t<div id=\"adddiv\" ");
if ($_POST["addnew"] != "Y") {
	echo("style=\"display:none;\"");
}
echo(" >\n\t\t<form action=\"\" id=\"addform\" method=\"post\">\n\t\t<input type=\"hidden\" name=\"addnew\" value=\"Y\"/>\n\t\t<table class=\"formtab\"><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Currency"));
echo(": </td>\n\t\t\t<td class=\"fvalues\">\n\t\t\t\t<select name=\"CODE\" style=\"width:90px;\">\n\t\t\t\t\t");
FShowSelectOptions($arNCurs, $_POST["CODE"]);
echo("\t\t\t\t</select></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Rate"));
echo(": </td>\n\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"RATE\" value=\"");
echo($_POST["RATE"]);
echo("\" maxlength=\"12\" style=\"width:90px;\" /> <span class=\"tiptext\">");
echo(Tip("With_respect_to_base_currency"));
echo("</span></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Template"));
echo(": </td>\n\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" name=\"TEMPLATE\" value=\"");
echo($_POST["TEMPLATE"]);
echo("\" maxlength=\"8\" style=\"width:90px;\" /> <span class=\"tiptext\">");
echo(Lng("Example"));
echo(": #\xe2\x82\xac</span></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Clipping_cents"));
echo(": </td>\n\t\t\t<td class=\"fvalues\">\n\t\t\t\t<select name=\"TRUNCATE\" style=\"width:310px;\">\n\t\t\t\t\t");
FShowSelectOptionsK($arClip, $_POST["TRUNCATE"]);
echo("\t\t\t\t</select></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\"></td>\n\t\t\t<td class=\"fvalues\"><div class=\"bluebut\" onclick=\"\$('#addform').submit();\">");
echo(Lng("Add_new", 0, 0));
echo("</div></td></tr>\n\t\t</table>\n\t\t<div class=\"tclear\"></div>\n\t\t</form>\n\t\t<hr>\n\t</div>\n\t\n\t<div id=\"editdiv\" ");
if ($_POST["edit"] != "Y") {
	echo("style=\"display:none;\"");
}
echo(" >\n\t\t<form action=\"\" id=\"editform\" method=\"post\">\n\t\t<input type=\"hidden\" name=\"edit\" value=\"Y\"/>\n\t\t<input type=\"hidden\" name=\"CODE\" id=\"ecode\" value=\"\"/>\n\t\t<table class=\"formtab\"><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Rate"));
echo(" <b id=\"ecur\"></b>: </td>\n\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" id=\"erate\" name=\"RATE\" value=\"");
echo($_POST["RATE"]);
echo("\" maxlength=\"12\" style=\"width:90px;\" /> <span class=\"tiptext\">");
echo(Tip("With_respect_to_base_currency"));
echo("</span></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Template"));
echo(": </td>\n\t\t\t<td class=\"fvalues\"><input class=\"styler\" type=\"text\" id=\"etempl\" name=\"TEMPLATE\" value=\"");
echo($_POST["TEMPLATE"]);
echo("\" maxlength=\"8\" style=\"width:90px;\" /> <span class=\"tiptext\">");
echo(Lng("Example"));
echo(": #\xe2\x82\xac</span></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\">");
echo(Lng("Clipping_cents"));
echo(": </td>\n\t\t\t<td class=\"fvalues\">\n\t\t\t\t<select name=\"TRUNCATE\" id=\"etrunc\" style=\"width:310px;\">\n\t\t\t\t\t");
FShowSelectOptionsK($arClip, $_POST["TRUNCATE"]);
echo("\t\t\t\t</select></td>\n\t\t\t</tr><tr>\n\t\t\t<td class=\"fname\"></td>\n\t\t\t<td class=\"fvalues\"><div class=\"bluebut\" onclick=\"\$('#editform').submit();\">");
echo(Lng("Edit", 0, 0));
echo("</div></td>\n\t\t</table>\n\t\t<div class=\"tclear\"></div>\n\t\t</form>\n\t\t<hr>\n\t</div>\n\t\n\t<form action=\"\" id=\"crform\" method=\"post\">\n\t<input type=\"hidden\" name=\"editme\" value=\"Y\"/>\n\t\t\t<link rel=\"stylesheet\" href=\"/");
echo(TDM_ROOT_DIR);
echo("/media/js/colorbox/cmain.css\" />\n\t\t\t<script type=\"text/javascript\" language=\"javascript\" src=\"/");
echo(TDM_ROOT_DIR);
echo("/media/js/colorbox/colorbox.js\"></script>\n\t\t\t<script>\n\t\t\t\t\$(document).ready(function(){\n\t\t\t\t\t\$(\".popup\").colorbox({rel:false, current:'', preloading:false, arrowKey:false, scrolling:false, overlayClose:false});\n\t\t\t\t});\n\t\t\t\t\$(\"#cboxPrevious\").hide();\n\t\t\t\t\$(\"#cboxNext\").hide();\n\t\t\t</script>\n\t\t\t\n\t\t\t<table><tr><td style=\"vertical-align:top;\">\n\t\t\t\t<table class=\"etab\">\n\t\t\t\t\t<tr class=\"head\"><td>");
echo(Lng("Currency"));
echo("</td><td>");
echo(Lng("Rate"));
echo("</td><td title=\"");
echo(Lng("Clipping_cents", 1, 0));
echo("\"><img src=\"images/cent1.png\" width=\"16\" height=\"16\"></td><td>");
echo(Lng("Template"));
echo("</td><td></td></tr>\n\t\t\t\t\t");
foreach ($arCurs as $arCur) {
	if ($arCur["CODE"] == "RUB") {
		$GetInformers = "Y";
		$GenInfoRUB = "Y";
	}
	if ($arCur["CODE"] == "UAH") {
		$GetInformers = "Y";
		$GenInfoUAH = "Y";
	}
	if ($arCur["CODE"] == "BYR") {
		$GetInformers = "Y";
		$GenInfoBYR = "Y";
	}
	++$Rows;
	$arRates[$arCur["CODE"]] = $arCur["RATE"];
	if ($arCur["RATE"] == 1) {
		$arCur["Style"] = "style=\"font-weight:bold;\"";
	}
	echo("\t\t\t\t\t\t<tr class=\"rows tarig\"><td ");
	echo($arCur["Style"]);
	echo(">");
	echo($arCur["CODE"]);
	echo("</td>\n\t\t\t\t\t\t<td ");
	echo($arCur["Style"]);
	echo(">");
	echo($arCur["RATE"]);
	echo("</td>\n\t\t\t\t\t\t<td>");
	if (1 < $arCur["TRUNCATE"]) {
		echo("<img src=\"images/cent");
		echo($arCur["TRUNCATE"]);
		echo(".png\" width=\"16\" height=\"16\" title=\"");
		echo($arClip[$arCur["TRUNCATE"]]);
		echo("\">");
	}
	echo("</td>\n\t\t\t\t\t\t<td>");
	echo($arCur["TEMPLATE"]);
	echo("</td>\n\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t");
	if ($arCur["RATE"] != 1) {
		echo("\t\t\t\t\t\t\t\t<a href=\"javascript:void(0);\" onclick=\"");
		jsDelConfirm($arCur["CODE"], Lng("Really_delete_record", 0, 0) . ": " . $arCur["CODE"]);
		echo("\" ><img src=\"images/trash.gif\" width=\"16\" height=\"16\" title=\"");
		echo(Lng("Delete", 1, 0));
		echo("\"></a>\n\t\t\t\t\t\t\t");
	}
	echo("\t\t\t\t\t\t\t<a href=\"javascript:void(0);\" onclick=\"ShowEditForm('");
	echo($arCur["CODE"]);
	echo("','");
	echo($arCur["RATE"]);
	echo("','");
	echo($arCur["TEMPLATE"]);
	echo("',");
	echo($arCur["TRUNCATE"]);
	echo(")\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" title=\"");
	echo(Lng("Edit", 1, 0));
	echo("\"></a>\n\t\t\t\t\t\t</td>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t");
}
echo("\t\t\t\t\t");
if ($Rows <= 0) {
	echo("\t\t\t\t\t\t<tr><td class=\"\" colspan=\"10\"><center>");
	echo(Lng("No_records"));
	echo("...</center></td>\n\t\t\t\t\t");
}
echo("\t\t\t\t</table>\n\t\t\t</td><td style=\"padding-left:20px; vertical-align:top;\">\n\t\t\t\t<div style=\"font-size:42px; padding:50px 20px 0px 0px; float:left; color:#9E9E9E;\">&#8680;</div>\n\t\t\t\t");
if (0 < count($arRates) && 1 < $Rows) {
	echo("\t\t\t\t\t<table class=\"etab\">\n\t\t\t\t\t\t<tr class=\"head\">\n\t\t\t\t\t\t<td></td>\n\t\t\t\t\t\t");
	foreach ($arRates as $CODE => $Rate) {
		echo("<td>");
		echo($CODE);
		echo("</td>");
	}
	echo("\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t");
	$Nominal = 1;
	foreach ($arRates as $CODE => $Rate) {
		$arRates2 = $arRates;
		if (99 < $Rate) {
			$Rate = $Rate / 10000;
			$Nominal = 10000;
		}
		else {
			$Nominal = 1;
		}
		echo("\t\t\t\t\t\t\t<tr class=\"rows\">\n\t\t\t\t\t\t\t\t<td class=\"tarig\"><img src=\"images/\xd1\x8116.png\" width=\"1\" height=\"16\">");
		echo($Nominal);
		echo(" <b>");
		echo($CODE);
		echo("</b> =</td>\n\t\t\t\t\t\t\t\t");
		foreach ($arRates2 as $CODE2 => $Rate2) {
			if ($CODE != $CODE2) {
				$Res = $Rate2 / $Rate;
				if (100 < $Res) {
					$Res = round($Res, 2);
				}
				else {
					$Res = round($Res, 5);
				}
				if (1000 < $Nominal) {
					$Res = round($Res, 3);
				}
			}
			else {
				$Res = "-";
			}
			echo("\t\t\t\t\t\t\t\t\t<td>");
			echo($Res);
			echo("</td>\n\t\t\t\t\t\t\t\t");
		}
		echo("\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t");
	}
	echo("\t\t\t\t\t</table>\n\t\t\t\t");
}
echo("\t\t\t</table>\n\t\t\t<br>\n\t\t\t\n\t</form>\n\n\t\n\t");
if ($GetInformers == "Y") {
	echo("\t\t<hr>\n\t\t<span class=\"tiptext\">");
	echo(Tip("Widgets_1"));
	echo(" <b>");
	echo(date("d.m.y"));
	echo("</b> ");
	echo(Tip("Widgets_2"));
	echo(":</span>\n\t\t<div class=\"tclear\"></div>\n\t\t<br>\n\t\t");
	if ($GenInfoRUB == "Y") {
		echo("\t\t\t<div class=\"cursdiv\">\n\t\t\t\t<table class=\"curstab\">\n\t\t\t\t\t<tr><td rowspan=\"10\" class=\"bankstd\"><img src=\"images/cbrf.png\" width=\"64\" height=\"64\" title=\"\xd0\xa6\xd0\xb5\xd0\xbd\xd1\x82\xd1\x80\xd0\xb0\xd0\xbb\xd1\x8c\xd0\xbd\xd1\x8b\xd0\xb9 \xd0\xb1\xd0\xb0\xd0\xbd\xd0\xba \xd0\xa0\xd0\xbe\xd1\x81\xd1\x81\xd0\xb8\xd0\xb9\xd1\x81\xd0\xba\xd0\xbe\xd0\xb9 \xd0\xa4\xd0\xb5\xd0\xb4\xd0\xb5\xd1\x80\xd0\xb0\xd1\x86\xd0\xb8\xd0\xb8\"><br><b>\xd0\xa6\xd0\x91\xd0\xa0\xd0\xa4</b><br>cbr.ru</td>\n\t\t\t\t\t\t<td class=\"hdr\"><b>1 \xd1\x80\xd1\x83\xd0\xb1.</b></td><td class=\"hdr\">\xd0\x9f\xd1\x80\xd1\x8f\xd0\xbc\xd0\xbe\xd0\xb9</td><td class=\"hdr\">\xd0\x9e\xd0\xb1\xd1\x80\xd0\xb0\xd1\x82\xd0\xbd\xd1\x8b\xd0\xb9</td></tr>\n\t\t\t\t\t\t");
		$obCBRF = new ExchangeRatesCBRF();
		echo("\t\t\t\t\t\t");
		foreach ($arRates as $CODE => $Rate) {
			if ($CODE != "RUB") {
				$RVal = "";
				$cRate = $obCBRF->GetRate($CODE);
				if (0 < $cRate) {
					$RVal = round(1 / $cRate, 5);
				}
				echo("\t\t\t\t\t\t\t\t<tr><td class=\"hdr\">");
				echo($CODE);
				echo("</td><td>");
				echo(round($cRate, 5));
				echo("</td><td>");
				echo($RVal);
				echo("</td></tr>\n\t\t\t\t\t\t\t");
			}
			echo("\t\t\t\t\t\t");
		}
		echo("\t\t\t\t</table>\n\t\t\t</div>\n\t\t");
	}
	echo("\t\t\t\t\n\t\t");
	if ($GenInfoUAH == "Y") {
		echo("\t\t\t<div class=\"cursdiv\">\n\t\t\t\t<table class=\"curstab\">\n\t\t\t\t\t<tr><td rowspan=\"10\" class=\"bankstd\"><img src=\"images/nbu.png\" width=\"64\" height=\"64\" title=\"\xd0\x9d\xd0\xb0\xd1\x86\xd0\xb8\xd0\xbe\xd0\xbd\xd0\xb0\xd0\xbb\xd1\x8c\xd0\xbd\xd1\x8b\xd0\xb9 \xd0\xb1\xd0\xb0\xd0\xbd\xd0\xba \xd0\xa3\xd0\xba\xd1\x80\xd0\xb0\xd0\xb8\xd0\xbd\xd1\x8b\"><br><b>\xd0\x9d\xd0\x91\xd0\xa3</b><br>bank-ua.com</td>\n\t\t\t\t\t\t<td class=\"hdr\"><b>1 \xd0\xb3\xd1\x80\xd0\xbd.</b></td><td class=\"hdr\">\xd0\x9f\xd1\x80\xd1\x8f\xd0\xbc\xd0\xbe\xd0\xb9</td><td class=\"hdr\">\xd0\x9e\xd0\xb1\xd1\x80\xd0\xb0\xd1\x82\xd0\xbd\xd1\x8b\xd0\xb9</td></tr>\n\t\t\t\t\t\t");
		$obNBU = new ExchangeRatesNBU();
		echo("\t\t\t\t\t\t");
		foreach ($arRates as $CODE => $Rate) {
			if ($CODE != "UAH") {
				$RVal = "";
				$cRate = $obNBU->GetRate($CODE);
				if (0 < $cRate) {
					$RVal = round(1 / $cRate, 5);
				}
				echo("\t\t\t\t\t\t\t\t<tr><td class=\"hdr\">");
				echo($CODE);
				echo("</td><td>");
				echo(round($cRate, 5));
				echo("</td><td>");
				echo($RVal);
				echo("</td></tr>\n\t\t\t\t\t\t\t");
			}
			echo("\t\t\t\t\t\t");
		}
		echo("\t\t\t\t</table>\n\t\t\t</div>\n\t\t");
	}
	echo("\t\t\t\t\n\t\t");
	if ($GenInfoBYR == "Y") {
		echo("\t\t\t<div class=\"cursdiv\">\n\t\t\t\t<table class=\"curstab\">\n\t\t\t\t\t<tr><td rowspan=\"10\" class=\"bankstd\"><img src=\"images/nbrb.png\" width=\"64\" height=\"64\" title=\"\xd0\x9d\xd0\xb0\xd1\x86\xd0\xb8\xd0\xbe\xd0\xbd\xd0\xb0\xd0\xbb\xd1\x8c\xd0\xbd\xd1\x8b\xd0\xb9 \xd0\xb1\xd0\xb0\xd0\xbd\xd0\xba \xd0\xa0\xd0\xb5\xd1\x81\xd0\xbf\xd1\x83\xd0\xb1\xd0\xbb\xd0\xb8\xd0\xba\xd0\xb8 \xd0\x91\xd0\xb5\xd0\xbb\xd0\xb0\xd1\x80\xd1\x83\xd1\x81\xd1\x8c\"><br><b>\xd0\x9d\xd0\x91\xd0\xa0\xd0\x91</b><br>nbrb.by</td>\n\t\t\t\t\t\t<td class=\"hdr\"><b>10000 \xd1\x80.</b></td><td class=\"hdr\">\xd0\x9f\xd1\x80\xd1\x8f\xd0\xbc\xd0\xbe\xd0\xb9</td><td class=\"hdr\">\xd0\x9e\xd0\xb1\xd1\x80\xd0\xb0\xd1\x82\xd0\xbd\xd1\x8b\xd0\xb9</td></tr>\n\t\t\t\t\t\t");
		$obNBRB = new ExchangeRatesNBRB();
		echo("\t\t\t\t\t\t");
		foreach ($arRates as $CODE => $Rate) {
			if ($CODE != "BYR") {
				$RVal = "";
				$cRate = $obNBRB->GetRate($CODE);
				if (0 < $cRate) {
					$RVal = round(1 / ($cRate / 10000), 3);
				}
				echo("\t\t\t\t\t\t\t\t<tr><td class=\"hdr\">");
				echo($CODE);
				echo("</td><td>");
				echo(round($cRate, 5));
				echo("</td><td>");
				echo($RVal);
				echo("</td></tr>\n\t\t\t\t\t\t\t");
			}
			echo("\t\t\t\t\t\t");
		}
		echo("\t\t\t\t</table>\n\t\t\t</div>\n\t\t");
	}
	echo("\t\t\n\t\t<div class=\"tclear\"></div>\n\t");
}
echo("\t\t\t\n\n</div>\n\n\n\n");

