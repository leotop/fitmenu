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

?>


    <div class="head-wrapper"><h1 class="head"><?=$arResult['NAME']?></h1></div>


<!--<div class="sort_catalog">

<b>Сортировать:</b>

<ul>

<li>По цене(возр.)</li>

<li>По цене(убыв.)</li>

<li>По рейтингу(возр.)</li>

<li>По рейтингу(убыв.)</li>

</ul>

</div>   -->



<div class="catalog-section">

    <?if($arParams["DISPLAY_TOP_PAGER"]):?>

        <p><?=$arResult["NAV_STRING"]?></p>

        <?endif?>



    <div class="catalog-view clearfix">

        <div class="sorting_block"><?

                // arshow($arParams);

            ?>

            <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(

                    "1"=>array("NAME"=>"по имени", "CODE"=> "NAME", "sort"=>"ASC"),

                    "2"=>array("NAME"=>"по возрастанию цены", "CODE"=> "CATALOG_PRICE_".$arResult["PRICES_ALLOW"][0], "sort"=>"ASC"),

                    "3"=>array("NAME"=>"по убыванию цены", "CODE"=> "CATALOG_PRICE_".$arResult["PRICES_ALLOW"][0], "sort"=>"DESC"),

                    // "3"=>array("NAME"=>"популярности(возр.)", "CODE" => "PROPERTY_rating", "sort"=>"ASC"),

                    "4"=>array("NAME"=>"по популярности", "CODE" => "PROPERTY_rating", "sort"=>"DESC"),

                    "5"=>array("NAME"=>"по акциям", "CODE" => "propertysort_209", "sort"=>"DESC"),

                    "6"=>array("NAME"=>"по новинкам", "CODE" => "propertysort_210", "sort"=>"DESC"),

                )));?><?

            ?>

            <div class="clear"></div>

        </div>

        <div class="btn-group">

            <button class="catalog-view__triggers is_active" id="catalog-list" title="Список"></button>

            <button class="catalog-view__triggers" id="catalog-grid" title="Сетка"></button>

        </div>

    </div>



    <table class="data-table category" cellspacing="0" cellpadding="0"  width="100%">

        <thead class="hidden-480">

            <tr>

                <td>Бренд</td>

                <td><?=GetMessage("CATALOG_TITLE")?></td>

                <?if(count($arResult["ITEMS"]) > 0):

                    foreach($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"] as $arProperty):?>

                    <?

                        if ($arProperty['CODE']== "ANONS") { continue;}

                    ?>

                    <td class="td <? echo ($arProperty['CODE'] == 'CML2_MANUFACTURER' ? "hidden" : " ")  ?>"<? echo ($arProperty['CODE'] == 'SUPER_FOOD' ? "style='display:none'" : "") ?> > <?=$arProperty["NAME"]?></td>

                    <?endforeach;

                    endif;?>

                <?foreach($arResult["PRICES"] as $code=>$arPrice):?>

                    <td>Цена<? //=$arPrice["TITLE"]?></td>

                    <?endforeach?>

                <?if(count($arResult["PRICES"]) > 0):?>

                    <td class="w_150"><? echo GetMessage("CATALOG_TD_ORDER")?></td>

                    <?endif?>

            </tr>

        </thead>

        <?foreach($arResult["ITEMS"] as $arElement){?>

            <?

                $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));

                $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

            ?>

            <? if(! empty($arElement['BREND'])): ?>

                <tr class="tr brend">

                    <td colspan="6"><? echo $arElement['BREND']['VIEW'] ?></td>

                </tr>

                <? endif ?>



            <? echo "<!--" . $arOffer['CATALOG_QUANTITY'] . "-->" ?>



            <tr class="category-item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">



                <td class="category-item__img-box"><? $preview = $arElement['DETAIL_PICTURE'];?>



                    <? echo label_product($arElement['PROPERTIES']) ?>



                    <div class="shide">

                        <?

                            $txt =  '<a href="'.$arElement["DETAIL_PAGE_URL"].'" title="'.$arElement["NAME"].'" class="preview">';

                            if(! empty($preview))

                            {

                                $txt .= '<img src="'.$preview["SRC"].'" alt="'.$arElement["NAME"].'" />';

                            }

                            $txt .= '</a>';



                            //                echo '<!--', base64_encode($txt), '-->';
                            echo $txt;

                        ?>

                    </div>

                </td>

                <td class="category-item__descr">

                    <div class="shide">

                        <?

                            /*echo '<!--', base64_encode(
                            '<a href="'.$arElement["DETAIL_PAGE_URL"].'" class="name">'.$arElement["NAME"].'</a>'
                            ), '-->'; */
                            echo '<a href="'.$arElement["DETAIL_PAGE_URL"].'" class="name">'.$arElement["NAME"].'</a>';

                        ?>

                    </div>

                    <?if(count($arElement["SECTION"]["PATH"])>0):?>

                        <br />

                        <?foreach($arElement["SECTION"]["PATH"] as $arPath):?>

                            / <a href="<?=$arPath["SECTION_PAGE_URL"]?>"><?=$arPath["NAME"]?></a>

                            <?endforeach?>

                        <?endif?>

                    <div class="desc">

                        <div class="shide">

                            <?

                                //     echo '<!--', base64_encode( $arElement['PREVIEW_TEXT'] ), '-->';

                                //  echo  '<!--', base64_encode($arElement['DISPLAY_PROPERTIES']['ANONS']['VALUE']), '-->';
                            echo  $arElement['PREVIEW_TEXT']; //$arElement['DISPLAY_PROPERTIES']['ANONS']['VALUE'];   //             arshow($arElement);

                            ?>

                        </div>

                    </div>

                </td>

                <?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

                    <?

                        // if ($arProperty['CODE']== "ANONS") { continue;}

                    ?>

                    <td class="td hidden-480 <? echo ($arProperty['CODE'] == 'PACK' ? "category-item__weight" : "") ?>" <? echo ($arProperty['CODE'] == 'SUPER_FOOD' ? "style='display:none'" : "") ?><? echo ($arProperty['CODE'] == 'CML2_MANUFACTURER' ? "style='display:none'" : "")  ?>>



                        <?if(is_array($arProperty["DISPLAY_VALUE"]))

                                echo implode(" / ", $arProperty["DISPLAY_VALUE"]);

                            elseif($arProperty["DISPLAY_VALUE"] === false)

                                echo " ";

                            else

                                echo '<span class="shide">'.$arProperty["DISPLAY_VALUE"].'</span>';
                                //echo '<span class="shide"><!--'.base64_encode($arProperty["DISPLAY_VALUE"]).'--></span>';
                                ?>

                    </td>

                    <?endforeach?>

                <?foreach($arResult["PRICES"] as $code=>$arPrice):?>

                    <td class="category__price">



                        <?if($arPrice = $arElement["PRICES"][$code]):?>

                            <?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>

                                <p class="old"><?=$arPrice["VALUE"]?> Р<span>Выгода: <? echo $arPrice["VALUE"] - $arPrice["DISCOUNT_VALUE"] ?> Р</span></p>

                                <p class="product-price shk-price" ><?echo '<span class="shide">'.round($arPrice["DISCOUNT_VALUE"]).'</span>'; ?><span  class="rub"> Р</span></p>

                                <?else:?>

                                <p class="product-price shk-price" ><?echo '<span class="shide">'.$arPrice["VALUE"].'</span>';?><span class="rub"> Р</span></p>

                                <?endif?>

                            <?else:?>

                             

                            <?endif;?>

                    </td>

                    <?endforeach;?>

                <td class="category__usp">

                    <ul class="category__usp-list">

                        <li class="category__usp-delivery">

                            <div class="category__usp-image"></div>

                            Бесплатная доставка

                        </li>

                        <li class="category__usp-pickup">

                            <div class="category__usp-image"></div>

                            Самовывоз

                        </li>

                        <li class="category__usp-pay">

                            <div class="category__usp-image"></div>

                            Удобная оплата

                        </li>

                    </ul>

                </td>

                <?if(count($arResult["PRICES"]) > 0):?>

                    <td class="category-item__buy">

                        <? //print_r($arElement['OFFERS']); ?>

                        <?if($arElement["CAN_BUY"]):?>

                            <? if(count($arElement['OFFERS']) < 1): ?>

                                <noindex>

                                    <!--<a href="<?echo $arElement["BUY_URL"]?>" class="to-cart" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>

                                      -->  <a href="<?echo $arElement["ADD_URL"]?>" class="to-cart" rel="nofollow"><? echo GetMessage("CATALOG_ADD")?></a>

                                </noindex>

                                <? endif ?>



                            <? // echo $offer['ID'].'--'.$offer['CAN_BUY'].'--'.$offer['CATALOG_QUANTITY']; ?>

                            <div class="offers">

                                <? $k_offers = 0; ?>

                                <? $arShowOffers = array(); $s_o = 0; foreach ($arElement['OFFERS'] as $key => $arOffer): ?>

                                    <? // echo $arOffer['CATALOG_QUANTITY']; ?>

                                    <? if(! empty($arOffer['PROPERTIES']['CML2_ATTRIBUTES']['VALUE'])): ?>

                                        <? $arShowOffer = $arOffer;

                                            $CML2_ATTRIBUTES = $arOffer['PROPERTIES']['CML2_ATTRIBUTES']['VALUE'];

                                            $CML2_ATTRIBUTES_DESCRIPTION = $arOffer['PROPERTIES']['CML2_ATTRIBUTES']['DESCRIPTION'];

                                            $k_brend = array_search('Бренд',$CML2_ATTRIBUTES_DESCRIPTION);

                                            if(isset($k_brend)){

                                                unset($CML2_ATTRIBUTES[$k_brend]);

                                            }

                                        ?>

                                        <? $arShowOffer['ATTRIBUTES'] = $CML2_ATTRIBUTES;

                                            $arShowOffer['ATTRIBUTES_DECRIPTION'] = $CML2_ATTRIBUTES_DESCRIPTION;

                                            $arShowOffer['CATALOG_QUANTITY'] = $arOffer['CATALOG_QUANTITY'];

                                            $arShowOffer['SUBSCRIBE_URL'] = $arOffer['SUBSCRIBE_URL'];

                                            $arShowOffer['ID'] = $arOffer['ID'];

                                            $arShowOffers[] = $arShowOffer; ?>

                                        <? foreach($CML2_ATTRIBUTES as $k => $CML2_ATTRIBUTE): ?>

                                            <? $k_offers++; ?>

                                            <? endforeach ?>

                                        <? endif ?>

                                    <? endforeach ?>



                                <? if($k_offers > 0): ?>

                                    <div class="select_sku">

                                        <? $SHOW_NOT_AVALIBELE = FALSE; // выводить подписку ?>

                                        <noindex>

                                            <select name="offers" class="offers-select">

                                                <? foreach($arShowOffers as $arShowOffer): ?>

                                                    <?  if($arShowOffer['CATALOG_QUANTITY'] > 0 OR $SHOW_NOT_AVALIBELE): // В наличии ?>

                                                        <option value="<? echo $arShowOffer['ID']  ?>" <?// echo (++$s_o == 1 ? 'selected="selected"' : ''); ?>>

                                                            <? //echo $arShowOffer['CATALOG_QUANTITY'].'-'; ?>

                                                            <? if(count($arShowOffer['ATTRIBUTES']) > 0): ?>

                                                                <? foreach($arShowOffer['ATTRIBUTES'] as $k => $CML2_ATTRIBUTE): ?>



                                                                    <? echo

                                                                        $arShowOffer['ATTRIBUTES_DECRIPTION'][$k].': '.$CML2_ATTRIBUTE

                                                                        ;?>



                                                                    <? endforeach ?>

                                                                <? else: ?>

                                                                <? echo $arShowOffer['NAME']; ?>

                                                                <? endif ?>

                                                        </option>

                                                        <? else: ?>



                                                        <? endif ?>

                                                    <? endforeach ?>

                                            </select>

                                        </noindex>

                                    </div>

                                    <? endif ?>



                                <? $b_o = 0; foreach($arShowOffers as $arShowOffer): ?>

                                    <div class="offer <? echo ($b_o > 0 ? 'hidden' : '');?>" id="_offer_<? echo $arShowOffer['ID']  ?>">

                                        <?  if($arShowOffer['CATALOG_QUANTITY'] > 0): // В наличии ?>

                                            <? if(count($arShowOffer['ATTRIBUTES']) > 0): ?>

                                                <div class="left">

                                                    <? foreach($arShowOffer['ATTRIBUTES'] as $k => $CML2_ATTRIBUTE): ?>

                                                        <p>

                                                            <b><? echo '<span class="shide">',

                                                                    $arShowOffer['ATTRIBUTES_DECRIPTION'][$k]

                                                                , '</span>: ';?></b>



                                                            <? echo '<span class="shide">',

                                                                    $CML2_ATTRIBUTE

                                                                , '</span>';?>



                                                        </p>

                                                        <? endforeach ?>

                                                </div>

                                                <div class="prices">

                                                    <? foreach($arShowOffer['PRICES'] as $k => $Offer_price): ?>

                                                        <p class="price"><b><? echo $Offer_price['VALUE'] ?></b><span class="rub">P</span> </p>

                                                        <? endforeach ?>

                                                </div>

                                                <? endif ?>

                                            <div class="buy">

                                                <a href="<? echo $arShowOffer['ADD_URL'] ?>" id="<? echo $arShowOffer['ID'] ?>_buy_link" onclick="return addtoBasket(<? echo $arShowOffer['ID']?>)" class="to-cart" title="Купить"><span>Купить</span> <?  echo $buyBtnMessage; ?></a>

                                                <a href="javascript:;" class="add_to_favorite" data-id="<?=$arElement["ID"]?>"></a>


                                                <!-- КУПИТЬ В ОДИН КЛИК -->



                                                <div class="one-click-buy">

                                                    <span data-id="<?=$arElement["ID"]?>">Купить в 1 клик</span>

                                                    <div class="nameElement" style="display:none"><?=$arElement["NAME"]?></div>

                                                </div>



                                            </div>

                                            <?  $b_o++;?>

                                            <? elseif($SHOW_NOT_AVALIBELE): ?>

                                            <?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(

                                                    "NOTIFY_ID" => $arShowOffer['ID'],

                                                    "NOTIFY_URL" => htmlspecialcharsback($arShowOffer["SUBSCRIBE_URL"]),

                                                    "NOTIFY_USE_CAPTHA" => "N"

                                                    ),

                                                    $component

                                                );?>

                                            <? endif ?>

                                    </div>

                                    <? endforeach ?>

                            </div>



                            <?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>

                            <? //print_r($arElement) ?>

                            <? foreach ($arElement['OFFERS'] as $key => $arOffer): ?>

                                <? //echo 'Q'.$arOffer['CATALOG_QUANTITY'] ?>

                                <? endforeach ?>

                            <div class="slad_empty">

                                <span class="hide-cart-trigger" data-id="<?=$arElement["ID"]?>"><?//=GetMessage("CATALOG_NOT_AVAILABLE")?>Сделать предзаказ</span>

                            </div>

                            <?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(

                                    "NOTIFY_ID" => $arElement['ID'],

                                    "NOTIFY_URL" => htmlspecialcharsback($arElement["SUBSCRIBE_URL"]),

                                    "NOTIFY_USE_CAPTHA" => "N"

                                    ),

                                    $component

                                );?>

                            <?endif?>

                    </td>

                    <?endif;?>

            </tr>

            <?};?>

    </table>

    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>

        <p><?=$arResult["NAV_STRING"]?></p>

        <?endif?>

