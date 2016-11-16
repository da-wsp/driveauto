<?php

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
	TDMSetTime("GetManufByCode(UBRAND)");
	if ($arManuf = $rsManuf->Fetch()) {
		$arResult["MFA_MFC_CODE"] = $arManuf["MFA_MFC_CODE"];
		$rsModel = TDSQL::GetModelByID($arManuf["MFA_ID"], $MOD_ID);
		TDMSetTime("GetModelByID(MFA,MOD)");
		if ($arModel = $rsModel->Fetch()) {
			$arResult["MOD_ID"] = $arModel["MOD_ID"];
			$DateFr = TDDateFormat($arModel["MOD_PCON_START"], Lng("to_pt"), "year");
			$DateTo = TDDateFormat($arModel["MOD_PCON_END"], Lng("to_pt"), "year");
			$arResult["MODEL"] = $arModel["MOD_CDS_TEXT"];
			$arResult["YEAR"] = "(" . $DateFr . " - " . $DateTo . ")";
			$rsType = TDSQL::GetTypeByID($arModel["MOD_ID"], $TYP_ID);
			TDMSetTime("GetTypeByID(MOD,TYP)");
			if ($arType = $rsType->Fetch()) {
				$arResult["TYPE_ID"] = $arType["TYP_ID"];
				$arRComSets = TDMGetSets("sections");
				$RSID = array_search($_REQUEST["sec_name"], $arRComSets["CODE"]);
				if (0 < $RSID) {
					$arResult["SECTION_NAME"] = UWord(Lng($arRComSets["NAME"][$RSID], 0, 0));
					$arResult["RSEC_LINK"] = "/" . TDM_ROOT_DIR . "/" . $_REQUEST["brand"] . "/" . $_REQUEST["mod_name"] . "/" . $_REQUEST["type_name"] . "/";
					$arResult["CSEC_LINK"] = $arResult["RSEC_LINK"] . $_REQUEST["sec_name"] . "/";
					$arResult["FIRST_PAGE_LINK"] = $arResult["CSEC_LINK"] . $_REQUEST["subsec_name"] . "/" . "?of=m" . $MOD_ID . ";t" . $TYP_ID . ";s" . $SEC_ID;
					$TDMCore->arFreeData["TD_SEC_NAME"] = $arResult["SECTION_NAME"];
					$TDMCore->arFreeData["TD_SEC_RSID"] = $RSID;
					$arSubSec = TDSQL::GetSectionData($SEC_ID);
					$arSubComSets = TDMGetSets("subsections");
					if (0 < $arSubSec["STR_ID"] && $arSubComSets["CODE"][$SEC_ID] == $_REQUEST["subsec_name"]) {
						$arResult["SUBSECTION_NAME"] = Lng($arSubComSets["NAME"][$SEC_ID], 0, 0);
						if ($arResult["SUBSECTION_NAME"] == "") {
							$arResult["SUBSECTION_NAME"] = $arSubSec["STR_DES_TEXT"];
						}
						$arResult["SUBSECTION_NAME"] = UWord($arResult["SUBSECTION_NAME"]);
						$TDMCore->arFreeData["TD_SUBSEC_NAME"] = $arResult["SUBSECTION_NAME"];
						$BrandLogoSrc = "/" . TDM_ROOT_DIR . "/media/brands/90/" . $arResult["MFA_MFC_CODE"] . ".png";
						if (file_exists($_SERVER["DOCUMENT_ROOT"] . $BrandLogoSrc)) {
							$arResult["BRAND_LOGO_SRC"] = $BrandLogoSrc;
						}
						else {
							$arResult["BRAND_LOGO_SRC"] = "/" . TDM_ROOT_DIR . "/media/brands/" . $arResult["MFA_MFC_CODE"] . ".png";
						}
						if ($_POST["VIEW"] == "LIST") {
							$_SESSION["TDM_SECPARTS_DEFAULT_VIEW"] = 2;
						}
						if ($_POST["VIEW"] == "CARD") {
							$_SESSION["TDM_SECPARTS_DEFAULT_VIEW"] = 1;
						}
						if ($_SESSION["TDM_SECPARTS_DEFAULT_VIEW"] == 0) {
							$_SESSION["TDM_SECPARTS_DEFAULT_VIEW"] = $arComSets["DEFAULT_VIEW"];
						}
						if ($_SESSION["TDM_SECPARTS_DEFAULT_VIEW"] == 1) {
							$arResult["VIEW"] = "CARD";
						}
						else {
							$arResult["VIEW"] = "LIST";
						}
						$arResult["LIST_PRICES_LIMIT"] = $arComSets["LIST_PRICES_LIMIT"];
						$arResult["ALLOW_ORDER"] = $arComSets["ALLOW_ORDER"];
						if ($arResult["LIST_PRICES_LIMIT"] < 3) {
							$arResult["LIST_PRICES_LIMIT"] = 2;
						}
						if (1 < $TDMCore->UserGroup) {
							$arResult["GROUP_NAME"] = $TDMCore->arPriceType[$TDMCore->UserGroup];
							$arResult["GROUP_DISCOUNT"] = $TDMCore->arPriceDiscount[$TDMCore->UserGroup];
							$arResult["GROUP_VIEW"] = $TDMCore->arPriceView[$TDMCore->UserGroup];
						}
						$arPARTS_noP = array();
						$arPARTS = array();
						$arResult["ALL_BRANDS"] = array();
						$arResult["ALL_BRANDS_LETTERS"] = array();
						$rsArts = TDSQL::GetSectionParts($TYP_ID, $SEC_ID);
						while ($arArts = $rsArts->Fetch()) {
							$PBKEY = TDMSingleKey($arArts["BRAND"], true);
							$PAKEY = TDMSingleKey($arArts["ARTICLE"]);
							$arPARTS_noP[$PBKEY . $PAKEY] = array("PKEY" => $PBKEY . $PAKEY, "BKEY" => $PBKEY, "AKEY" => $PAKEY, "AID" => $arArts["AID"], "ARTICLE" => $arArts["ARTICLE"], "BRAND" => $arArts["BRAND"], "TD_NAME" => $arArts["TD_NAME"], "NAME" => $arArts["TD_NAME"], "IMG_SRC" => "/" . TDM_ROOT_DIR . "/media/images/nopic.jpg");
							$arPAIDs_noP[] = $arArts["AID"];
						}
						TDMSetTime("GetSectionParts(TYP,SEC) ## Not sorted TecDoc result items count - <b>" . count($arPAIDs_noP)) . "</b>";
						require_once(TDM_PATH . "/tdmcore/components/listparts.php");
						foreach ($arPARTS as $arPart) {
							$SEO_PARTS_LIST .= $arPart["BRAND"] . " " . $arPart["ARTICLE"] . ", ";
						}
						SetComMeta("SECTIONPARTS", array("PARTS_LIST" => $SEO_PARTS_LIST, "BRAND" => $arResult["UBRAND"], "MODEL" => $arResult["MODEL"], "DATE" => $arResult["YEAR"], "TYPE" => $arType["TYP_CDS_TEXT"], "SUBSECTION" => $arResult["SUBSECTION_NAME"], "SECTION" => $arResult["SECTION_NAME"]));
					}
					else {
						TDMRedirect($_REQUEST["brand"] . "/" . $_REQUEST["mod_name"] . "/" . $_REQUEST["type_name"] . "/" . $_REQUEST["sec_name"] . "/?of=m" . $MOD_ID . ";t" . $TYP_ID . ";s" . $RSID);
					}
				}
				else {
					TDMRedirect($_REQUEST["brand"] . "/" . $_REQUEST["mod_name"] . "/" . $_REQUEST["type_name"] . "/?of=m" . $MOD_ID . ";t" . $TYP_ID);
				}
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

