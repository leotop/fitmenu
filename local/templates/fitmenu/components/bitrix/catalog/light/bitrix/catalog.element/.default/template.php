<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */

/** @var array $arResult */

/** @global CMain $APPLICATION */

/** @global CUser $USER */

/** @global CDatabase $DB */

/** @var CBitrixComponentTemplate $this */

/** @var string $templateName */

/** @var string $templateFile */

/** @var string $templateFolder */

/** @var string $componentPath */

/** @var CBitrixComponent $component */

$this->setFrameMode(true);


$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);



$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);

$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;
$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);

$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);

?><div class="allTovar bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
<? if ('Y' == $arParams['DISPLAY_NAME']){ ?>
<? if(FALSE): ?>
<div class="bx_item_title">
	
		<span><? echo (
			isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			: $arResult["NAME"]
		); ?></span>
	
</div>

<? endif ?>
<?
}
reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
	<div class="bx_item_container">
		<div class="bx_lt"><? //print_r($arResult['PROPERTIES']) ?>
           <? echo label_product($arResult['PROPERTIES']) ?>
            <div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
            	<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
            		<div class="bx_bigimages_imgcontainer ">
            			<span class="bx_bigimages_aligner"><img	id="<? echo $arItemIDs['PICT']; ?>"	src="<? echo $arFirstPhoto['SRC']; ?>"
        				alt="<? echo $strAlt; ?>"title="<? echo $strTitle; ?>"/></span>
<? if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']){ ?>
			<div class="bx_stick_disc" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>" style="display: none;"></div>
<? }
if ($arResult['LABEL']){
?>
			<div class="bx_stick new" id="<? echo $arItemIDs['STICKER_ID'] ?>"><? echo $arResult['LABEL_VALUE']; ?></div>
<? } ?>
    	</div>
	</div>
<?
if ($arResult['SHOW_SLIDER']){
	if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])){
		if (5 < $arResult['MORE_PHOTO_COUNT'])
		{
			$strClass = 'bx_slider_conteiner full';
			$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
			$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
			$strSlideStyle = '';
		}
		else{
			$strClass = 'bx_slider_conteiner';
			$strOneWidth = '20%';
			$strWidth = '100%';
			$strSlideStyle = 'display: none;';
		}

?>

	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
		<div class="bx_slider_scroller_container">
			<div class="bx_slide">
				<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
<? foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto){?>
					<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?	}		unset($arOnePhoto); ?>
				</ul>
			</div>
			<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
			<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
		</div>
	</div>
<?	}
else	{
		foreach ($arResult['OFFERS'] as $key => $arOneOffer)	{
			if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
				continue;
			$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
			if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
			{
				$strClass = 'bx_slider_conteiner full';
				$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_slider_conteiner';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}

?>

	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
		<div class="bx_slider_scroller_container">
			<div class="bx_slide">
				<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
<?			foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto){
?>

					<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>

<?

			}

			unset($arOnePhoto);
?>
				</ul>
			</div>
			<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
			<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
		</div>
	</div>
<?
		}
	}
}
?>
</div>

		</div>
	<div class="bx_rt">

<?

$useBrands = ('Y' == $arParams['BRAND_USE']);

$useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);

if ($useBrands || $useVoteRating)

{

?>
	<div class="bx_optionblock">
<?
	if ($useBrands)
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", ".default", array(

			"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"ELEMENT_ID" => $arResult['ID'],
			"ELEMENT_CODE" => "",
			"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
			"WIDTH" => "",
			"HEIGHT" => ""
			),
			$component,
			array("HIDE_ICONS" => "Y")

		);?><?
	}
?>
	</div>
