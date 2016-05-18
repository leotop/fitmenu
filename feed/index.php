<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Напишите нам");
?> <?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback", 
	".default", 
	array(
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "fitmenu@fitmenu.ru",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "EMAIL",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "7",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>