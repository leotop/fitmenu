<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="view-list">
	<span class="h3"><?=GetMessage("VIEW_HEADER");?></span>
	<?foreach($arResult as $arItem):?>
    <?//arshow($arItem)?>
		<div class="view-item">
			<?if($arParams["VIEWED_CANBUY"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
				<noindex>
					<a class="to-cart" href="<?=$arItem["BUY_URL"]?>" rel="nofollow"></a>
				</noindex>
			<?endif?>
			<?if($arParams["VIEWED_CANBASKET"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
				<noindex>
					<a class="to-cart" href="<?=$arItem["ADD_URL"]?>" rel="nofollow"></a>
				</noindex>
			<?endif?>
			<?if($arParams["VIEWED_IMAGE"]=="Y" && is_array($arItem["PICTURE"])):?>
			<div class="picture">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
					<img src="<?=$arItem["PICTURE"]["src"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>">
				</a>
			</div>
			<?endif?>
			
			<div class="viewed__descr">
        <?if($arParams["VIEWED_NAME"]=="Y"):?>
			    <div><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
			  <?endif?>
			  <?if($arParams["VIEWED_PRICE"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
			    <div><?=CurrencyFormat($arItem["PRICE"], "RUB");?></div>
			  <?endif?>
		  </div>
			
		</div>
	<?endforeach;?>
</div>
<?endif;?>