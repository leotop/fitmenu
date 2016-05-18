<? 
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle(""); 
?> 
<?
    $APPLICATION->IncludeComponent("bitrix:catalog.top", ".default", Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],    // Тип инфоблока
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],    // Инфоблок
        "ELEMENT_SORT_FIELD" => "PROPERTY_BUY_NUM",    // По какому полю сортируем элементы
        "ELEMENT_SORT_ORDER" => "desc",    // Порядок сортировки элементов
        "ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки элементов
        "ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки элементов
        "FILTER_NAME" => "arFilterBestSell",    // Имя массива со значениями фильтра для фильтрации элементов
        "HIDE_NOT_AVAILABLE" => "Y",    // Не отображать товары, которых нет на складах
        "ELEMENT_COUNT" => "4",    // Количество выводимых элементов
        "LINE_ELEMENT_COUNT" => "4",    // Количество элементов выводимых в одной строке таблицы
        "PROPERTY_CODE" => array(    // Свойства
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
        "OFFERS_LIMIT" => "1",    // Максимальное количество предложений для показа (0 - все)
        "VIEW_MODE" => "SECTION",    // Показ элементов
        "TEMPLATE_THEME" => "blue",    // Цветовая тема
        "PRODUCT_DISPLAY_MODE" => "N",
        "ADD_PICT_PROP" => "MORE_PHOTO",
        "LABEL_PROP" => "-",
        "SHOW_DISCOUNT_PERCENT" => "N",    // Показывать процент скидки
        "SHOW_OLD_PRICE" => "N",    // Показывать старую цену
        "SHOW_CLOSE_POPUP" => "N",    // Показывать кнопку продолжения покупок во всплывающих окнах
        "MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
        "MESS_BTN_COMPARE" => "Сравнить",    // Текст кнопки "Сравнить"
        "MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
        "MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
        "SECTION_URL" => "",    // URL, ведущий на страницу с содержимым раздела
        "DETAIL_URL" => "",    // URL, ведущий на страницу с содержимым элемента раздела
        "SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
        "PRODUCT_QUANTITY_VARIABLE" => "",    // Название переменной, в которой передается количество товара
        "CACHE_TYPE" => "A",    // Тип кеширования
        "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
        "CACHE_GROUPS" => "Y",    // Учитывать права доступа
        "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
        "ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
        "PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
        "PRICE_CODE" => array(    // Тип цены
            0 => "Интернет-магазин",
        ),
        "USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
        "SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
        "PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
        "CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
        "BASKET_URL" => "/personal/basket.php",    // URL, ведущий на страницу с корзиной покупателя
        "USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
        "ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
        "PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
        "PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
        "PRODUCT_PROPERTIES" => "",    // Характеристики товара
        "OFFERS_CART_PROPERTIES" => "",
        "ADD_TO_BASKET_ACTION" => "ADD",    // Показывать кнопку добавления в корзину или покупки
        "DISPLAY_COMPARE" => "N",    // Разрешить сравнение товаров
        ),
        false
    ); 

?> 

 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>