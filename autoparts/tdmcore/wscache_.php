<?php

$WID = intval($_GET["WID"]);
$SID = intval($_GET["SID"]);
$PKEY = substr($_GET["PKEY"], 0, 18);
if (0 < $WID) {
	define("TDM_PROLOG_INCLUDED", true);
	require_once("defines.php");
	require_once("classes.php");
	require_once("functions.php");
	$TDMCore = new TDMCore();
	$TDMCore->DBConnect("MODULE");
	$resDB = new TDMQuery();
	$resDB->Select("TDM_WS", array(), array("ID" => $WID, "ACTIVE" => 1));
	if ($arWS = $resDB->Fetch()) {
		foreach ($_POST as $Brand => $arNums) {
			$Brand = str_replace("_", " ", $Brand);
			foreach ($arNums as $Num) {
				$arWSData[$Brand][] = $Num;
				$arWsParts[] = array("BKEY" => TDMSingleKey($Brand, true), "AKEY" => TDMSingleKey($Num), "BRAND" => $Brand, "ARTICLE" => $Num);
			}
		}
		if (0 < count($arWsParts)) {
			$WS = new TDMWebservers();
			$WS->WSQuery($arWS, $arWsParts, array("CACHE_MODE" => true, "SID" => $SID, "PKEY" => $PKEY, "REFRESH_PAGE" => "N"));
		}
	}
	$SvRes = TDMSaveSetsFile(TDM_PATH . "/admin/wsdata/" . $WID . ".php", "arWSData", array(array("S", "TIME", date("m.d.Y h:i", time())), array("I", "SID", $SID), array("S", "PKEY", $PKEY), array("A", "PARTS", $arWSData, array(1, 1, 1, 1))));
}
ErShow();