</div>



<!-- Форма предзаказ -->

<div class="order_one_click preOrder">

    <div class="close_order_form show-cart-trigger">X</div>

    <p>Как только товар появится у нас на складе, мы сразу же свяжемся с Вами!</p>

    <form action="javascript:void(0)" id="order_one_click_new" name="order_one_click_new" method="post">

        <span>Имя</span>

        <input type="text" name="name_order" placeholder="обязательное поле" id="name_order" value="" required>

        <span>Тел.</span>

        <input type="number" name="phone_order" placeholder="обязательное поле" id="phone_order" value="" required>

        <span>E-mail</span>

        <input type="text" name="email_order" id="email_order" value="">

        <input type="hidden" form="order_one_click_new" id="id_order" name="id_order" value="">

        <span style=" font-size: 12px; font-weight: 600; ">Комментарий к заказу</span>

        <textarea type="text" name="coment_order" value=""></textarea>

        <input type="submit" value="Отправить" onclick="sendData()">

    </form>

    <div class="form_alert"></div>

</div>



<div class="popup-wrapper popup-oneClick">



    <div class="popup">

        <div class="popup__content">

            <h3 class="popup__title">Заказ в один клик</h3>

            <form class="popup__form" action="javascript:void(0)" id="newOneClick" name="newOneClick">

                <input type="text" id="name" name="name" placeholder="Имя" required>

                <input type="text" id="phone" name="phone" placeholder="Телефон" required>

                <input type="hidden" id="one_click_id" name="id_order" value="">

                <button type="submit" onclick="sendOneClick()">Отправить</button>

            </form>

            <div class="close-trigger">x</div>

        </div>

    </div>



