<?
$strTmp = $APPLICATION -> GetCurpageParam(); // для формирования ссылок
$arTmp = parse_url($_SERVER["REQUEST_URI"]);
$APPLICATION->SetCurPage($arTmp["path"], $arTmp["query"]);

if($arChoose)
{   
    if (empty($_REQUEST["orderby"])) $_REQUEST["orderby"] = "";
    if (empty($_REQUEST["sort"])) $_REQUEST["sort"] = "DESC";
   // arshow($_GET);
?>
<b class="sort_title">Сортировать: </b>
<select class="sorting_list" onchange="window.location.href=this.options[this.selectedIndex].value">
    <?
    foreach($arChoose as $arItem)
    {?>
        <option <?if($_GET["orderby"] == $arItem["CODE"] and $_GET["sort"] == $arItem["sort"]){ echo "selected='selected'";}?> value="<?=$APPLICATION->GetCurPageParam('orderby='.$arItem["CODE"].'&sort='.$arItem["sort"], array('sort', 'orderby', "producerCode", "sef"))?>"><?=$arItem["NAME"]?></option>
   <?}?>
    
</select><?
}

$strTmp = $APPLICATION -> GetCurpageParam(); // возвращаем чтобы ничего не сломать
$arTmp = parse_url($strTmp);
$APPLICATION->SetCurPage($arTmp["path"], $arTmp["query"]);
?>
