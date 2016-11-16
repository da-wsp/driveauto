<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<?
$TDMCore->DBConnect("TECDOC");
$rsManuf = TDSQL::GetManufs($arComSets['SHOW_CARS_TRUCKS']);
while($arManuf = $rsManuf->Fetch()){
	$arManufs[] = $arManuf;
	$arManNames[] = $arManuf['MFA_BRAND'];
}

//Save changes
if($_POST['editme']=="Y"){
	if($_POST['TEMPLATE']==""){ErAdd(Lng('A_required_field')." - ".Lng('Template'),1);}
	if($_POST['SHOW_CARS_TRUCKS']<0 OR $_POST['SHOW_CARS_TRUCKS']>2){ErAdd(Lng('A_required_field')." - ".Lng('Show_tabs'),1);}
	if($_POST['SELECTED_ACTION']<0 OR $_POST['SELECTED_ACTION']>1){ErAdd("Selected action not set!",2);}
	if(ErCheck()){
		$FAVORITE = trim($_POST['FAVORITE_ITEMS']);
		if($FAVORITE!=''){
			$arNewFav = Array();
			$arFav = explode(',',$FAVORITE); $FAVORITE='';
			foreach($arFav as $Fav){
				$Fav = trim($Fav);
				if(in_array($Fav,$arManNames)){$arNewFav[]=$Fav;}
			}
			if(count($arNewFav)>0){$FAVORITE=implode(', ',$arNewFav);}
		}
		$SvRes = TDMSaveSetsFile(TDMGetSetsPath($CompCode),"arComSets",Array(
			Array("S","TEMPLATE",$_POST['TEMPLATE']),
			Array("I","CACHE",intval($_POST['CACHE'])),
			Array("I","SHOW_CARS_TRUCKS",$_POST['SHOW_CARS_TRUCKS']),
			Array("I","SELECTED_ACTION",$_POST['SELECTED_ACTION']),
			Array("A","SELECTED_ITEMS",$_POST['SELECTED_ITEMS'],Array(false,false,false,false)),
			Array("S","FAVORITE_ITEMS",$FAVORITE),
		));
		if($SvRes){
			NtAdd(Lng("Settings_saved"));
			$arComSets = TDMGetSets($CompCode);
			$arManufs=Array(); $arManNames=Array(); 
			$rsManuf = TDSQL::GetManufs($arComSets['SHOW_CARS_TRUCKS']);
			while($arManuf = $rsManuf->Fetch()){
				$arManufs[] = $arManuf;
				$arManNames[] = $arManuf['MFA_BRAND'];
			}
			//clear cache
			array_map('unlink', glob(TDM_PATH.'/tdmcore/cache/'.$CompCode.'/*'));
		}else{ErAdd("False to save settings!",2);}
	}
}
?>
<?ErShow();?>
<table class="formtab">
<tr>
	<td class="fname"><?=Lng('Component_cache')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="CACHE" value="1" <?if($arComSets['CACHE']==1){?> checked <?}?> >
		<a href="/<?=TDM_ROOT_DIR?>/" class="flrig bglink"><?=Lng('Public_view',1,0)?> &#10148;</a>
	</td>
</tr><tr>
	<td class="fname"><?=Lng('Template')?>: </td>
	<td class="fvalues">
		<select name="TEMPLATE" style="width:200px;">
			<?$arTemps = TDMGetTemplates($CompCode);
			FShowSelectOptions($arTemps,$arComSets['TEMPLATE']);?>
		</select>
	</td>
</tr><tr>
	<td class="fname"><?=Lng('Show_tabs')?>: </td>
	<td class="fvalues" id="fortabs">
		<?$arCTabs = Array(0=>Lng('Cars_only'), 1=>Lng('Cars_only').' '.Lng('and',2).' '.Lng('Commercial_vehicles',2), 2=>Lng('Commercial_vehicles'));
		FShowInputRadio("SHOW_CARS_TRUCKS",$arCTabs,$arComSets['SHOW_CARS_TRUCKS']);?>
		<script> $("#fortabs input").change(function(){ $("#setsform").submit(); }); </script>
	</td>
</tr><tr>
	<td class="fname"><?=Lng('List_of_favourites')?>: </td>
	<td class="fvalues">
		<textarea class="styler" name="FAVORITE_ITEMS" style="width:700px; height:70px;" placeholder="<?=Tip('com_manufacturers_1')?>"/><?=$arComSets['FAVORITE_ITEMS']?></textarea>
	</td>
</tr><tr>	
	<td class="fname"><?=Lng('Manufacturers')?>: </td>
	<td class="fvalues">
		<select name="SELECTED_ACTION" style="width:200px;">
			<?$arSLogic = Array(0=>Lng('Show_selected'),1=>Lng('Hide_selected'));
			FShowSelectOptionsK($arSLogic,$arComSets['SELECTED_ACTION']);?>
		</select> 
	</td>
</tr>
</table>

<table class="formtab">
	<tr><td>
		<?$AllCnt=count($arManufs); $InColumn = ceil($AllCnt/5);
		foreach($arManufs as $arManuf){
			$MnCnt++; $SumCnt++;
			if($MnCnt>$InColumn){echo '</td><td>'; $MnCnt=1;}
			if(in_array($arManuf['MFA_ID'],$arComSets['SELECTED_ITEMS'])){$IsSel="checked";}else{$IsSel="";}?>
			<div class="ditem200">
				<label title="Code: <?=$arManuf['MFA_MFC_CODE']?><br> ID: <?=$arManuf['MFA_ID']?>">
					<input type="checkbox" name="SELECTED_ITEMS[]" value="<?=$arManuf['MFA_ID']?>" <?=$IsSel?> >
					<span><?=$arManuf['MFA_BRAND']?></span>
				</label>
			</div>
		<?}?></td></tr>
	</td></tr>
</table>

<div class="tarig"><?=Lng('Selected')?>: <b><?=count($arComSets['SELECTED_ITEMS'])?></b> <?=Lng('out_of')?> <?=$SumCnt?></div>
