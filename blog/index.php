<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Блог");
?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "sidebar", Array(
	"IBLOCK_TYPE" => "news",	// Тип инфоблока
	"IBLOCK_ID" => "14",	// Инфоблок
	"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
	"SECTION_CODE" => "",	// Код раздела
	"COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
	"TOP_DEPTH" => "2",	// Максимальная отображаемая глубина разделов
	"SECTION_FIELDS" => array(	// Поля разделов
		0 => "PICTURE",
		1 => "",
	),
	"SECTION_USER_FIELDS" => array(	// Свойства разделов
		0 => "",
		1 => "",
	),
	"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
	"VIEW_MODE" => "LINE",	// Вид списка подразделов
	"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>