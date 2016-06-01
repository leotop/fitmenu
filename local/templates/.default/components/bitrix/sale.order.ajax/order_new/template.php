<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
    {
        if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
        {
            if(strlen($arResult["REDIRECT_URL"]) > 0)
            {
                $APPLICATION->RestartBuffer();
            ?>            <script type="text/javascript">
                window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
            </script>
            <?
                die();
            }
        }
    }

    $APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
    $APPLICATION->SetAdditionalCSS($templateFolder."/style.css");

    CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));
?>

<h1 class="order-title"><?=GetMessage("ORDER_TITLE")?></h1>

<? if(!$USER->IsAuthorized()): ?>
    <div class="wrapper block-order" id="block_auth">
        <div class="block last">

            <div class="holder">    
                <!--<form action="">-->
                <? //    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");       ?>
                <a href="#bay" class="bay_noreg btn-noreg-buy" title="Купить без регистрации" >Купить без регистрации</a><!--class="bay_noreg it-button"-->
                <!--</form> -->
            </div>

        </div>
        <div class="ili"><? echo GetMessage('TITLE_ILI'); ?></div>
        <div class="menu-open__wrapper">

            <div class="menu-open__inner menu-open__inner--login">
                <span class="menu-open__title">Войти</span>
                <button class="menu-open__trigger" type="button">☰</button>
            </div>

            <div class="menu-open block first">
                <div class="shadow">
                    <div class="holder">
                        <?                   $APPLICATION->IncludeComponent("bitrix:system.auth.form","order",Array(
                                "REGISTER_URL" => "register.php",
                                "FORGOT_PASSWORD_URL" => "",
                                "PROFILE_URL" => "profile.php",
                                "SHOW_ERRORS" => "Y" 
                                )
                            ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?/*<script>
        $(function(){
        $('#order_form_div').hide();
        $('.bay_noreg').click(function(){
        $('#block_auth').hide();
        $('#order_form_div').show();
        return !1;
        })
        })
    </script>*/?>  
    <? endif ?>


<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
    <NOSCRIPT>
        <div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
    </NOSCRIPT>

    <?
        if (!function_exists("getColumnName"))
        {
            function getColumnName($arHeader)
            {
                return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
            }
        }

        if (!function_exists("cmpBySort"))
        {
            function cmpBySort($array1, $array2)
            {
                if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
                    return -1;

                if ($array1["SORT"] > $array2["SORT"])
                    return 1;

                if ($array1["SORT"] < $array2["SORT"])
                    return -1;

                if ($array1["SORT"] == $array2["SORT"])
                    return 0;
            }
        }
    ?>

    <div class="bx_order_make">
        <?
            if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
            {
                if(!empty($arResult["ERROR"]))
                {
                    foreach($arResult["ERROR"] as $v)
                        echo ShowError($v);
                }
                elseif(!empty($arResult["OK_MESSAGE"]))
                {
                    foreach($arResult["OK_MESSAGE"] as $v)
                        echo ShowNote($v);
                }

                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
            }
            else
            {
                if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
                {
                    if(strlen($arResult["REDIRECT_URL"]) == 0)
                    {
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
                    }
                }
                else
                {
                ?>
                <script>
                    function submitForm(val) {
                        if(val != 'Y')
                            BX('confirmorder').value = 'N';

                        var orderForm = BX('ORDER_FORM');
                        BX.showWait();
                        BX.ajax.submit(orderForm, ajaxResult);

                        return true;
                    };

                    function ajaxResult(res) {
                        try {
                            var json = JSON.parse(res);
                            BX.closeWait();

                            if (json.error) {
                                return;
                            }
                            else if (json.redirect) {
                                window.top.location.href = json.redirect;
                            }
                        }
                        catch (e) {
                            BX('order_form_content').innerHTML = res;
                        }

                        BX.closeWait();
                        /*$("#ORDER_PROP_3").mask("+7 (999) 999-99-99");*/
                        <?if (!($USER->IsAuthorized())) {   ?> 
                            checkEmail();
                            <?}?>

                    };

                    function SetContact(profileId) {
                        BX("profile_change").value = "Y";
                        submitForm();
                    };
                </script>


                <?if($_POST["is_ajax_post"] != "Y")
                    {
                    ?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
                        <?=bitrix_sessid_post()?>
                        <div id="order_form_content">
                            <?
                            }
                            else
                            {
                                $APPLICATION->RestartBuffer();
                            }
                            if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
                            {
                                foreach($arResult["ERROR"] as $v)
                                    echo ShowError($v);
                            ?>
                            <div style="display: none;"><?
                                arshow($_POST);
                                arshow($arResult);

                            ?></div>
                            <script type="text/javascript">
                                top.BX.scrollToNode(top.BX('ORDER_FORM'));
                            </script>
                            <?
                            }

                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
                        ?>

                        <?    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");       ?>




                        <?
                            if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
                            {
                                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
                                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                            }
                            else
                            {
                                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
                            }

                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");

                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
                            if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
                                echo $arResult["PREPAY_ADIT_FIELDS"];
                        ?>

                        <?if($_POST["is_ajax_post"] != "Y")
                            {
                            ?>
                        </div>
                        <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
                        <input type="hidden" name="profile_change" id="profile_change" value="N">
                        <input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
                        <input type="hidden" name="json" value="Y">
                        <div class="bx_ordercart_order_pay_center"><a href="javascript:void();" onclick="submitForm('Y'); return false;" class="checkout"><?=GetMessage("SOA_TEMPL_BUTTON")?></a></div>
                    </form>       

                    <?
                        if($arParams["DELIVERY_NO_AJAX"] == "N")
                        {
                        ?>
                        <div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
                        <?
                        }
                    }
                    else
                    {
                    ?>
                    <script type="text/javascript">
                        top.BX('confirmorder').value = 'Y';
                        top.BX('profile_change').value = 'N';
                    </script>
                    <?
                        die();
                    }
                }
            }
        ?>

    </div>
</div>

<script>
    //Mask for phone input
    $(document).ready(function($){
        $("#ORDER_PROP_3").mask("+7 (999) 999-99-99");  
    });

    $('body').on('click','.pickupVariant', function(){
        $(".pickupVariant").removeClass("checked-pay");
        $(this).addClass("checked-pay");

        var val = text = $(this).attr("pickupVal");
        $('#ORDER_PROP_28 option').removeAttr('selected');
        $("#ORDER_PROP_28 option[value=" + val + "]").attr('selected', 'true').text(text);
    });

    $('body').on('click','.delivery-block', function(){
        $(".delivery-block").removeClass("active-delivery-block");
        $(this).addClass("active-delivery-block");
    }); 

    $('body').on('click','.delivery-choose-variant', function(){
        var idVar = $(this).prop("id");
        idVar='#'+idVar+"Block"; 
        $(".delivery-choosen-block").hide();
        $(idVar).fadeIn();
        $(".delivery-choose-variant").removeClass("active-variant");
        $(this).addClass("active-variant");
        if (idVar=="#varDeliveryBlock") {
            $("#ID_DELIVERY_ID_15").click();
        } else {
            $("#ID_DELIVERY_ID_2").click();
            $(".pickupVariant").first().click();
            $(".custom-delivery-block").hide();
        }
    });


    $(".delete-product").click(function(){
        var delDataId = $(this).prop("id"); 
        $.ajax({
            type: "POST",
            url: "/ajax/deleteProductOrder.php",
            data: { delDataId: delDataId, action: "delete"}
        }).done(function( strResult ) {
            location.reload(); 
        });  
    });

    $('body').on('change','#ORDER_PROP_5', function(){
        var idLocation=$("#ORDER_PROP_5").val();
        $("#ORDER_PROP_6").val(idLocation);
        if (idLocation!='') {
            $.ajax({
                type: "POST",
                url: "/ajax/getZipLocation.php",
                data: { id: idLocation}
            }).done(function( strResult ) {
                $("#ORDER_PROP_4").val(strResult);
                submitForm();
            });  
        }
    });

    function checkEmail() { 
        var email = $("#ORDER_PROP_2").val();
        var reg = /[0-9a-z_]+@[0-9a-z_^.]+\.[a-z]{2,3}/i;

        if(reg.test(email)) {
            $.post("/personal/order/make/getmail.php",
                {
                    mailE: email,
                },
                onAjaxSuccess("Заказ успешно оформлен!")
            );
        }
    };

    function onAjaxSuccess(data) {
        $(".main_desc").html(data);
    };

</script>

<div style="display: none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.locations", "order_location", Array(
        "CITY_OUT_LOCATION" => "Y",    // Возвращать ID местоположения (в противном случае - города)
        "ALLOW_EMPTY_CITY" => "Y",    // Выбор города местоположения не обязателен
        "COUNTRY_INPUT_NAME" => "COUNTRY",    // Имя поля формы для страны
        "REGION_INPUT_NAME" => "REGION",    // Имя поля формы для региона
        "CITY_INPUT_NAME" => "LOCATION",    // Имя поля формы для города (местоположения)
        "COUNTRY" => "1",    // Стартовое значение страны
        "ONCITYCHANGE" => "",    // Обработчик смены значения города (местоположения)
        "NAME" => "q",    // Имя поля ввода местоположения
        "COMPONENT_TEMPLATE" => "popup"
        ),
        false
    );?> </div>