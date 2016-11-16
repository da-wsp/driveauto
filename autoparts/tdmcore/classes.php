<?php

abstract class SymsSet {

	static private $Selfins = null;

	protected $templ = null;

	
	static public function GetChimm() {
		self::$Selfins = new static();
		self::$Selfins->templ = get_called_class() . " " . "SymsSet";
		return self::$Selfins;
	}
	
}

class TDMCore {

	public $arConfig = array();

	public $arSettings = array();

	public $arErrors = array();

	public $arNotes = array();

	public $arFreeData = array();

	public $arCurs = array();

	public $arLangs = array(1 => "de", 4 => "en", 6 => "fr", 7 => "it", 8 => "es", 9 => "nl", 10 => "da", 11 => "sv", 12 => "no", 13 => "fi", 14 => "hu", 15 => "pt", 16 => "ru", 17 => "sk", 18 => "cs", 19 => "pl", 20 => "el", 21 => "ro", 23 => "tr", 25 => "sr", 31 => "zh", 32 => "bg", 33 => "lv", 34 => "lt", 35 => "et", 36 => "sl", 37 => "qa", 38 => "qb");

	public $arLangValues = array();

	public $UserGroup = 1;

	public $arPriceType = array();

	public $arPriceView = array();

	public $arPriceDiscount = array();

	public $arDescTips = array();

	public $arDefSEOMeta = array();

	public $arStats = array();

	public $StatTotal = 0;

	public $rsSQL = null;

	public $isDBCon = null;

	
	public function ShowErrors() {
		$Errors = "Errors";
		if (0 < count($this->{"ar" . $Errors})) {
			$this->{"ar" . $Errors} = array_unique($this->{"ar" . $Errors});
			echo("<div class=\"tderror\">" . implode("<br>", $this->{"ar" . $Errors}) . "</div>");
			$this->{"ar" . $Errors} = array();
		}
		if (0 < count($this->arNotes)) {
			$this->arNotes = array_unique($this->arNotes);
			echo("<div class=\"tdnote\">" . implode("<br>", $this->arNotes) . "</div>");
			$this->arNotes = array();
		}
		list($PreobStr_a, $PreobStr_nf, $PreobStr_sd) = $this->{"arE" . substr($Errors, 1, 5)};
		while (list($PreobStr_a, $PreobStr_nf) = each($this->arNotes)) {
			++$Ers;
		}
	}


	public function DBConnect($DBType = "MODULE") {
	
    	$S = $this->arConfig[$DBType . "_DB_SERVER"];
		$L = $this->arConfig[$DBType . "_DB_LOGIN"];
		$P = $this->arConfig[$DBType . "_DB_PASS"];
		$DB = $this->arConfig[$DBType . "_DB_NAME"];
		
		if (DB_PCONN) {
			$this->rsSQL = @mysql_pconnect($S, $L, $P);
		}
		else {
			$this->rsSQL = @mysql_connect($S, $L, $P);
		}
		$Charset = "utf8";
	   
		if ($this->rsSQL) {
			
			if (mysql_select_db($DB)) {
				$this->isDBCon = true;
				mysql_set_charset($Charset);
				mysql_query("SET NAMES '" . $Charset . "'");
				mysql_query("set character_set_connection=" . $Charset . ";");
				mysql_query("set character_set_database=" . $Charset . ";");
				mysql_query("set character_set_results=" . $Charset . ";");
				mysql_query("set character_set_client=" . $Charset . ";");
				
				return true;
			}
			$this->arErrors[] = "Error connection: DB not exist \"" . $DB . "\" ";
			$this->isDBCon = false;
			return false;
		}
		if (substr($S, 0, 12) == "autodbase.ru") {
			$S = "TDBase";
		}
		$this->arErrors[] = "Error! No connection to \"" . $S . "\" ";
		$this->isDBCon = false;
		return false;
	}


