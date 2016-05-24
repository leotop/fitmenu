<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form name="<?echo $arResult['FILTER_NAME']."_form"?>" action="<?echo $arResult['FORM_ACTION']?>" method="get" class="ts-form ts-filter">

    <?foreach($arResult['ITEMS'] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem['INPUT'];
		endif;
	endforeach;?>
	
    
	<div class="ts-items">
	
	<?if(!empty($arParams['FILTER_TITLE'])):?>
		<div class="ts-item ts-filter__title"><b><?=$arParams['FILTER_TITLE'];?></b></div>
	<?endif;?>
	
	<?foreach($arResult['ITEMS'] as $arItem):?>
		<?if(!array_key_exists("HIDDEN", $arItem)):?>
				<div class="ts-item">
					<span class="ts-name"><?=$arItem['NAME'];?></span> 
					<div class="ts-filter__params"><?=$arItem['INPUT'];?>
					<div class="ts-buttons" style="text-align: <?=$arParams['BUTTON_ALIGN'];?>">
						<button type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>"><?=GetMessage("IBLOCK_SET_FILTER");?></button>&nbsp;&nbsp;
						<button type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>"><?=GetMessage("IBLOCK_DEL_FILTER");?></button>
					</div>
					</div>
				</div>
		<?endif?>
	<?endforeach;?>
	</div>
</form>