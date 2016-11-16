<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<?
if(trim($_REQUEST['brand'])==''){ErAdd('Brand name not set');}
$arBrnd = GetURLBrand();


$TDMCore->DBConnect("TECDOC");
$rsManuf = TDSQL::GetManufByCode($arBrnd['uname']);
if($arManuf = $rsManuf->Fetch()){
	$rsModels = TDSQL::GetModels($arManuf['MFA_ID'],TDM_LANG_ID,Array(),false,0,$arBrnd['trucks'],$arComSets['HIDE_USA']);
	while($arModel = $rsModels->Fetch()){
		$arModels[] = $arModel;
	}
}else{ErAdd('Wrong brand name');}

//Save changes
if($_POST['editme']=="Y"){
	if($_POST['TEMPLATE']==""){ErAdd(Lng('A_required_field')." - ".Lng('Template'),1);}
	if($_POST['SHOW_HIDE_SELECTED']<0 OR $_POST['SHOW_HIDE_SELECTED']>2){ErAdd(Lng('A_required_field')." - ".Lng('Models_list'),1);}
	if(ErCheck()){
		$arSHOW_HIDE_SELECTED = $arComSets['SHOW_HIDE_SELECTED']; //Add records of other brands models to
		$arSHOW_HIDE_SELECTED[$arBrnd['uname']] = $_POST['SHOW_HIDE_SELECTED'];
		$arSELECTED_ITEMS = $arComSets['SELECTED_ITEMS'];
		$arSELECTED_ITEMS[$arBrnd['uname']] = $_POST['SELECTED_ITEMS'];
		$SvRes = TDMSaveSetsFile(TDMGetSetsPath($CompCode),"arComSets",Array(
			Array("S","TEMPLATE",$_POST['TEMPLATE']),
			Array("I","CACHE",intval($_POST['CACHE'])),
			Array("I","HIDE_USA",$_POST['HIDE_USA']),
			Array("A","SHOW_HIDE_SELECTED",$arSHOW_HIDE_SELECTED,Array(1,0,1,0)),
			Array("A","SELECTED_ITEMS",$arSELECTED_ITEMS,Array(1,1,1,0)), //WithKeys,NewLine,KeyStr,ValStr
		));
		if($SvRes){
			NtAdd(Lng("Settings_saved"));
			$arComSets = TDMGetSets($CompCode);
			$arModels=Array();
			$rsModels = TDSQL::GetModels($arManuf['MFA_ID'],TDM_LANG_ID,Array(),false,0,$arBrnd['trucks'],$arComSets['HIDE_USA']);
			while($arModel = $rsModels->Fetch()){
				$arModels[] = $arModel;
			}
			//clear cache
			array_map('unlink', glob(TDM_PATH.'/tdmcore/cache/'.$CompCode.'/*'));
		}else{ErAdd("False to save settings!",2);}
	}
}
?>
<?ErShow();?>
<table class="formtab" >
<tr>
	<td class="fname"><?=Lng('Component_cache')?>: </td>
	<td class="ftext">
		<input type="checkbox" name="CACHE" value="1" <?if($arComSets['CACHE']==1){?> checked <?}?> > 
		<a href="/<?=TDM_ROOT_DIR?>/<?=$arBrnd['name']?>/" class="flrig bglink"><?=Lng('Public_view',1,0)?> &#10148;</a>
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
	<td class="fname"><?=Lng('Hide_models')?> [USA]: </td>
	<td class="ftext">
		<input type="checkbox" name="HIDE_USA" value="1" <?if($arComSets['HIDE_USA']==1){?> checked <?}?> >
	</td>
</tr><tr><td colspan="2"><hr></td>
</tr><tr>
	<td class="fname"><?=Lng('Models_list')?> <strong><?=$arBrnd['uname']?></strong><?=$AddTruck?>: </td>
	<td class="fvalues" id="fortabs">
		<?$arCTabs = Array(0=>Lng('Show_all'), 1=>Lng('Show_selected').':', 2=>Lng('Hide_selected').':');
		FShowInputRadio("SHOW_HIDE_SELECTED",$arCTabs,$arComSets['SHOW_HIDE_SELECTED'][$arBrnd['uname']]);?>
	</td>
</tr>
</table>

<?if(count($arModels)>0){?>
<table class="formtab"><tr><td>
	<?$AllCnt=count($arModels); $InColumn = ceil($AllCnt/2); //echo '<pre>'; print_r($arModels); echo '</pre>';
	$arSELECTED_ITEMS = Array(); $arUnIDs=Array();
	if(is_array($arComSets['SELECTED_ITEMS'][$arBrnd['uname']])){$arSELECTED_ITEMS=$arComSets['SELECTED_ITEMS'][$arBrnd['uname']];}
	foreach($arModels as $arModel){
		$NStyle='';
		if(!in_array($arModel['MOD_ID'],$arUnIDs)){$arUnIDs[]=$arModel['MOD_ID'];}else{$NStyle='style="color:#bb801a;"';}
		$MnCnt++; $SumCnt++;
		if($MnCnt>$InColumn){echo '</td><td>'; $MnCnt=1;}
		if(in_array($arModel['MOD_ID'],$arSELECTED_ITEMS)){$IsSel="checked";}else{$IsSel="";}?>
		<div class="ditem200" style="width:500px;">
			<label title="ID: <?=$arModel['MOD_ID']?>">
				<input type="checkbox" name="SELECTED_ITEMS[]" value="<?=$arModel['MOD_ID']?>" <?=$IsSel?> >
				<span <?=$NStyle?> ><?=$arModel['MOD_CDS_TEXT']?> '<?=TDDateFormat($arModel['MOD_PCON_START'],Lng('to_pt'),'syear')?>-<?=TDDateFormat($arModel['MOD_PCON_END'],Lng('to_pt'),'syear')?></span>
			</label>
		</div>
	<?}?></td></tr>
</table>
<?}?>

<div class="tarig"><?=Lng('Selected')?>: <b><?=count($arComSets['SELECTED_ITEMS'][$arBrnd['uname']])?></b> <?=Lng('out_of')?> <?=$SumCnt?></div>