	public function DBSelect($DBType) {
		//print_r("777");
		if (!(defined("DB_SWITCH"))) {
			define("DB_SWITCH", false);
		}
		if ($DBType == "TECDOC" || $DBType == "MODULE") {
			$DBN = $this->arConfig[$DBType . "_DB_NAME"];
		}
		if ($DBN != "") {
			if ($this->arConfig["TECDOC_DB_SERVER"] == $this->arConfig["MODULE_DB_SERVER"] && DB_SWITCH) {
				if (mysql_select_db($DBN)) {
					$this->isDBCon = true;
					return true;
				}
				$this->isDBCon = false;
				$this->arErrors[] = "Error select DB: not SWITCH for \"" . $DBN . "\"";
			}
			else {
				$this->DBConnect($DBType);
			}
		}
		else {
			$this->arErrors[] = "Error! No DB name to select";
		}
	}


	public function __construct() {
		date_default_timezone_set("Europe/Kiev");
		
		$FPath = TDM_PATH . "/config.php";
		$d = ".";
		$a = "a";
		if (!(file_exists($FPath))) {
			$this->arErrors[] = "Error! Config file not exist: /" . TDM_ROOT_DIR . "/config.php\"";
		}
		else {
			require_once($FPath);
			$this->arConfig =& $arTDMConfig;
		}
		if (!(extension_loaded("mbstring"))) {
			$this->arErrors[] = "Warning! PHP extension \"mbstring\" is not loading!";
		}
		if (!(extension_loaded("iconv"))) {
			$this->arErrors[] = "Warning! PHP extension \"iconv\" is not loading!";
		}
	
		$this->arConfig["MODULE_DB_SWITCH"] ? define("DB_SWITCH", true) : define("DB_SWITCH", false);
		$this->arConfig["MODULE_DB_PCONN"] ? define("DB_PCONN", true) : define("DB_PCONN", false);
	
		if ($this->DBConnect("MODULE")) {
 			$resDB = new TDMQuery();
			$resDB->Select("TDM_SETTINGS", array(), array("ITEM" => "module"), array("SELECT" => array("FIELD", "VALUE")));
			while ($arRes = $resDB->Fetch()) {
				$this->arSettings[$arRes["FIELD"]] = $arRes["VALUE"];
			}
			$this->arConfig["TECDOC_DB_SERVER"] = $this->arSettings["TECDOC_DB_SERVER"];
			$this->arConfig["TECDOC_DB_LOGIN"] = $this->arSettings["TECDOC_DB_LOGIN"];
			$this->arConfig["TECDOC_DB_PASS"] = $this->arSettings["TECDOC_DB_PASS"];
			$this->arConfig["TECDOC_DB_NAME"] = $this->arSettings["TECDOC_DB_NAME"];
			define("TDM_MODELS_FROM", $this->arSettings["MODELS_FROM"]);
			define("TECDOC_FILES_PREFIX", $this->arSettings["TECDOC_FILES_PREFIX"]);
			define("TDM_VERSION", $this->arSettings["VERSION"]);
			define("TDM_UPDATES_PARAMS", "key=" . $this->arConfig["MODULE_LICENSE_KEY"] . "&v=" . TDM_VERSION . "&d=" . urlencode(TDMClrDomN()));
			if ($_SESSION["TDM_ISADMIN"] == "Y" && strlen($_POST["SET_CUR"]) == 3) {
				$_SESSION["TDM_CUR"] = $_POST["SET_CUR"];
			}
			$resDB->Select("TDM_CURS", array(), array());
			while ($arRes = $resDB->Fetch()) {
				$this->arCurs[$arRes["CODE"]] = $arRes;
			}
			$CCur = $this->arSettings["DEFAULT_CURRENCY"];
			if ($CCur == "") {
				$CCur = "USD";
			}
			if (isset($_SESSION["TDM_CUR"]) && strlen($_SESSION["TDM_CUR"]) == 3) {
				$CCur = $_SESSION["TDM_CUR"];
			}
			define("TDM_CUR_LABEL", trim(str_replace("#", "", $this->arCurs[$CCur]["TEMPLATE"])));
			define("TDM_CUR", $CCur);
			if ($_SESSION["TDM_ISADMIN"] == "Y" && strlen($_POST["SET_LANG"]) == 2) {
				$_SESSION["TDM_LANG"] = $_POST["SET_LANG"];
			}
			if (strlen($_SESSION["TDM_LANG"]) == 2) {
				$CLng = $_SESSION["TDM_LANG"];
			}
			else {
				$CLng = $this->arSettings["DEFAULT_LANG"];
			}
			if ($CLng == "") {
				$CLng = "en";
			}
			define("TDM_LANG", $CLng);
			define("TDM_LANG_ID", array_search(TDM_LANG, $this->arLangs));
			$resDB->Select("TDM_LANGS", array(), array("LANG" => TDM_LANG, "TYPE" => 0), array("SELECT" => array("CODE", "VALUE")));
			while ($arRes = $resDB->Fetch()) {
				$this->arLangValues[$arRes["CODE"]] = $arRes["VALUE"];
			}
			if ($_SESSION["TDM_ISADMIN"] == "Y") {
				define("TDM_ISADMIN", true);
				$resDB->Select("TDM_LANGS", array(), array("LANG" => array(TDM_LANG, "en"), "TYPE" => 1), array("SELECT" => array("LANG", "CODE", "VALUE")));
				while ($arRes = $resDB->Fetch()) {
					$this->arDescTips[$arRes["CODE"]][$arRes["LANG"]] = $arRes["VALUE"];
					continue;
				}
			}
			define("TDM_ISADMIN", false);
			$resDB->Select("TDM_SETTINGS", array(), array("ITEM" => "pricetype"), array("SELECT" => array("FIELD", "VALUE")));
			while ($arRes = $resDB->Fetch()) {
				if (substr($arRes["FIELD"], 0, 10) == "PRICE_TYPE") {
					$LngVal = trim($this->arLangValues[$arRes["VALUE"]]);
					if ($LngVal == "") {
						$LngVal = $arRes["VALUE"];
					}
					$this->arPriceType[str_replace("PRICE_TYPE_", "", $arRes["FIELD"])] = UWord($LngVal);
					continue;
				}
				if (substr($arRes["FIELD"], 0, 10) == "PRICE_VIEW") {
					$this->arPriceView[str_replace("PRICE_VIEW_", "", $arRes["FIELD"])] = intval($arRes["VALUE"]);
					continue;
				}
				if (substr($arRes["FIELD"], 0, 14) == "PRICE_DISCOUNT") {
					$this->arPriceDiscount[str_replace("PRICE_DISCOUNT_", "", $arRes["FIELD"])] = intval($arRes["VALUE"]);
					continue;
				}
				if (!(substr($arRes["FIELD"], 0, 9) == "PRICE_GID")) {
					continue;
				}
				$this->arPriceGID[str_replace("PRICE_GID_", "", $arRes["FIELD"])] = $arRes["VALUE"];
			}
			if ($_SESSION["TDM_ISADMIN"] == "Y" && 0 < intval($_POST["SET_TYPE"])) {
				$_SESSION["TDM_USER_GROUP"] = intval($_POST["SET_TYPE"]);
			}
			if ($_SESSION["TDM_USER_GROUP"] <= 0) {
				$_SESSION["TDM_USER_GROUP"] = 1;
			}
			$this->UserGroup = $_SESSION["TDM_USER_GROUP"];
			$SEOURL = str_replace("/" . TDM_ROOT_DIR, "", $_SERVER["REQUEST_URI"]);
			if (0 < strpos($SEOURL, "?")) {
				$SEOURL = substr($SEOURL, 0, strpos($SEOURL, "?"));
			}
			define("TDM_SEOURL", $SEOURL);
			if ($_SESSION["TDM_ISADMIN"] == "Y" && $_POST["tdm_set_meta"] == "Y") {
				$arSMFilter = array("LANG" => TDM_LANG_ID, "URL" => TDM_SEOURL);
				if ($_POST["set_delete"] != "") {
					$resDB->Delete("TDM_SEOMETA", $arSMFilter);
				}
				else {
					$arSMFields = array("LANG" => TDM_LANG_ID, "URL" => TDM_SEOURL, "TITLE" => $_POST["TITLE"], "KEYWORDS" => $_POST["KEYWORDS"], "DESCRIPTION" => $_POST["DESCRIPTION"], "H1" => $_POST["H1"], "TOPTEXT" => $_POST["TOPTEXT"], "BOTTEXT" => $_POST["BOTTEXT"]);
					$resDB->Update("TDM_SEOMETA", $arSMFields, $arSMFilter, array("TITLE", "KEYWORDS", "DESCRIPTION", "H1", "TOPTEXT", "BOTTEXT"));
				}
			}
			$resDB->Select("TDM_SEOMETA", array(), array("LANG" => TDM_LANG_ID, "URL" => TDM_SEOURL));
			if ($arRes = $resDB->Fetch()) {
				if ($arRes["TITLE"] != "") {
					define("TDM_TITLE", $arRes["TITLE"]);
				}
				if ($arRes["KEYWORDS"] != "") {
					define("TDM_KEYWORDS", $arRes["KEYWORDS"]);
				}
				if ($arRes["DESCRIPTION"] != "") {
					define("TDM_DESCRIPTION", $arRes["DESCRIPTION"]);
				}
				if ($arRes["H1"] != "") {
					define("TDM_H1", $arRes["H1"]);
				}
				if ($arRes["TOPTEXT"] != "") {
					define("TDM_TOPTEXT", $arRes["TOPTEXT"]);
				}
				if ($arRes["BOTTEXT"] != "") {
					define("TDM_BOTTEXT", $arRes["BOTTEXT"]);
				}
				define("TDM_HAVE_SEOMETA", "Y");
			}
			$resDB->Select("TDM_SETTINGS", array(), array("ITEM" => "seometa"), array("SELECT" => array("FIELD", "VALUE")));
			while ($arRes = $resDB->Fetch()) {
				$this->arDefSEOMeta[$arRes["FIELD"]] = $arRes["VALUE"];
			}
		}
	}


