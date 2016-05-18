<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<div class="modal-inner">
<div class="modal-cross" onclick="$('.modal').fadeOut(500);">x</div>
<h1 class="h">Ваша корзина</h1>
<?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket",
    "popup",
    Array(
        "COLUMNS_LIST" => array(0=>"NAME",1=>"DISCOUNT",2=>"PROPS",3=>"DELETE",4=>"DELAY",5=>"PRICE",6=>"QUANTITY",7=>"SUM",),
        "PATH_TO_ORDER" => "/personal/order/make/",
        "HIDE_COUPON" => "Y",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
        "USE_PREPAYMENT" => "N",
        "QUANTITY_FLOAT" => "N",
        "SET_TITLE" => "Y",
        "ACTION_VARIABLE" => "action",
        "OFFERS_PROPS" => array(0=>"CML2_ATTRIBUTES",),
        "USE_AJAX"=>"Y"
    )
);?>
</div>