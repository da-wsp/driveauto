<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();


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
			<a href="javascript:void(0)" class="tdbrand <?=$BrandClass?>" title="<?echo Lng('Information_about_brand',0,0);?>"><?=$arPart['BRAND']?></a>
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

//echo '<pre>'; print_r($arResult); echo '</pre>';
?>