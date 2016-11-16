<?php

function TDMPrepareSubSection($arSec, $arComSets) {
	if (!(in_array($arSec["STR_ID"], $arComSets["PARENT"]))) {
		if (array_key_exists($arSec["STR_ID"], $arComSets["CODE"])) {
			$arSec["URL"] = $arComSets["CODE"][$arSec["STR_ID"]] . "/?of=m" . intval($_REQUEST["mod_id"]) . ";t" . intval($_REQUEST["type_id"]) . ";s" . $arSec["STR_ID"];
		}
	}
	if (array_key_exists($arSec["STR_ID"], $arComSets["NAME"])) {
		$arSec["NAME"] = Lng($arComSets["NAME"][$arSec["STR_ID"]], 0, 0);
	}
	else {
		$arSec["NAME"] = UWord($arSec["STR_DES_TEXT"]);
	}
	if (TDM_ISADMIN) {
		$arSec["TITLE"] = "Section ID: " . $arSec["STR_ID"];
	}
	else {
		$arSec["TITLE"] = "";
	}
	return $arSec;
}

if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}
$arBrnd = GetURLBrand();
$arResult["UBRAND"] = $arBrnd["uname"];
$arResult["BRAND"] = $arBrnd["name"];
$MOD_ID = intval($_REQUEST["mod_id"]);
$TYP_ID = intval($_REQUEST["type_id"]);
$SEC_ID = intval($_REQUEST["sec_id"]);
$arResult["SECTIONS"] = array();
if ($arResult["UBRAND"]) {
	$TDMCore->DBSelect("TECDOC");
	TDMSetTime();
	$rsManuf = TDSQL::GetManufByCode($arResult["UBRAND"]);
	TDMSetTime("GetManufByCode");
	if ($arManuf = $rsManuf->Fetch()) {
		$arResult["MFA_MFC_CODE"] = $arManuf["MFA_MFC_CODE"];
		$rsModel = TDSQL::GetModelByID($arManuf["MFA_ID"], $MOD_ID);
		TDMSetTime("GetModelByID");
		if ($arModel = $rsModel->Fetch()) {
			$arResult["MOD_ID"] = $arModel["MOD_ID"];
			$DateFr = TDDateFormat($arModel["MOD_PCON_START"], Lng("to_pt"), "year");
			$DateTo = TDDateFormat($arModel["MOD_PCON_END"], Lng("to_pt"), "year");
			$arResult["MODEL"] = $arModel["MOD_CDS_TEXT"];
			$arResult["YEAR"] = "(" . $DateFr . " - " . $DateTo . ")";
			$rsType = TDSQL::GetTypeByID($arModel["MOD_ID"], $TYP_ID);
			TDMSetTime("GetTypeByID");
			if ($arType = $rsType->Fetch()) {
				$arResult["TYPE_ID"] = $arType["TYP_ID"];
				$BrandLogoSrc = "/" . TDM_ROOT_DIR . "/media/brands/90/" . $arResult["MFA_MFC_CODE"] . ".png";
				if (file_exists($_SERVER["DOCUMENT_ROOT"] . $BrandLogoSrc)) {
					$arResult["BRAND_LOGO_SRC"] = $BrandLogoSrc;
				}
				else {
					$arResult["BRAND_LOGO_SRC"] = "/" . TDM_ROOT_DIR . "/media/brands/" . $arResult["MFA_MFC_CODE"] . ".png";
				}
				$arRComSets = TDMGetSets("sections");
				$arResult["SECTION_NAME"] = Lng($arRComSets["NAME"][$SEC_ID], 0, 0);
				$arResult["RSEC_LINK"] = "/" . TDM_ROOT_DIR . "/" . $_REQUEST["brand"] . "/" . $_REQUEST["mod_name"] . "/" . $_REQUEST["type_name"] . "/";
				$arResult["CSEC_LINK"] = $arResult["RSEC_LINK"] . $_REQUEST["sec_name"] . "/";
				if (is_array($_SESSION["TDM_LAST_RSECTIONS_ARIDS"])) {
					foreach ($_SESSION["TDM_LAST_RSECTIONS_ARIDS"] as $RLSID) {
						$RLink = $arResult["RSEC_LINK"] . $arRComSets["CODE"][$RLSID] . "/?of=m" . $_REQUEST["mod_id"] . ";t" . $_REQUEST["type_id"] . ";s" . $RLSID;
						if ($RLSID == $SEC_ID) {
							$RActive = "Y";
							$RLink = "javascript:void(0)";
						}
						else {
							$RActive = "N";
						}
						$arResult["ROOT_SECTIONS"][] = array("ACTIVE" => $RActive, "NAME" => Lng($arRComSets["NAME"][$RLSID], 0, 0), "LINK" => $RLink);
					}
				}
				else {
					$arComSets["CACHE"] = 0;
				}
				$TDMCore->arFreeData["TD_SEC_NAME"] = $arResult["SECTION_NAME"];
				$TDMCore->arFreeData["TD_SEC_RSID"] = $SEC_ID;
				$SPicSrc = "/" . TDM_ROOT_DIR . "/media/sections/" . $SEC_ID . ".jpg";
				if (file_exists($_SERVER["DOCUMENT_ROOT"] . $SPicSrc)) {
					$arResult["RSECTION_PICTURE"] = $SPicSrc;
				}
				else {
					$arResult["RSECTION_PICTURE"] = "/" . TDM_ROOT_DIR . "/media/sections/default.png";
				}
				$arACTIVE = array();
				if (is_array($arComSets["ACTIVE"][$SEC_ID])) {
					$arACTIVE = $arComSets["ACTIVE"][$SEC_ID];
				}
				$arPARENT = $arComSets["PARENT"];
				if ($arComSets["IGNORE"][$SEC_ID] == 1) {
					$arResult["FILTER_BY_TYPE"] = false;
				}
				else {
					$arResult["FILTER_BY_TYPE"] = $TYP_ID;
				}
				$arResult["ROOT_SID"] = $SEC_ID;
				$rsSec = TDSQL::GetSections($arResult["FILTER_BY_TYPE"], $SEC_ID);
				while ($arSec = $rsSec->Fetch()) {
					if (in_array($arSec["STR_ID"], $arACTIVE)) {
						continue;
					}
					$arSec = TDMPrepareSubSection($arSec, $arComSets);
					++$arResult["CNT"];
					$rsSec2 = TDSQL::GetSections($arResult["FILTER_BY_TYPE"], $arSec["STR_ID"]);
					while ($arSec2 = $rsSec2->Fetch()) {
						if (in_array($arSec2["STR_ID"], $arACTIVE)) {
							continue;
						}
						$arSec2 = TDMPrepareSubSection($arSec2, $arComSets);
						$rsSec3 = TDSQL::GetSections($arResult["FILTER_BY_TYPE"], $arSec2["STR_ID"]);
						while ($arSec3 = $rsSec3->Fetch()) {
							if (in_array($arSec3["STR_ID"], $arACTIVE)) {
								continue;
							}
							$arSec3 = TDMPrepareSubSection($arSec3, $arComSets);
							if (array_key_exists($arSec3["STR_ID"], $arPARENT)) {
								$PID = $arPARENT[$arSec3["STR_ID"]];
							}
							else {
								$PID = $arSec2["STR_ID"];
							}
							if ($PID != $arSec2["STR_ID"]) {
								$arSec3["MOVED"] = $arSec2["NAME"];
							}
							++$arResult["CHILDS"][$PID];
							$arResult["SECTIONS"][$PID][] = $arSec3;
						}
						if (array_key_exists($arSec2["STR_ID"], $arPARENT)) {
							$PID = $arPARENT[$arSec2["STR_ID"]];
						}
						else {
							$PID = $arSec["STR_ID"];
						}
						if ($PID != $arSec["STR_ID"]) {
							$arSec2["MOVED"] = $arSec["NAME"];
						}
						++$arResult["CHILDS"][$PID];
						$arResult["SECTIONS"][$PID][] = $arSec2;
					}
					$arResult["SECTIONS"][$SEC_ID][] = $arSec;
				}
				TDMSetTime("GetSections");
				SetComMeta("SUBSECTIONS", array("BRAND" => $arResult["UBRAND"], "MODEL" => $arResult["MODEL"], "DATE" => $arResult["YEAR"], "TYPE" => $arType["TYP_CDS_TEXT"], "SECTION" => $arResult["SECTION_NAME"]));
			}
			else {
				TDMRedirect($arResult["BRAND"]);
			}
		}
		else {
			TDMRedirect($arResult["BRAND"]);
		}
	}
	else {
		TDMRedirect();
	}
}
else {
	TDMRedirect();
}

