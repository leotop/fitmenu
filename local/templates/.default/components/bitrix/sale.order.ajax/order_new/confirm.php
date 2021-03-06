<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
    if (!empty($arResult["ORDER"]))
    {
    ?>
    <style>
        .order-title {
            display: none;
        }
    </style>
    <div class="order-confirm">
        <div class="order-confirm-title">Ваш заказ успешно оформлен, в скором времени с Вами свяжется менеджер.</div>
    </div>
    <?$this->SetViewTarget('reachgoal');?>
    <script type="text/javascript">
        var yaParams = {
            order_id: "<?=$arResult[ORDER_ID]?>",
            order_price: <?=$arResult[ORDER][PRICE]?>, 
            currency: "RUR",
            exchange_rate: 1,
        };
    </script>
    <?$this->EndViewTarget();?>
    <? if (!empty($arResult["PAY_SYSTEM"])): ?>
        <? if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0): ?>
            <div class="paymaster-block">
                <? if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y"): ?>
                    <?
                        header("Location: ".$arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"])));
                    ?>
                    <?=GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
                    <? if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE'])) : ?>
                        <?=GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
                        <? endif ?>
                    <? else : ?>
                    <? if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0): ?>
                        <?  include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]); ?>
                        <? endif ?>

                <? endif ?>

                <script type="text/javascript">
                    function openPayWindow(id) {
                        var a = $(id)[0];
                        var evObj = document.createEvent('MouseEvents');
                        evObj.initMouseEvent('click', true, true, window);
                        a.dispatchEvent(evObj); 
                    }
                    openPayWindow('#payMaster')
                </script>
            </div>
            <? endif ?>
        <? endif ?>

    <? if(FALSE): ?>
        <table class="sale_order_full_table">
            <tr>
                <td><?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?></td>
                <td></td>
                <td><?
                    if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
                    {
                    ?>
                    <script language="JavaScript">
                        window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
                    </script>


                    <?
                        if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
                        {
                        ?><br />
                        <?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
                        <?
                        }

                    }
                    else
                    {
                        if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
                        {
                            include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
                        }
                    }
                ?></td>
                <td></td>
            </tr>
        </table>
        <? endif ?> 
    <? if(FALSE): ?>
        <table class="sale_order_full_table">
            <tr>
                <td>
                    <?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?>
                </td>
            </tr>
        </table>
        <? endif ?>
    <?
        if (!empty($arResult["PAY_SYSTEM"]) AND FALSE)
        {
        ?>
        <table class="sale_order_full_table">
            <tr>
                <td class="ps_logo">
                    <div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
                    <?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
                    <div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
                </td>
            </tr>
            <?
                if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
                {
                ?>
                <tr>
                    <td>
                        <?
                            if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
                            {
                            ?>
                            <script language="JavaScript">
                                window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
                            </script>
                            <?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>

                            <?
                                if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
                                {
                                ?><br />
                                <?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
                                <?
                                }

                            }
                            else
                            {
                                if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
                                {
                                    include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?
                }
            ?>
        </table>

        <?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>
        <?
        }
    }
    else
    {
    ?>
    <b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

    <table class="sale_order_full_table">
        <tr>
            <td>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
            </td>
        </tr>
    </table>


    <?
    }
?>