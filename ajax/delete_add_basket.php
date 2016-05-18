<? require_once ("../bitrix/modules/main/include.php");?>

<?
    CModule::IncludeModule("sale");
    CModule::IncludeModule("catalog");
    CSaleBasket::Delete($_REQUEST["deletebasketid"]);
?>