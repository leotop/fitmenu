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
?><? if (! empty($arResult['DISCOUNT'])):?>
<div class="sales">

<div class="list"> 

<?

	// Получение цены без скидки
	$good_id = $arResult["ITEMS"]['ID'];
	
	foreach($arResult["ITEMS"] as $arElement):
		foreach($arElement as $key => $value):
			if ($key == "ID") {
				$good_id = $value;
			}
		endforeach;
	endforeach;
	
	if(CModule::IncludeModule("catalog")) {
		//Дёргаем цену и элемента с id - $id
		$ar_price = GetCatalogProductPrice($good_id, 1);
		//В переменной $price теперь содержится цена товара
		$price = round($ar_price['PRICE'], 10);
	}

?>

<?foreach($arResult["ITEMS"] as $arElement):?>
	<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	?>
<div class="product" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
	<?if(is_array($arElement["PICTURE"])):?>
		<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" title="<? echo $arElement["NAME"] ?>" class="preview"><img border="0" src="<?=$arElement["PICTURE"]["SRC"]?>" alt="<?=$arElement['NAME']?>" title="<?=$arElement['NAME']?>" /></a><br /><!-- <?=$arElement["PICTURE"]["SRC"]?> -->
	<?endif?>
    <div class="price"><? echo SaleFormatCurrency($arElement['PRICE']['PRICE'], $arElement['PRICE']['CURRENCY']); ?></div>

        <div class="special-discount-price">
            <span>2300<!--<?= $price ?>--></span>
        </div>

	<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" title="<?=$arElement["NAME"]?>" class="name"><?=$arElement["NAME"]?></a>
</div>
<? endforeach ?>
</div>
<? // print_r($arResult['DISCOUNT']) ?>
<? if(! empty($arResult['DISCOUNT']['NOTES'])): ?>
<span class="discount_name"><? echo $arResult['DISCOUNT']['NOTES'] ?></span>

<span class="discount_description"><? echo $d = CurrencyFormat($arResult['DISCOUNT']["DISCOUNT_VALUE"], $arResult['DISCOUNT']["CURRENCY"]); ?></span>
<? endif ?>
<? if(! empty($arResult['JS'])): ?>
	<span class="title_block">Успевай! До конца акции:</span>
<div id="timer" data-time="<? echo $arResult['JS'] ?>"></div>
<script>
$(function(){
    var d_timer = $('#timer').attr('data-time');
   
   $('#timer').timeTo({
    timeTo: new Date(d_timer),
    displayDays: 2,
    //fontFamily: 'Arial',
    theme: "black",
    displayCaptions: true,
    fontSize: 25,
    captionSize: 15,
    lang:'ru'
});
});
</script>
<? endif ?>
</div>
<? endif ?>