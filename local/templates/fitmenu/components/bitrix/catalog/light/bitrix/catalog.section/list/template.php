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

<h1 class="head"><?=  $arResult['NAME'] ?></h1>

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
			<td>Цена<? //=$arPrice["TITLE"]?></td>
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
            <div class="desc"><? echo $arElement['PREVIEW_TEXT'] ?></div>
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
			<?if($arPrice = $arElement["PRICES"][$code]):?>
				<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
                    <p class="old"><?=$arPrice["VALUE"]?></p>
                    <p class="product-price shk-price" ><?=$arPrice["DISCOUNT_VALUE"]?><span  class="rub">&nbsp;Р</span></p>
				<?else:?>
                    <p class="product-price shk-price" ><?=$arPrice["VALUE"]?><span class="rub">&nbsp;Р</span></p>
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
                
                <div class="offers">
                        <? $k_offers = 0; ?>
                             
                            <? $arShowOffers = array(); $s_o = 0; foreach ($arElement['OFFERS'] as $key => $arOffer): ?>
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
                                      $arShowOffers[] = $arShowOffer; ?>
                                         <? foreach($CML2_ATTRIBUTES as $k => $CML2_ATTRIBUTE): ?>
                                           <? $k_offers++; ?>
                                         <? endforeach ?>
                               <? endif ?> 
                            <? endforeach ?>
                            
                        <? if($k_offers > 0): ?>
                        <div class="select_sku">
                        <select name="offers" class="offers-select">
                        <? foreach($arShowOffers as $arShowOffer): ?>
                             <? if(count($arShowOffer['ATTRIBUTES']) > 0): ?>
                                    <? foreach($arShowOffer['ATTRIBUTES'] as $k => $CML2_ATTRIBUTE): ?>
                                          <option value="<? echo $arShowOffer['ID']  ?>" <? echo (++$s_o == 1 ? 'selected="selected"' : ''); ?>   >
                                         <p><b><?echo $arShowOffer['ATTRIBUTES_DECRIPTION'][$k]?>:</b> <? echo $CML2_ATTRIBUTE  ?></p></option>
                                    <? endforeach ?>
                             <? endif ?>
                        <? endforeach ?>
                        </select>
                        </div>
                        <? endif ?>
                        
                    <? $b_o = 0; foreach($arShowOffers as $arShowOffer): ?>
                             <div class="offer <? echo (++$b_o > 1 ? 'hidden' : '');?>" id="_offer_<? echo $arShowOffer['ID']  ?>">
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
                                    <? ///print_r($arShowOffer) ?> 
                                    <a href="<? echo $arShowOffer['ADD_URL'] ?>" id="<? echo $arShowOffer['ID'] ?>_buy_link" onclick="return addtoBasket(<? echo $arShowOffer['ID']?>)" class="to-cart" title="Купить"><span></span> <?  echo $buyBtnMessage; ?></a>
                                </div>
                             </div>
                    <? endforeach ?>
                    </div>
                
			<?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
				<div class="slad_empty"><?//=GetMessage("CATALOG_NOT_AVAILABLE")?></div>
				<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
							"NOTIFY_ID" => $arElement['ID'],
							"NOTIFY_URL" => htmlspecialcharsback($arElement["SUBSCRIBE_URL"]),
							"NOTIFY_USE_CAPTHA" => "N"
							),
							$component
						);?>
			<?endif?>&nbsp;
		</td>
		<?endif;?>
	</tr>
	<?endforeach;?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
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
        })
        setTimeout(function(){
            $('#popup_product').hide();
        },5000)
        var shopBasket = $('.hiddencart');
        BX.ajax.get('/basketajax.php', '', function(html) {
            
            var cart = $(html).filter('.hiddencart');
            if(cart.length > 0){
                
            }else{
                cart = $(html).find('.hiddencart');
            }
            shopBasket.html(cart.html());    
        })
        
    });
    return !1;
}

</script>
<? endif ?>
