<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("developers");
?> <?$APPLICATION->IncludeComponent(
    "bitrix:sale.export.1c",
    "",
    Array(
        "SITE_LIST" => "s1",
        "IMPORT_NEW_ORDERS" => "N",
        "1C_SITE_NEW_ORDERS" => "s1",
        "EXPORT_PAYED_ORDERS" => "Y",
        "EXPORT_ALLOW_DELIVERY_ORDERS" => "Y",
        "EXPORT_FINAL_ORDERS" => "N",
        "REPLACE_CURRENCY" => "руб.",
        "GROUP_PERMISSIONS" => array("1"),
        "USE_ZIP" => "Y",
        "INTERVAL" => "30",
        "FILE_SIZE_LIMIT" => "204800"
    ),
false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>