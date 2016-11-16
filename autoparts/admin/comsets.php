<?define('TDM_PROLOG_INCLUDED',true); define('TDM_ADMIN_SIDE',true);
require_once("../tdmcore/init.php");
if($_SESSION['TDM_ISADMIN']!="Y" OR $_REQUEST['to']==""){header('Location: /'.TDM_ROOT_DIR.'/admin/'); die();}
?>
<head><title>TDM :: <?=Lng('Edit')?> <?=Lng('Component',2)?></title></head>
<div class="apanel_cont"><?require_once("apanel.php");?></div>
<div class="tdm_acontent">
	<?jsLinkJqueryUi()?>
	<?jsLinkFormStyler()?>
	<script>
		AddFSlyler('input, select, textarea, checkbox, radio');
		AddTips(true);
	</script>

	<?
	switch ($_REQUEST["to"]) {
	case "manufacturers":
		$CanEdit = "Y";
		$Mrk = "::";
		$CompCode = $_REQUEST["to"];
		$CompName = "Manufacturers list";
		break;

	case "models":
		$CanEdit = "Y";
		$Mrk = "::";
		$CompCode = $_REQUEST["to"];
		$CompName = Lng("Models_list", 1, 0);
		break;

	case "types":
		$CanEdit = "Y";
		$Mrk = "::";
		$CompCode = $_REQUEST["to"];
		$CompName = Lng("Type_of_engine", 1, 0);
		break;

	case "sections":
		$CanEdit = "Y";
		$Mrk = "::";
		$CompCode = $_REQUEST["to"];
		$CompName = Lng("Sections_of_parts", 1, 0);
		break;

	case "subsections":
		$CanEdit = "Y";
		$Mrk = "::";
		$CompCode = $_REQUEST["to"];
		$CompName = Lng("Subsections_of_parts", 1, 0) . " (SID: " . $_REQUEST["sec_id"] . ")";
		break;

	case "sectionparts":
		$CanEdit = "Y";
		$Mrk = "::";
		$CompCode = $_REQUEST["to"];
		$CompName = Lng("Parts_of_section", 1, 0);
		break;

	case "searchparts":
			$CanEdit = "Y";
			$Mrk = "::";
			$CompCode = $_REQUEST["to"];
			$CompName = Lng("Search_by_parts_number", 1, 0);
			break;

	case "analogparts":
		$CanEdit = "Y";
		$Mrk = "::";
		$CompCode = $_REQUEST["to"];
		$CompName = Lng("Analogs_of_brand_number", 1, 0);

}

	?>
	<h1><?=Lng('Edit')?> <?=Lng('Component',2)?> <?=$Mrk?> <?=$CompName?></h1>
	<hr>
	<form action="" id="setsform" method="post">
	<input type="hidden" name="editme" value="Y"/>
	<?
	ErShow();
	if($CanEdit=='Y'){
		$arComSets = TDMGetSets($CompCode);
		if($arComSets){
			$EditPath = TDM_PATH.'/tdmcore/components/'.$_REQUEST['to'].'/edit.php';
			if(file_exists($EditPath)){
				require_once($EditPath);
			}else{ErAdd('Error! Edit script for component "'.$_REQUEST['to'].'" not exist.');}
		}else{ErAdd('Error! Settings file for component "'.$_REQUEST['to'].'" not exist.');}
	}else{ErAdd('Error! Unregistered component "'.$_REQUEST['to'].'" ');}
	?>
	<?ErShow()?>
	<hr>
	<input type="submit" value="<?=Lng('Save',1,false)?> <?=Lng('Settings',2,false)?>" class="abutton"/>
	</form>
	<form id="addform" method="POST"><input type="hidden" name="ADDFIELD" id="ADDFIELD" value=""></form>
	<script>
		function AddFormPost(value){
			$('#ADDFIELD').val(value); $('#addform').submit();
		}
	</script>
</div>