<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Yandex Market");
//global $arrFilter; $arrFilter = array("!PROPERTY_WF_SALE" => false);
?> <?$APPLICATION->IncludeComponent(
	"webfly:yandex.market", 
	".default", 
	array(
		"PARAMS" => array(
		),
		"COND_PARAMS" => array(
		),
		"SALES_NOTES" => "0",
		"SALES_NOTES_TEXT" => "",
		"AGENT_CHECK" => "Y",
		"HTTPS_CHECK" => "N",
		"IBLOCK_TYPE_LIST" => array(
			0 => "catalog",
		),
		"SAVE_IN_FILE" => "N",
		"IBLOCK_CATALOG" => "Y",
		"IBLOCK_ID_IN" => array(
			0 => "23",
		),
		"IBLOCK_SECTION" => array(
			0 => "0",
		),
		"DO_NOT_INCLUDE_SUBSECTIONS" => "N",
		"IBLOCK_AS_CATEGORY" => "N",
		"UTM_CHECK" => "N",
		"UTM_SOURCE" => "YandexMarket",
		"UTM_CAMPAIGN" => "0",
		"UTM_MEDIUM" => "cpc",
		"UTM_TERM" => "0",
		"SITE" => "fitmenu.ru",
		"COMPANY" => "Фитменю",
		"SKU_NAME" => "PRODUCT_AND_SKU_NAME",
		"SKU_PROPERTY" => "PROPERTY_CML2_LINK",
		"FILTER_NAME" => "arrFilter",
		"MORE_PHOTO" => "MORE_PHOTO",
		"PRICE_ROUND" => "N",
		"PRICE_CODE" => array(
			0 => "Интернет-магазин",
		),
		"IBLOCK_ORDER" => "N",
		"CURRENCIES_CONVERT" => "NOT_CONVERT",
		"LOCAL_DELIVERY_COST" => "",
		"LOCAL_DELIVERY_COST_OFFER" => "0",
		"STORE_OFFER" => "0",
		"STORE_PICKUP" => "0",
		"NAME_PROP" => "0",
		"DETAIL_TEXT_PRIORITET" => "N",
		"NO_DESCRIPTION" => "N",
		"DISCOUNTS" => "DISCOUNT_CUSTOM",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "86400",
		"CACHE_FILTER" => "Y",
		"CACHE_NON_MANAGED" => "N",
		"BIG_CATALOG_PROP" => "800",
		"COMPONENT_TEMPLATE" => ".default",
		"OLD_PRICE" => "N",
		"AVAILABLE_ALGORITHM" => "QUANTITY_ZERO",
		"DELIVERY_OPTIONS_SHOP_EX" => "",
		"DELIVERY_OPTIONS_EX" => "",
		"NAME_PROP_COMPILE" => "",
		"NAME_CUT" => "",
		"PROPDUCT_PROP" => array(
		),
		"OFFER_PROP" => array(
		),
		"PREFIX_PROP" => "0",
		"DESCRIPTION" => "0",
		"AGE_CATEGORY" => "0",
		"AGE_CATEGORY_UNIT" => "year",
		"BID" => "0",
		"CBID" => "0",
		"CPA_SHOP" => "",
		"CPA_OFFERS" => "0",
		"MARKET_CATEGORY_PROP" => "",
		"DEVELOPER" => "",
		"VENDOR_CODE" => "",
		"COUNTRY" => "",
		"MANUFACTURER_WARRANTY" => ""
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>