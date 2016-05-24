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

<span class="head"><?=  $arResult['NAME'] ?></span>

<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
<table class="data-table category" cellspacing="0" cellpadding="0"  width="100%">
	<thead>
	<tr>
		<td></td>
        <td><?=GetMessage("CATALOG_TITLE")?></td>
		<?if(count($arResult["ITEMS"]) > 0):
			foreach($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"] as $arProperty):?>
				<td><?=$arProperty["NAME"]?></td>
			<?endforeach;
		endif;?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
			<td>Цена<? //=$arPrice["TITLE"]?></td>
		<?endforeach?>
		<?if(count($arResult["PRICES"]) > 0):?>
			<td>&nbsp;</td>
		<?endif?>
	</tr>
	</thead>
	<?foreach($arResult["ITEMS"] as $arElement):?>
	<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	?>
    <? if(! empty($arElement['BREND'])): ?>
         <tr>
            <td colspan="4"><? echo $arElement['BREND']['VIEW'] ?></td>
         </tr>
    <? endif ?>
    
	<tr id="<?=$this->GetEditAreaId($arElement['ID']);?>">
		<td><? /*print_R($arElement);*/ $preview = $arElement['PREVIEW_PICTURE'];   ?>
			<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
                <?php if(! empty($preview)): ?>
                <img src="<?=$preview["SRC"]?>" alt="<?=$arElement["NAME"]?>" width="100" />
                <?php endif ?>
            </a>
		</td>
        <td>
			<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
			<?if(count($arElement["SECTION"]["PATH"])>0):?>
				<br />
				<?foreach($arElement["SECTION"]["PATH"] as $arPath):?>
					/ <a href="<?=$arPath["SECTION_PAGE_URL"]?>"><?=$arPath["NAME"]?></a>
				<?endforeach?>
			<?endif?>
		</td>
		<?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		<td>
			<?if(is_array($arProperty["DISPLAY_VALUE"]))
				echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
			elseif($arProperty["DISPLAY_VALUE"] === false)
				echo "&nbsp;";
			else
				echo $arProperty["DISPLAY_VALUE"];?>
		</td>
		<?endforeach?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
    	<td>
			<?if($arPrice = $arElement["PRICES"][$code]):?>
				<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
                    <p class="old"><?=$arPrice["VALUE"]?></p>
                    <p class="product-price shk-price" ><?=$arPrice["DISCOUNT_VALUE"]?><span style="color:#000">&nbsp;&#8399;</span></p>
				<?else:?>
                    <p class="product-price shk-price" ><?=$arPrice["VALUE"]?><span style="color:#000">&nbsp;&#8399;</span></p>
				<?endif?>
			<?else:?>
				&nbsp; 
			<?endif;?>
		</td>
		<?endforeach;?>
		<?if(count($arResult["PRICES"]) > 0):?>
		<td>
			<?if($arElement["CAN_BUY"]):?>
				<noindex>
				<!--<a href="<?echo $arElement["BUY_URL"]?>" class="to-cart" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
				&nbsp; -->  <a href="<?echo $arElement["ADD_URL"]?>" class="to-cart" rel="nofollow"><? //echo GetMessage("CATALOG_ADD")?></a>
				</noindex>
			<?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
				<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
                <? // echo $arElement['ID']. $arElement["SUBSCRIBE_URL"]; ?>
				<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
							"NOTIFY_ID" => $arElement['ID'],
							"NOTIFY_URL" => htmlspecialcharsback($arElement["SUBSCRIBE_URL"]),
							"NOTIFY_USE_CAPTHA" => "N"
							),
							$component
						);?>
			<?endif?>&nbsp;
		</td>
		<?endif;?>
	</tr>
	<?endforeach;?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
</div>
