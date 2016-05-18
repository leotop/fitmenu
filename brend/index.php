<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
?><?$APPLICATION->IncludeComponent(
    "bitrix:news.line",
    "",
    Array(
        "IBLOCK_TYPE" => "references",
        "IBLOCKS" => array("9"),
        "NEWS_COUNT" => "20",
        "FIELD_CODE" => array(),
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "DETAIL_URL" => "",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "300",
        "CACHE_GROUPS" => "Y"
    ),
false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>