</div>



<div class="popup-answer-wrapper">

    <div class="popup-answer__content">

        <div class="popup-answer__title">Ваша заявка отравлена!</div>

        <p class="popup-answer__text">Оператор Вам позвонит для уточнения деталей заказа.</p>

    </div>

</div>



<? if(! is_ajax() AND empty($_GET['ajax_buy'])) : ?>

    <div id="popup_form_product" style="display: none;">

        <input type="hidden" value="" name="popup_product_url" id="popup_product_url" />

        <div class="h3"><?=GetMessage("MESSAGE_ADD_CART"); ?></div>

        <div class="product">

            <div class="img hidden">

            </div>

            <span class="name hidden"></span>

            <span class="sku hidden"></span>

            <span class="price hidden"></span>

        </div>

        <div class="bottons"></div>

    </div>



    <script>

        var wind2 = new BX.PopupWindow('popup_product', BX('popup_form_product'), {

            lightShadow : true,

            offsetTop: 10,

            offsetLeft: 0,

            autoHide: true,

            closeByEsc: true,

            zIndex: 510,

            bindOptions: {position: "right"},

            /*buttons: [

            new BX.PopupWindowButton({

            text : '<?=GetMessage("GOTO_CART");?>',

            events : {

            click : function() {

            window.location.assign('/personal/cart/');

            }

            }

            }),

            new BX.PopupWindowButton({

            text : '<?=GetMessage('POPUP_CLOSE')?>',

            events : {

            click : function() {

            wind2.close();

            }

            }

            })

            ]*/

        });



        wind2.setContent(BX('popup_form_product'));

        function addtoBasket(id)

        {

            var a = $('#' + id + '_buy_link'), url = a.attr('href')+ "&ajax_basket=Y&ajax_buy=1";
            var tr = a.closest('tr'), preview = $('.preview',tr), name = $('.name',tr), offers_select = $('.offers-select',tr);

            wind2.setBindElement(BX(id + '_buy_link'));
            var popup_product = $('#popup_product');
            if(preview.length > 0){
                $('.product .img', popup_product).html(preview.html());
            }else{
                $('.product .img', popup_product).html('');
            }

            if(name.length > 0) {
                $('.product .name', popup_product).html(name.html());
            } else {
                $('.product .name', popup_product).html('');
            }

            if(offers_select.length > 0){
                var sku = $('option:selected',offers_select);
                $('.product .sku', popup_product).html(sku.html());
            } else {
                $('.product .sku', popup_product).html('');
            }

            wind2.show();

            BX.ajax.post(url, '', function(res) {
                var shopCart = $('#shopCart');


                BX.ajax.get('/', '', function(html) {
                    var cart = $(html).filter('#shopCart');
                    if(cart.length > 0){
                    }else{
                        cart = $(html).find('#shopCart');
                    }
                    shopCart.html(cart.html());
                    $('.hiddencart').html('').load('/basketajax.php');


                })

                setTimeout(function(){

                    $('#popup_product').hide();

                    },5000)


            });


            return !1;



        }



    </script>

    <? endif ?>