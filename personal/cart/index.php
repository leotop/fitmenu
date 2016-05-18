<?
$FULL_WIDTH = "Y";
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Корзина");
?> 
<h1 class="h">Ваша корзина</h1>
 
<!--<div class="warning-price-oplata" style="width: 550px; float: right; margin-top: 0px; margin-right: 40px;">Друзья! В связи с резким изменением курса валют цены пересчитыватся консультантом по каждому заказу. После размещения заказа с Вами свяжется консультант и сообщит точную информацию. Приносим извинения за предоставленные неудобства. 
  <br />
 
  <br />
 Ваша команда Fitmenu.ru </div>-->
 <?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket",
	"fitnes",
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
		"OFFERS_PROPS" => array(0=>"CML2_ATTRIBUTES",)
	)
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>