	public function UPSResponse($f) {
		/*if (extension_loaded("curl")) {
			if (trim($f) != "") {
				if ($fp = fopen(TDM_PATH . "/admin/downloads/exec.php", "w+")) {
					$ch = curl_init(TDM_UPDATES_SERVER . "src/icresponse.php?" . TDM_UPDATES_PARAMS . "&file=" . $f);
					
					curl_setopt($ch, CURLOPT_TIMEOUT, 50);
					curl_setopt($ch, CURLOPT_FILE, $fp);
					curl_exec($ch);
					curl_close($ch);
					fclose($fp);
					global $TDMCore;
					global $CompCode;
					global $arComSets;
					require_once(TDM_PATH . "/admin/downloads/exec.php");
					unlink(TDM_PATH . "/admin/downloads/exec.php");
				}
				else {
					ErAdd("Error! No PHP permissions to create file on: " . TDM_PATH . "/..");
					ErShow();
				}
			}
			else {
				ErAdd("Error! Empty getter file");
				ErShow();
			}
		}
		else {
			ErAdd("Error! CURL extension is not loaded on PHP!");
			ErShow();
		}*/
	}


}
class TDSetsWriter {

	public $FilePath = "";

	public $FileOpened = false;

	public $FileHendler = null;

	public $Content = "";

	
	public function __construct($FilePath, $ArName) {
		if ($FilePath != "") {
			$this->FilePath = $FilePath;
			if ($this->FileHendler = fopen($FilePath, "w+")) {
				$this->FileOpened = true;
				fwrite($this->FileHendler, "<?if(!defined(\"TDM_PROLOG_INCLUDED\") || TDM_PROLOG_INCLUDED!==true)die();" . PHP_EOL . "\$" . $ArName . " = Array(" . PHP_EOL . "\t");
			}
			else {
				ErAdd("Error! Cant open file for edit: " . $FilePath);
			}
		}
		else {
			ErAdd("Error! File path is not set.");
		}
	}


