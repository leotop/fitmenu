<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("list");
?> Text here.... <?$APPLICATION->IncludeComponent("bitrix:photogallery.detail.list.ex", "light", Array(
	"THUMBNAIL_SIZE" => "250",	// Размер фотографии-анонса (px)
	"SHOW_PAGE_NAVIGATION" => "bottom",	// Показывать навигацию
	"SHOW_RATING" => "N",	// Показывать голосования
	"SHOW_SHOWS" => "N",	// Показывать количество показов
	"SHOW_COMMENTS" => "N",	// Показывать количество комментариев
	"MAX_VOTE" => "5",	// Максимальный балл
	"VOTE_NAMES" => "",	// Подписи к баллам
	"DISPLAY_AS_RATING" => "rating",	// В качестве рейтинга показывать
	"IBLOCK_TYPE" => "gallery",	// Тип инфоблока
	"IBLOCK_ID" => "8",	// Инфоблок
	"BEHAVIOUR" => "SIMPLE",	// Режим работы галереи
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => $arParams["CACHE_TIME"],	// Время кеширования (сек.)
	"SECTION_ID" => "",	// ID раздела
	"ELEMENT_LAST_TYPE" => "none",	// Дополнительные параметры выбора фото
	"ELEMENT_SORT_FIELD" => "NAME",	// Первое поле сортировки фото
	"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки фото
	"ELEMENT_SORT_FIELD1" => "",	// Второе поле сортировки фото
	"ELEMENT_SORT_ORDER1" => "asc",	// Порядок сортировки фото
	"DRAG_SORT" => "N",	// Сортировать фотографии в альбоме перетаскиванием
	"PROPERTY_CODE" => "",	// Свойства
	"DETAIL_URL" => "",	// Страница детального просмотра
	"DETAIL_SLIDE_SHOW_URL" => "slide_show.php?SECTION_ID=#SECTION_ID#&ELEMENT_ID=#ELEMENT_ID#",	// Страница слайд-шоу
	"SEARCH_URL" => "search.php",	// Страница поиска
	"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
	"GROUP_PERMISSIONS" => "",	// Группы пользователей, имеющие доступ к детальной информации
	"USE_DESC_PAGE" => "Y",	// Использовать обратную навигацию
	"PAGE_ELEMENTS" => "5",	// Количество фото на странице
	"DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT_DETAIL"],	// Формат вывода даты
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"ADDITIONAL_SIGHTS" => "",	// Дополнительные эскизы
	"PICTURES_SIGHT" => "real",	// Активный эскиз (один из множества дополнительных и основных эскизов)
	"PATH_TO_USER" => $arParams["PATH_TO_USER"],	// Путь к профилю пользователя
	"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],	// Отображение имени
	"SHOW_LOGIN" => "N",	// Показывать логин, если не задано имя
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>