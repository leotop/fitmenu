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

<div class="list blogs">
<? foreach ($arResult['SECTIONS'] as &$arSection) : ?>
						<div class="it-blog author" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
                        	<div class="preview">
                              <img alt="<? echo $arSection['PICTURE']['TITLE']; ?>" src="<? echo $arSection['PICTURE']['SRC']; ?>" />
                           </div>
                        	<div class="holder">
                        		<a class="link" title="<?= $arSection["NAME"] ?>" href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
                                <h4><?= $arSection["NAME"] ?></h4></a>
                        		<?= $arSection["PREVIEW_TEXT"] ?>
                        	</div>	
                        </div>
<? endforeach ?>
<div class="pages">  </div>
</div>