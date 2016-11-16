<?php

if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}
$arBrnd = GetURLBrand();
$arResult["UBRAND"] = $arBrnd["uname"];
$arResult["BRAND"] = $arBrnd["name"];
$MOD_ID = intval($_REQUEST["mod_id"]);
$TYP_ID = intval($_REQUEST["type_id"]);
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
				$Node = 10001;
				$rsSec = TDSQL::GetSections($TYP_ID, $Node);
				TDMSetTime("GetSections");
				$arSections = array();
				while ($arSec = $rsSec->Fetch()) {
					if (!(in_array($arSec["STR_ID"], $arComSets["ACTIVE"]))) {
						continue;
					}
					$arSections[] = $arSec;
				}
				$CurUPath = "/" . TDM_ROOT_DIR . "/" . $_REQUEST["brand"] . "/" . $_REQUEST["mod_name"] . "/" . $_REQUEST["type_name"] . "/";
				foreach ($arSections as $arSec) {
					++$arResult["CNT"];
					$SID = $arSec["STR_ID"];
					if (array_key_exists($SID, $arComSets["CODE"])) {
						$arSec["URL"] = $CurUPath . $arComSets["CODE"][$SID] . "/?of=m" . $MOD_ID . ";t" . $TYP_ID . ";s" . $SID;
					}
					if (array_key_exists($SID, $arComSets["NAME"])) {
						$arSec["NAME"] = Lng($arComSets["NAME"][$SID], 0, 0);
						if (substr($arSec["NAME"], 0, 2) == "zS") {
							$arSec["NAME"] = UWord($arSec["STR_DES_TEXT"]);
						}
					}
					else {
						$arSec["NAME"] = UWord($arSec["STR_DES_TEXT"]);
					}
					if (TDM_ISADMIN) {
						$arSec["TITLE"] = "Section ID: " . $SID;
					}
					else {
						$arSec["TITLE"] = "";
					}
					if ($arComSets["SORT"][$SID] <= 0) {
						$arComSets["SORT"][$SID] = 99;
					}
					$arSortKeys[] = $arComSets["SORT"][$SID];
					$SPicSrc = "/" . TDM_ROOT_DIR . "/media/sections/" . $SID . ".jpg";
					if (file_exists($_SERVER["DOCUMENT_ROOT"] . $SPicSrc)) {
						$arSec["PICTURE"] = $SPicSrc;
					}
					else {
						$arSec["PICTURE"] = "/" . TDM_ROOT_DIR . "/media/sections/default.png";
					}
					$arResult["SECTIONS"][] = $arSec;
				}
				if (0 < $arResult["CNT"]) {
					array_multisort($arSortKeys, $arResult["SECTIONS"]);
				}
				$_SESSION["TDM_LAST_RSECTIONS_ARIDS"] = array();
				foreach ($arResult["SECTIONS"] as $arSSec) {
					$_SESSION["TDM_LAST_RSECTIONS_ARIDS"][] = $arSSec["STR_ID"];
				}
				SetComMeta("SECTIONS", array("BRAND" => $arResult["UBRAND"], "MODEL" => $arResult["MODEL"], "DATE" => $arResult["YEAR"], "TYPE" => $arType["TYP_CDS_TEXT"]));
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

