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
<div class="tclear"></div>
<h1>

<?=TDMShowSEOText("TOP")?>

<?if($Tabs==2){?>
	<div id="tabs">
		<ul>
			<li><a href="<?=$_SERVER['REQUEST_URI']?>#cars"><h1>Каталог Текдок</h1></a></li>
			<li><a href="<?=$_SERVER['REQUEST_URI']?>#tracks"><h1>Оригинальные каталоги</h1></a></li>
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
<div id="cars">
			<script>var AllLng = 'Все';</script>
			<div class="carsfilter">
				<a href="javascript:void(0)">Все</a>
			</div>

			<a href="http://alfa-romeo.catalogs-parts.com/#{client:pero;page:models;lang:ru}" target="_blank" class="fav_logo carsbuts" style="background:url(/autoparts/media/brands/90/ALFA.png)" title="ALFA ROMEO"><div class="tdmbut-text">ALFA ROMEO</div></a>
			<a href="http://audi.catalogs-parts.com/#{client:pero;page:models;lang:ru;region:rdw}" target="_blank" class="fav_logo carsbuts" style="background:url(/autoparts/media/brands/90/AUDI.png)" title="AUDI"><div class="tdmbut-text">AUDI</div></a>
			<a href="http://bmw.catalogs-parts.com/#{client:pero;page:models;lang:ru;name:bmw}" class="fav_logo carsbuts" target="_blank" style="background:url(/autoparts/media/brands/90/BMW.png)" title="BMW"><div class="tdmbut-text">BMW</div></a>
			<a href="http://fiat.catalogs-parts.com/#{client:pero;page:models;lang:ru}" class="fav_logo carsbuts" target="_blank" style="background:url(/autoparts/media/brands/90/FIAT.png)" title="FIAT"><div class="tdmbut-text">FIAT</div></a>
			<a href="http://hyundai.catalogs-parts.com/#{client:pero;page:models;lang:ru;catalog:eur}" class="fav_logo carsbuts" target="_blank" style="background:url(/autoparts/media/brands/90/HYUNDAI.png)" title="HYUNDAI"><div class="tdmbut-text">HYUNDAI</div></a>
			
						<div class="tclear"></div>
			
		</div>
		</div>
	</div>
<?}?>

<?=TDMShowSEOText("BOT")?>