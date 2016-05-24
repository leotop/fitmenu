<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global CDatabase $DB */
    /** @var CBitrixComponentTemplate $this */
    /** @var string $templateName */
    /** @var string $templateFile */
    /** @var string $templateFolder */
    /** @var string $componentPath */
    /** @var CBitrixComponent $component */
    $this->setFrameMode(true);
    if (!$arParams['FILTER_VIEW_MODE'])
        $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
    $arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
    $verticalGrid = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");

    if ($verticalGrid)
    {
    ?>    <div class="workarea grid2x1"><?
        }
        if ($arParams['USE_FILTER'] == 'Y')
        {

            $arFilter = array(
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ACTIVE" => "Y",
                "GLOBAL_ACTIVE" => "Y",
            );
            if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
            {
                $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
            }
            elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
            {
                $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
            }

            $obCache = new CPHPCache();
            if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
            {
                $arCurSection = $obCache->GetVars();
            }
            elseif ($obCache->StartDataCache())
            {
                $arCurSection = array();
                if (\Bitrix\Main\Loader::includeModule("iblock"))
                {
                    $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "NAME", "DESCRIPTION"));

                    if(defined("BX_COMP_MANAGED_CACHE"))
                    {
                        global $CACHE_MANAGER;
                        $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                        if ($arCurSection = $dbRes->Fetch())
                        {
                            $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
                        }
                        $CACHE_MANAGER->EndTagCache();
                    }
                    else
                    {
                        if(!$arCurSection = $dbRes->Fetch())
                            $arCurSection = array();
                    }
                }
                $obCache->EndDataCache($arCurSection);
            }
            if (!isset($arCurSection))
            {
                $arCurSection = array();
            }
            if ($verticalGrid)
            {
            ?><div class="bx_sidebar"><?
                }
            ?>

<?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.smart.filter",
                    //"visual_".($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL" ? "horizontal" : "vertical"),
                    ".default",
                    Array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arCurSection['ID'],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SAVE_IN_SESSION" => "N",
                        "XML_EXPORT" => "Y",
                        "SECTION_TITLE" => "NAME",
                        "SECTION_DESCRIPTION" => "DESCRIPTION",
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );?>

<?
                if ($verticalGrid)
                {
            ?></div><?
            }
        }
    ?>
    <?$arResult["VARIABLES"]["SECTION_ID"] = $arCurSection['ID'];?>

    <div class="in_stock_filter">
        <form action="" method="GET">
            <? $_GET['in_stock'] = ! empty($_GET['in_stock']) ? intval($_GET['in_stock']) : 0; 
                $arParams['HIDE_NOT_AVAILABLE'] = ($_GET['in_stock'] ? 'Y' : 'N');
                // $arParams['HIDE_NOT_AVAILABLE'] = "N"; $_GET['in_stock'] =0; // все в наличии
            ?>
            <input type="radio" class="hidden set" name="in_stock" value="1" <?= (! empty($_GET['in_stock']) ? ($_GET['in_stock'] == 1 ? 'checked="checked"' : '' ): '' ) ?> />
            <input type="radio" class="hidden reset" name="in_stock" value="0" <?= (! empty($_GET['in_stock']) ? ($_GET['in_stock'] == 0 ? 'checked="checked"' : '') : '') ?> />
        </form>	
        <a href="#in_stock" class="noactive">Показать</a>
        <span>, которых НЕТ в наличии</span>
    </div>

    <?

        if ($verticalGrid)
        {
        ?><div class="bx_content_section"><?
            }
        ?><?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                    "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                    "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                    "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                    "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
                ),
                $component
            );?><?
            if($arParams["USE_COMPARE"]=="Y")
            {
            ?><?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.compare.list",
                    "",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "NAME" => $arParams["COMPARE_NAME"],
                        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                        "COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
                    ),
                    $component
                );?><?
            }

            $intSectionID = 0;

            global $arrFilter;
            if($arParams["HIDE_NOT_AVAILABLE"] == 'Y'){

                $arrFilter['=ID'] = CIBlockElement::SubQuery("PROPERTY_CML2_LINK", 
                    array(
                        "IBLOCK_ID" => 24,
                        ">CATALOG_QUANTITY" => 0
                    )
                )
                ;
                $HIDE_NOT_AVAILABLE = "Y";

            }


            if($_GET["orderby"]) {
                $sort_od = $_GET["orderby"];
            } else {
                $sort_od = "PROPERTY_CML2_MANUFACTURER.SORT";
            };
            if ($_GET["sort"]) {
                $sort_a_d = $_GET["sort"];
            } else {  
                $sort_a_d = "asc";
            };   
            if ($sort_od == "propertysort_209") {
                $sort_field2 = "PROPERTY_stock";
            } elseif ($sort_od == "propertysort_210") {
                $sort_field2 = "PROPERTY_new";
            } else {
                $sort_field2 = "PROPERTY_CATEGORY_PRODUCT";
            };


        ?><?
            $intSectionID = $APPLICATION->IncludeComponent(
                "bitrix:catalog.section", 
                "list",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "ELEMENT_SORT_FIELD" => $sort_od,
                    "ELEMENT_SORT_ORDER" => $sort_a_d,
                    "ELEMENT_SORT_FIELD2" => $sort_field2,
                    "ELEMENT_SORT_ORDER2" => "asc",
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                    'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                    'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                    'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                    'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                    "ADD_SECTIONS_CHAIN" => "N"
                ),
                $component
            );            
        ?><?
            if ($verticalGrid)
            {
        ?></div>
    </div><?
    }
