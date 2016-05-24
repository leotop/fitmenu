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

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>

<ul  class="blogs">
<? foreach ($arResult['SECTIONS'] as &$arSection) : ?>
    <li>
	<div class="blog-person">
		 <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" title="<? echo $arSection['NAME']; ?>">
            <img alt="<? echo $arSection['PICTURE']['TITLE']; ?>" src="<? echo $arSection['PICTURE']['SRC']; ?>" />
         </a>   
		<p class="name"><?= $arSection["NAME"] ?></p>
		<p class="discription"><?= $arSection["PREVIEW_TEXT"] ?></p>
	</div>
	<div class="blog-post">
			<p class="blog-date"><?= $arSection['LAST_POST']['DATE_CREATE']; ?></p>
				<a class="blog-link" href="<?= $arSection['LAST_POST']['DETAIL_PAGE_URL']; ?>"><?= $arSection['LAST_POST']['NAME']; ?></a>
								<p class="blog-discription"><?= $arSection['LAST_POST']['PREVIEW_TEXT']; ?></p>
			</div>
    </li>
<? endforeach ?>
</ul>