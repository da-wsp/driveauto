<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();
?>
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
		<td class="tdbrand">
			<a href="javascript:void(0)" class="<?=$BrandClass?>" title="<?echo Lng('Information_about_brand',0,0);?>"><?=$arPart['BRAND']?></a>
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
					<div class="prevphoto" style="background-image:url('<?=$arPart['IMG_SRC']?>');" ><?if($AddF>0){?><div class="addphoto" title="<?=Lng('Photo_count',1,0);?>">x<?=($AddF+1)?></div><?}?></div>
				<?}?>
			</a>
		</td>
		<td>
			<b class="name" title="TecDoc name: <?=$arPart['TD_NAME']?>"><?=$arPart['NAME']?></b><br>
			<div class="criteria"><?=$arPart['CRITERIA']?></div>
			<div class="itemprops" id="props<?=$arPart['PKEY']?>">
				<?if($arPart["PROPS_COUNT"]>0){
					foreach($arPart['PROPS'] as $PName=>$PValue){?>
						<span class="criteria"><?=$PName?><?if($PValue!=''){?>: <?=$PValue?><?}?></span><br>
					<?}
				}?>
			</div>
			<?if($arPart["PROPS_COUNT"]>3){?>
				<a class="moreprops" href="javascript:void(0)" onClick="ShowMoreProps(this,'props<?=$arPart['PKEY']?>')">&#9660; <?=Lng('Show_more_properties',1,false)?> (<?=($arPart["PROPS_COUNT"]-3)?>)</a>
			<?}?>
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
			}elseif($arResult['ALLOW_ORDER']==1){?>
				<a href="javascript:void(0)" class="tdorder" OnClick="TDMOrder('<?=$arPart['PKEY']?>')"><?=Lng('Order',1,0)?></a>
			<?}?>
			<?if(TDM_ISADMIN){?>
				<?if($arPart["PRICES_COUNT"]<=0){?><br><?}?>
				<a href="/<?=TDM_ROOT_DIR?>/admin/dbedit_price.php?ID=NEW&ARTICLE=<?=urlencode($arPart['ARTICLE'])?>&BRAND=<?=urlencode($arPart['BRAND'])?>" class="popup addprice" title="Add price record">+$</a>
				<a href="/<?=TDM_ROOT_DIR?>/admin/dbedit_link.php?ID=NEW&BKEY=<?=$arPart['BKEY']?>&AKEY=<?=$arPart['AKEY']?>" class="popup addprice" title="Add cross record">+X</a>
			<?}?>
		</td>
		</tr><?
	}?>
</table>