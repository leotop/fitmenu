<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul class="special-list">
    <li>
    	<div class="special-product-image">
            <a href="<?=$arResult["DETAIL_PAGE_URL"]?>">
                 <? if(empty($arResult["PICTURE"]["SRC"])): ?>
                 <? $arResult["PICTURE"] = array("SRC" => '/bitrix/templates/fitmenu/components/bitrix/catalog/fitmenu/bitrix/catalog.element/.default/images/no_photo.png'); ?>
                 <? endif ?> 
                  <img  src="<?=$arResult["PICTURE"]["SRC"]?>" alt="<?=$arResult['NAME']?>" title="<?=$arResult['NAME']?>" />
             </a>
        </div>
        <div class="special-product-title"><a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><?=$arResult['NAME']?></a></div>
    	<div class="special-product"><span><?=GetMessage('CR_PRICE')?>:</span> <?=$arResult["PROPERTY_PRICE_VALUE"]?></div>
    </li>
</ul>