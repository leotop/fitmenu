<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Фотогаллерея");
?><?$APPLICATION->IncludeComponent("bitrix:photogallery.section.list", "home", array(
	"IBLOCK_TYPE" => "gallery",
	"IBLOCK_ID" => "8",
	"SECTION_ID" => $_REQUEST["SECTION_ID"],
	"SECTION_CODE" => "",
	"BEHAVIOUR" => "SIMPLE",
	"PHOTO_LIST_MODE" => "Y",
	"SHOWN_ITEMS_COUNT" => "1",
	"ELEMENT_SORT_FIELD" => "SORT",
	"ELEMENT_SORT_ORDER" => "asc",
	"ELEMENT_SORT_FIELD1" => "",
	"ELEMENT_SORT_ORDER1" => "asc",
	"SORT_BY" => "UF_DATE",
	"SORT_ORD" => "ASC",
	"PAGE_ELEMENTS" => "0",
	"INDEX_URL" => "index.php",
	"SECTION_URL" => "section.php?SECTION_ID=#SECTION_ID#",
	"SECTION_EDIT_URL" => "section_edit.php?SECTION_ID=#SECTION_ID#",
	"SECTION_EDIT_ICON_URL" => "section_edit_icon.php?SECTION_ID=#SECTION_ID#",
	"UPLOAD_URL" => "upload.php?SECTION_ID=#SECTION_ID#",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"ALBUM_PHOTO_SIZE" => "250",
	"ALBUM_PHOTO_THUMBS_SIZE" => "250",
	"PAGE_NAVIGATION_TEMPLATE" => "",
	"DATE_TIME_FORMAT" => "d.m.Y",
	"SET_STATUS_404" => "N",
	"SET_TITLE" => "Y"
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>