<?
}
//unset($useVoteRating);
unset($useBrands);
?>
<h1 class="hTovar"><?= $arResult["NAME"] ?></h1>
<div class="wrapperblockUpak">
		<div class="blockUpak">
                <div class="item_price priceGood">
                <?
                $boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
                ?>
                <? if($boolDiscountShow) : ?>
                <div class="label_discount">
                    <span>Скидка!</span>
                </div>
                <? endif ?>
                <div class="price-full">
                	<div class="item_old_price" id="<? echo '_'.$arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>">
                        <? echo ($boolDiscountShow ? $arResult['MIN_PRICE']['VALUE'].'<span class="rub">Р</span>' : ''); //$arResult['MIN_PRICE']['PRINT_VALUE'] ?>
                    </div>

                	<div class="_item_current_price product-price" id="<? echo '_'.$arItemIDs['PRICE']; ?>">
                        <span class="p"><?= $_price = number_format($arResult['MIN_PRICE']['DISCOUNT_VALUE'],0,'.',' '); //DISCOUNT_VALUE ?></span> 
                        <span class="rub">Р</span>
                    </div>
                 </div>   
               	<div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>">
                   <? echo ($boolDiscountShow ? GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?>
                   </div>
                </div>
                
              
                
                
                
        
         </div>
                <div class="params">
                					<p class="bendLink">Категория: <strong>
                                    <? $sections = $arResult['SECTION']['PATH']; $section = array_pop($sections) ?>
                                    <? //foreach($arResult['SECTION']['PATH'] as $section): ?>
                                        <a href="<?= $section['SECTION_PAGE_URL'] ?>" title="<?= $section['NAME']?>"><?= $section['NAME']?></a>
                                    <? // endforeach ?>
                                    </strong>
                                    </p>
                					<p class="bendLink">Производитель: <strong><? echo (! empty($arResult['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['DISPLAY_VALUE']) ? $arResult['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['DISPLAY_VALUE'] : ''); ?></strong></p>
                                    <p class="bendLink">Упаковка: <strong><? echo (! empty($arResult['DISPLAY_PROPERTIES']['PACK']['DISPLAY_VALUE']) ? $arResult['DISPLAY_PROPERTIES']['PACK']['DISPLAY_VALUE'] : ''); ?></strong></p>

                   </div>
                </div>
                
                
                <div class="wrapperblockUpak do">
		              <div class="blockUpak">
                           <div class="price_section">
                            <span>Цена за порцию</span>
                             <? $COUNT_PACK = ! empty($arResult['PROPERTIES']['COUNT_PACK']['VALUE']) ? $arResult['PROPERTIES']['COUNT_PACK']['VALUE'] : $arResult['PROPERTIES']['COUNT_PACK']['DEFAULT_VALUE']; ?>
                            <b><? $_p_pack = $arResult['MIN_PRICE']['DISCOUNT_VALUE']/$COUNT_PACK; echo number_format($_p_pack,0,'.',' '); ?></b><span class="rub">Р</span>
                        </div>
                      </div>
                      <div class="params">
                                   <div class="bendLink count_pack">
                                        Порций в упаковке: <strong><? echo (! empty($arResult['PROPERTIES']['COUNT_PACK']['VALUE']) ? $arResult['PROPERTIES']['COUNT_PACK']['VALUE'] : '1'); ?></strong>
                                </div>
                      </div>
                </div>
                
                
                <div class="wrapperblockUpak tre">
                      <div class="blockUpak">
                      
                             <?
                    if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))                  {
                    	$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
                    }
                    else{
                    	$canBuy = $arResult['CAN_BUY'];
                    }
                    if ($canBuy){
                    	$buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
                    	$buyBtnClass = 'bx_big bx_bt_button bx_cart';
                    }
                    else{
                        
                        
                        $subsrieb = true;
                        $buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
                    	$buyBtnClass = 'bx_big bx_bt_button_type_2 bx_cart';
                    }
                    ?>
                
                	<?  if($canBuy): ?>
                            <div class="quantity">
                                <span class="item_section_name_gray">Кол-во<? // echo GetMessage('CATALOG_QUANTITY'); ?></span>
                        		<span class="item_buttons_counter_block">
                        			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" data-quantity="down" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
                        			<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
                        					? 1
                        					: $arResult['CATALOG_MEASURE_RATIO']
                        				); ?>">
    
                        			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" data-quantity="down" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
                        			<span class="bx_cnt_desc" id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
                        		</span>
                            </div>
                    <? endif ?>
                    
                    <div class="blockUpak2">
                                <div class="shk-item buttonBlock">
                   <? if ('Y' == $arParams['USE_PRODUCT_QUANTITY']){
                    ?>
                    <? if($canBuy) : ?>
                        <div class="item_buttons vam">
                    		<span class="item_buttons_counter_block">
                    			<? if(count($arResult['OFFERS']) < 1): ?>
                                <a href="javascript:void(0);" class="<? echo $buyBtnClass; ?>  to-cart-full" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><?  echo $buyBtnMessage; ?></a>
                                <? if(! empty($subsrieb)){
                                    $APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
							"NOTIFY_ID" => $arResult['ID'],
                            "NOTIFY_PRODUCT_ID" => $arResult['ID'],
							"NOTIFY_URL" => htmlspecialcharsback($arResult["SUBSCRIBE_URL"]),
							"NOTIFY_USE_CAPTHA" => "N"
							),false,
							$component
						);
                                } ?>
                                
                                <? endif ?>
                    <?	if ('Y' == $arParams['DISPLAY_COMPARE']){   ?>

                    			<a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" style="margin-left: 10px"><? echo ('' != $arParams['MESS_BTN_COMPARE']

                    					? $arParams['MESS_BTN_COMPARE']

                    					: GetMessage('CT_BCE_CATALOG_COMPARE')

                    				); ?></a>

                    <?      	}               ?>
                    		</span>

                    	</div>
                        
                       <? endif ?> 
                    <div class="offers">
                       <? $k_offers = 0; ?>
                                 
                            <? $arShowOffers = array(); $s_o = 0; foreach ($arResult['OFFERS'] as $key => $arOffer): ?>
                               <? if(! empty($arOffer['PROPERTIES']['CML2_ATTRIBUTES']['VALUE'])): ?>
                                    <? $arShowOffer = $arOffer; 
                                      $CML2_ATTRIBUTES = $arOffer['PROPERTIES']['CML2_ATTRIBUTES']['VALUE'];
                                       $CML2_ATTRIBUTES_DESCRIPTION = $arOffer['PROPERTIES']['CML2_ATTRIBUTES']['DESCRIPTION'];
                                       $k_brend = array_search('Бренд',$CML2_ATTRIBUTES_DESCRIPTION);
                                       if(isset($k_brend)){
                                          unset($CML2_ATTRIBUTES[$k_brend]);
                                       }
                                     ?>
                                     <? $arShowOffer['ATTRIBUTES'] = $CML2_ATTRIBUTES;
                                         $arShowOffer['ATTRIBUTES_DECRIPTION'] = $CML2_ATTRIBUTES_DESCRIPTION;
                                      $arShowOffers[] = $arShowOffer; ?>
                                     
                                         
                                         <? foreach($CML2_ATTRIBUTES as $k => $CML2_ATTRIBUTE): ?>
                                            <? $k_offers++; ?>
                                         <? endforeach ?>
                               <? endif ?> 
                            <? endforeach ?>
                            
                            <? if($k_offers > 0): ?>
                                <div class="select_sku">
                                <select name="offers" class="offers-select">
                                <? foreach($arShowOffers as $arShowOffer): ?>
                                     <? if(count($arShowOffer['ATTRIBUTES']) > 0): ?>
                                            <? foreach($arShowOffer['ATTRIBUTES'] as $k => $CML2_ATTRIBUTE): ?>
                                                  <option value="<? echo $arShowOffer['ID']  ?>" <? echo (++$s_o == 1 ? 'selected="selected"' : ''); ?>   >
                                                 <p><b><?echo $arShowOffer['ATTRIBUTES_DECRIPTION'][$k]?>:</b> <? echo $CML2_ATTRIBUTE  ?></p></option>
                                            <? endforeach ?>
                                     <? endif ?>
                                <? endforeach ?>
                                </select>
                                </div>
                            <? endif ?>
                    <? $b_o = 0; foreach($arShowOffers as $arShowOffer): ?>
                             <div class="offer <? echo (++$b_o > 1 ? 'hidden' : '');?>" id="_offer_<? echo $arShowOffer['ID']  ?>">
                                <? if(count($arShowOffer['ATTRIBUTES']) > 0): ?>
                                <div class="left">
                                    <? foreach($arShowOffer['ATTRIBUTES'] as $k => $CML2_ATTRIBUTE): ?>
                                    <p><b><?echo $arShowOffer['ATTRIBUTES_DECRIPTION'][$k]?>:</b> <? echo $CML2_ATTRIBUTE  ?></p>
                                    <? endforeach ?>
                                </div>
                                <div class="prices">
                                    <? foreach($arShowOffer['PRICES'] as $k => $Offer_price): ?>
                                        <p class="price"><b><? echo $Offer_price['VALUE'] ?></b><span class="rub">P</span> </p>
                                    <? endforeach ?>
                                </div>
                                <? endif ?>
                                <? if($canBuy) : ?>
                                 <div class="buy">
                                    <a href="<? echo $arShowOffer['ADD_URL'] ?>" id="<? echo $arShowOffer['ID'] ?>_buy_link" class="bx_big bx_bt_button bx_cart to-cart-full" title="Купить"><span></span> <?  echo $buyBtnMessage; ?></a>
                                </div>
                                <? else : ?>
                                   	<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
        							"NOTIFY_ID" => $arShowOffer['ID'],
        							"NOTIFY_URL" => htmlspecialcharsback($arShowOffer["SUBSCRIBE_URL"]),
        							"NOTIFY_USE_CAPTHA" => "N"
        							),
        							$component
        						);?>
                                <? endif ?>
                             </div>
                    <? endforeach ?>
                    </div>
                         
                   <?       	if ('Y' == $arParams['SHOW_MAX_QUANTITY'])                   	{
                    		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
                    		{
                    ?>
                    	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
                    <?
                    		}
                    		else
                    		{
                    			if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO'])
                    			{
                    ?>
                   	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? echo $arResult['CATALOG_QUANTITY']; ?></span></p>
                   <?
                    			}
                    		}
                    	}
                    }
                    else
                    {
                    ?>
                    	<div class="item_buttons vam">
                    		<span class="item_buttons_counter_block">
                    			<a href="javascript:void(0);" class="<? echo $buyBtnClass; ?>" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
                    <?
                   	if ('Y' == $arParams['DISPLAY_COMPARE'])
                    	{
                    ?>
                    			<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" style="margin-left: 10px"><? echo ('' != $arParams['MESS_BTN_COMPARE']
                    					? $arParams['MESS_BTN_COMPARE']
                    					: GetMessage('CT_BCE_CATALOG_COMPARE')
                    				); ?></a>
                    <?
                    	}
                    ?>
                    		</span>
                    	</div>
                    <?
                    }
                    ?>
                </div>
                </div>
                      </div>
                      
                      
                      <div class="params">
                                      	<div class="w">
                                        
                        					<div >
                    						<p><strong>Рейтинг</strong></p>
                    						<div class="anythingRating">
                                              <? if ($useVoteRating)
                                            	{
                                           		?><?$APPLICATION->IncludeComponent(
                                            			"bitrix:iblock.vote",
                                            			"stars",
                                            			array(
                                            				"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                                            				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                            				"ELEMENT_ID" => $arResult['ID'],
                                            				"ELEMENT_CODE" => "",
                                            				"MAX_VOTE" => "5",
                                            				"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
                                            				"SET_STATUS_404" => "N",
                                            				"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
                                            				"CACHE_TYPE" => $arParams['CACHE_TYPE'],
                                            				"CACHE_TIME" => $arParams['CACHE_TIME']
                                            			),
                                           			$component,
                                            			array("HIDE_ICONS" => "Y")
                                            		);?><?
                                            	}
                                                unset($useVoteRating);
                                                 ?>
                                            </div>
                    					</div>
                                        <? $drink = $arResult['PROPERTIES']['drink']; if(! empty($drink['VALUE'])) : ?>
                                        <div class="drink hidden">
                                            <p><b><? echo $drink['NAME'] ?>:</b>
                                                <span><? echo implode('</span>,<span>',$drink['VALUE']); ?></span>
                                            </p>
                                        </div>
                                        <? endif ?>
                                    </div>	
                                <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                            <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,facebook,twitter,gplus" data-yashareTheme="counter"></div>
                      </div>
                      
                </div>
                
                <? $shops = $arResult['DISPLAY_PROPERTIES']['SHOPS']; if(! empty($shops['DISPLAY_VALUE'])) : ?>
                <?  // print_r($shops) ?>
                <div class="shop-block">
                    <h5>В магазинах</h5>
                    <ul>
                    <? foreach($shops['DISPLAY_VALUE'] as $shop): ?>
                        <li><? echo $shop ?></li>
                    <? endforeach ?>
                    </ul>
                </div>
                <? endif ?>
                
               
                                       
                <div class="wrapperblockUpak">
                       <div class="params">
                
                
            <? //  if($arParams["USE_STORE"] == "Y" && \Bitrix\Main\ModuleManager::isModuleInstalled("catalog")) : ?>
	<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", ".default", array(
		"PER_PAGE" => "10",
		"USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
		"SCHEDULE" => $arParams["USE_STORE_SCHEDULE"],
		"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
		"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
		"ELEMENT_ID" => $arResult['ID'],
		"STORE_PATH"  =>  $arParams["STORE_PATH"],
		"MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
	),
	$component
);
?> 
<? // endif ?>
                </div>
                
                </div>

  

  </div>

