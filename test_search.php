<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(""); ?><?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"search_new", 
	array(
		"PRICE_CODE" => array(
			0 => "1",
		),
		"SEARCH_IN_TREE" => "Y",
		"PAGE" => "#SITE_DIR#search-new/",
		"PAGE_2" => "#SITE_DIR#search-new/",
		"COLOR_SCHEME" => "red",
		"CURRENCY" => "RUB",
		"CACHE_TIME" => "86400",
		"INCLUDE_JQUERY" => "Y",
		"EXAMPLE_ENABLE" => "N",
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "10",
		"ORDER" => "rank",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "Y",
		"CATEGORY_OTHERS_TITLE" => "Прочее:",
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "23",
		),
		"COMPONENT_TEMPLATE" => "search_new",
		"CACHE_TYPE" => "A"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>