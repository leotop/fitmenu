<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?//global $arrFilter?>
<span class="head">Акции</span>



<?
        if($_GET["orderby"]){$sort_od = $_GET["orderby"];}else{$sort_od = "NAME";};
        if($_GET["sort"]){$sort_a_d = $_GET["sort"];}else{$sort_a_d = "asc";};    
     ?>
<?
$APPLICATION->IncludeComponent(
	"api:search.filter", 
	"filter_shares", 
	array(
		"COMPONENT_TEMPLATE" => "filter_shares",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "23",
		"FILTER_NAME" => "arrFilter",
		"REDIRECT_FOLDER" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "CML2_MANUFACTURER",
			1 => "mission",
			2 => "indicator",
			3 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_ACTIVE_SECTIONS" => "Y",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"LIST_HEIGHT" => "5",
		"TEXT_WIDTH" => "209",
		"NUMBER_WIDTH" => "85",
		"SELECT_WIDTH" => "220",
		"ELEMENT_IN_ROW" => "1",
		"NAME_WIDTH" => "",
		"FILTER_TITLE" => "Фильтр",
		"BUTTON_ALIGN" => "left",
		"SELECT_IN_CHECKBOX" => array(
			0 => "CML2_MANUFACTURER",
			1 => "mission",
			2 => "indicator",
			3 => "",
		),
		"CHECKBOX_NEW_STRING" => "N",
		"REPLACE_ALL_LABEL" => "N",
		"REMOVE_POINTS" => "N",
		"SECTIONS_DEPTH_LEVEL" => "",
		"SECTIONS_FIELD_TITLE" => "Разделы",
		"SECTIONS_FIELD_VALUE_TITLE" => "Все разделы",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"PRICE_CODE" => array(
			0 => "Интернет-магазин",
		),
		"INCLUDE_JQUERY" => "N",
		"INCLUDE_PLACEHOLDER" => "Y",
		"INCLUDE_CHOSEN_PLUGIN" => "Y",
		"CHOSEN_PLUGIN_PARAM__disable_search_threshold" => "30",
		"INCLUDE_FORMSTYLER_PLUGIN" => "Y",
		"INCLUDE_AUTOCOMPLETE_PLUGIN" => "N",
		"INCLUDE_JQUERY_UI" => "N",
		"INCLUDE_JQUERY_UI_SLIDER" => "N",
		"JQUERY_UI_SLIDER_BORDER_RADIUS" => "N",
		"INCLUDE_JQUERY_UI_SLIDER_TOOLTIP" => "Y",
		"JQUERY_UI_THEME" => "ts-red",
		"JQUERY_UI_FONT_SIZE" => "10px"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
); 
?>
<?
/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter", 
	"visual_vertical", 
	array(
		"COMPONENT_TEMPLATE" => "visual_vertical",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "23",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"TEMPLATE_THEME" => "black",
		"FILTER_VIEW_MODE" => "horizontal",
		"DISPLAY_ELEMENT_COUNT" => "N",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"INSTANT_RELOAD" => "Y",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PRICE_CODE" => array(
			0 => "Интернет-магазин",
		),
		"CONVERT_CURRENCY" => "Y",
		"XML_EXPORT" => "N",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "-",
		"POPUP_POSITION" => "left",
		"SEF_RULE" => "/examples/books/#SECTION_ID#/filter/#SMART_FILTER_PATH#/apply/",
		"SECTION_CODE_PATH" => "",
		"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
		"CURRENCY_ID" => "RUB"
	),
	false
);*/
?>
 <? 
    $arrFilter["PROPERTY_stock"] = 45;
    
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"list_shares", 
	array(
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "N",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"OFFER_ADD_PICT_PROP" => "FILE",
		"OFFER_TREE_PROPS" => array(
			0 => "-",
		),
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_CLOSE_POPUP" => "Y",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"AJAX_MODE" => "Y",
		"SEF_MODE" => "N",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "23",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => $sort_od,
		"ELEMENT_SORT_ORDER" => $sort_a_d,
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"ADD_SECTIONS_CHAIN" => "Y",
		"DISPLAY_COMPARE" => "N",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "NAME",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "",
		"SET_LAST_MODIFIED" => "Y",
		"USE_MAIN_ELEMENT_SECTION" => "Y",
		"SET_STATUS_404" => "Y",
		"PAGE_ELEMENT_COUNT" => "25",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "CML2_MANUFACTURER",
			1 => "PACK",
			2 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_ATTRIBUTES",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "active_from",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "",
		"BACKGROUND_IMAGE" => "-",
		"PRICE_CODE" => array(
			0 => "Интернет-магазин",
		),
		"USE_PRICE_COUNT" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRODUCT_PROPERTIES" => array(
			0 => "stock",
			1 => "new",
		),
		"USE_PRODUCT_QUANTITY" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"COMPONENT_TEMPLATE" => "list_shares",
		"MESS_BTN_COMPARE" => "Сравнить",
		"AJAX_OPTION_ADDITIONAL" => "",
		"FILE_404" => ""
	),
	false
);?>

 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>