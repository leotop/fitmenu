<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>         <? if(is_home()): ?>
    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
            "AREA_FILE_SHOW" => "page",
            "AREA_FILE_SUFFIX" => "bottom",
            "EDIT_TEMPLATE" => "standard.php"
            )
        );?>
    <? endif ?>
</div>
</div>
<?include "linkpager.php";?>
</div>

<div id="footer">
    <div class="footer__top-inner">
        <div class="fix-width">

            <ul class="footer__menu">
                <li><a href="http://fitmenu.ru/">Главная</a></li>
                <li><a href="http://fitmenu.ru/about/delivery/" target="_blanc">Доставка</a></li>
                <li><a href="http://fitmenu.ru/about/stocks/" target="_blanc">Акции</a></li>
                <li><a href="http://fitmenu.ru/about/discount/" target="_blanc">Скидки</a></li>
                <li><a href="/#filter">Как выбрать</a></li>
                <li><a href="http://fitmenu.ru/about/oplata/" target="_blanc">Оплата</a></li>
                <li><a href="http://fitmenu.ru/magaziny/" target="_blanc">Магазины</a></li>
                <li><a href="http://fitmenu.ru/news/" target="_blanc">Новости</a></li>
            </ul>
            <div class="social">
                <ul>
                    <li class="fb">
                        <a href="https://www.facebook.com/fitmenu.ru" target="_blank" title="Facebook" rel="nofollow"></a>
                    </li>
                    <li class="vk">
                        <a href="https://vk.com/fitmenu" title="Вконтакте" target="_blank" rel="nofollow"></a>
                    </li>
                    <li class="inst">
                        <a href="http://instagram.com/fitmenu" target="_blank" title="Инстаграм" rel="nofollow"></a>
                    </li>
                    <li class="tw">
                        <a href="https://twitter.com/fitmenu_ru" target="_blank" title="Twitter" rel="nofollow"></a>
                    </li>
                </ul>
                <div class="footer__join-us">Присоединяйся!</div>
            </div>
            <div class="footer__logo"><a class="link-layout" href="/"></a></div>

        </div>
    </div>
    <div class="footer__bottom-inner">
        <div class="fix-width footer__bottom">
            <div class="footer__copyright">
                © 2011 - <?php echo date('Y') ?> ООО Fitmenu.ru - Интернет магазин спортивного питания. Все права защищены. Доставка по всей России.
            </div>
            <ul class="footer__payments">
                <li><a href="http://fitmenu.ru/about/oplata/"></a></li>
                <li><a href="http://fitmenu.ru/about/oplata/"></a></li>
                <li><a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=2508/*http://market.yandex.ru/shop/272337/reviews" target="_blank"><img src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=2505/*http://grade.market.yandex.ru/?id=272337&action=image&size=0" border="0" width="88" height="31" alt="Читайте отзывы покупателей и оценивайте качество магазина на Яндекс.Маркете" /></a></li>
            </ul>
            <div class="hidden-480"><a style="color:white;display:inline-block;margin-top:20px;" href="http://promoexpert.pro" style="text-transform: none"><br/>Продвижение сайтов</a></div>
            <div class="footer__info">
                <div class="footer__contacts">
                    <a style="display:inline-block; float:right;" class="email" href="mailto:fitmenu@fitmenu.ru" title="fitmenu@fitmenu.ru">fitmenu@fitmenu.ru</a>
                    <p>
                        +7 (343) 351-05-85
                    </p>
                </div>
                <div class="footer__logo-icon">
                    <a href="fitmenu.ru"><img src="/bitrix/templates/fitmenu/images/logo.gif" alt="logo"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-up"></div>

    <div class="footer__sticky">
        <div class="footer__sticky-inner">
            <?
                $APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => SITE_TEMPLATE_PATH."/includes/action.php",
                    "EDIT_TEMPLATE" => "standard.php"
                    )
                );
            ?>
        </div>
    </div>
    <div class="discount_link"><a href="http://fitmenu.ru/about/stocks/">Акция</a></div>

    <div class="popup_discount mfp-hide"><img src="<?php echo SITE_TEMPLATE_PATH; ?>/images/popups/gift.jpg" alt="IMAGE" class="img-responsive"></div>
</div>

<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/settings.js"></script>

<script>
    $(window).scroll(function() {
        var shopCart = $('#shopCart');
        var scrollTop = $(document).scrollTop();
        var top = $('#header .top-menu').eq(0).height();
        var top2 = top + shopCart.height();
        var h = top;
        if(scrollTop > top2) {
            shopCart.addClass('fixed');
            $('.right-sidebar').addClass('m');
        }
        if(scrollTop < top) {
            shopCart.removeClass('fixed');
            $('.right-sidebar').removeClass('m');
        }
    });
</script> 
<?if(!$USER->IsAdmin()) { ?>
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
        (function(){ var widget_id = '6mVNGaKGA1';
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
    <!-- {/literal} END JIVOSITE CODE -->
    <?}?>

<div class="modal hiddencart">
    <div class="modal-inner">
        <div class="modal-cross show-cart-trigger">x</div>
        <span class="h1">Ваша корзина</span>
        <?$APPLICATION->IncludeComponent(
                "bitrix:sale.basket.basket",
                "popup",
                array(
                    "COLUMNS_LIST" => array(
                        0 => "NAME",
                        1 => "DISCOUNT",
                        2 => "PROPS",
                        3 => "DELETE",
                        4 => "DELAY",
                        5 => "PRICE",
                        6 => "QUANTITY",
                        7 => "SUM",
                    ),
                    "PATH_TO_ORDER" => "/personal/order/make/",
                    "HIDE_COUPON" => "N",
                    "PRICE_VAT_SHOW_VALUE" => "N",
                    "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
                    "USE_PREPAYMENT" => "N",
                    "QUANTITY_FLOAT" => "N",
                    "SET_TITLE" => "N",
                    "ACTION_VARIABLE" => "action",
                    "OFFERS_PROPS" => array(
                        0 => "CML2_ATTRIBUTES",
                    ),
                    "COMPONENT_TEMPLATE" => "popup",
                    "USE_AJAX"=>"Y"
                ),
                false
            );?>
    </div>
</div>

<!-- Yandex.Metrika informer -->
<a class="ya-inf" style="display:none" href="https://metrika.yandex.ru/stat/?id=30697873&amp;from=informer"
    target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/30697873/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
        style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:30697873,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    var yaParams = {/*Здесь параметры визита*/};
