<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?><!DOCTYPE html>
<html lang="ru">
<head>
    <base href="<?= $_SERVER['REQUEST_URI']?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="initial-scale=1,width=device-width" />

    <link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
    <?
        echo '<meta http-equiv="Content-Type" content="text/html; charset='.LANG_CHARSET.'"'.(true ? ' /':'').'>'."\n";
        $APPLICATION->ShowMeta("robots", false, true);
        $APPLICATION->ShowMeta("keywords", false, true);
        $APPLICATION->ShowMeta("description", false, true);
        $APPLICATION->ShowCSS(true, true);
    ?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <?

        $APPLICATION->ShowHeadStrings();
        CAjax::Init();
        $APPLICATION->ShowHeadScripts();

        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.7.1.min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/justSlider.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/justTabs.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/fancybox/jquery.mousewheel-3.0.6.pack.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/fancybox/jquery.fancybox.js");

        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.form.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.bpopup.min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.validate.min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.bpopup.min.js");
    ?>
    <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/order_form.js"></script>
    <?
        //        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/shide.js");

        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/fxSlider.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.maskedinput.min.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/respon.js");
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.magnific-popup.min.js");

        if(isset($_REQUEST[PAGEN_1])){
        ?><meta name="robots" content="noindex,follow" /><?
        }
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/main.js");

    ?>
    <?//Don't add shide.js across AddHeadScript
        //    <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH/js/shide.js"></script>
    ?>
    <link href="<?= SITE_TEMPLATE_PATH ?>/css/popup.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?= SITE_TEMPLATE_PATH ?>/css/respon.css" rel="stylesheet">
    <link href="<?= SITE_TEMPLATE_PATH ?>/css/magnific-popup.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
    <?php
        $curPage = $APPLICATION->GetCurPage(true);
        if (preg_match('/^\/catalog/', $curPage)) {
            echo '<link rel="canonical" href="' . $curPage . '" />';
        }
    ?>
</head>

<?php if ( is_home() ): ?>
    <body class="home">
    <?php else: ?>
    <body>
    <?php endif ?>

<div class="fon_buy"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.2&appId=530367760434104";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
</script>
<div id="fb-root"></div>

<div id="panel"><?$APPLICATION->ShowPanel();?></div>

