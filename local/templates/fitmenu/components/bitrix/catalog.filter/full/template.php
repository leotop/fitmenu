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
?>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>
	
		<?=GetMessage("IBLOCK_FILTER_TITLE")?>
		    
    <div class="full-filter">
        <div class="versions">
        <? $i_index = 1; ?>
		<?foreach($arResult["ITEMS"] as $prop => $arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
				 <? $prop_id = str_replace('PROPERTY_','',$prop); $prop_id = intval($prop_id);
                 $property = ! empty($arResult['arrProp'][$prop_id]) ? $arResult['arrProp'][$prop_id] : array();
                 $class = ! empty($property['CODE']) ? $property['CODE'] : NULL;
                 ?>
                 <div class="version <?= $class ?>">
                    <div class="h"><span><?= $i_index ?>.</span><?=$arItem["NAME"]?></div>
					<div class="values">
                        <?=$arItem["INPUT"]?>
                    </div>
				</div>
                <? $i_index++; ?>
			<?endif?>
		<?endforeach;?>
        </div>
        <div class="last version">
            <input type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" />
            <input type="hidden" name="set_filter" value="Y" />&nbsp;&nbsp;<input type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" />
        </div>
    </div>    
	
</form>
