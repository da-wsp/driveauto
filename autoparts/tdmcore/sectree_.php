<?php

define("TDM_PROLOG_INCLUDED", true);
define("TDM_ROOT_DIR", $_REQUEST["rd"]);
define("TDM_PATH", $_SERVER["DOCUMENT_ROOT"] . "/" . TDM_ROOT_DIR);
session_start();
require_once("classes.php");
require_once("tdquery.php");
require_once("functions.php");
header("Content-type: text/html; charset=utf-8");
global $arTDMConfig;
global $TDMCore;
$TDMCore = new TDMCore();
$TDMCore->DBConnect("TECDOC");
$Brand = substr($_REQUEST["brand"], 0, 18);
$MOD_ID = intval(substr($_REQUEST["model"], 0, 9));
$TYP_ID = intval(substr($_REQUEST["type"], 0, 9));
$Ubrand = strtoupper($Brand);
if (0 < strlen($Brand)) {
	$rsManuf = TDSQL::GetManufByCode($Ubrand);
	if ($arManuf = $rsManuf->Fetch()) {
		$rsModel = TDSQL::GetModelByID($arManuf["MFA_ID"], $MOD_ID);
		if ($arModel = $rsModel->Fetch()) {
			$rsType = TDSQL::GetTypeByID($arModel["MOD_ID"], $TYP_ID);
			if ($arType = $rsType->Fetch()) {
				echo("[");
				if (0 < $_REQUEST["id"]) {
					$Node = intval($_REQUEST["id"]);
				}
				else {
					$Node = 10001;
				}
				$rsSecR = TDSQL::GetSections($arType["TYP_ID"], $Node);
				while ($arSecR = $rsSecR->Fetch()) {
					$arSecR["NAME"] = UWord($arSecR["STR_DES_TEXT"]);
					$Children = "";
					if (0 < $arSecR["DESCENDANTS"]) {
						if ($_REQUEST["sec"] == $arSecR["STR_ID"]) {
							$State = ", \"state\": \"open\"";
							$Children = ", \"children\":[";
							$rsSecSub = TDSQL::GetSections($arType["TYP_ID"], $arSecR["STR_ID"]);
							while ($arSecSub = $rsSecSub->Fetch()) {
								$arSecSub["NAME"] = UWord($arSecSub["STR_DES_TEXT"]);
								if (0 < $arSecSub["DESCENDANTS"]) {
									$State2 = ", \"state\": \"closed\"";
									$Icon2 = ", \"rel\":\"folder\"";
								}
								else {
									$Href2 = ", \"href\": \"/" . TDM_ROOT_DIR . "/model/" . $Brand . "/m" . $MOD_ID . "/t" . $TYP_ID . "/s" . $arSecSub["STR_ID"] . "/\"";
									$State2 = ", \"state\": \"\"";
									$Icon2 = ", \"rel\":\"file\"";
								}
								$Children .= $Comma2 . "{\"data\":\"" . $arSecSub["NAME"] . "\", \"attr\": {\"id\":\"" . $arSecSub["STR_ID"] . "\"" . $Icon2 . $Href2 . "}" . $State2 . "}";
								$Comma2 = ", ";
							}
							$Children .= "]";
						}
						else {
							$State = ", \"state\": \"closed\"";
						}
						$Icon = ", \"rel\":\"folder\"";
					}
					else {
						$Href = ", \"href\": \"/" . TDM_ROOT_DIR . "/" . $Brand . "/" . $_REQUEST["mod_name"] . "/" . $_REQUEST["type_name"] . "/?of=m" . $MOD_ID . ";t" . $TYP_ID . ";s" . $arSecR["STR_ID"] . "\"";
						$State = ", \"state\": \"\"";
						$Icon = ", \"rel\":\"file\"";
					}
					echo($Comma . "{\"data\":\"" . $arSecR["NAME"] . "\", \"attr\": {\"id\":\"" . $arSecR["STR_ID"] . "\"" . $Icon . $Href . "}" . $State . $Children . "}");
					$Comma = ", ";
				}
				echo("]");
			}
			else {
				echo("[\"Error There is no types of brand\"]");
			}
		}
		else {
			echo("[\"Error There is no model\"]");
		}
	}
	else {
		echo("[\"Error There is no brand\"]");
	}
}
else {
	echo("[\"Error Brand not specified\"]");
}

