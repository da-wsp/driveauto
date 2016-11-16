<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();?>
<link rel="stylesheet" href="/<?=TDM_ROOT_DIR?>/media/js/colorbox/cmain.css" />
<script type="text/javascript" language="javascript" src="/<?=TDM_ROOT_DIR?>/media/js/colorbox/colorbox.js"></script>
<?jsLinkFormStyler()?>
<script>AddFSlyler('select');</script>
<?jsLinkJqueryUi()?>
<script> $(function() {  
	$(".popup").colorbox({rel:false, current:'', preloading:false, arrowKey:false, scrolling:false, overlayClose:false});
	$('.ttip').tooltip({ position:{my:"left+25 top+20"}, track:true, content:function(){return $(this).prop('title');}});   }); 
</script>
	
<div class="tclear"></div>
<h1><?=TDM_H1?></h1>
<?TDMShowBreadCumbs()?>
<hr style="width:86%;">
<div class="autopic" title="<?=$arResult['MFA_MFC_CODE']?>" style="background:url(<?=$arResult['BRAND_LOGO_SRC']?>)"></div>
<?=TDMShowSEOText("TOP")?>

<?if(count($arResult['PARTS'])>0){?>


<?if($arResult['SHOW_FILTER_BRANDS']==1 AND $arResult['ALL_BRANDS_COUNT']>0 AND ($arResult['PAGINATION']['TOTAL_PAGES']>1 OR $arResult['FILTERED_BRANDS_COUNT']>0) ){?>
	<script>FIRST_PAGE_LINK='<?=$arResult['FIRST_PAGE_LINK']?>';</script>
	<div class="filterdiv">
		<div class="bftitle"><?=Lng('Filter_by_manufacturer',1,0)?>: </div>
		<?if($arResult['ALL_BRANDS_COUNT']>$arResult['LETTERS_LIMIT']){?>
			<div class="letfilter"><?foreach($arResult['ALL_BRANDS_LETTERS'] as $LET){?><a href="javascript:void(0)"><?=$LET?></a><?}?></div><div class="tclear"></div>
			<script>ShowLettersFilter=1;</script>
			<div class="allbrands">
				<?foreach($arResult['ALL_BRANDS'] as $BKEY=>$BRAND){
					if($arResult['AB_MIN_PRICE_F'][$BKEY]>0){$MinPrice='<i>'.Lng('from',2,0).'</i> <span>'.$arResult['AB_MIN_PRICE_F'][$BKEY].'</span>';}else{$MinPrice='';}?>
					<a href="javascript:void(0)" class="bfname" OnClick="AddBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?></a>
				<?}?>
			</div>
			<div class="tclear"></div>
			<?if($arResult['FILTERED_BRANDS_COUNT']>0){?>
				<div class="allbrands" style="padding-top:10px;">
					<div class="filteredby"><?=Lng('Filtered_by',1,0)?>: </div>
					<?foreach($arResult['FILTERED_BRANDS'] as $BKEY=>$BRAND){
						if($arResult['AB_MIN_PRICE_F'][$BKEY]>0){$MinPrice='<i>'.Lng('from',2,0).'</i> <span>'.$arResult['AB_MIN_PRICE_F'][$BKEY].'</span>';}else{$MinPrice='';}?>
						<a href="javascript:void(0)" class="remove" OnClick="RemoveBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?> <div class="delimg"></div></a>
					<?}
					if($arResult['FILTERED_BRANDS_COUNT']>1){?>
						<a href="javascript:void(0)" class="removeall" OnClick="RemoveBrandFilter('BFRA')"><div></div></a>
					<?}?>
				</div>
			<?}?>
		<?}else{?>
			<div class="allbrands">
				<?foreach($arResult['ALL_BRANDS'] as $BKEY=>$BRAND){
					if($arResult['AB_MIN_PRICE_F'][$BKEY]>0){$MinPrice='<i>'.Lng('from',2,0).'</i> <span>'.$arResult['AB_MIN_PRICE_F'][$BKEY].'</span>';}else{$MinPrice='';}
					if(array_key_exists($BKEY,$arResult['FILTERED_BRANDS'])){?>
						<a href="javascript:void(0)" class="remove" OnClick="RemoveBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?> <div class="delimg"></div></a>
					<?}else{?>
						<a href="javascript:void(0)" class="bfname" OnClick="AddBrandFilter('<?=$BKEY?>')"><?=$BRAND?> <?=$MinPrice?></a>
					<?}?>
				<?}?>
				<?if($arResult['FILTERED_BRANDS_COUNT']>1){?>
					<a href="javascript:void(0)" class="removeall" OnClick="RemoveBrandFilter('BFRA')"> <?=$MinPrice?> <div></div></a>
				<?}?>
			</div>
			
		<?}?>
		<div class="tclear"></div>
		<hr>
	</div>
<?}?>


<div class="sortdiv">
	<form action="<?=$arResult['FIRST_PAGE_LINK']?>" id="sortform" method="post">
		<?=Lng('Sort_by',1,0)?>: 
		<select name="SORT" id="sortby" class="styled" style="width:300px;" OnChange="$('#sortform').submit();">
			<option value="1" ><?=Lng('Sort_brand_rating_price',1,0)?></option>
			<option value="2" <?if($arResult['SORT']==2){echo 'selected';}?> ><?=Lng('Sort_description_price',1,0)?></option>
			<option value="3" <?if($arResult['SORT']==3){echo 'selected';}?> ><?=Lng('Sort_lowest_price',1,0)?></option>
			<option value="4" <?if($arResult['SORT']==4){echo 'selected';}?> ><?=Lng('Sort_lowest_delivery_time',1,0)?></option>
			<option value="5" <?if($arResult['SORT']==5){echo 'selected';}?> ><?=Lng('Sort_photo_available',1,0)?></option>
		</select>
		<?if($arResult['VIEW']=="CARD"){?>
			<a href="javascript:void(0)" class="vlist vbox vactive" OnClick="ViewSwitch('LIST')"><div></div></a>
			<a href="javascript:void(0)" class="vcard_ vbox"><div></div></a>
		<?}else{?>
			<a href="javascript:void(0)" class="vlist_ vbox"><div></div></a>
			<a href="javascript:void(0)" class="vcard vbox vactive" OnClick="ViewSwitch('CARD')"><div></div></a>
		<?}?>
		<div class="vtext"><?=Lng('View')?>: </div>
	</form>
</div>
<hr>

<?if($arResult['PAGINATION']['TOTAL_PAGES']>1){?>
	<?TDMShowPagination($arResult['PAGINATION'],Array(
		"PAGE_TEXT"=>"Y",
		"TOTAL_TEXT"=>Lng('Total_items',1,0),
		"PAGES_DIAPAZON"=>6,
	))?>
<?}?>
<?if($arResult['GROUP_NAME']!=''){?>
	<div class="pricetype">
		<?=Lng('Your_prices_level')?>: <b><?=$arResult['GROUP_NAME']?> 
		<?if($arResult['GROUP_VIEW']==2){echo '('.$arResult['GROUP_DISCOUNT'].'%)';}?></b>
	</div>
<?}?>
<div class="tclear"></div>


<?
///////////////////////////////////////////////////////////////////////
// CARD view 
///////////////////////////////////////////////////////////////////////
if($arResult['VIEW']=="CARD"){

	foreach($arResult['PARTS'] as $NumKey=>$arPart){
		$Cnt++; $PCnt=0; $cm=''; $AddF=0;
		//Criteria display method
		if($arPart['CRITERIAS_COUNT']>0){
			foreach($arPart['CRITERIAS'] as $Criteria=>$Value){ 
				if($Criteria!=''){$arPart['CRITERIA'].=$cm.$Criteria.' - '.$Value;}else{$arPart['CRITERIA'].=$cm.UWord($Value);} $cm='; ';
			}
		}
		//Pictures display method
		if($arPart['IMG_ZOOM']=='Y'){
			$Zoom=$arPart['IMG_SRC']; $ZClass='cbx_imgs';
			$PicText=''; $Target='';
		}else{
			$Zoom='https://www.google.com/search?q='.$arPart['BRAND'].'+'.$arPart['ARTICLE'].'&tbm=isch'; $ZClass='';
			$PicText=Lng('Search_photo_in_google',1,0); $Target='target="_blank"';
		}?>
		<div class="tditem" style="width:432px;" id="item<?=$arPart['PKEY']?>">
			<?// Preview images: ?>
			<a href="<?=$Zoom?>" class="image <?=$ZClass?>" rel="img<?=$arPart['PKEY']?>" <?=$Target?> title="<?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?>">
				<?if($arResult['ART_LOGOS'][$arPart['AID']]!=''){?>
					<div style="background-image:url('<?=$arResult['ART_LOGOS'][$arPart['AID']]?>');" class="logobox"></div>
				<?}?>
				<?if($PicText!=''){?>
					<div class="gosrch"><?=$PicText?></div>
				<?}else{?>
					<div style="background-image:url('<?=$arPart['IMG_SRC']?>');" class="photobox"></div>
				<?}?>
			</a>
			<?if(is_array($arPart["IMG_ADDITIONAL"])){
				foreach($arPart["IMG_ADDITIONAL"] as $AddImgSrc){ $AddF++;?><a href="<?=$AddImgSrc?>" class="cbx_imgs" rel="img<?=$arPart['PKEY']?>" title="<?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?>"></a><?}
			}?>
			<?if($AddF>0){?><div class="addphoto" title="<?=Lng('Photo_count',1,0);?>">x<?=($AddF+1)?></div><?}?>
			<?// Brand & article: ?>
			<?if(TDM_ISADMIN AND $arPart['LINK_CODE']!=''){$BrandClass='linked';?>
				<a href="/<?=TDM_ROOT_DIR?>/admin/dbedit.php?selecttable=Y&table=TDM_LINKS&LINK=<?=$arPart['LINK_LEFT_AKEY']?>" target="_blank" class="ttip link" title="<?=$arPart['LINK_INFO']?><br><?=$arPart['LINK_CODE']?>"></a>
			<?}else{$BrandClass='';}?>
			<a href="javascript:void(0)" class="brand <?=$BrandClass?>" title="<?echo Lng('Information_about_brand',0,0);?>"><?=$arPart['BRAND']?></a>
			<?if($arPart["AID"]>0){?>
				<a href="javascript:void(0)" OnClick="AppWin('<?=TDM_ROOT_DIR?>',<?=$arPart["AID"]?>,980)" class="carsapp" target="_blank" title="<?=Lng('Applicability_to_model_cars',1,0)?>"></a>
				<a href="/<?=TDM_ROOT_DIR?>/props.php?of=<?=$arPart["AID"]?>" class="dopinfo popup" target="_blank" title="<?=Lng('Additional_Information',1,0)?>"></a>
			<?}?>
			<div class="article <?if(TDM_ISADMIN){?>ttip " title="BKEY: <?=$arPart['BKEY']?><br>AKEY: <?=$arPart['AKEY']?><?}?>" >
				<?=$arPart['ARTICLE']?> 
				<?if(TDM_ISADMIN){?><span class="aid">ID:<?=$arPart['AID']?></span><?}?>
			</div>
			<hr>
			<?// Name & criterias: ?>
			<div class="name" OnMouseOver="$(this).css('overflow','visible');" OnMouseOut="$(this).css('overflow','hidden');" <?if($arPart["PRICES_COUNT"]<2){?>style="height:84px;"<?}?> >
				<b title="TecDoc name: <?=$arPart['TD_NAME']?>"><?=$arPart['NAME']?></b>. <span class="criteria"><?=$arPart['CRITERIA']?></span>
			</div>
			<?// Prices: ?>
			<div class="prices">
			<?if($arPart["PRICES_COUNT"]>0){?>
				<form action="" method="post" >
				<table class="pricetab">
				<tr class="head"><td></td><td><?=Lng('Avail.',1,1)?></td><td class="ttip" title="<?=Lng('Dtime_delivery',1,0)?>"><?=Lng('Dtime',1,1)?></td><td class="ttip" title="<?=TDM_CUR?>"><?=Lng('Price',1,1)?> <?=TDM_CUR_LABEL?></td><td></td></tr>
				<?if(is_array($arResult['PRICES'][$arPart['PKEY']])){
					foreach($arResult['PRICES'][$arPart['PKEY']] as $arPrice){
						$PCnt++;
						if($PCnt>2){$HClass='ip'.$arPart['PKEY']; $HStyle='style="display:none;"';}else{$HStyle=''; $HClass='';}?>
						<tr class="prow <?=$HClass?>" <?=$HStyle?> >
							<td class="options"><?=$arPrice['OPTIONS']['VIEW']?></td>
							<td><?=$arPrice['AVAILABLE']?></td>
							<td class="ttip" title="<?=$arPrice['INFO']?>"><?=$arPrice['DAY']?></td>
							<td class="cost ttip">
								<?if($arPrice['EDIT_LINK']!=''){?><a href="<?=$arPrice['EDIT_LINK']?>" class="popup editprice" title="<?=Lng('Price',1,0)?>: <?=Lng('Edit',2,0)?>"><?}?>
								<?=$arPrice['PRICE_FORMATED']?></a>
							</td>
							<td>
								<?if($arResult['ADDED_PHID']==$arPrice['PHID']){?>
									<div class="tdcartadded" title="<?=Lng('Added_to_cart',1,0)?>"></div>
								<?}else{?>
									<a href="javascript:void(0)" class="tdcartadd" OnClick="TDMAddToCart('<?=$arPrice['PHID']?>')" title="<?=Lng('Add_to_cart',1,0)?>"></a>
								<?}?>
							</td>
						</tr><?
					}
				}?>
				</table>
				</form>
				<?if($arPart["PRICES_COUNT"]>2){?>
					<a href="javascript:void(0)" OnClick="ShowMPrices('<?=$arPart['PKEY']?>')" class="sbut sb<?=$arPart['PKEY']?>">&#9660; <?=Lng('Show_more_prices',1,0)?> (<?=($arPart["PRICES_COUNT"]-2)?>)</a>
					<a href="javascript:void(0)" OnClick="HideMPrices('<?=$arPart['PKEY']?>')" class="hbut hb<?=$arPart['PKEY']?>">&#9650; <?=Lng('Hide_prices',1,0)?></a>
					<script>$("#item<?=$arPart['PKEY']?>" ).mouseleave(function() { HideMPrices('<?=$arPart['PKEY']?>'); }); </script><?
				}
			}?>
			</div>
		</div>
		<?if($Cnt==2){$Cnt=0;?><div class="tclear"></div><?}
	}

}else{
///////////////////////////////////////////////////////////////////////
// LIST view 
///////////////////////////////////////////////////////////////////////?>
	<table class="tdlist">
	<tr class="head"><td><?=Lng('Brand',1,0);?></td><?/*<td><?=Lng('Number',1,0);?></td>*/?><td></td><td><?=Lng('Name',1,0);?></td><td></td><td></td>
		<td style="padding:0px; text-align:right;">
			<table class="listprice"><tr class="thead">
				<td class="avail"><?=Lng('Avail.',1,1)?></td>
				<td class="day ttip" title="<?=Lng('Dtime_delivery',1,0)?>"><?=Lng('Dtime',1,1)?></td>
				<td class="cost ttip" title="<?=TDM_CUR?>"><?=Lng('Price',1,1)?> <?=TDM_CUR_LABEL?></td>
				<td class="tocart"></td></tr>
			</table>
		</td>
	</tr>
	<?
	foreach($arResult['PARTS'] as $NumKey=>$arPart){
		$Cnt++; $PCnt=0; $OpCnt=0; $cm=''; $AddF=0;
		//Criteria display method
		if($arPart['CRITERIAS_COUNT']>0){
			foreach($arPart['CRITERIAS'] as $Criteria=>$Value){ 
				if($Criteria!=''){$arPart['CRITERIA'].=$cm.$Criteria.' - '.$Value;}else{$arPart['CRITERIA'].=$cm.UWord($Value);} $cm='; ';
			}
		}
		//Pictures display method
		if($arPart['IMG_ZOOM']=='Y'){
			$Zoom=$arPart['IMG_SRC']; $ZClass='cbx_imgs';
			$PicText=''; $Target='';
		}else{
			$Zoom='https://www.google.com/search?q='.$arPart['BRAND'].'+'.$arPart['ARTICLE'].'&tbm=isch'; $ZClass='';
			$PicText=Lng('Search_photo_in_google',1,0); $Target='target="_blank"';
		}
		if(TDM_ISADMIN AND $arPart['LINK_CODE']!=''){$BrandClass='linked';
			$BrLink = '<a href="/'.TDM_ROOT_DIR.'/admin/dbedit.php?selecttable=Y&table=TDM_LINKS&LINK='.$arPart['LINK_LEFT_AKEY'].'" target="_blank" class="ttip link" title="'.$arPart['LINK_INFO'].'<br>'.$arPart['LINK_CODE'].'"></a>';
		}else{$BrandClass=''; $BrLink='';}
		?>
		<tr class="cols">
		<td class="brand">
			<a href="javascript:void(0)" class="brand <?=$BrandClass?>" title="<?echo Lng('Information_about_brand',0,0);?>"><?=$arPart['BRAND']?></a>
			<?=$BrLink?><br>
			<div class="ttip" <?if(TDM_ISADMIN){?>ttip" title="BKEY: <?=$arPart['BKEY']?><br>AKEY: <?=$arPart['AKEY']?><br>ID:<?=$arPart['AID']?><?}?>"><?=$arPart['ARTICLE']?></div>
		</td>
		<?/*
		<td class="article <?if(TDM_ISADMIN){?>ttip" title="BKEY: <?=$arPart['BKEY']?><br>AKEY: <?=$arPart['AKEY']?><br>ID:<?=$arPart['AID']?><?}?>">
			<?=$arPart['ARTICLE']?>
		</td>*/?>
		<td>
			<?if(is_array($arPart["IMG_ADDITIONAL"])){
				foreach($arPart["IMG_ADDITIONAL"] as $AddImgSrc){ $AddF++;?><a href="<?=$AddImgSrc?>" class="cbx_imgs" rel="img<?=$arPart['PKEY']?>" title="<?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?>"></a><?}
			}?>
			<a href="<?=$Zoom?>" class="image <?=$ZClass?>" rel="img<?=$arPart['PKEY']?>" <?=$Target?> title="<?=$arPart['BRAND']?> <?=$arPart['ARTICLE']?>">
				<?if($PicText!=''){?>
					<div class="gosrch ttip" title="<?=$PicText?>"><?=Lng('Search_photo',1,0)?></div>
				<?}else{?>
					<div class="prevphoto" style="background-image:url('<?=$arPart['IMG_SRC']?>');" ></div>
					<?/*<div class="listphoto"><?if($AddF>0){?><div class="addphoto" title="<?=Lng('Photo_count',1,0);?>"><?=($AddF+1)?></div><?}?></div>*/?>
				<?}?>
			</a>
		</td>
		<td>
			<b class="name" title="TecDoc name: <?=$arPart['TD_NAME']?>"><?=$arPart['NAME']?></b><br>
			<div class="criteria"><?=$arPart['CRITERIA']?></div>
			<?if($arPart["PROPS_COUNT"]>0){
				foreach($arPart['PROPS'] as $PName=>$PValue){?>
					<span class="criteria"><?=$PName?><?if($PValue!=''){?>: <?=$PValue?><?}?></span><br>
				<?}
			}?>
		</td>
		<td style="width:40px; white-space:nowrap;" class="rigbord">
			<?if($arPart["AID"]>0){?>
				<a href="/<?=TDM_ROOT_DIR?>/props.php?of=<?=$arPart["AID"]?>" class="dopinfo popup" title="<?=Lng('Additional_Information',1,0)?>"></a>
				<a href="javascript:void(0)" OnClick="AppWin('<?=TDM_ROOT_DIR?>',<?=$arPart["AID"]?>,980)" class="carsapp" target="_blank" title="<?=Lng('Applicability_to_model_cars',1,0)?>"></a>
			<?}?>
		</td>
		<td class="options">
			<?if($arPart["PRICES_COUNT"]>0){?>
				<table class="optionstab">
				<?foreach($arResult['PRICES'][$arPart['PKEY']] as $arPrice){ $OpCnt++;
					if($OpCnt>$arResult['LIST_PRICES_LIMIT']){$OpClass='op'.$arPart['PKEY']; $OpStyle='style="display:none;"'; }else{$OpClass=''; $OpStyle='';}?>
					<tr class="<?=$OpClass?>" <?=$OpStyle?> ><td><?=$arPrice['OPTIONS']['VIEW_INTAB']?></td></tr>
				<?}?>
				</table>
			<?}?>
		</td>
		<td style="padding:0px;">
			<?if($arPart["PRICES_COUNT"]>0){?>
				<table class="listprice">
				<?foreach($arResult['PRICES'][$arPart['PKEY']] as $arPrice){
					$PCnt++;
					if($PCnt>1){$TopBord='topbord';}else{$TopBord='';}
					if($PCnt>$arResult['LIST_PRICES_LIMIT']){$HClass='pr'.$arPart['PKEY']; $HStyle='style="display:none;"'; }else{$HStyle=''; $HClass='';}?>
					<tr class="trow <?=$HClass?> <?=$TopBord?>" <?=$HStyle?> >
						<td class="avail"><?=$arPrice['AVAILABLE']?></td>
						<td class="day ttip" <?if(TDM_ISADMIN){?>title="<?=$arPrice['INFO']?>"<?}?> >
							<?=$arPrice['DAY']?>
						</td>
						<td class="cost ttip">
							<?if($arPrice['EDIT_LINK']!=''){?><a href="<?=$arPrice['EDIT_LINK']?>" class="popup editprice" title="<?=Lng('Price',1,0)?>: <?=Lng('Edit',2,0)?>"><?}?>
							<?=$arPrice['PRICE_FORMATED']?></a>
						</td>
						<td class="tocart">
							<?if($arResult['ADDED_PHID']==$arPrice['PHID']){?>
								<div class="tdcartadded" title="<?=Lng('Added_to_cart',1,0)?>"></div>
							<?}else{?>
								<a href="javascript:void(0)" class="tdcartadd" OnClick="TDMAddToCart('<?=$arPrice['PHID']?>')" title="<?=Lng('Add_to_cart',1,0)?>"></a>
							<?}?>
						</td>
					</tr>
				<?}?>
				</table>
				<?
				if($arPart["PRICES_COUNT"]>$arResult['LIST_PRICES_LIMIT']){?>
					<a href="javascript:void(0)" OnClick="ShowMoreListPrices('<?=$arPart['PKEY']?>')" class="sbut sb<?=$arPart['PKEY']?>">&#9660; <?=Lng('Show_more_prices',1,0)?> (<?=($arPart["PRICES_COUNT"]-$arResult['LIST_PRICES_LIMIT'])?>)</a><?
				}
			}?>
		</td>
		</tr><?
	}?>
	</table><?
}


}else{?>
	<br><br>
	<b><?=Lng('No_parts_for_model')?>...</b>
		
	<br><br><br><br>
	
	<script>
		jQuery(function($){
			$(document).ready(function() {
				$('#search ul #tecdoc').removeClass('active');
				$('#search ul #tecdoc > li').addClass('active');
				$('input[name=\'search\']').attr('value', "<?=$_REQUEST['article']?>");
				$('.button-search').click();
			});
		});
	</script>


<?}?>

<div class="tclear"></div>

<?if($arResult['PAGINATION']['TOTAL_PAGES']>1 AND $arResult['PAGINATION']['ITEMS_ON_THIS_PAGE']>6){?>
	<br>
	<?TDMShowPagination($arResult['PAGINATION'],Array(
		"PAGE_TEXT"=>"Y",
		"TOTAL_TEXT"=>Lng('Total_items',1,0),
		"PAGES_DIAPAZON"=>6,
	))?>
	<div class="tclear"></div>
	<hr>
<?}?>



<?=TDMShowSEOText("BOT")?>
<br>
<br>


<script>
	$(document).ready(function(){
		$(".cbx_imgs").colorbox({ current:'', innerWidth:900, innerHeight:600, onComplete:function(){$('.cboxPhoto').unbind().click($.colorbox.next);} });
		$(".cbx_chars").colorbox({rel:false, current:'', overlayClose:true, arrowKey:false, opacity:0.6});
		
		
	});
</script>

<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>