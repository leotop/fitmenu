<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<script type="text/javascript">
    function fShowStore(id, showImages, formWidth, siteId)
    {
        var strUrl = '<?=$templateFolder?>' + '/map.php';
        var strUrlPost = 'delivery=' + id + '&showImages=' + showImages + '&siteId=' + siteId;

        var storeForm = new BX.CDialog({
            'title': '<?=GetMessage('SOA_ORDER_GIVE')?>',
            head: '',
            'content_url': strUrl,
            'content_post': strUrlPost,
            'width': formWidth,
            'height':450,
            'resizable':false,
            'draggable':false
        });

        var button = [
            {
                title: '<?=GetMessage('SOA_POPUP_SAVE')?>',
                id: 'crmOk',
                'action': function ()
                {
                    GetBuyerStore();
                    BX.WindowManager.Get().Close();
                }
            },
            BX.CDialog.btnCancel
        ];
        storeForm.ClearButtons();
        storeForm.SetButtons(button);
        storeForm.Show();
    }

    function GetBuyerStore()
    {
        BX('BUYER_STORE').value = BX('POPUP_STORE_ID').value;
        //BX('ORDER_DESCRIPTION').value = '<?=GetMessage("SOA_ORDER_GIVE_TITLE")?>: '+BX('POPUP_STORE_NAME').value;
        BX('store_desc').innerHTML = BX('POPUP_STORE_NAME').value;
        BX.show(BX('select_store'));
    }

    function showExtraParamsDialog(deliveryId)
    {
        var strUrl = '<?=$templateFolder?>' + '/delivery_extra_params.php';
        var formName = 'extra_params_form';
        var strUrlPost = 'deliveryId=' + deliveryId + '&formName=' + formName;

        if(window.BX.SaleDeliveryExtraParams)
        {
            for(var i in window.BX.SaleDeliveryExtraParams)
            {
                strUrlPost += '&'+encodeURI(i)+'='+encodeURI(window.BX.SaleDeliveryExtraParams[i]);
            }
        }

        var paramsDialog = new BX.CDialog({
            'title': '<?=GetMessage('SOA_ORDER_DELIVERY_EXTRA_PARAMS')?>',
            head: '',
            'content_url': strUrl,
            'content_post': strUrlPost,
            'width': 500,
            'height':200,
            'resizable':true,
            'draggable':false
        });

        var button = [
            {
                title: '<?=GetMessage('SOA_POPUP_SAVE')?>',
                id: 'saleDeliveryExtraParamsOk',
                'action': function ()
                {
                    insertParamsToForm(deliveryId, formName);
                    BX.WindowManager.Get().Close();
                }
            },
            BX.CDialog.btnCancel
        ];

        paramsDialog.ClearButtons();
        paramsDialog.SetButtons(button);
        //paramsDialog.adjustSizeEx();
        paramsDialog.Show();
    }

    function insertParamsToForm(deliveryId, paramsFormName)
    {
        var orderForm = BX("ORDER_FORM"),
        paramsForm = BX(paramsFormName);
        wrapDivId = deliveryId + "_extra_params";

        var wrapDiv = BX(wrapDivId);
        window.BX.SaleDeliveryExtraParams = {};

        if(wrapDiv)
            wrapDiv.parentNode.removeChild(wrapDiv);

        wrapDiv = BX.create('div', {props: { id: wrapDivId}});

        for(var i = paramsForm.elements.length-1; i >= 0; i--)
        {
            var input = BX.create('input', {
                props: {
                    type: 'hidden',
                    name: 'DELIVERY_EXTRA['+deliveryId+']['+paramsForm.elements[i].name+']',
                    value: paramsForm.elements[i].value
                }
                }
            );

            window.BX.SaleDeliveryExtraParams[paramsForm.elements[i].name] = paramsForm.elements[i].value;

            wrapDiv.appendChild(input);
        }

        orderForm.appendChild(wrapDiv);

        BX.onCustomEvent('onSaleDeliveryGetExtraParams',[window.BX.SaleDeliveryExtraParams]);
    }



