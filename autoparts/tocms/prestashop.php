<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

require($_SERVER["DOCUMENT_ROOT"].'/config/config.inc.php');

//$sql = 'SELECT * FROM `ps_1product` WHERE `id_product` = 10 ';
//$arRes = Db::getInstance()->executeS($sql);
//echo '<br><pre>';print_r($arRes);echo '</pre>';

if(!TDM_ISADMIN){
    global $TDMCore;
    $arPGID = $TDMCore->arPriceGID;
    global $USER;
    $arGroups = array((int)Group::getCurrent()->id);

    $isAuthorisedGroup = false;
    foreach($arPGID as $TDM_GID=>$CMS_GID){
        if(in_array($CMS_GID,$arGroups)){
            $isAuthorisedGroup = true;
            if($_SESSION['TDM_USER_GROUP']!=$TDM_GID){
                $_SESSION['TDM_USER_GROUP']=$TDM_GID;
                header('Location: '.$_SERVER['REQUEST_URI']);
            }
            break;
        }
    }
    if (!$isAuthorisedGroup) {
        unset($_SESSION['TDM_USER_GROUP']);
    }
}

//Add to cart
if(defined('TDM_ADD_TO_CART') AND TDM_ADD_TO_CART){
	global $arCartPrice;
	if(is_array($arCartPrice)){
		if($arCartPrice['OPTIONS']['MINIMUM']>1){$QUANTITY=$arCartPrice['OPTIONS']['MINIMUM'];}else{$QUANTITY=1;}
		$DefaultCategory = 12;
		$DefaultTaxGroup = 0;
		$Price = $arCartPrice['PRICE_CONVERTED'];
		$Reference = $arCartPrice['ARTICLE'].' / '.$arCartPrice['BRAND'];

		//Presta init
		global $context;
		if(!$context){$context = Context::getContext();}
		$logged = $context->cookie->__get('logged');
		$id_cart = $context->cookie->__get('id_cart');
		$id_lang = $context->cookie->__get('id_lang');
		$id_guest = $context->cookie->__get('id_guest');
		$id_currency = $context->cookie->__get('id_currency');

		// Add cart if no cart found
		if (!$id_cart){
			$context->cart = new Cart();
			$context->cart->id_customer = $context->customer->id;
			$context->cart->id_currency = $id_currency;
			$context->cart->add();
			if($context->cart->id){
				$context->cookie->id_cart = (int)$context->cart->id;
			}
            $id_cart = (int)$context->cart->id;
		}

		$doAdd="Y";
		//if(!$logged>0){$doAdd="N"; $TCore->arErrorMessages[] = 'You must be <a href="/index.php?controller=my-account">logged in</a> to buy products';}
		//if(trim($Reference)=='' OR !$Price>0 OR !$QUANTITY>0){$doAdd="N"; $TCore->arErrorMessages[] = 'Add to cart data is missing!';}
		if(!$id_cart>0){$doAdd="N"; ErAdd("Your cookie <b>id_cart</b> is wrong!",1);}
		if(!$id_lang>0){$doAdd="N"; ErAdd("Your cookie <b>id_lang</b> is wrong!",1);}
		if($doAdd!="N"){
			//Check avail. tecdoc item in Presta
			$sql = 'SELECT p.`id_product`, pl.`name` FROM `'._DB_PREFIX_.'product` p
					LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product`)
					WHERE pl.`id_lang` = '.$id_lang.' AND
					p.`price` = '.$Price.' AND
					p.`reference` = "'.$Reference.'"
					';
			$arRes = Db::getInstance()->executeS($sql);
			if(count($arRes)>0){
				$NewTID = $arRes[0]['id_product'];
			}else{
                    //Supplier data (for 1C integration)
					$supplierName = $arCartPrice['SUPPLIER_STOCK'];
                    $supplierId = $suppliers = (Supplier::getIdByName($supplierName));
                    if (!$supplierId) {
                        $supplier = new Supplier();
                        $supplier->name = $supplierName;
                        $supplier->active = 1;
                        $supplier->add();
                        $supplierId = $supplier->id;
                    }
					
					$obProduct = new Product(false,false,$id_lang);
					$obProduct->id_category_default = $DefaultCategory;
					$obProduct->unity = $arCartPrice['ADD_URL'];
					$obProduct->name = substr($arCartPrice['NAME'],0,400);
					$obProduct->description = 'This product is created automatically by TecDoc Module. http://tecdoc-module.com';
					$obProduct->description_short = $arCartPrice['SUPPLIER_STOCK'].' ['.$arCartPrice['DAY'].' days]';
					$obProduct->price = $Price;
                    $obProduct->wholesale_price = $arCartPrice['PRICE'];
					$obProduct->reference = $Reference;
					$obProduct->link_rewrite = $arCartPrice['CPID'];
					$obProduct->available_for_order = 1; //true
					$obProduct->visibility = 'none';
					$obProduct->is_virtual = 0;
					if($arCartPrice['OPTIONS']['WEIGHT']>0){$obProduct->weight = round($arCartPrice['OPTIONS']['WEIGHT']/1000,2);}
					if($arCartPrice['OPTIONS']['MINIMUM']>0){$obProduct->minimal_quantity = $arCartPrice['OPTIONS']['MINIMUM']; $QUANTITY=$arCartPrice['OPTIONS']['MINIMUM'];}
					if($arCartPrice['OPTIONS']['USED']>0){$obProduct->condition = 'used';}
					if($arCartPrice['OPTIONS']['RESTORED']>0){$obProduct->condition = 'refurbished';}

                    //supplier
                    $obProduct->supplier_name = $supplierName;
                    $obProduct->id_supplier = $supplierId;

					$obProduct->id_tax_rules_group = $DefaultTaxGroup;
					//echo '<br><pre>';print_r($obProduct);echo '</pre>';die();
					$obProduct->add();
					if($obProduct->id>0){
						$NewTID = $obProduct->id;
						$obProduct->setWsCategories(Array(Array("id"=>$DefaultCategory)));
						//Add image
						if($arCartPrice['IMG_SRC']!='' AND $NewTID>0){
							$shops = Shop::getShops(true, null, true);
							$image = new Image();
							$image->id_product = $NewTID;
							$image->position = Image::getHighestPosition($NewTID)+1;
							$image->cover = true; // or false;
							if(($image->validateFields(false, true)) === true && ($image->validateFieldsLang(false, true)) === true && $image->add()){
								$image->associateTo($shops);
								$tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
								if(Tools::copy($arCartPrice['IMG_SRC'], $tmpfile)){
									$path = $image->getPathForCreation();
									ImageManager::resize($tmpfile, $path.'.jpg');
								}
								unlink($tmpfile);
							}
						}
					}else{
						ErAdd("Prestashop new Item ID is false",1);
					}
					unset($obProduct);
			}

			if($NewTID>0){
				if($arCartPrice['AVAILABLE']>0){StockAvailable::setQuantity($NewTID, false, $arCartPrice['AVAILABLE']);}
				$obCart = new Cart($id_cart);
				$obCart->id_lang = $id_lang;
				$obCart->id_currency = $id_currency;
				if($obCart->updateQty($QUANTITY,$NewTID)){
					Header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); die();
				}else{
					ErAdd("Prestashop Add to Cart is false. NewTID=".$NewTID,1);
				}
			}
		}

	}
}


require($_SERVER["DOCUMENT_ROOT"]."/header.php");

ErShow();
echo $TDMContent;

require($_SERVER["DOCUMENT_ROOT"]."/footer.php");
?>