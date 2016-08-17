<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
    $bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
    $colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
    $bPropsColumn = false;
    $bUseDiscount = false;
    $bPriceType = false;
    $bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>
<div class="bx_ordercart product-container">
    <div class="product-title"><?=GetMessage("SUM_SALE_PRODUCTS");?></div>
    <div class="bx_ordercart_order_table_container">
        <table>
            <thead class="hidden-respon">
                <tr>
                    <td class="margin"></td>
                    <?
                        $bPreviewPicture = false;
                        $bDetailPicture = false;
                        $imgCount = 0;

                        // prelimenary column handling
                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
                        {
                            if ($arColumn["id"] == "PROPS")
                                $bPropsColumn = true;

                            if ($arColumn["id"] == "NOTES")
                                $bPriceType = true;

                            if ($arColumn["id"] == "PREVIEW_PICTURE")
                                $bPreviewPicture = true;

                            if ($arColumn["id"] == "DETAIL_PICTURE")
                                $bDetailPicture = true;
                        }

                        if ($bPreviewPicture || $bDetailPicture)
                            $bShowNameWithPicture = true;


                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

                            if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
                                continue;

                            if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
                                continue;

                            if ($arColumn["id"] == "NAME" && $bShowNameWithPicture):
                            ?>
                            <td class="item" colspan="2">
                            <?

                                elseif ($arColumn["id"] == "NAME" && !$bShowNameWithPicture):
                            ?>
                            <td class="item">
                            <?
                                echo $arColumn["name"];
                                elseif ($arColumn["id"] == "PRICE"):
                            ?>
                            <td class="price">
                            <?
                                echo $arColumn["name"];
                                else:
                            ?>
                            <td class="custom">
                                <?
                                    if ($arColumn["id"]=="QUANTITY") {
                                        echo GetMessage("SOA_TEMPL_SUM_QUANTITY");
                                    } else {
                                        echo $arColumn["name"];
                                    }
                                    endif;
                            ?>
                        </td>
                        <?endforeach;?>
                    <td class="delete-head"></td>
                    <td class="margin"></td>
                </tr>
            </thead>

            <tbody>
                <?foreach ($arResult["GRID"]["ROWS"] as $k => $arData):?>
                    <tr class="basket__main-row">
                        <td class="margin"></td>
                        <?
                            if ($bShowNameWithPicture):
                            ?>
                            <td class="itemphoto basket__left-column">
                                <div class="bx_ordercart_photo_container">
                                    <?
                                        if (strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0):
                                            $url = $arData["data"]["PREVIEW_PICTURE_SRC"];
                                            elseif (strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0):
                                            $url = $arData["data"]["DETAIL_PICTURE_SRC"];
                                            else:
                                            $url = $templateFolder."/images/no_photo.png";
                                            endif;

                                        if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                        <div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
                                    <?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                </div>
                                <?
                                    if (!empty($arData["data"]["BRAND"])):
                                    ?>
                                    <div class="bx_ordercart_brand">
                                        <img alt="" src="<?=$arData["data"]["BRAND"]?>" />
                                    </div>
                                    <?
                                        endif;
                                ?>
                            </td>

                            <td class="basket__right-column">
                                <table>
                                    <tr>

                                        <?
                                            endif;

                                        // prelimenary check for images to count column width
                                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
                                        {
                                            $arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];
                                            if (is_array($arItem[$arColumn["id"]]))
                                            {
                                                foreach ($arItem[$arColumn["id"]] as $arValues)
                                                {
                                                    if ($arValues["type"] == "image")
                                                        $imgCount++;
                                                }
                                            }
                                        }

                                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

                                            $class = ($arColumn["id"] == "PRICE_FORMATED") ? "price" : "";

                                            if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
                                                continue;

                                            if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
                                                continue;

                                            $arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];

                                            if ($arColumn["id"] == "NAME"):
                                                $width = 70 - ($imgCount * 20);
                                            ?>
                                            <td class="item">

                                                <h2 class="bx_ordercart_itemtitle">
                                                    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                                        <?=$arItem["NAME"]?>
                                                    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                                </h2>

                                                <div class="bx_ordercart_itemart">
                                                    <?   /*
                                                        if ($bPropsColumn):
                                                        foreach ($arItem["PROPS"] as $val):
                                                        echo $val["NAME"].": <span>".$val["VALUE"]."<span><br/>";
                                                        endforeach;
                                                        endif;  */
                                                    ?>
                                                </div>
                                                <?
                                                    if (is_array($arItem["SKU_DATA"])):
                                                        foreach ($arItem["SKU_DATA"] as $propId => $arProp):

                                                            // is image property
                                                            $isImgProperty = false;
                                                            foreach ($arProp["VALUES"] as $id => $arVal)
                                                            {
                                                                if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
                                                                {
                                                                    $isImgProperty = true;
                                                                    break;
                                                                }
                                                            }

                                                            $full = (count($arProp["VALUES"]) > 5) ? "full" : "";

                                                            if ($isImgProperty): // iblock element relation property
                                                            ?>
                                                            <div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

                                                                <span class="bx_item_section_name_gray">
                                                                    <?=$arProp["NAME"]?>:
                                                                </span>

                                                                <div class="bx_scu_scroller_container">

                                                                    <div class="bx_scu">
                                                                        <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%;margin-left:0%;">
                                                                            <?
                                                                                foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                                    $selected = "";
                                                                                    foreach ($arItem["PROPS"] as $arItemProp):
                                                                                        if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                                        {
                                                                                            if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
                                                                                                $selected = "class=\"bx_active\"";
                                                                                        }
                                                                                        endforeach;
                                                                                ?>
                                                                                <li style="width:10%;" <?=$selected?>>
                                                                                    <a href="javascript:void(0);">
                                                                                        <span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
                                                                                    </a>
                                                                                </li>
                                                                                <?
                                                                                    endforeach;
                                                                            ?>
                                                                        </ul>
                                                                    </div>

                                                                    <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                                    <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                                </div>

                                                            </div>
                                                            <?
                                                                else:
                                                            ?>
                                                            <div class="bx_item_detail_size_small_noadaptive <?=$full?>">

                                                                <span class="bx_item_section_name_gray">
                                                                    <?=$arProp["NAME"]?>:
                                                                </span>

                                                                <div class="bx_size_scroller_container">
                                                                    <div class="bx_size">
                                                                        <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left:0%;">
                                                                            <?
                                                                                foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                                    $selected = "";
                                                                                    foreach ($arItem["PROPS"] as $arItemProp):
                                                                                        if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                                        {
                                                                                            if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
                                                                                                $selected = "class=\"bx_active\"";
                                                                                    }
                                                                                    endforeach;
                                                                            ?>
                                                                            <li style="width:10%;" <?=$selected?>>
                                                                                <a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
                                                                            </li>
                                                                            <?
                                                                                endforeach;
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                                <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                            </div>

                                                        </div>
                                                        <?
                                                            endif;
                                                            endforeach;
                                                        endif;
                                                ?>
                                            </td>
                                            <?
                                                elseif ($arColumn["id"] == "PRICE_FORMATED"):
                                            ?>
                                            <td class="price right">
                                                <div class="current_price"><?=SaleFormatCurrency($arItem["PRICE"], $arItem["CURRENCY"])?></div>
                                                <div class="old_price right">
                                                    <?
                                                        if (doubleval($arItem["DISCOUNT_PRICE"]) > 0):
                                                            echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
                                                            $arResult['FULL_DISCOUNT'] += $arItem["DISCOUNT_PRICE"];
                                                            $bUseDiscount = true;
                                                            endif;
                                                    ?>
                                                </div>

                                                <?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
                                                    <div style="text-align: left">
                                                        <div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
                                                        <div class="type_price_value"><?=$arItem["NOTES"]?></div>
                                                    </div>
                                                    <?endif;?>
                                            </td>
                                            <?
                                                elseif ($arColumn["id"] == "DISCOUNT"):
                                            ?>
                                            <td class="custom percent right">
                                                <span><?=getColumnName($arColumn)?>:</span>
                                                <?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
                                            </td>
                                            <?
                                                elseif ($arColumn["id"] == "DETAIL_PICTURE" && $bPreviewPicture):
                                            ?>
                                            <td class="itemphoto">
                                                <div class="bx_ordercart_photo_container">
                                                    <?
                                                        $url = "";
                                                        if ($arColumn["id"] == "DETAIL_PICTURE" && strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0)
                                                            $url = $arData["data"]["DETAIL_PICTURE_SRC"];

                                                        if ($url == "")
                                                            $url = $templateFolder."/images/no_photo.png";

                                                        if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                                        <div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
                                                    <?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                                </div>
                                            </td>
                                            <?
                                                elseif (in_array($arColumn["id"], array("QUANTITY", "WEIGHT_FORMATED", "DISCOUNT_PRICE_PERCENT_FORMATED", "SUM"))):
                                            ?>
                                            <td class="custom right">
                                                <span><?=getColumnName($arColumn)?>:</span>
                                                <? if ($arColumn["id"]=="QUANTITY") {
                                                        echo intval($arItem[$arColumn["id"]]);
                                                    } else if ($arColumn["id"]=="DISCOUNT_PRICE_PERCENT_FORMATED") {
                                                        echo $arItem[$arColumn["id"]];
                                                    } else if ($arColumn["id"]=="SUM") {
                                                        echo $arItem["~SUM"];
                                                    } else {
                                                        echo SaleFormatCurrency($arItem[$arColumn["id"]], $arItem["CURRENCY"]);
                                                    }
                                                ?>


                                            </td>
                                            <?
                                                else: // some property value

                                                if (is_array($arItem[$arColumn["id"]])):

                                                    foreach ($arItem[$arColumn["id"]] as $arValues)
                                                        if ($arValues["type"] == "image")
                                                            $columnStyle = "width:20%";
                                            ?>
                                            <td class="custom" style="<?=$columnStyle?>">
                                                <span><?=getColumnName($arColumn)?>:</span>
                                                <?
                                                    foreach ($arItem[$arColumn["id"]] as $arValues):
                                                        if ($arValues["type"] == "image"):
                                                        ?>
                                                        <div class="bx_ordercart_photo_container">
                                                            <div class="bx_ordercart_photo" style="background-image:url('<?=$arValues["value"]?>')"></div>
                                                        </div>
                                                        <?
                                                            else: // not image
                                                            echo $arValues["value"]."<br/>";
                                                            endif;
                                                        endforeach;
                                                ?>
                                            </td>
                                            <?
                                                else: // not array, but simple value
                                            ?>
                                            <td class="custom" style="<?=$columnStyle?>">
                                                <span><?=getColumnName($arColumn)?>:</span>
                                                <?
                                                    echo $arItem[$arColumn["id"]];
                                                ?>
                                            </td>
                                            <?
                                                endif;
                                            endif;

                                            endforeach;
                                    ?>
                                    <?/*<td><div class="delete-product" id="<?=$arItem["ID"]?>"></div></td>*/?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?endforeach;?>
            </tbody>
        </table>
        
        <div class="bx_ordercart__gift bx_ordercart__gift_order">
					<?$APPLICATION->IncludeComponent(
						"sebekon:present.block",
						"gift",
						Array(
						)
					);?>
				</div>
    </div>
    <div class="bx_ordercart_order_pay">
        <div class="bx_ordercart_order_pay_right">
            <table class="bx_ordercart_order_sum">
                <tbody>
                    <?/* if(FALSE): ?>
                        <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_WEIGHT_SUM")?></td>
                        <td class="custom_t2" class="price"><?=$arResult["ORDER_WEIGHT_FORMATED"]?></td>
                        </tr>
                        <? endif ?>
                        <? if (! $bUseDiscount): ?>
                        <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_SUMMARY")?></td>
                        <td class="custom_t2" class="price"><?=$arResult["ORDER_PRICE_FORMATED"]?></td>
                        </tr>
                        <? endif ?>
                        <?
                        if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
                        {
                        ?>
                        <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:</td>
                        <td class="custom_t2" class="price"><?echo $arResult["DISCOUNT_PRICE_FORMATED"]?></td>
                        </tr>
                        <?
                        }
                        if(!empty($arResult["TAX_LIST"]))
                        {
                        foreach($arResult["TAX_LIST"] as $val)
                        {
                        ?>
                        <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=$val["NAME"]?> <?=$val["VALUE_FORMATED"]?>:</td>
                        <td class="custom_t2" class="price"><?=$val["VALUE_MONEY_FORMATED"]?></td>
                        </tr>
                        <?
                        }
                        }
                        if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
                        {
                        ?>
                        <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DELIVERY")?></td>
                        <td class="custom_t2" class="price"><?=$arResult["DELIVERY_PRICE_FORMATED"]?></td>
                        </tr>
                        <?
                        }
                        if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
                        {
                        ?>
                        <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_PAYED")?></td>
                        <td class="custom_t2" class="price"><?=$arResult["PAYED_FROM_ACCOUNT_FORMATED"]?></td>
                        </tr>
                        <?
                        }

                        if ($bUseDiscount):
                        ?>
                        <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>"><?=GetMessage("SOA_TEMPL_DISKOUNT_IT")?></td>
                        <td class="custom_t2"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></td>
                        </tr>
                        <tr>
                        <td class="custom_t1 fwb" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
                        <td class="custom_t2 fwb" class="price"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></td>
                        </tr>
                        <tr>
                        <td class="custom_t1 fwb" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_DISKOUNT_2_IT")?></td>
                        <td class="custom_t2 fwb" class="price"><? echo  SaleFormatCurrency($arResult["FULL_DISCOUNT"],'RUB'); //$arResult['FULL_DISCOUNT_FORMAT']; //= ($arResult["ORDER_TOTAL_PRICE_FORMATED"])?></td>
                        </tr>

                        <?
                        else:
                    */?>
                    <tr>
                        <td class="custom_t1 fwb sum-delivery" colspan="<?=$colspan?>" class="itog"><?=GetMessage("DELIVERY_1")?>:</td>
                        <td class="custom_t2 fwb sum-delivery"> <?=' '.round($arResult["DELIVERY_PRICE"], 0)?></td>
                        <?
                        ?>
                    </tr><tr>
                        <td class="custom_t1 fwb sum-price" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
                        <td class="custom_t2 fwb sum-price" class="price"> <?=' '.round($arResult["ORDER_PRICE"]+$arResult["DELIVERY_PRICE"], 0)?></td>
                    </tr>
                    <?
                        //endif;
                    ?>
                </tbody>
            </table>
            <div style="clear:both;"></div>

        </div>
        <div style="clear:both;"></div>

    </div>
</div>
<div class="bx_section">
    <div class="comment-title"><?=GetMessage("SOA_TEMPL_SUM_COMMENTS")?></div>
    <div class="bx_block w100"><textarea class="comment-input" name="ORDER_DESCRIPTION" placeholder="<?=GetMessage("COMMENT_PLACE")?>" id="ORDER_DESCRIPTION" style="max-width:90%;min-height:100px"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea></div>
    <input type="hidden" name="" value="">
    <div style="clear: both;"></div><br />
</div>