<!--</div>-->



<div class="bx_md">

<div class="mitWrapper hidden">

       <h3>С этим товаром покупают</h3>

       <div class="wrapperMit">

       	
       </div>
    </div>
    
    
    <div class="tab">
	   <div class="nav">
       	   <ul>
			   <li><a href="#description" id="nav_description">Описание</a></li>
			   <li><a href="#applying"  id="nav_applying">Применение</a></li>
    		   <li><a href="#totals" id="nav_totals">Состав</a></li>
			   <li><a href="#reviews" id="nav_reviews">Отзывы</a></li>
		   </ul>	   
		</div>	
		<div class="wrapper">
    		<div class="description block" id="tab_description">
				<h2>Описание</h2>
                <?
                	if ('html' == $arResult['DETAIL_TEXT_TYPE'])
                	{
                		echo $arResult['DETAIL_TEXT'];
                	}
                   	else
                	{
                		?><p><? echo $arResult['DETAIL_TEXT']; ?></p><?
                	}
                ?>
        	</div>
		<div class="applying  block" id="tab_applying">
				<h2>Применение</h2>
                <? //print_r($arResult['DISPLAY_PROPERTIES']) ?>
                <? echo(! empty($arResult['DISPLAY_PROPERTIES']['applying']['DISPLAY_VALUE']) ? $arResult['DISPLAY_PROPERTIES']['applying']['DISPLAY_VALUE'] : '') ?>
        	</div>
			<div class="total_products  block" id="tab_totals">
				<h2>Состав</h2>
			<? echo(! empty($arResult['DISPLAY_PROPERTIES']['totals']['DISPLAY_VALUE']) ? $arResult['DISPLAY_PROPERTIES']['totals']['DISPLAY_VALUE'] : '') ?>
        	</div>
			<div class="description  block" id="tab_reviews">
				<h2>Отзывы</h2>
                <? $APPLICATION->IncludeComponent(
                	"bitrix:catalog.comments",
                	"",
                	array(
                		"ELEMENT_ID" => $arResult['ID'],
                		"ELEMENT_CODE" => $arResult['CODE'],
                		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
                		"URL_TO_COMMENT" => "",
                		"WIDTH" => "600",
                		"COMMENTS_COUNT" => "5",
                		"BLOG_USE" => $arParams['BLOG_USE'],
                		"FB_USE" => $arParams['FB_USE'],
                		"FB_APP_ID" => $arParams['FB_APP_ID'],
                		"VK_USE" => $arParams['VK_USE'],
                		"VK_API_ID" => $arParams['VK_API_ID'],
                		"CACHE_TYPE" => "N",
                		"CACHE_TIME" => $arParams['CACHE_TIME'],
                		"BLOG_TITLE" => "",
                		"BLOG_URL" => $arParams['BLOG_URL'],
                		"PATH_TO_SMILE" => "",
                		"EMAIL_NOTIFY" => "Y",
                		"AJAX_POST" => "Y",
                		"SHOW_SPAM" => "Y",
                		"SHOW_RATING" => "Y",
                		"FB_TITLE" => "Комментарии",
                		"FB_USER_ADMIN_ID" => "leo.schneider.902",
                		"FB_COLORSCHEME" => "light",
                		"FB_ORDER_BY" => "reverse_time",
                		"VK_TITLE" => "",
                	),
                	false,
                	array("HIDE_ICONS" => "Y")
                );  ?>
        	</div>
		</div>
    </div>
