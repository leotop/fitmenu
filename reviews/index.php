<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Отзывы");
$APPLICATION->SetPageProperty("keywords", "Отзывы");
$APPLICATION->SetPageProperty("title", "Отзывы");
$APPLICATION->SetTitle("Отзывы");
?><a href="/feed" class="button-reviws" >Написать отзыв</a>
<br />
 
<!--
<img id="bxid_84224" src="//u37751.netangels.ru.images.1c-bitrix-cdn.ru/bitrix/images/fileman/htmledit2/php.gif?1401205842507" border="0"  /> 

-->
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"reviews", 
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "30",
		"NEWS_COUNT" => "5",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "DATE_CREATE",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.M.Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Отзывы",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"COMPONENT_TEMPLATE" => "reviews"
	),
	false
);?> <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

<script type="text/javascript">
  VK.init({apiId: 4630690, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Comments block will be -->

<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 10, width: "718", attach: "*"});
</script>
<div id="vk_comments"></div>
<div class="fb-comments" data-href="http://fitmenu.ru/reviews/" data-width="718" data-numposts="5"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>