<div id="header">
    <div class="top-banner">
    <a class="full-size-link" href="/catalog/sumki_sixpackfitness"></a>
    <div class="top-banner__inner">СУПЕР АКЦИЯ на сумки <span class="top-banner__logo lennylarry"><img
    src="<?= SITE_TEMPLATE_PATH ?>/images/top-banner/6pack.jpeg" alt="6pack" width="95px"></span> только до 30 июня!
    <a class="discount-link" href="/catalog/sumki_sixpackfitness">Подробнее</a> </div>
    </div>
    <div class="full-width">
        <div class="rs-navbar">
            <div class="main-menu-trigger"></div>
            <div class="rs-navbar__triggers">
                <div class="search-trigger"></div>
                <div class="login-trigger"></div>
                <div class="cart-trigger">
                    <span class="num-goods"></span>
                </div>
            </div>
        </div>
        <div class="top-nav-wrap row">
            <?$APPLICATION->IncludeComponent("bitrix:menu", "top", array(
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "Y",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "Y"
                    ),
                    false
                );?>
            <div class="favorite-list">
                <?$APPLICATION->IncludeComponent(
                        "yenisite:favorite.list",
                        ".default",
                        array(
                            "COMPONENT_TEMPLATE" => ".default",
                            "SECTION_USER_FIELDS" => array(
                                0 => "",
                                1 => "",
                            ),
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "FILTER_NAME" => "arrFilter",
                            "SHOW_ALL_WO_SECTION" => "N",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "THEME" => "red-flat",
                            "DETAIL_URL" => "",
                            "AJAX_MODE" => "Y",
                            "AJAX_OPTION_JUMP" => "Y",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "undefined",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_FILTER" => "N",
                            "ACTION_VARIABLE" => "action",
                            "PRICE_CODE" => array(
                                0 => "Интернет-магазин",
                            ),
                            "USE_PRICE_COUNT" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "PRICE_VAT_INCLUDE" => "Y",
                            "CONVERT_CURRENCY" => "N"
                        ),
                        false
                    );?>
            </div>
            <?  $APPLICATION->IncludeComponent("bitrix:system.auth.form", "light", array(
                    "REGISTER_URL" => SITE_DIR."login/",
                    "PROFILE_URL" => SITE_DIR."personal/",
                    "SHOW_ERRORS" => "N"
                    ),
                    false,
                    array()
                ); ?>
        </div>
    </div>
    <div class="fix-width">
        <div class="logo">

            <a href="/" title="Главная"></a>
        </div>
        <div class="wrapper search-box rs-show">
            <div class="s_wrapper">
                <!-- <div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'http://fitmenu.ru/search-ya/index.php','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2242885,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'Поиск','input_placeholderColor':'#000000','input_borderColor':'#787878'}"><form action="http://yandex.ru/search/site/" method="get" target="_self"><input type="hidden" name="searchid" value="2242885"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input type="submit" value="Найти"/></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script> -->
                <div class="searchTitle">
                    <?$APPLICATION->IncludeComponent(
                            "bitrix:search.title",
                            "search_new",
                            array(
                                "PRICE_CODE" => array(
                                    0 => "1",
                                ),
                                "SEARCH_IN_TREE" => "Y",
                                "PAGE" => "#SITE_DIR#search-new/",
                                "PAGE_2" => "#SITE_DIR#search-new/",
                                "COLOR_SCHEME" => "red",
                                "CURRENCY" => "RUB",
                                "CACHE_TIME" => "86400",
                                "INCLUDE_JQUERY" => "Y",
                                "EXAMPLE_ENABLE" => "N",
                                "NUM_CATEGORIES" => "1",
                                "TOP_COUNT" => "10",
                                "ORDER" => "rank",
                                "USE_LANGUAGE_GUESS" => "N",
                                "CHECK_DATES" => "N",
                                "SHOW_OTHERS" => "N",
                                "CATEGORY_OTHERS_TITLE" => "Прочее:",
                                "CATEGORY_0_TITLE" => "Поиск",
                                "CATEGORY_0" => array(
                                    0 => "iblock_catalog",
                                ),
                                "CATEGORY_0_iblock_catalog" => array(
                                    0 => "23",
                                ),
                                "COMPONENT_TEMPLATE" => "search_new",
                                "CACHE_TYPE" => "A"
                            ),
                            false
                        );?>
                </div>
                <p class="phone">+7 (343) 351-05-85</p>
            </div>
            <div class="holder">
                <ul class="social">

                    <li class="fb">
                        <a href="https://www.facebook.com/fitmenu.ru" target="_blank" title="Facebook" rel="nofollow"></a>
                    </li>
                    <li class="vk">
                        <a href="https://vk.com/fitmenu"  title="Вконтакте"  target="_blank" rel="nofollow"></a>
                    </li>
                    <li class="inst">
                        <a href="http://instagram.com/fitmenu"  target="_blank" title="Инстаграм" rel="nofollow"></a>
                    </li>
                    <li class="tw">
                        <a href="https://twitter.com/fitmenu_ru"  target="_blank" title="Twitter" rel="nofollow"></a>
                    </li>
                </ul>
                <div class="contacts">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                            "AREA_FILE_SHOW" => "sect",
                            "AREA_FILE_SUFFIX" => "work_time",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "standard.php"
                            )
                        );?>

                    <a class="call" href="/call" title="Заказать обратный звонок">Закажи обратный звонок</a>
                </div>
            </div>
        </div>

        <div class="private">

            <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "main",
                    array(
                        "ROOT_MENU_TYPE" => "main",
                        "MENU_CACHE_TYPE" => "Y",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "N",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                        "COMPONENT_TEMPLATE" => "main"
                    ),
                    false
                );?>

        </div>
    </div>
</div>
<div id="content">
<div class="fix-width <? echo (! empty($FULL_WIDTH) ? 'full' : '')?>">

