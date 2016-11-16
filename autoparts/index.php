<?php



namespace tdmcore {

abstract class RootSet {

	static private $Selfins = null;

	protected $templ = null;

	
	static public function GetChimm() {
		self::$Selfins = new static();
		self::$Selfins->templ = get_called_class() . " " . "\RootSet";
		return self::$Selfins;
	}


	
}
} /* namespace tdmcore */

namespace tdmcore {
	define("TDM_PROLOG_INCLUDED", true);
	require_once("tdmcore/defines.php");
	/*$Mdom = function ($n) {
			static $Mdom;
			$arFpth = array(TDM_PATH . "/public_key.php");
			return true;
			/*while (list($n1, $pth) = each($arFpth)) {
				
				if (file_exists($pth)) {
					$pkey = substr(file_get_contents($pth), 0, 64);
					exit();
					if (trait_exists("\RootSet", FALSE) || true && !(defined("TDM_DOMAIN")) && define("TDM_DOMAIN", $_SERVER["SERVER_NAME"])) {
						TDM_DOMAIN ? $pkey : print("Error TDM_D");
						TDM_DOMAIN;
						$ms = str_replace("www.", "", TDM_DOMAIN);
						if ($pkey == md5("1480983" . $ms . "4572889")) {
							return true;
						}
						$err .= "Error! Authentication is false for <b>" . $ms . "</b> <br>";
						continue;
					}
					$err .= "Error! Invalid domain name <br>";
					continue;
				}
				$err .= "Error! Public key file not exist<br>";
			}
			echo("<link rel=\"stylesheet\" href=\"/" . TDM_ROOT_DIR . "/styles.css\" type=\"text/css\">");
			echo("<div style=\"width:980px; margin:0px auto 0px auto;\"><div class=\"tderror\">" . $err . "</div></div>");
			//unset($ms);
			//exit();
			//exit();
		}*/