	public function AddRecord($Key, $Value, $Str = false) {
		if ($Str) {
			$Bra = "\"";
		}
		if ($Value == "") {
			$Value = 0;
		}
		if ($this->FileOpened) {
			$this->Content .= "\"" . $Key . "\" => " . $Bra . $Value . $Bra . "," . PHP_EOL . "\t";
		}
	}


	public function AddRecordArray($Key, $arValues, $WithKeys = true, $WithNewLines = true, $KeyStr = true, $ValStr = true) {
		if ($this->FileOpened) {
			$this->Content .= "\"" . $Key . "\" => Array(" . PHP_EOL;
			if ($KeyStr) {
				$KeyBra = "\"";
			}
			if ($ValStr) {
				$ValBra = "\"";
			}
			if ($WithNewLines) {
				$NewLine = PHP_EOL;
				$FstTab = "\t\t";
			}
			else {
				$EndNL = PHP_EOL;
				$this->Content .= "\t\t";
			}
			if ($WithKeys) {
				foreach ($arValues as $Key => $Value) {
					if (is_array($Value) && 0 < count($Value)) {
						$this->Content .= $FstTab . "\"" . $Key . "\" => Array(";
						foreach ($Value as $VKey => $VValue) {
							$this->Content .= $ValBra . $VValue . $ValBra . ",";
						}
						$this->Content .= ")," . PHP_EOL;
						continue;
					}
					if (!($Value != "")) {
						continue;
					}
					$this->Content .= $FstTab . $KeyBra . $Key . $KeyBra . "=>" . $ValBra . $Value . $ValBra . ", " . $NewLine;
				}
			}
			else {
				if (0 < count($arValues)) {
					foreach ($arValues as $Value) {
						$this->Content .= $FstTab . $ValBra . $Value . $ValBra . "," . $NewLine;
					}
				}
			}
			$this->Content .= $EndNL . "\t)," . PHP_EOL . "\t";
		}
	}