</div>   	
<div class="bx_md">
<?
if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
{
?>
<? if(FALSE) :?>
<div class="item_info_section">
<?
	if (!empty($arResult['DISPLAY_PROPERTIES']))
	{
?>
	<dl>
<?
		foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp)
		{
?>
		<dt><? echo $arOneProp['NAME']; ?></dt><?

			echo '<dd>', (

				is_array($arOneProp['DISPLAY_VALUE'])

				? implode(' / ', $arOneProp['DISPLAY_VALUE'])

				: $arOneProp['DISPLAY_VALUE']

			), '</dd>';

		}

		unset($arOneProp);

?>

	</dl>

<?

	}

	if ($arResult['SHOW_OFFERS_PROPS'])

	{

?>

	<dl id="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?>" style="display: none;"></dl>

<?

	}

?>

</div>



 <? endif ?>

<?

}

if ('' != $arResult['PREVIEW_TEXT'])

{

	if (

		'S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE']

		|| ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])

	)

	{

?>

<div class="item_info_section">

<?

	//	echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');

?>

</div>

<?

	}

}

if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))

{

	$arSkuProps = array();

?>

<div class="item_info_section" style="padding-right:150px;" id="<? echo $arItemIDs['PROP_DIV']; ?>">

<?

	foreach ($arResult['SKU_PROPS'] as &$arProp)

	{

		if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))

			continue;

		$arSkuProps[] = array(

			'ID' => $arProp['ID'],

			'SHOW_MODE' => $arProp['SHOW_MODE'],

			'VALUES_COUNT' => $arProp['VALUES_COUNT']

		);

		if ('TEXT' == $arProp['SHOW_MODE'])

		{

			if (5 < $arProp['VALUES_COUNT'])

			{

				$strClass = 'bx_item_detail_size full';

				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';

				$strWidth = (20*$arProp['VALUES_COUNT']).'%';

				$strSlideStyle = '';

			}

			else

			{

				$strClass = 'bx_item_detail_size';

				$strOneWidth = '20%';

				$strWidth = '100%';

				$strSlideStyle = 'display: none;';

			}

?>

	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">

		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

		<div class="bx_size_scroller_container"><div class="bx_size">

			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">

<?

			foreach ($arProp['VALUES'] as $arOneValue)

			{

?>

				<li

					data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>"

					data-onevalue="<? echo $arOneValue['ID']; ?>"

					style="width: <? echo $strOneWidth; ?>; display: none;"

				><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span></li>

<?

			}

?>

			</ul>

			</div>

			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>

			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>

		</div>

	</div>

<?

		}

		elseif ('PICT' == $arProp['SHOW_MODE'])

		{

			if (5 < $arProp['VALUES_COUNT'])

			{

				$strClass = 'bx_item_detail_scu full';

				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';

				$strWidth = (20*$arProp['VALUES_COUNT']).'%';

				$strSlideStyle = '';

			}

			else

			{

				$strClass = 'bx_item_detail_scu';

				$strOneWidth = '20%';

				$strWidth = '100%';

				$strSlideStyle = 'display: none;';

			}

?>

	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">

		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

		<div class="bx_scu_scroller_container"><div class="bx_scu">

			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">

<?

			foreach ($arProp['VALUES'] as $arOneValue)

			{

?>

				<li

					data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>"

					data-onevalue="<? echo $arOneValue['ID']; ?>"

					style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>; display: none;"

				><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>

				<span class="cnt"><span class="cnt_item"

					style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"

					title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"

				></span></span></li>

<?

			}

?>

			</ul>

			</div>

			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>

			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>

		</div>

	</div>

<?

		}

	}

	unset($arProp);

