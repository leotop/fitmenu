<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "optimum, bcaa-три незаменимых аминокислоты(лейцин,валин и изолейцин), которые не вырабатываются нашим организмом, и так необходимы спортсмену");
$APPLICATION->SetPageProperty("keywords", "optimum bcaa");
$APPLICATION->SetPageProperty("title", "optimum bcaa Optimum Nutrition - купить со скидкой в Fitmenu");
$APPLICATION->SetTitle("optimum bcaa Optimum Nutrition");
?> 

<?$APPLICATION->IncludeComponent(
    "bitrix:news.detail", 
    "brend", 
    array(
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "N",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "USE_SHARE" => "N",
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "references",
        "IBLOCK_ID" => "",
        "ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
        "ELEMENT_CODE" => $_REQUEST["CODE"],
        "CHECK_DATES" => "Y",
        "FIELD_CODE" => array(
            0 => "DETAIL_TEXT",
            1 => "",
        ),
        "PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "IBLOCK_URL" => "",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        "ADD_ELEMENT_CHAIN" => "N",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "USE_PERMISSIONS" => "N",
        "CACHE_TYPE" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "PAGER_TEMPLATE" => ".default",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Страница",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => ""
    ),
    false
);?>

<?
$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter", 
	"default_brends", 
	array(
		"COMPONENT_TEMPLATE" => "default_brends",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "23",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"TEMPLATE_THEME" => "site",
		"FILTER_VIEW_MODE" => "horizontal",
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"SEF_MODE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"INSTANT_RELOAD" => "Y",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PRICE_CODE" => array(
			0 => "Интернет-магазин",
		),
		"CONVERT_CURRENCY" => "Y",
		"XML_EXPORT" => "N",
		"SECTION_TITLE" => "-",
		"SECTION_DESCRIPTION" => "-",
		"POPUP_POSITION" => "left",
		"SEF_RULE" => "/brend/".$_GET["CODE"]."/filter/#SMART_FILTER_PATH#/apply/",
		"SECTION_CODE_PATH" => "",
		"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
		"CURRENCY_ID" => ""
	),
	false
); 
?>
       
 <?
     if($_GET["orderby"]){$sort_od = $_GET["orderby"];}else{$sort_od = "PROPERTY_CATEGORY_PRODUCT";};
    if($_GET["sort"]){$sort_a_d = $_GET["sort"];}else{$sort_a_d = "asc";};   
    if($sort_od == "propertysort_209"){
        $sort_field2 = "PROPERTY_stock";
    }elseif($sort_od == "propertysort_210"){
        $sort_field2 = "PROPERTY_new";
    }else{
        $sort_field2 = "PROPERTY_CATEGORY_PRODUCT";
    };  

    if($_GET['select_id_catalog']){
        $arrSection_id = $_GET['select_id_catalog'];
        //создаем фильтр в который помещаем массив с id  разделов 1 уровня
        $arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, "SECTION_ID" => $arrSection_id);
        $db_list = CIBlockSection::GetList(Array("SORT"=>"­­ASC"), $arFilter, false);
        while($ar_result = $db_list->GetNext())
        {     // добавления id всех подразделов для фильтрации
            $new_section_filter[] = $ar_result["ID"]; 
        }
        // добавление id 1 уровня
        foreach( $arrSection_id as $id_section){
           $new_section_filter[] =  $id_section;
        }

        $arrFilter["SECTION_ID"] = $new_section_filter; 
    }  
    
 $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"list", 
	array(
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "23",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => $sort_od,
		"ELEMENT_SORT_ORDER" => $sort_a_d,
		"ELEMENT_SORT_FIELD2" => $sort_field2,
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"DISPLAY_COMPARE" => "N",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "N",
		"PAGE_ELEMENT_COUNT" => "30",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "CML2_MANUFACTURER",
			1 => "PACK",
			2 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "CML2_BASE_UNIT",
			2 => "MORE_PHOTO",
			3 => "CML2_MANUFACTURER",
			4 => "CML2_TRAITS",
			5 => "CML2_TAXES",
			6 => "FILES",
			7 => "CML2_ATTRIBUTES",
			8 => "CML2_BAR_CODE",
			9 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "5",
		"PRICE_CODE" => array(
			0 => "Интернет-магазин",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "Y",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRODUCT_PROPERTIES" => array(
			0 => "CML2_ATTRIBUTES",
		),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PAGER_TEMPLATE" => "modern",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"CONVERT_CURRENCY" => "N",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "CML2_ATTRIBUTES",
		),
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "Y",
		"COMPONENT_TEMPLATE" => "list",
		"BACKGROUND_IMAGE" => "-",
		"SEF_MODE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => ""
	),
	false
); ?>
     
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>