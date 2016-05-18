<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
$aMenuLinksExt = array();

if(CModule::IncludeModule('iblock'))
{
	
    
    
    $IBLOCK_ID = 9;
    $arOrder = Array("SORT"=>"ASC");    // сортируем по свойству SORT по возрастанию
    $arSelect = Array("ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL");
    $arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
    
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();            // берем поля
       
            $aMenuLinksExt[] = Array(
                        $arFields['NAME'],
                        $arFields['DETAIL_PAGE_URL'],
                        Array(),
                        Array(),
                        ""
                        );
        }            

	if(defined("BX_COMP_MANAGED_CACHE"))
		$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>