?>

</div>

<?

}

?>



			<div class="clb"></div>

		</div>



		<div class="bx_md">

<div class="item_info_section">
<?

if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))

{

	if ($arResult['OFFER_GROUP'])

	{

		foreach ($arResult['OFFERS'] as $arOffer)

		{

			if (!$arOffer['OFFER_GROUP'])

				continue;

?>

	<span id="<? echo $arItemIDs['OFFER_GROUP'].$arOffer['ID']; ?>" style="display: none;">

<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",

	".default",

	array(

		"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],

		"ELEMENT_ID" => $arOffer['ID'],

		"PRICE_CODE" => $arParams["PRICE_CODE"],

		"BASKET_URL" => $arParams["BASKET_URL"],

		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],

		"CACHE_TYPE" => $arParams["CACHE_TYPE"],

		"CACHE_TIME" => $arParams["CACHE_TIME"],

		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

	),

	$component,

	array("HIDE_ICONS" => "Y")

);?><?

?>

	</span>

<?

		}

	}

}

else

{

	if ($arResult['MODULES']['catalog'])

	{

?><?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",

	".default",

	array(

		"IBLOCK_ID" => $arParams["IBLOCK_ID"],

		"ELEMENT_ID" => $arResult["ID"],

		"PRICE_CODE" => $arParams["PRICE_CODE"],

		"BASKET_URL" => $arParams["BASKET_URL"],

		"CACHE_TYPE" => $arParams["CACHE_TYPE"],

		"CACHE_TIME" => $arParams["CACHE_TIME"],

		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

	),

	$component,

	array("HIDE_ICONS" => "Y")

);?><?

	}

}