</script>

<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter30697873 = new Ya.Metrika({id:30697873,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,params:window.yaParams||{ }});
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/30697873" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<!-- old y-metrika -->

<span class="yandexmetrika"><!-- Yandex.Metrika informer -->
    <a href="https://metrika.yandex.ru/stat/?id=26396478&amp;from=informer"
        target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/26396478/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
            style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:26396478,lang:'ru'});return false}catch(e){}"/></a>

    <!-- Yandex.Metrika counter -->

    <?global $APPLICATION;
        $APPLICATION->ShowViewContent('reachgoal');?>

    <script type="text/javascript">
        (function (d, w, c) {


            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter26396478 = new Ya.Metrika({id:26396478,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,params:window.yaParams||{ }});
                } catch(e) { }
            });
            var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>

    <noscript><div><img src="//mc.yandex.ru/watch/26396478" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter --></span>

<!-- End old y-metrika -->


<span class="liveinternet"><!--LiveInternet counter--><script type="text/javascript"><!--
    document.write("<a style='display:none' href='//www.liveinternet.ru/click' "+
        "target=_blank><img src='//counter.yadro.ru/hit?t45.4;r"+
        escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
        ";"+Math.random()+
        "' alt='' title='LiveInternet' "+
        "border='0' width='31' height='31'><\/a>")
    //--></script><!--/LiveInternet--></span>
	
	  <div class="popup_discount mfp-hide">
    	<div class="popup_discount__inner">
    	    <img src="<?php echo SITE_TEMPLATE_PATH; ?>/images/popups/stock_email.jpg" alt="STOCK" class="img-responsive">
    	    <form action="" class="discount-form">
    	        <div class="discount-form__inner">
    	            <input type="text" class="discount-form__input" placeholder="E-mail" name="email">
    	            <button class="discount-form__submit">ОК</button>
    	        </div>
    	    </form>
    	</div>
    </div>
</body>
</html>