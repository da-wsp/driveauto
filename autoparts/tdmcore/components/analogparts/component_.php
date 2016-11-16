<?php

if (!(defined("TDM_PROLOG_INCLUDED")) || TDM_PROLOG_INCLUDED !== true) {
	exit();
}
$S_ARTICLE = TDMSingleKey($_REQUEST["article"]);
if (strlen($S_ARTICLE) < 3) {
	TDMRedirect();
}
$S_BRAND = BrandNameDecode($_REQUEST["brand"]);
if (strlen($S_BRAND) < 2) {
	TDMRedirect();
}
$TDMCore->DBSelect("TECDOC");
TDMSetTime();
if ($_POST["VIEW"] == "LIST") {
	$_SESSION["TDM_SEACH_DEFAULT_VIEW"] = 2;
}
if ($_POST["VIEW"] == "CARD") {
	$_SESSION["TDM_SEACH_DEFAULT_VIEW"] = 1;
}
if ($_SESSION["TDM_SEACH_DEFAULT_VIEW"] == 0) {
	$_SESSION["TDM_SEACH_DEFAULT_VIEW"] = $arComSets["DEFAULT_VIEW"];
}
if ($_SESSION["TDM_SEACH_DEFAULT_VIEW"] == 1) {
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
$rsArts = TDSQL::LookupByBrandNumber($S_BRAND, $S_ARTICLE);
while ($arArts = $rsArts->Fetch()) {
	$BKEY = TDMSingleKey($arArts["BRAND"], true);
	$AKEY = TDMSingleKey($arArts["ARTICLE"]);
	$arPARTS_noP[$BKEY . $AKEY] = array("PKEY" => $BKEY . $AKEY, "BKEY" => $BKEY, "AKEY" => $AKEY, "KIND" => $arArts["KIND"], "AID" => $arArts["AID"], "ARTICLE" => $arArts["ARTICLE"], "BRAND" => $arArts["BRAND"], "TD_NAME" => $arArts["TD_NAME"], "NAME" => $arArts["TD_NAME"], "IMG_SRC" => "/" . TDM_ROOT_DIR . "/media/images/nopic.jpg");
	$arPAIDs_noP[] = $arArts["AID"];
}
TDMSetTime("LookupByBrandNumber(ARTICLE) ## Not sorted TecDoc result items count - <b>" . count($arPARTS_noP)) . "</b>";
$TDMCore->DBSelect("MODULE");
$rsDBPrices = new TDMQuery();
$rsDBPrices->SimpleSelect("SELECT * FROM TDM_PRICES WHERE AKEY=\"" . $S_ARTICLE . "\" AND BKEY=\"" . TDMSingleKey($S_BRAND, true) . "\" ");
while ($arSArts = $rsDBPrices->Fetch()) {
	$arSArts["PKEY"] = $arSArts["BKEY"] . $arSArts["AKEY"];
	if (is_array($arPARTS_noP[$arSArts["PKEY"]])) {
		continue;
	}
	$arPARTS_noP[$arSArts["PKEY"]] = array("PKEY" => $arSArts["PKEY"], "BKEY" => $arSArts["BKEY"], "AKEY" => $arSArts["AKEY"], "ARTICLE" => $arSArts["ARTICLE"], "BRAND" => $arSArts["BRAND"], "TD_NAME" => $arSArts["ALT_NAME"], "NAME" => $arSArts["ALT_NAME"], "IMG_SRC" => "/" . TDM_ROOT_DIR . "/media/images/nopic.jpg");
	continue;
}
$SrPKEY = TDMSingleKey($S_BRAND, true) . $S_ARTICLE;
$SrPKEYc = $SrPKEY;
if (array_key_exists($SrPKEY, $arPARTS_noP)) {
	unset($SrPKEY);
}
$arWSP[$S_BRAND . $S_ARTICLE] = array("PKEY" => $S_BRAND . $S_ARTICLE, "BKEY" => TDMSingleKey($S_BRAND, true), "AKEY" => $S_ARTICLE, "ARTICLE" => $_REQUEST["article"], "BRAND" => $S_BRAND);
require_once(TDM_PATH . "/tdmcore/components/listparts.php");
if (is_array($arPARTS) && 0 < count($arPARTS)) {
	foreach ($arPARTS as $arPart) {
		$SEO_PARTS_LIST .= $arPart["BRAND"] . " " . $arPart["ARTICLE"] . ", ";
	}
}
SetComMeta("ANALOGPARTS", array("PARTS_LIST" => $SEO_PARTS_LIST, "SEARCH_NUMBER" => $S_ARTICLE, "SEARCH_BRAND" => $S_BRAND));

