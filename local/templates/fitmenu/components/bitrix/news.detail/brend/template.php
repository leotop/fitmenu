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
	$this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
<div class="brend section" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <h1><? echo $arResult["NAME"] ?></h1>
    <div class="content"><?echo $arResult["DETAIL_TEXT"];?></div>
</div>