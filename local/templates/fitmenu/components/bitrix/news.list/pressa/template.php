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
<?
$GLOBALS['APPLICATION']->SetAdditionalCSS($templateFolder.'/css/magnific-popup.css');
	$GLOBALS['APPLICATION']->AddHeadScript($templateFolder.'/js/jquery.magnific-popup.min.js');
?>
<div class="pressa-block gallery">
					<ul class="pressa">

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<? $index = 0; foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <li id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?  echo(++$index > 4 ? 'class="hidden"' : '') ?>>

             <a class="link" href="<?=$arItem['DETAIL_PICTURE']['SRC']?>" title="<?echo $arItem["NAME"]?>">
                <div class="preview">
                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" />
               </div>
            </a>
             <!--<a class="news-link" href="<?=$arItem['DETAIL_PICTURE']['SRC']?>" title="<?echo $arItem["NAME"]?>"><?echo $arItem["NAME"]?>
             </a>-->
    </li>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</ul>
</div>