</script>

<div class="delivery-choose">
    <div class="delivery-choose-title"><?=GetMessage("CHOOSE_DELIVERY");?></div>

    <div class="delivery-choose-variant <? if ($_POST["DELIVERY_ID"]!=2 && $_POST["DELIVERY_ID"]!='') { echo "active-variant";}?>" id="varDelivery"><?=GetMessage("DELIVERY_1");?></div>
    <div class="delivery-choose-variant <? if ($_POST["DELIVERY_ID"]==2) { echo "active-variant";}?>" id="varPickup"><?=GetMessage("DELIVERY_2");?></div>

    <?/*<div class="delivery-choosen-block" id="varDeliveryBlock">Доставка</div>*/ ?> 
    <div class="delivery-choosen-block" id="varPickupBlock" <? if ($_POST["DELIVERY_ID"]==2) { echo "style='display: block'";}?>>
        <div class="delivery-order-title"><?=GetMessage("PICKUP_TITLE")?></div>
        <div class="pickup-list">
            <div class="pickupVariant <? if ($_POST["ORDER_PROP_28"]==1 || empty($_POST["ORDER_PROP_28"])) { echo "checked-pay";}?>" pickupVal="1">
                <div class="check-input"></div>
                <div>Парк Хаус <br>
                    <span>Сулимова, 50</span>
                </div>

            </div>
            <div class="pickupVariant <? if ($_POST["ORDER_PROP_28"]==2) { echo "checked-pay";}?>" pickupVal="2">
                <div class="check-input "></div>
                <div>Мегаполис <br>
                    <span>8 марта, 149</span>
                </div>

            </div>
            <div class="pickupVariant <? if ($_POST["ORDER_PROP_28"]==3) { echo "checked-pay";}?>" pickupVal="3">
                <div class="check-input "></div>
                <div class="one-name">Хохрякова,32</div>
            </div>
        </div>
    </div>


    <input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult["BUYER_STORE"]?>" />
    <div class="bx_section delivery_section delivery-choosen-block" id="varDeliveryBlock" <? if ($_POST["DELIVERY_ID"]!=2 && $_POST["DELIVERY_ID"]!='') { echo "style='display: block'";}?>>
        <?//var_dump($arResult["DELIVERY"]);
            if(!empty($arResult["DELIVERY"]))
            { 
                $width = ($arParams["SHOW_STORES_IMAGES"] == "Y") ? 850 : 700;
            ?>
            <div class="delivery-order-title"><?=GetMessage("DELIVERY_TITLE")?></div>
            <div class="delivery-list">
                <?
                    foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
                    {
                        if ($delivery_id !== 0 && intval($delivery_id) <= 0)
                        {
                            foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
                            {
                                if (!empty($profile_id)) {
                                    $deliveryid = $delivery_id.':'.$profile_id;
                                }  else {
                                    $deliveryid = $delivery_id;
                                }
                            ?>
                            <div class="bx_block w100 vertical delivery-block <? if ($_POST["DELIVERY_ID"]==$deliveryid) { echo "active-delivery-block"; }?>"  id="BLOCK_DELIVERY_<?=$delivery_id?>">
                                <div class="bx_element">

                                    <input
                                        type="radio"
                                        id="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>"
                                        name="<?=htmlspecialcharsbx($arProfile["FIELD_NAME"])?>"
                                        value="<?=$delivery_id.":".$profile_id;?>"
                                        <?=$arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : "";?>
                                        onclick="submitForm();"
                                        />

                                    <label for="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>">

                                        <?
                                            if (count($arDelivery["LOGOTIP"]) > 0):

                                                $arFileTmp = CFile::ResizeImageGet(
                                                    $arDelivery["LOGOTIP"]["ID"],
                                                    array("width" => "95", "height" =>"55"),
                                                    BX_RESIZE_IMAGE_PROPORTIONAL,
                                                    true
                                                );

                                                $deliveryImgURL = $arFileTmp["src"];
                                                else:
                                                $deliveryImgURL = $templateFolder."/images/logo-default-d.gif";
                                                endif;

                                            if($arDelivery["ISNEEDEXTRAINFO"] == "Y")
                                                $extraParams = "showExtraParamsDialog('".$delivery_id.":".$profile_id."');";
                                            else
                                                $extraParams = "";

                                        ?>
                                        <?/*?><div class="bx_logotype" onclick="BX('ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>').checked=true;<?=$extraParams?>submitForm();">
                                            <span style='background-image:url(<?=$deliveryImgURL?>);'></span>
                                            </div>
                                        <?*/?>
                                        <div class="bx_description" onclick="BX('ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>').checked=true;<?=$extraParams?>submitForm();">

                                            <div class="name no-padding"><span onclick="BX('ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>').checked=true;<?=$extraParams?>submitForm();">
                                                    <?=htmlspecialcharsbx($arDelivery["TITLE"])." (".htmlspecialcharsbx($arProfile["TITLE"]).")";?>
                                                </span></div>

                                            <?/*?> <span class="bx_result_price"><!-- click on this should not cause form submit -->
                                                <?
                                                if($arProfile["CHECKED"] == "Y" && doubleval($arResult["DELIVERY_PRICE"]) > 0):
                                                ?>
                                                <div><?=GetMessage("SALE_DELIV_PRICE")?>:&nbsp;<b><?=$arResult["DELIVERY_PRICE_FORMATED"]?></b></div>
                                                <?
                                                if ((isset($arResult["PACKS_COUNT"]) && $arResult["PACKS_COUNT"]) > 1):
                                                echo GetMessage('SALE_PACKS_COUNT').': <b>'.$arResult["PACKS_COUNT"].'</b>';
                                                endif;

                                                else:
                                                $APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
                                                "NO_AJAX" => $arParams["DELIVERY_NO_AJAX"],
                                                "DELIVERY" => $delivery_id,
                                                "PROFILE" => $profile_id,
                                                "ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
                                                "ORDER_PRICE" => $arResult["ORDER_PRICE"],
                                                "LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
                                                "LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
                                                "CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
                                                "ITEMS" => $arResult["BASKET_ITEMS"],
                                                "EXTRA_PARAMS_CALLBACK" => $extraParams
                                                ), null, array('HIDE_ICONS' => 'Y'));
                                                endif;
                                                ?>
                                                </span>

                                                <p onclick="BX('ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>').checked=true;submitForm();">
                                                <?if (strlen($arProfile["DESCRIPTION"]) > 0):?>
                                                <?=nl2br($arProfile["DESCRIPTION"])?>
                                                <?else:?>
                                                <?=nl2br($arDelivery["DESCRIPTION"])?>
                                                <?endif;?>
                                            </p> <?*/?>
                                        </div>

                                    </label>

                                </div>
                            </div>
                            <?
                            } // endforeach
                        }
                        else // stores and courier
                        {
                            if (!empty($profile_id)) {
                                $deliveryid = $delivery_id.':'.$profile_id;
                            }  else {
                                $deliveryid = $delivery_id;
                            }
                            if (count($arDelivery["STORE"]) > 0)
                                $clickHandler = "onClick = \"fShowStore('".$arDelivery["ID"]."','".$arParams["SHOW_STORES_IMAGES"]."','".$width."','".SITE_ID."')\";";
                            else
                                $clickHandler = "onClick = \"BX('ID_DELIVERY_ID_".$arDelivery["ID"]."').checked=true;submitForm();\"";
                        ?>
                        <div class="bx_block w100 vertical delivery-block <? if ($_POST["DELIVERY_ID"]==$deliveryid) { echo "active-delivery-block"; }?>"  id="BLOCK_DELIVERY_<?=$delivery_id?>">

                            <div class="bx_element">

                                <input type="radio"
                                    id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>"
                                    name="<?=htmlspecialcharsbx($arDelivery["FIELD_NAME"])?>"
                                    value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>
                                    onclick="submitForm();"
                                    />

                                <label for="ID_DELIVERY_ID_<?=$arDelivery["ID"]?>" <?=$clickHandler?>>

                                    <?
                                        if (count($arDelivery["LOGOTIP"]) > 0):

                                            $arFileTmp = CFile::ResizeImageGet(
                                                $arDelivery["LOGOTIP"]["ID"],
                                                array("width" => "95", "height" =>"55"),
                                                BX_RESIZE_IMAGE_PROPORTIONAL,
                                                true
                                            );

                                            $deliveryImgURL = $arFileTmp["src"];
                                            else:
                                            $deliveryImgURL = $templateFolder."/images/logo-default-d.gif";
                                            endif;
                                    ?>

                                    <?/*?>
                                        <div class="bx_logotype"><span style='background-image:url(<?=$deliveryImgURL?>);'></span></div>
                                    <?*/?>
                                    <div class="bx_description">
                                        <div class="name"><span><?= htmlspecialcharsbx($arDelivery["NAME"])?></span></div>
                                        <?/*?>
                                            <span class="bx_result_price">
                                            <?
                                            if (strlen($arDelivery["PERIOD_TEXT"])>0)
                                            {
                                            echo $arDelivery["PERIOD_TEXT"];
                                            ?><br /><?
                                            }
                                            ?>
                                            <?=GetMessage("SALE_DELIV_PRICE");?>: <b><?=$arDelivery["PRICE_FORMATED"]?></b><br />
                                            </span>
                                            <p>
                                            <?
                                            if (strlen($arDelivery["DESCRIPTION"])>0)
                                            echo $arDelivery["DESCRIPTION"]."<br />";

                                            if (count($arDelivery["STORE"]) > 0):
                                            ?>
                                            <span id="select_store"<?if(strlen($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"]) <= 0) echo " style=\"display:none;\"";?>>
                                            <span class="select_store"><?=GetMessage('SOA_ORDER_GIVE_TITLE');?>: </span>
                                            <span class="ora-store" id="store_desc"><?=htmlspecialcharsbx($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"])?></span>
                                            </span>
                                            <?
                                            endif;
                                            ?>
                                            </p>
                                        <?*/?>
                                    </div>

                                </label>

                                <div class="clear"></div>   
                            </div>
                        </div>
                        <?
                        }
                    }
                }
            ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="custom-delivery-block"> 
        <? if ($_POST["DELIVERY_ID"]==16 || $_POST["DELIVERY_ID"]==11 || $_POST["DELIVERY_ID"]==12 || $_POST["DELIVERY_ID"]==40 || $_POST["DELIVERY_ID"]==41) {   ?>    
            <div class="i-text f_ORDER_PROP_5">
                <div class="bx_block r1x3 pt8 name street"><?=GetMessage("CITY_PROP");?></div>
                <div class="bx_block r3x1">
                    <? /*<input type="text" placeholder="<?=GetMessage("PH_REQUIRED");?>" class="text-input street" maxlength="250" size="40" value="<? if (!empty($_POST["ORDER_PROP_5"])) { echo $_POST["ORDER_PROP_5"];}?>" name="ORDER_PROP_5" id="ORDER_PROP_5">  */ ?>
                    <?$APPLICATION->IncludeComponent("bitrix:sale.ajax.locations", "order_location", Array(
                            "CITY_OUT_LOCATION" => "Y",    // Возвращать ID местоположения (в противном случае - города)
                            "ALLOW_EMPTY_CITY" => "Y",    // Выбор города местоположения не обязателен
                            "COUNTRY_INPUT_NAME" => "COUNTRY",    // Имя поля формы для страны
                            "REGION_INPUT_NAME" => "REGION",    // Имя поля формы для региона
                            "CITY_INPUT_NAME" => "ORDER_PROP_CITY",    // Имя поля формы для города (местоположения)
                            "COUNTRY" => "1",    // Стартовое значение страны
                            "ONCITYCHANGE" => "",    // Обработчик смены значения города (местоположения)
                            "NAME" => "q",    // Имя поля ввода местоположения
                            "COMPONENT_TEMPLATE" => "popup"
                            ),
                            false
                        );?>
                </div>           
                <div style="clear: both;"></div>
            </div>
            <?  }  ?>
        <? if ($_POST["DELIVERY_ID"]==40 || $_POST["DELIVERY_ID"]==41) {   
            ?>    
            <div class="i-text f_ORDER_PROP_4">
                <div class="bx_block r1x3 pt8 name zip"><?=GetMessage("ZIP_PROP");?></div>
                <div class="bx_block r3x1">
                    <input type="text" placeholder="<?=GetMessage("PH_REQUIRED");?>" class="text-input street" maxlength="250" size="40" value="<? if (!empty($_POST["ORDER_PROP_4"])) { echo $_POST["ORDER_PROP_4"];}?>" name="ORDER_PROP_4" id="ORDER_PROP_4">
                </div>           
                <div style="clear: both;"></div>
            </div>
            <?  }  ?>

        <? if ($_POST["DELIVERY_ID"]==15 || $_POST["DELIVERY_ID"]==16 || $_POST["DELIVERY_ID"]==11 || $_POST["DELIVERY_ID"]==12 || $_POST["DELIVERY_ID"]==17 ||  $_POST["DELIVERY_ID"]==40 || $_POST["DELIVERY_ID"]==41) {   ?>    
            <div class="i-text f_ORDER_PROP_20">
                <div class="bx_block r1x3 pt8 name street"><?=GetMessage("STREET_PROP");?></div>
                <div class="bx_block r3x1">
                    <input type="text" class="text-input street" maxlength="250" size="0" value="<? if (!empty($_POST["ORDER_PROP_20"])) { echo $_POST["ORDER_PROP_20"];}?>" name="ORDER_PROP_20" id="ORDER_PROP_20">
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="i-w-text">
                <div class="i-text f_ORDER_PROP_21">
                    <div class="bx_block r1x3 pt8 name"><?=GetMessage("HOUSE_PROP");?></div>
                    <div class="bx_block r3x1">
                        <input type="text" class="text-input" maxlength="250" size="0" value="<? if (!empty($_POST["ORDER_PROP_21"])) { echo $_POST["ORDER_PROP_21"];}?>" name="ORDER_PROP_21" id="ORDER_PROP_21">
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="i-text f_ORDER_PROP_22">
                    <div class="bx_block r1x3 pt8 name"><?=GetMessage("CORP_PROP");?></div>
                    <div class="bx_block r3x1">
                        <input type="text" class="text-input" maxlength="250" size="0" value="<? if (!empty($_POST["ORDER_PROP_22"])) { echo $_POST["ORDER_PROP_22"];}?>" name="ORDER_PROP_22" id="ORDER_PROP_22">
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="i-text f_ORDER_PROP_23">
                    <div class="bx_block r1x3 pt8 name"><?=GetMessage("FLOOR_PROP");?></div>
                    <div class="bx_block r3x1">
                        <input type="text" class="text-input" maxlength="250" size="0" value="<? if (!empty($_POST["ORDER_PROP_23"])) { echo $_POST["ORDER_PROP_23"];}?>" name="ORDER_PROP_23" id="ORDER_PROP_23">
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="i-text f_ORDER_PROP_24">
                    <div class="bx_block r1x3 pt8 name"><?=GetMessage("FLAT_PROP");?></div>
                    <div class="bx_block r3x1">
                        <input type="text" class="text-input" maxlength="250" size="0" value="<? if (!empty($_POST["ORDER_PROP_24"])) { echo $_POST["ORDER_PROP_24"];}?>" name="ORDER_PROP_24" id="ORDER_PROP_24">
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
            <?  }  ?>
    </div>
</div>