	//$Mdom(0);
	//unset($Mdom);
	global $TDMContent;
	global $TDMAPanel;
	global $TDMTop;
	global $TDMComponent;
	ob_start();
	require_once("tdmcore/init.php");
	require_once("urlrewrite.php");
	foreach ($arUrlRewrite as $arVal) {
		if (!(preg_match($arVal["CONDITION"], $_SERVER["REQUEST_URI"]))) {
			continue;
		}
		$pURL = preg_replace($arVal["CONDITION"], $arVal["RULE"], $_SERVER["REQUEST_URI"]);
		$CacheName = preg_replace($arVal["CONDITION"], $arVal["CACHE"], $_SERVER["REQUEST_URI"]);
		parse_str($pURL, $vars);
		$_GET += $vars;
		$_REQUEST += $vars;
		$GLOBALS += $vars;
		break;
	}
	if (0 < $_REQUEST["ID"] && $_REQUEST["KEY"] != "") {
		chdir(TDM_PATH . "/admin/import/");
		require_once(TDM_PATH . "/admin/import/run.php");
		exit();
	}
	require_once("includes.php");
	if ($_REQUEST["com"] != "") {
		$arComSets = TDMGetSets($_REQUEST["com"]);
		if ($arComSets) {
			$CachePath = TDM_PATH . "/tdmcore/cache/" . $_REQUEST["com"] . "/" . $CacheName . "_" . TDM_LANG . ".php";
			if ($TDMCore->arSettings["USE_CACHE"] && $arComSets["CACHE"] && ErCheck()) {
				if (file_exists($CachePath)) {
					if ($_POST["recache"] == "Y" && $_SESSION["TDM_ISADMIN"] == "Y") {
						array_map("unlink", glob(TDM_PATH . "/tdmcore/cache/" . $_REQUEST["com"] . "/*"));
					}
					else {
						define("TDM_CCACHE_INCLUDED", true);
					}
				}
			}
			$TDMTop = GetPHPCached();
			if ($_SESSION["TDM_ISADMIN"] == "Y") {
				require_once("admin/apanel.php");
				$TDMAPanel = GetPHPCached();
			}
			if (defined("TDM_CCACHE_INCLUDED")) {
				require_once($CachePath);
			}
			else {
				$ComPath = TDM_PATH . "/tdmcore/components/" . $_REQUEST["com"] . "/component.php";
				if (file_exists($ComPath)) {
					$TScriptName = "template";
					require_once($ComPath);
					ErShow();
					if ($_REQUEST["com"] == "searchparts" || $_REQUEST["com"] == "sectionparts" || $_REQUEST["com"] == "analogparts") {
						$TemType = "partslist";
					}
					else {
						$TemType = $_REQUEST["com"];
					}
					$TemPath = TDM_PATH . "/templates/" . $TemType . "/" . $arComSets["TEMPLATE"] . "/" . $TScriptName . ".php";
					if (file_exists($TemPath)) {
						$StylPath = TDM_PATH . "/templates/" . $TemType . "/" . $arComSets["TEMPLATE"] . "/style.css";
						if (file_exists($StylPath)) {
							echo("<link rel=\"stylesheet\" href=\"/" . TDM_ROOT_DIR . "/templates/" . $TemType . "/" . $arComSets["TEMPLATE"] . "/style.css\" type=\"text/css\">");
						}
						$JsPath = TDM_PATH . "/templates/" . $TemType . "/" . $arComSets["TEMPLATE"] . "/funcs.js";
						if (file_exists($JsPath)) {
							echo("<script src=\"/" . TDM_ROOT_DIR . "/templates/" . $TemType . "/" . $arComSets["TEMPLATE"] . "/funcs.js\"></script>");
						}
						require_once($TemPath);
						if ($TDMCore->arSettings["USE_CACHE"] && $arComSets["CACHE"] && ErCheck()) {
							$CDir = dirname($CachePath);
							if (!(is_dir($CDir))) {
								mkdir($CDir, 493, true);
							}
							if ($cHand = fopen($CachePath, "w")) {
								$CachMeta = GetComMetaForCache();
								fwrite($cHand, $CachMeta . ob_get_contents());
								fclose($cHand);
							}
						}
					}
					else {
						ErAdd("Components \"" . $_REQUEST["com"] . "\" - template \"" . $arComSets["TEMPLATE"] . "\" not exists...");
					}
				}
				else {
					ErAdd("Component \"" . $_REQUEST["com"] . "\" not exists...");
				}
			}
			$TDMComponent = GetPHPCached();
		}
		else {
			ErAdd("No settings file associated with component \"" . $_REQUEST["com"] . "\" ");
		}
	}
	else {
		ErAdd("No component name associated with FURL...");
	}
	if ($TDMCore->arSettings["SHOW_SEARCHFORM"] == 1) {
		require_once("searchform.php");
	}
	ErShow();
	global $TDMContent;
	$TDMContent .= $TDMTop;
	if ($TDMCore->arSettings["APANEL_POSITION"] != "Bottom") {
		$TDMContent .= $TDMAPanel;
	}
	$TDMContent .= "<div class=\"tdm_content\">";
	$TDMContent .= GetPHPCached();
	$TDMContent .= $TDMComponent;
	$TDMContent .= "<div class=\"tclear\"></div>";
	if ($_SESSION["TDM_ISADMIN"] == "Y" && $TDMCore->arSettings["SHOW_STAT"] == 1) {
		$TDMContent .= TDMShowStat();
	}
	$TDMContent .= "</div>";
	if ($TDMCore->arSettings["APANEL_POSITION"] == "Bottom") {
		$TDMContent .= $TDMAPanel;
	}
	if (defined("TDM_VERSION")) {
		$TDMContent .= "<a href=\"http://tecdoc-module.com\" target=\"_blank\" class=\"tdmversion\" title=\"" . TDM_VERSION . "\">&nbsp;</a><style>.tdmversion{font-size:10px; display:block; color:#c1c1c1!important; float:right; margin:8px;}</style>";
	}
	ob_end_clean();
	if ($TDMCore->arSettings["CMS_INTEGRATION"] == "") {
		$TDMCore->arSettings["CMS_INTEGRATION"] = "NoCMS";
	}
	require_once(TDM_PATH . "/tocms/" . $TDMCore->arSettings["CMS_INTEGRATION"] . ".php");
}