?>  
<?

    if (\Bitrix\Main\ModuleManager::isModuleInstalled("sale"))
    {
        $arRecomData = array();
        $recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
        $obCache = new CPHPCache();
        /*if ($obCache->InitCache(36000, serialize($recomCacheID), "/sale/bestsellers"))
        {
        $arRecomData = $obCache->GetVars();
        }
        elseif ($obCache->StartDataCache())
        {
        if (\Bitrix\Main\Loader::includeModule("catalog"))
        {
        $arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
        $arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
        }
        $obCache->EndDataCache($arRecomData);
        }
        if (!empty($arRecomData))
        {*/

        GLOBAL $arFilterBestSell;
        $arFilterBestSell = array(
            "SECTION_ID"=>$arResult["VARIABLES"]["SECTION_ID"], 
            "IBLOCK_ID"=>$arParams["IBLOCK_ID"],
            "INCLUDE_SUBSECTIONS"=>"Y"
        );
        $APPLICATION->IncludeComponent("bitrix:catalog.top", "bestsellers", Array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],	// Тип инфоблока
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],	// Инфоблок
            "ELEMENT_SORT_FIELD" => "PROPERTY_BUY_NUM",	// По какому полю сортируем элементы
            "ELEMENT_SORT_ORDER" => "desc",	// Порядок сортировки элементов
            "ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки элементов
            "ELEMENT_SORT_ORDER2" => "desc",	// Порядок второй сортировки элементов
            "FILTER_NAME" => "arFilterBestSell",	// Имя массива со значениями фильтра для фильтрации элементов
            "HIDE_NOT_AVAILABLE" => "Y",	// Не отображать товары, которых нет на складах
            "ELEMENT_COUNT" => "4",	// Количество выводимых элементов
            "LINE_ELEMENT_COUNT" => "4",	// Количество элементов выводимых в одной строке таблицы
            "PROPERTY_CODE" => array(	// Свойства
                //0 => "BUY_NUM",
                1 => "",
            ),
            "OFFERS_FIELD_CODE" => array(
                0 => "NAME",
                1 => "PREVIEW_PICTURE",
                2 => "",
            ),
            "OFFERS_PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "OFFERS_SORT_FIELD" => "sort",
            "OFFERS_SORT_ORDER" => "asc",
            "OFFERS_SORT_FIELD2" => "id",
            "OFFERS_SORT_ORDER2" => "desc",
            "OFFERS_LIMIT" => "1",	// Максимальное количество предложений для показа (0 - все)
            "VIEW_MODE" => "SECTION",	// Показ элементов
            "TEMPLATE_THEME" => "blue",	// Цветовая тема
            "PRODUCT_DISPLAY_MODE" => "N",
            "ADD_PICT_PROP" => "MORE_PHOTO",
            "LABEL_PROP" => "-",
            "SHOW_DISCOUNT_PERCENT" => "N",	// Показывать процент скидки
            "SHOW_OLD_PRICE" => "N",	// Показывать старую цену
            "SHOW_CLOSE_POPUP" => "N",	// Показывать кнопку продолжения покупок во всплывающих окнах
            "MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
            "MESS_BTN_COMPARE" => "Сравнить",	// Текст кнопки "Сравнить"
            "MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
            "MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
            "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
            "DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
            "SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
            "PRODUCT_QUANTITY_VARIABLE" => "",	// Название переменной, в которой передается количество товара
            "CACHE_TYPE" => "A",	// Тип кеширования
            "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
            "CACHE_GROUPS" => "Y",	// Учитывать права доступа
            "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
            "ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
            "PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
            "PRICE_CODE" => array(	// Тип цены
                0 => "Интернет-магазин",
            ),
            "USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
            "SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
            "PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
            "CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
            "BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
            "USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
            "ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
            "PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
            "PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
            "PRODUCT_PROPERTIES" => "",	// Характеристики товара
            "OFFERS_CART_PROPERTIES" => "",
            "ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
            "DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
            ),
            false
        );
        /*}*/
    }    
?>
<div class="content">
<?=$arCurSection['DESCRIPTION'] ?></div>