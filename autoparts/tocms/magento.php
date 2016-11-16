<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();


session_write_close();
chdir($_SERVER["DOCUMENT_ROOT"]);
include($_SERVER["DOCUMENT_ROOT"]."/index.php");
chdir($CurDirPath);
?>