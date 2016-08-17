<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
if(empty($arResult['BASKET']['PRESENTS']['CURRENT']) && empty($arResult['BASKET']['PRESENTS']['NEED_MORE'])) {
	return;
}
?>
<h2><?=GetMessage('PRESENT_BLOCK_TITLE')?></h2>
<div class="present-block">
	<?if(!empty($arResult['BASKET']['PRESENTS']['CURRENT'])):?>
		<div class="current-present">
			
			<div class="present-text"><?=GetMessage('CURRENT_PRESENT' . (count($arResult['BASKET']['PRODUCT_IDS']['CURRENT']) > 1 ? 'S' : ''))?></div>
			
			<?foreach($arResult['BASKET']['PRESENTS']['CURRENT'] as $sum => $arPresents):?>
				<?foreach($arPresents as $productId => $arPresent):?>
					<div class="present-item">
						<?$arCurrentPresent = $arResult['BASKET']['PRESENTS']['DATA'][$productId];?>
						<a href="<?=$arCurrentPresent['DETAIL_PAGE_URL']?>">
							<?if(!empty($arCurrentPresent['PICTURE'])):?> 
								<img class="present-image" src="<?=$arCurrentPresent['PICTURE']['src']?>">
							<?endif;?>
							<span class="present-name"><?=$arCurrentPresent['NAME']?></span>
						</a><span class="present-quantity"><?=($arPresent['PROPERTY_QUANTITY_VALUE'] > 1 ? '(x ' . $arPresent['PROPERTY_QUANTITY_VALUE'] . ')' : '')?></span>
					</div>
				<?endforeach;?>
			<?endforeach;?>
		</div>
	<?endif;?>
	<?if(!empty($arResult['BASKET']['PRESENTS']['NEED_MORE'])):?>
		<div class="next-present">
			<div class="present-text"><?=GetMessage('NEXT_PRESENT', array('#SUM#' => sb\CPresents::wordDeclension($arResult['BASKET']['PRESENTS']['NEED_MORE'], GetMessage('CURRENCY_N'), GetMessage('CURRENCY_A'), GetMessage('CURRENCY_G'))))?></div>
			<?foreach($arResult['BASKET']['PRESENTS']['NEXT'] as $sum => $arPresents):?>
				<?foreach($arPresents as $productId => $arPresent):?>
					<div class="present-item">
						<?$arNextPresent = $arResult['BASKET']['PRESENTS']['DATA'][$productId];?>
						<a href="<?=$arNextPresent['DETAIL_PAGE_URL']?>">
							<?if(!empty($arNextPresent['PICTURE'])):?>
								<img class="present-image" src="<?=$arNextPresent['PICTURE']['src']?>">
							<?endif;?>
							<span class="present-name"><?=$arNextPresent['NAME']?></span>
						</a><span class="present-quantity"><?=($arPresent['PROPERTY_QUANTITY_VALUE'] > 1 ? '(x ' . $arPresent['PROPERTY_QUANTITY_VALUE'] . ')' : '')?></span>
					</div>
				<?endforeach;?>
			<?endforeach;?>
		</div>
	<?endif;?>
</div>