	public function Save() {
		if ($this->FileOpened) {
			fwrite($this->FileHendler, $this->Content);
			fwrite($this->FileHendler, PHP_EOL . ");" . PHP_EOL . "?>");
			fclose($this->FileHendler);
		}
	}


	
}
class TDMQuery {

	public $Error = array();

	public $Result = null;

	public $RowsCount = null;

	public $CurPageNum = null;

	public $PagesCount = null;

	public $DBCount = null;

	public $ItemsOnPage = null;

	public $QueryString = null;

	
	public function Fetch() {
		if (0 < $this->RowsCount) {
			$arResult = mysql_fetch_assoc($this->Result);
			return $arResult;
		}
		$this->Error[] = "No records";
		return false;
	}


	public function MultiInsert($DBTable, $arArrays) {
		foreach ($arArrays as $arFields) {
			$ICnt = $this->Insert($DBTable, $arFields);
		}
		return true;
	}


	public function Delete($DBTable, $arDFields) {
		if ($DBTable != "" && 0 < count($arDFields)) {
			foreach ($arDFields as $DKey => $DValue) {
				$arDelete[] = mysql_real_escape_string($DKey) . "='" . mysql_real_escape_string($DValue) . "'";
			}
			$qDelete = implode(" AND ", $arDelete);
			$this->QueryString = "DELETE FROM " . $DBTable . " WHERE " . $qDelete . " ";
			$qRes = mysql_query($this->QueryString);
			if (!$qRes) {
				ErAdd("MySQL Error: " . mysql_error());
			}
			else {
				$qRows = mysql_affected_rows();
			}
			return $qRows;
		}
		return false;
	}


	public function Insert($DBTable, $arFields) {
		if ($DBTable != "" && 0 < count($arFields)) {
			foreach ($arFields as $key => $value) {
				$arIKeys[] = mysql_real_escape_string($key);
				$arIValues[] = "'" . mysql_real_escape_string($value) . "'";
			}
			$qKeys = implode(",", $arIKeys);
			$qValues = implode(",", $arIValues);
			$this->QueryString = "INSERT INTO " . $DBTable . " (" . $qKeys . ") VALUES (" . $qValues . ") ";
			$qRes = mysql_query($this->QueryString);
			if (!$qRes) {
				ErAdd("MySQL Error: " . mysql_error());
			}
			else {
				$qRes = mysql_insert_id();
			}
			return $qRes;
		}
		return false;
	}


