<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult['CARS'])>0){
	$Tabs++;
	foreach($arResult['CARS'] as $arElem){
		if(in_array($arElem['NAME'],$arResult['FAVORITE'])){
			$FAV_CARS .= '<a href="'.$arElem['LINK'].'/" class="fav_logo carsbuts" style="background:url(/'.TDM_ROOT_DIR.'/media/brands/90/'.$arElem['LOGO'].'.png)" title="'.$arElem['NAME'].'"><div class="tdmbut-text">'.$arElem['NAME'].'</div></a>';
		}else{
			$CARS .= '<a href="'.$arElem['LINK'].'/" class="tdmbut carsbuts">
				<div class="tdmbut-logo" style="background:url(/'.TDM_ROOT_DIR.'/media/brands/'.$arElem['LOGO'].'.png)"></div>
				<div class="tdmbut-text">'.$arElem['NAME'].'</div></a>';
		}
	}
}
if(count($arResult['TRUCKS'])>0){
	$Tabs++;
	foreach($arResult['TRUCKS'] as $arElem){
		if(in_array($arElem['NAME'],$arResult['FAVORITE'])){
			$FAV_TRUCKS .= '<a href="'.$arElem['LINK'].'-trucks/" class="fav_logo" style="background:url(/'.TDM_ROOT_DIR.'/media/brands/90/'.$arElem['LOGO'].'.png)" title="'.$arElem['NAME'].'"></a>';
		}else{
			$TRUCKS .= '<a href="'.$arElem['LINK'].'-trucks/" class="tdmbut tracksbuts">
				<div class="tdmbut-logo" style="background:url(/'.TDM_ROOT_DIR.'/media/brands/'.$arElem['LOGO'].'.png)"></div>
				<div class="tdmbut-text">'.$arElem['NAME'].'</div></a>';
		}
	}
}
?>
<?if($Tabs==2){?>
	<?jsLinkJqueryUi()?>
	<script>$(function() {$( "#tabs" ).tabs();});</script>
<?}?>
<h1><?=TDM_H1?></h1>

<?=TDMShowSEOText("TOP")?>

<?if($Tabs==2){?>
	<div id="tabs">
		<ul>
			<li><a href="<?//=$_SERVER['REQUEST_URI']?>#cars" class="tbcars"><?=Lng('Cars_only',1,0)?></a></li>
			<li><a href="<?//=$_SERVER['REQUEST_URI']?>#tracks" class="tbtracks"><?=Lng('Commercial_vehicles',1,0)?></a></li>
		</ul>
		<div id="cars">
<?}?>
			<script>var AllLng = '<?=Lng('All',1,0)?>';</script>
			<div class="carsfilter">
				<a href="javascript:void(0)"><?=Lng('All',1,0)?></a>
			</div>

			<?=$FAV_CARS?>
			<div class="tclear"></div>
			<?=$CARS?>
			<div class="tclear"></div>
			
<?if($Tabs==2){?>
		</div>
		<div id="tracks">
<?}?>
			
			<?=$FAV_TRUCKS?>
			<div class="tclear"></div>
			<?=$TRUCKS?>
			<div class="tclear"></div>
			
<?if($Tabs==2){?>
		</div>
	</div>
<?}?>

<?=TDMShowSEOText("BOT")?>