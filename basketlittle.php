<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "header", array(
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"SHOW_PRODUCTS" => "N",
		"POSITION_FIXED" =>"N",
	),
	false,
	array()
);?>