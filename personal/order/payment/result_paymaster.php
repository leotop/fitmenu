<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результат оплаты");

//define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/paymaster_log.txt");
//AddMessage2Log("module called ".$_SERVER["REMOTE_ADDR"], "result_payment");
//AddMessage2Log(print_r($_POST, true), "result_payment");

?><?$APPLICATION->IncludeComponent(
    "bitrix:sale.order.payment.receive",
    "",
    Array(
        "PAY_SYSTEM_ID" => "11",
        "PERSON_TYPE_ID" => "1"
    ),
false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>