
<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");

?>
<div class="p404-wrap">
<div class="p404-child"><span class="p404-child-title">Упс!</span></div>
        <div class="p404-main">
            <p class="p404-main__title">Страница не найдена</p>
            <p class="p404-main__description">Попробуй еще раз, у тебя получится!</p>
        </div>
        <a href="/" class="p404-btn">Вернуться на главную</a>
</div>
<?



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>