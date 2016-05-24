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

$intRowsCount = count($arResult['ITEMS']);
$strContID = 'cat_top_cont_'.$this->randString();
?><div id="<? echo $strContID; ?>" class="bx_catalog_tile_home_type_2 col<? echo $arParams['LINE_ELEMENT_COUNT']; ?> <? echo $templateData['TEMPLATE_CLASS']; ?>">
<div class="bx_catalog_tile_section">
<?
$boolFirst = true;
$arRowIDs = array();
foreach ($arResult['ITEMS'] as $keyRow => $arOneRow)
{
	$strRowID = 'cat-top-'.$keyRow.'_'.$this->randString();
	$arRowIDs[] = $strRowID;
?>
<div id="<? echo $strRowID; ?>" class="bx_catalog_tile_slide <? echo ($boolFirst ? 'active' : 'notactive'); ?>">
<ul class="products">
<?
	foreach ($arOneRow as $keyItem => $arItem)
	{
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
		$strMainID = $this->GetEditAreaId($arItem['ID']);

		$arItemIDs = array(
			'ID' => $strMainID,
			'PICT' => $strMainID.'_pict',
			'SECOND_PICT' => $strMainID.'_secondpict',
			'MAIN_PROPS' => $strMainID.'_main_props',

			'QUANTITY' => $strMainID.'_quantity',
			'QUANTITY_DOWN' => $strMainID.'_quant_down',
			'QUANTITY_UP' => $strMainID.'_quant_up',
			'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
			'BUY_LINK' => $strMainID.'_buy_link',
			'SUBSCRIBE_LINK' => $strMainID.'_subscribe',

			'PRICE' => $strMainID.'_price',
			'DSC_PERC' => $strMainID.'_dsc_perc',
			'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

			'PROP_DIV' => $strMainID.'_sku_tree',
			'PROP' => $strMainID.'_prop_',
			'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
			'BASKET_PROP_DIV' => $strMainID.'_basket_prop'
		);

		$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
		$strTitle = (
			isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
			? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
			: $arItem['NAME']
		);
?>
<li>

<img alt="<? echo $arItem['NAME']; ?>" src="<? echo ($arItem['PREVIEW_PICTURE']['SRC'] ? $arItem['PREVIEW_PICTURE']['SRC'] : '/bitrix/templates/fitmenu/components/bitrix/catalog.top/hot_main/images/no_photo.png'); ?>" />
	<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="product-link"><? echo $arItem['NAME']; ?></a>
	<p class="product-discription"><? echo $arItem['PREVIEW_TEXT']; ?></p>
	<p class="product-price">
    
    <? if ($arItem['CAN_BUY']) : ?>
        <? if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) : ?>
			<div class="bx_catalog_item_controls_blockone"><div style="display: inline-block;position: relative;">
				<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
				<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
				<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
				<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
			</div></div>
    <? endif ?>
			<div class="bx_catalog_item_controls_blocktwo">
				<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow">
            <?	echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCT_TPL_MESS_BTN_BUY'));
            ?>
				</a>
			</div>
   <? else : ?>
			<div class="bx_catalog_item_controls_blockone"><span class="bx_notavailable">
     <?	echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCT_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
?>
			</span></div>
 <?	endif?>
    
    </p>
	<span class="promo"></span>
    
    
    </li>
<?
	}
?>
	</ul>
    <div style="clear: both;"></div>
</div>
<?
	$boolFirst = false;
}
?>
</div>
<?
if (1 < $intRowsCount)
{
	$arJSParams = array(
		'cont' => $strContID,
		'left' => array(
			'id' => $strContID.'_left_arr',
			'class' => 'bx_catalog_tile_slider_arrow_left'
		),
		'right' => array(
			'id' => $strContID.'_right_arr',
			'class' => 'bx_catalog_tile_slider_arrow_right'
		),
		'rows' => $arRowIDs,
		'rotate' => (0 < $arParams['ROTATE_TIMER']),
		'rotateTimer' => $arParams['ROTATE_TIMER']
	);
	if ('Y' == $arParams['SHOW_PAGINATION'])
	{
		$arJSParams['pagination'] = array(
			'id' => $strContID.'_pagination',
			'class' => 'bx_catalog_tile_slider_pagination'
		);
	}
?>
<script type="text/javascript">
var ob<? echo $strContID; ?> = new JCCatalogTopSliderList(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>
<?
}
?>
</div>