?>

</div>







		</div>

		<div class="bx_lb">

<div class="tac ovh">

</div>



		</div>

			<div style="clear: both;"></div>

	</div>

	<div class="clb"></div>

</div><?

if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))

{

	foreach ($arResult['JS_OFFERS'] as &$arOneJS)

	{

		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])

		{

			$arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));

			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];

		}

		$strProps = '';

		if ($arResult['SHOW_OFFERS_PROPS'])

		{

			if (!empty($arOneJS['DISPLAY_PROPERTIES']))

			{

				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)

				{

					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(

						is_array($arOneProp['VALUE'])

						? implode(' / ', $arOneProp['VALUE'])

						: $arOneProp['VALUE']

					).'</dd>';

				}

			}

		}

		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;

	}

	if (isset($arOneJS))

		unset($arOneJS);

	$arJSParams = array(

		'CONFIG' => array(

			'USE_CATALOG' => $arResult['CATALOG'],

			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],

			'SHOW_PRICE' => true,

			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),

			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),

			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),

			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],

			'OFFER_GROUP' => $arResult['OFFER_GROUP'],

			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']

		),

		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],

		'VISUAL' => array(

			'ID' => $arItemIDs['ID'],

		),

		'DEFAULT_PICTURE' => array(

			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],

			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']

		),

		'PRODUCT' => array(

			'ID' => $arResult['ID'],

			'NAME' => $arResult['~NAME']

		),

		'BASKET' => array(

			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],

			'BASKET_URL' => $arParams['BASKET_URL'],

			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES']

		),

		'OFFERS' => $arResult['JS_OFFERS'],

		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],

		'TREE_PROPS' => $arSkuProps

	);

}

