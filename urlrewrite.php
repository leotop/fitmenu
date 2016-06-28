<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^={\"/brend/\".\$_GET[\"CODE\"].\"/filter/(.+?)/apply/\"}\\??(.*)#",
		"RULE" => "SMART_FILTER_PATH=\$1&\$2",
		"ID" => "bitrix:catalog.smart.filter",
		"PATH" => "/brend/detail.php",
	),
	array(
		"CONDITION" => "#^/blog/([a-zA-Z-0-9_]+)/([a-zA-Z-0-9_]+)?#",
		"RULE" => "SECTION_CODE=\$1&CODE=\$2&\$3",
		"ID" => "",
		"PATH" => "/blog/detail.php",
	),
	array(
		"CONDITION" => "#^/brend/([a-zA-Z-0-9_]+)?#",
		"RULE" => "CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/brend/detail.php",
	),
	array(
		"CONDITION" => "#^/blog(\\/[a-zA-Z-0-9_]+)?#",
		"RULE" => "SECTION_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/blog/list.php",
	),
	array(
		"CONDITION" => "#^/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/photogallery/#",
		"RULE" => "",
		"ID" => "bitrix:photogallery",
		"PATH" => "/photogallery/index.php",
	),
	array(
		"CONDITION" => "#^/articles/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/articles/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/pressa/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/pressa/index.php",
	),
	array(
		"CONDITION" => "#^/store/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/store/index.php",
	),
	array(
		"CONDITION" => "#^/vybor/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/vybor/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
);

?>