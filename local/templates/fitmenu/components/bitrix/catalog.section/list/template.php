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
<div class="sorting_block"><?
        // arshow($arResult);
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
<span class="head"><?=  $arResult['NAME'] ?></span>

<div class="catalog-section">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <p><?=$arResult["NAV_STRING"]?></p>
        <?endif?>
    <table class="data-table category" cellspacing="0" cellpadding="0"  width="100%">
        <thead>
            <tr>
                <td>Бренд</td>
                <td><?=GetMessage("CATALOG_TITLE")?></td>
                <?if(count($arResult["ITEMS"]) > 0):
                    foreach($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"] as $arProperty):?>

                    <td class="td <? echo ($arProperty['CODE'] == 'CML2_MANUFACTURER' ? "hidden" : " ")  ?>" > <?=$arProperty["NAME"]?></td>
                    <?endforeach;
                    endif;?>
                <?foreach($arResult["PRICES"] as $code=>$arPrice):?>
                    <td>Упаковка<? //=$arPrice["TITLE"]?></td>
                    <?endforeach?>
                <?if(count($arResult["PRICES"]) > 0):?>
                    <td class="w_150"><? echo GetMessage("CATALOG_TD_ORDER")?></td>
                    <?endif?>
            </tr>
        </thead>
        <?foreach($arResult["ITEMS"] as $arElement):?>
            <?
                $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
            ?>
            <? if(! empty($arElement['BREND'])): ?>
                <tr class="tr brend">
                    <td colspan="6"><? echo $arElement['BREND']['VIEW'] ?></td>
                </tr>
                <? endif ?>
            <?$section = CIBlockSection::GetByID($arElement["IBLOCK_SECTION_ID"])->Fetch();
                if(empty($section["IBLOCK_SECTION_ID"])){
                    $section_code = $section["CODE"];
                }else{
                    $section_path = CIBlockSection::GetByID($section["IBLOCK_SECTION_ID"])->Fetch(); 
                    $section_code = $section_path["CODE"];
            }?>  

            <? if(!in_array($arElement['PROPERTY_CATEGORY_PRODUCT_VALUE'], $ar_name_category )): ?>
                <tr class="tr brend">
                    <td colspan="6"><a href="http://<?=$_SERVER["HTTP_HOST"].'/catalog/'.$section_code.'/'?>"><b><?= $arElement['PROPERTY_CATEGORY_PRODUCT_VALUE'] ?></b></a></td>
                </tr>
                <? endif ?>
            <?$ar_name_category[] = $arElement["PROPERTY_CATEGORY_PRODUCT_VALUE"];?>



            <tr id="<?=$this->GetEditAreaId($arElement['ID']);?>">
                <td><? /*print_R($arElement);*/ $preview = $arElement['PREVIEW_PICTURE'];   ?>
                    <? echo label_product($arElement['PROPERTIES']) ?>
                    <a href="<?=$arElement["DETAIL_PAGE_URL"]?>" title="<?=$arElement["NAME"]?>" class="preview">
                        <?php if(! empty($preview)): ?>
                            <img src="<?=$preview["SRC"]?>" alt="<?=$arElement["NAME"]?>" width="100" />
                            <?php endif ?>
                    </a>
                </td>
                <td>
                    <a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="name"><?=$arElement["NAME"]?></a>
                    <?if(count($arElement["SECTION"]["PATH"])>0):?>
                        <br />
                        <?foreach($arElement["SECTION"]["PATH"] as $arPath):?>
                            / <a href="<?=$arPath["SECTION_PAGE_URL"]?>"><?=$arPath["NAME"]?></a>
                            <?endforeach?>
                        <?endif?>
                    <div class="desc"><? echo $arElement['PREVIEW_TEXT'] ?>.</div>
                </td>
                <?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
                    <td class="td <? echo ($arProperty['CODE'] == 'CML2_MANUFACTURER' ? "hidden" : "")  ?>">
                        <?if(is_array($arProperty["DISPLAY_VALUE"]))
                                echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
                            elseif($arProperty["DISPLAY_VALUE"] === false)
                                echo "&nbsp;";
                            else
                                echo $arProperty["DISPLAY_VALUE"];?>
                    </td>
                    <?endforeach?>
                <?foreach($arResult["PRICES"] as $code=>$arPrice):?>
                    <td>
                        <?//if($arPrice = $arElement["PRICES"][$code]):
                            if($arPrice = $arElement["OFFERS"][0]["MIN_PRICE"]):?>
                            <?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
                                <p class="old"><?=$arPrice["VALUE"]?></p>
                                <p class="product-price shk-price" ><?=$arPrice["DISCOUNT_VALUE"]?><span  class="rub">&nbsp;Р </span></p>
                                <?else:?>
                                <p class="product-price shk-price" ><?=$arPrice["VALUE"]?><span class="rub">&nbsp;Р </span></p>
                                <?endif?>
                            <?else:?>
                            &nbsp; 
                            <?endif;?>
                    </td>
                    <?endforeach;?>
                <?if(count($arResult["PRICES"]) > 0):?>
                    <td>
                        <? //print_r($arElement['OFFERS']); ?>
                        <?if($arElement["CAN_BUY"]):?>
                            <? if(count($arElement['OFFERS']) < 1): ?> 
                                <noindex>
                                    <!--<a href="<?echo $arElement["BUY_URL"]?>" class="to-cart" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
                                    &nbsp; -->  <a href="<?echo $arElement["ADD_URL"]?>" class="to-cart" rel="nofollow"><? echo GetMessage("CATALOG_ADD")?></a>
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
                                        <? $SHOW_NOT_AVALIBELE = FALSE; // РІС‹РІРѕРґРёС‚СЊ РїРѕРґРїРёСЃРєСѓ ?>
                                        <select name="offers" class="offers-select">
                                            <? foreach($arShowOffers as $arShowOffer): ?>
                                                <?  if($arShowOffer['CATALOG_QUANTITY'] > 0 OR $SHOW_NOT_AVALIBELE): // Р’ РЅР°Р»РёС‡РёРё ?>
                                                    <option value="<? echo $arShowOffer['ID']  ?>" <? echo (++$s_o == 1 ? 'selected="selected"' : ''); ?>>
                                                        <? //echo $arShowOffer['CATALOG_QUANTITY'].'-'; ?>
                                                        <? if(count($arShowOffer['ATTRIBUTES']) > 0): ?>
                                                            <? foreach($arShowOffer['ATTRIBUTES'] as $k => $CML2_ATTRIBUTE): ?>
                                                                <?echo $arShowOffer['ATTRIBUTES_DECRIPTION'][$k]?>: <? echo $CML2_ATTRIBUTE  ?>
                                                                <? endforeach ?>
                                                            <? else: ?>
                                                            <? echo $arShowOffer['NAME']; ?>       
                                                            <? endif ?>
                                                    </option>
                                                    <? else: ?>

                                                    <? endif ?> 
                                                <? endforeach ?>
                                        </select>
                                    </div>
                                    <? endif ?>

                                <? $b_o = 0; foreach($arShowOffers as $arShowOffer): ?>
                                    <div class="offer <? echo ($b_o > 0 ? 'hidden' : '');?>" id="_offer_<? echo $arShowOffer['ID']  ?>">
                                        <?  if($arShowOffer['CATALOG_QUANTITY'] > 0): // Р’ РЅР°Р»РёС‡РёРё ?>
                                            <? if(count($arShowOffer['ATTRIBUTES']) > 0): ?>
                                                <div class="left">
                                                    <? foreach($arShowOffer['ATTRIBUTES'] as $k => $CML2_ATTRIBUTE): ?>
                                                        <p><b><?echo $arShowOffer['ATTRIBUTES_DECRIPTION'][$k]?>:</b> <? echo $CML2_ATTRIBUTE  ?></p>
                                                        <? endforeach ?>
                                                </div>
                                                <div class="prices">
                                                    <? foreach($arShowOffer['PRICES'] as $k => $Offer_price): ?>
                                                        <p class="price"><b><? echo $Offer_price['VALUE'] ?></b><span class="rub">P</span> </p>
                                                        <? endforeach ?>
                                                </div>
                                                <? endif ?>
                                            <div class="buy">
                                                <a href="<? echo $arShowOffer['ADD_URL'] ?>" id="<? echo $arShowOffer['ID'] ?>_buy_link" onclick="return addtoBasket(<? echo $arShowOffer['ID']?>)" class="to-cart" title="РљСѓРїРёС‚СЊ"><span></span> <?  echo $buyBtnMessage; ?></a>
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
                                <span><?//=GetMessage("CATALOG_NOT_AVAILABLE")?>Сделать предзаказ</span>
                                <input type="hidden" form="order_one_click" name="" value="<?=$arElement["ID"]?>">
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
            <?endforeach;?>
    </table>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <p><?=$arResult["NAV_STRING"]?></p>
        <?endif?>
</div>

<div class="order_one_click">
    <div class="close_order_form">X</div>
    <p>Как только товар появиться у нас на складе, мы сразу же свяжемся с Вами!</p>
    <form action="javascript:void(0)" id="order_one_click" name="order_one_click" method="post">
        <span>Имя</span>
        <input type="text" name="name_order" placeholder="обязательное поле" id="name_order" value="" required>
        <span>Тел.</span>
        <input type="number" name="phone_order" placeholder="обязательное поле" id="phone_order" value="" required>
        <span>E-mail</span>
        <input type="text" name="email_order" id="email_order" value="">
        <span style=" font-size: 12px; font-weight: 600; ">Комментарий к заказу</span>
        <textarea type="text" name="coment_order" value=""></textarea>
        <input type="submit" value="Отправить" onclick="sendData()">          
    </form>
    <div class="form_alert"></div>     
</div>
<? if(! is_ajax() AND empty($_GET['ajax_buy'])) : ?>
    <div id="popup_form_product" style="display: none;">
        <input type="hidden" value="" name="popup_product_url" id="popup_product_url" /> 
        <h3><?=GetMessage("MESSAGE_ADD_CART"); ?></h3>
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

            if(name.length > 0){
                $('.product .name', popup_product).html(name.html());
            }else{
                $('.product .name', popup_product).html('');
            }

            if(offers_select.length > 0){
                var sku = $('option:selected',offers_select);
                $('.product .sku', popup_product).html(sku.html());
            }else{
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