else

{

	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);

	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)

	{

?>

<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">

<?

		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))

		{

			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)

			{

?>

	<input

		type="hidden"

		name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"

		value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"

	>

<?

				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))

					unset($arResult['PRODUCT_PROPERTIES'][$propID]);

			}

		}

		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);

		if (!$emptyProductProperties)

		{

?>

	<table>

<?

			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)

			{

?>

	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>

	<td>

<?

				if(

					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']

					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']

				)

				{

					foreach($propInfo['VALUES'] as $valueID => $value)

					{

						?><label><input

							type="radio"

							name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"

							value="<? echo $valueID; ?>"

							<? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>

						><? echo $value; ?></label><br><?

					}

				}

				else

				{

					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?

					foreach($propInfo['VALUES'] as $valueID => $value)

					{

						?><option

							value="<? echo $valueID; ?>"

							<? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>

						><? echo $value; ?></option><?

					}

					?></select><?

				}

?>

	</td></tr>

<?

			}

?>

	</table>

<?

		}

?>

</div>

<?

	}

	$arJSParams = array(

		'CONFIG' => array(

			'USE_CATALOG' => $arResult['CATALOG'],

			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],

			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),

			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),

			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),

			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),

			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']

		),

		'VISUAL' => array(

			'ID' => $arItemIDs['ID'],

		),

		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],

		'PRODUCT' => array(

			'ID' => $arResult['ID'],

			'PICT' => $arFirstPhoto,

			'NAME' => $arResult['~NAME'],

			'SUBSCRIPTION' => true,

			'PRICE' => $arResult['MIN_PRICE'],

			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],

			'SLIDER' => $arResult['MORE_PHOTO'],

			'CAN_BUY' => $arResult['CAN_BUY'],

			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],

			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),

			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],

			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],

			'BUY_URL' => $arResult['~BUY_URL'],

		),

		'BASKET' => array(

			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),

			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],

			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],

			'EMPTY_PROPS' => $emptyProductProperties,

			'BASKET_URL' => $arParams['BASKET_URL']

		)

	);

	unset($emptyProductProperties);

}

