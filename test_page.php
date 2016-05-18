<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?> 
<? 
/*
echo 'd';

$filter = array();
$rsGroups = CGroup::GetList(($by="c_sort"), ($order="desc"), $filter); // выбираем группы
$is_filtered = $rsGroups->is_filtered; // отфильтрована ли выборка ?
$rsGroups->NavStart(50); // разбиваем постранично по 50 записей
echo $rsGroups->NavPrint(GetMessage("PAGES")); // печатаем постраничную навигацию
while($rsGroups->NavNext(true, "f_")) {
    echo "[".$f_ID."] ".$f_NAME." ".$f_DESCRIPTION."<br>";
}



$res = CUser::GetUserGroupList(1);
while ($arGroup = $res->Fetch()){
   print "<pre>"; print_r($arGroup); print "</pre>";
}
$arGroups = CUser::GetUserGroup(1);
$arGroups[] = 1;*/
//CUser::SetUserGroup(1, $arGroups);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>