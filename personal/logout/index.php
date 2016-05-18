<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выход из личного кабинета");

if ($USER->IsAuthorized()) {
	$USER->Logout();
}
LocalRedirect('/');
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>