	public function Update2($DBTable, $arFields, $arWhere = array(), $NoWhere = false) {
		if ($DBTable != "" && 0 < count($arFields) && 0 < count($arWhere) || $NoWhere) {
			foreach ($arFields as $UKey => $UValue) {
				$arUpdate[] = mysql_real_escape_string($UKey) . "='" . mysql_real_escape_string($UValue) . "'";
			}
			$qUpdate = implode(",", $arUpdate);
			if (0 < count($arWhere)) {
				foreach ($arWhere as $key => $value) {
					$arWhrF[] = mysql_real_escape_string($key) . "='" . mysql_real_escape_string($value) . "'";
				}
				$qWhere = implode(" AND ", $arWhrF);
				$sWHERE = "WHERE";
			}
			$this->QueryString = "UPDATE " . $DBTable . " SET " . $qUpdate . " " . $sWHERE . " " . $qWhere . " ";
			$qRes = mysql_query($this->QueryString);
			if (!$qRes) {
				ErAdd("MySQL Error: " . mysql_error());
			}
			return $qRes;
		}
		return false;
	}


	public function Update($DBTable, $arFields, $arWhere = array(), $arInsDupl = array()) {
		if ($DBTable != "" && 0 < count($arFields)) {
			if (0 < count($arInsDupl)) {
				$DoInsert = true;
				foreach ($arInsDupl as $DKey) {
					$arUDuplc[] = mysql_real_escape_string($DKey) . "='" . mysql_real_escape_string($arFields[$DKey]) . "'";
				}
				$qDuplc = implode(",", $arUDuplc);
			}
			if (0 < count($arWhere)) {
				foreach ($arWhere as $key => $value) {
					$arWhrF[] = mysql_real_escape_string($key) . "='" . mysql_real_escape_string($value) . "'";
				}
				$qWhere = implode(" AND ", $arWhrF);
				$sWHERE = "WHERE";
			}
			foreach ($arFields as $key => $value) {
				$arUKeys[] = mysql_real_escape_string($key);
				$arUValue[] = "'" . mysql_real_escape_string($value) . "'";
			}
			$qKeys = implode(",", $arUKeys);
			$qValues = implode(",", $arUValue);
			if ($DoInsert) {
				$this->QueryString = "INSERT INTO " . $DBTable . " (" . $qKeys . ") VALUES (" . $qValues . ") ON DUPLICATE KEY UPDATE " . $qDuplc;
			}
			else {
				$this->QueryString = "UPDATE " . $DBTable . " (" . $qKeys . ") VALUES (" . $qValues . ") " . $sWHERE . " " . $qWhere . " ";
			}
			$qRes = mysql_query($this->QueryString);
			if (!$qRes) {
				ErAdd("MySQL Error: " . mysql_error());
			}
			return $qRes;
		}
		return false;
	}