<? if(empty($FULL_WIDTH)): ?>
    <div class="left-sidebar">
        <div class="menu-open__wrapper">
            <div class="menu-open__inner menu-open__inner--catalog">
                <span class="menu-open__title">Каталог</span>
                <button class="menu-open__trigger" type="button">☰</button>
            </div>

            <div class="menu-open left-menu">
                <ul class="tabs tab-nav">
                    <li class="active">
                        <a href="#tab1">продукция</a>
                    </li>
                    <li>
                        <a href="#tab2">бренды</a>
                    </li>
                </ul>
                <div class="tabs-container">
                    <div id="tab1">
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "catalog_vertical", Array(
                            "ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
                            "MENU_THEME" => "site",	// Тема меню
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "MAX_LEVEL" => "3",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            ), false);?>
                    </div>
                    <div id="tab2">
                        <?$APPLICATION->IncludeComponent("bitrix:menu", ".default", Array(
                            "ROOT_MENU_TYPE" => "left_brend",	// Тип меню для первого уровня
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_THEME" => "site",
                            "CACHE_SELECTED_ITEMS" => "N",
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "MAX_LEVEL" => "3",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "left_brend",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            "DELAY" => "N",	// Откладывать выполнение шаблона меню
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            ),false);?>
                    </div>
                </div>
            </div>
            <?
                if(!is_home()):
                    $APPLICATION->IncludeComponent(
                        "bitrix:sale.viewed.product",
                        "sidebar",
                        array(
                            "VIEWED_COUNT" => "8",
                            "VIEWED_NAME" => "Y",
                            "VIEWED_IMAGE" => "Y",
                            "VIEWED_PRICE" => "Y",
                            "VIEWED_CANBUY" => "N",
                            "VIEWED_CANBUSKET" => "Y",
                            "VIEWED_IMG_HEIGHT" => "50",
                            "VIEWED_IMG_WIDTH" => "50",
                            "BASKET_URL" => "",
                            "ACTION_VARIABLE" => "action",
                            "PRODUCT_ID_VARIABLE" => "id_viewed",
                            "SET_TITLE" => "N",
                            "COMPONENT_TEMPLATE" => "sidebar",
                            "VIEWED_CURRENCY" => "default",
                            "VIEWED_CANBASKET" => "Y"
                        ),
                        false
                    );?>
                <?endif;?>
            <?  ?>
        </div>
    </div>

    <div class="right-sidebar">
        <div id="shopCart" class="cart cart-open rs-show">
            <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "header", array(
                    "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                    "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                    "SHOW_PERSONAL_LINK" => "N",
                    "SHOW_NUM_PRODUCTS" => "Y",
                    "SHOW_TOTAL_PRICE" => "Y",
                    "SHOW_PRODUCTS" => "N",
                    "POSITION_FIXED" =>"N",
                    'AJAX_MODE' => 'Y'
                    ),
                    false,
                    array()
                );?>
        </div>
        <div class="sidebar-holder right-sidebar__discount">
            <span class="h3">Акция</span>
            <div class="special">
                <noindex>
                    <?$APPLICATION->IncludeComponent(
	"it:catalog.sales", 
	"template1", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "23",
		"DISCOUNT_ID" => "642",
		"COUNT_PRODUCT" => "3",
		"IBLOCKS_PROP" => "203",
		"DETAIL_URL" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "30000",
		"CACHE_GROUPS" => "Y",
		"PARENT_SECTION" => "",
		"COMPONENT_TEMPLATE" => "template1"
	),
	false
);?></noindex>
            </div>
        </div>

        <div class="sidebar-holder hidden-480">

            <a href="http://fitmenu.ru/about/delivery/variant-dostavki-1.php"><img src="http://fitmenu.ru/upload/medialibrary/cbf/cbf7d469f91a69d5e4d0cb50dcfc266f.jpg" width="250px" height="250px"></a>

        </div>
        <? if(! is_home()): ?>
            <div class="fix_right" >
                <div class="full-width ovf"> <?$APPLICATION->IncludeComponent(
                        "it:catalog.filter",
                        "side",
                        Array(
                            "IBLOCK_TYPE" => "catalog",
                            "IBLOCK_ID" => "23",
                            "FILTER_NAME" => "arrFilter",
                            "FIELD_CODE" => array(0=>"",1=>"",),
                            "PROPERTY_CODE" => array(0=>"sports",1=>"indicator",2=>"sex",3=>"mission",),
                            "OFFERS_FIELD_CODE" => array(0=>"",1=>"",),
                            "OFFERS_PROPERTY_CODE" => array(0=>"",1=>"",),
                            "LIST_HEIGHT" => "5",
                            "TEXT_WIDTH" => "20",
                            "NUMBER_WIDTH" => "5",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_GROUPS" => "Y",
                            "SAVE_IN_SESSION" => "N",
                            "PRICE_CODE" => array()
                        )
                    );?> </div>
            </div>

            <div class="social hidden-480">
                <?  $APPLICATION->IncludeComponent(
                        "softbalance:vkgroupwidget",
                        ".default",
                        array(
                            "LINK" => "fitmenu",
                            "TYPE" => "0",
                            "WIDTH" => "220",
                            "HEIGHT" => "200",
                            "COLOR_BACKGROUND" => "#FFFFFF",
                            "COLOR_TEXT" => "#2B587A",
                            "COLOR_BUTTON" => "#5B7FA6",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "0",
                            "CACHE_NOTES" => ""
                        ),
                        false
                    );  ?>
                <br />
                <?/* <div class="fb-like-box" data-href="https://www.facebook.com/fitmenu.ru" data-width="220" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div> */?> 

            </div>

            <? endif ?>


        <?$APPLICATION->ShowViewContent("catalog_mit");?>


    </div>
    <? endif ?>

<div class="content-holder <? echo (! empty($FULL_WIDTH) ? 'full' : '')?>">

<? if(is_home()): ?>
    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
            "AREA_FILE_SHOW" => "page",
            "AREA_FILE_SUFFIX" => "top",
            "EDIT_TEMPLATE" => "standard.php"
            )
        );?>
    <? endif ?>