?>

<script type="text/javascript">

var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);

BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});

</script>

<? if(! is_ajax() AND empty($_GET['ajax_buy'])) : ?>
<div id="popup_form_product" style="display: none;">
	<input type="hidden" value="" name="popup_product_url" id="popup_product_url" /> 
	<h3><?=GetMessage("MESSAGE_ADD_CART"); ?></h3>
    <div class="product">
        <div class="img hidden">
        </div>
        <span class="name hidden"></span>
        <span class="sku hidden"></span>
        <span class="quantity hidden"></span>
        <span class="price hidden"></span>
    </div>
    <div class="bottons"></div>
</div>
<script>
 var wind2 = new BX.PopupWindow('popup_product', BX('popup_form_product'), {
        	lightShadow : true,
        	offsetTop: 10,
        	offsetLeft: 0,
        	autoHide: true,
        	closeByEsc: true,
        	zIndex: 510,
        	bindOptions: {position: "right"},
        	/*buttons: [
        		new BX.PopupWindowButton({
        			text : '<?=GetMessage("GOTO_CART");?>',
        			events : {
        				click : function() {
        				window.location.assign('/personal/cart/');
        			}
                    }
        		}),
        		new BX.PopupWindowButton({
        			text : '<?=GetMessage('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
        			events : {
        				click : function() {
        					wind2.close();
        				}
        			}
        		})
        	]*/
        });
        
wind2.setContent(BX('popup_form_product'));


$(function(){
    $('.to-cart-full').click(function(){
        var q = $('.transparent_input').val();
        q = parseInt(q);
        q = q < 1 ? 1 : q; 
        var a = $(this), url = a.attr('href') + '&ajax_basket=Y&quantity=' + q;
        
        var _product = $('.bx_item_detail').eq(0), preview = $('.bx_bigimages_aligner',_product), name = $('.hTovar',_product), offers_select = $('.offers-select',_product);
    
        //wind2.setBindElement(BX(id + '_buy_link'));
        wind2.setBindElement(BX(a.attr('id')));
        var popup_product = $('#popup_form_product');
        if(preview.length > 0){
            $('.product .img', popup_product).html(preview.html());
        }else{
            $('.product .img', popup_product).html('');
        }
        
        if(name.length > 0){
            $('.product .name', popup_product).html(name.html());
        }else{
            $('.product .name', popup_product).html('');
        }
        
        if(offers_select.length > 0){
            var sku = $('option:selected',offers_select);
            $('.product .sku', popup_product).html(sku.html());
        }else{
            $('.product .sku', popup_product).html('');
        }
        
        if(q > 0){
            $('.product .quantity', popup_product).html(q + '<b>шт.</b>');
        }else{
            $('.product .quantity', popup_product).html('');
        }
        wind2.show();
        
        BX.ajax.post(url, function(res){
           var shopCart = $('#shopCart');
            BX.ajax.get('/', '', function(html) {
                
                var cart = $(html).filter('#shopCart');
                if(cart.length > 0){
                    
                }else{
                    cart = $(html).find('#shopCart');
                }
                shopCart.html(cart.html()); 
                setTimeout(function(){
                    $('#popup_product').hide();
                },5000)   
            })
        })
        return !1;
    })
})

</script>
<? endif ?>