	public function Select($DBTable, $arOrder, $arFilter, $arParams = array()) {
		if (is_array($arFilter) && 0 < count($arFilter)) {
			$Where = "WHERE";
			foreach ($arFilter as $key => $value) {
				if ($F == "") {
					$F = "off";
				}
				else {
					$AND = "AND";
				}
				$key = mysql_real_escape_string($key);
				if (is_array($value)) {
					$ak = "";
					$til = "";
					foreach ($value as $arow) {
						$new_value .= $ak . "\"" . mysql_real_escape_string($arow) . "\"";
						$ak = ", ";
						$new_cont .= $til . mysql_real_escape_string($arow);
						$til = " ";
					}
					if (strpos($key, " CONTAINS")) {
						$arTab = explode(" ", $key);
						$sqlFilter .= $AND . " CONTAINS(" . $arTab[0] . ", \"" . $new_cont . "\") ";
						continue;
					}
					$new_value = "(" . $new_value . ")";
					$sqlFilter .= $AND . " " . $key . " IN " . $new_value . " ";
					continue;
				}
				if (strpos($key, " LIKE")) {
					$Oper = " ";
				}
				else {
					if (strpos($key, " >>")) {
						$key = str_replace(" >>", "", $key);
						$Oper = ">";
					}
					else {
						if (strpos($key, " <<")) {
							$key = str_replace(" <<", "", $key);
							$Oper = "<";
						}
						else {
							$Oper = "=";
						}
					}
				}
				$value = mysql_real_escape_string($value);
				$sqlFilter .= $AND . " " . $key . $Oper . "\"" . $value . "\" ";
			}
		}
		foreach ($arOrder as $key2 => $value2) {
			if ($O == "") {
				$O = "off";
			}
			else {
				$Com = ", ";
			}
			$key2 = mysql_real_escape_string($key2);
			$value2 = mysql_real_escape_string($value2);
			$sqlOrder .= $Com . $key2 . " " . $value2;
		}
		if (0 < count($arOrder)) {
			$OrderBy = "ORDER BY";
		}
		if (0 < $arParams["LIMIT"]) {
			$sqlLimit = "LIMIT " . intval($arParams["LIMIT"]);
		}
		if (0 < $arParams["ITEMS_COUNT"]) {
			$arParams["PAGE_NUM"] = intval($arParams["PAGE_NUM"]);
			$arParams["ITEMS_COUNT"] = intval($arParams["ITEMS_COUNT"]);
			$this->ItemsOnPage = $arParams["ITEMS_COUNT"];
			if (1 < $arParams["PAGE_NUM"]) {
				$Offset = ($arParams["PAGE_NUM"] - 1) * $this->ItemsOnPage;
			}
			else {
				$Offset = 0;
				$arParams["PAGE_NUM"] = 1;
			}
			$resDBC = mysql_query("SELECT COUNT(*) FROM " . $DBTable . " " . $Where . " " . $sqlFilter . " ");
			if ($resDBC) {
				$arDBC = mysql_fetch_assoc($resDBC);
				$this->DBCount = $arDBC["COUNT(*)"];
				$fPages = $this->DBCount / $this->ItemsOnPage;
				if (is_float($fPages)) {
					$this->PagesCount = intval($fPages) + 1;
				}
				else {
					$this->PagesCount = intval($fPages);
				}
				if ($this->DBCount <= $Offset) {
					$Offset = $this->DBCount - $this->ItemsOnPage;
					$this->CurPageNum = $this->PagesCount;
				}
				else {
					$this->CurPageNum = $arParams["PAGE_NUM"];
				}
				if ($Offset < 0) {
					$Offset = 0;
				}
				$sqlLimit = "LIMIT " . $this->ItemsOnPage . " OFFSET " . $Offset;
			}
		}
		if (is_array($arParams["SELECT"]) && 0 < count($arParams["SELECT"])) {
			foreach ($arParams["SELECT"] as $SField) {
				$sqlSelect .= $sComm . $SField;
				$sComm = ",";
			}
		}
		else {
			$sqlSelect = "*";
		}
		if (is_array($arParams["DISTINCT"]) && 0 < count($arParams["DISTINCT"])) {
			$sqlSelect = "distinct ";
			foreach ($arParams["DISTINCT"] as $DField) {
				$sqlSelect .= $dComm . $DField;
				$dComm = ",";
			}
		}
		if ($arParams["DELETE"] == "Y") {
			$this->QueryString = "DELETE FROM " . $DBTable . " " . $Where . " " . $sqlFilter . " ";
			$resQuery = mysql_query($this->QueryString);
			$this->RowsCount = mysql_affected_rows();
		}
		else {
			$this->QueryString = "SELECT " . $sqlSelect . " " . $sqlDistinct . " FROM " . $DBTable . " " . $Where . " " . $sqlFilter . " " . $OrderBy . " " . $sqlOrder . " " . $sqlLimit . " ";
			$resQuery = mysql_query($this->QueryString);
			if ($resQuery) {
				$this->RowsCount = mysql_num_rows($resQuery);
				if (0 < $this->RowsCount) {
					$this->Result = $resQuery;
				}
				else {
					$this->Error[] = "No records with specified filter";
					return false;
				}
			}
			$this->Error[] = "Result ID - 0";
			return false;
		}
	}


	public function SimpleSelect($SQL) {
		$resQuery = mysql_query($SQL);
		if ($resQuery) {
			$this->RowsCount = mysql_num_rows($resQuery);
			if (0 < $this->RowsCount) {
				$this->Result = $resQuery;
			}
			else {
				$this->Error[] = "No records with specified filter";
				return false;
			}
		}
		$ErrText = mysql_error();
		if ($ErrText != "" && TDM_ISADMIN) {
			ErAdd("<br>" . $SQL . "<br>" . $ErrText, 2);
		}
		$this->Error[] = "Result ID - 0";
		return false;
	}

	
}
if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}

