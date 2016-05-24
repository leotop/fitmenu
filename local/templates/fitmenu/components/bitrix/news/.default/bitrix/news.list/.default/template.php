<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (count($arResult["ITEMS"]) < 1)
	return;
?>

<ul class="bx_news news-list">

<?if($_SERVER['REQUEST_URI']!="/vybor/" && $_SERVER['REQUEST_URI']!="/articles/"): ########## ?>

<?foreach($arResult["ITEMS"] as $arItem):?>
<? 
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM')));

?>

	<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="news-item row">
    <div class="news-item__inner">
      <div class="news-item__image">
        <img class="news-item__image-preview"
          src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
          alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
          title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
        >
      </div>

      <div class="news-item__descr">

        <div class="news-item__date">
          <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
            <?echo $arItem["DISPLAY_ACTIVE_FROM"]?>
          <?endif?>
        </div>
        <div class="news-item__title">
          <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arResult["USER_HAVE_ACCESS"]):?>
              <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
            <?else:?>
              <?echo $arItem["NAME"]?>
            <?endif;?>
          <?endif;?>
        </div>
        <div class="news-item__text">
          <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
            <?echo $arItem["PREVIEW_TEXT"];?>
            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arResult["USER_HAVE_ACCESS"]):?>
              <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>">Подробнее...</a>
            <?else:endif;?>
          <?endif;?>
        </div>
      </div>

    </div>
	</li>
<?endforeach;?>

<?else: ############# shide ############ ?>

<?foreach($arResult["ITEMS"] as $arItem):?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM')));

?>
	<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="article-preview-item">
		<table>
    <tr class="preview-item-title">
        <td>
            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<h3>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arResult["USER_HAVE_ACCESS"]):?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo '<span class="shide"><!--', base64_encode( $arItem["NAME"] ), '--></span>'?></a>
			<?else:?>
				<?echo '<span class="shide"><!--', base64_encode( $arItem["NAME"] ), '--></span>'?>
			<?endif;?>
			</h3>
		<?endif;?>
        </td>
        <td>
            <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
		    	<div class="date"><?echo '<div class="shide"><!--', base64_encode( $arItem["DISPLAY_ACTIVE_FROM"] ), '--></div>'?></div>
		    <?endif?>
        </td>
    </tr>
    <tr>
        <td>
            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<p><?echo '<div class="shide"><!--', base64_encode( $arItem["PREVIEW_TEXT"] ), '--></div>';?></p>
		<?endif;?>
        </td>
    </tr>
</table>

	</li>
<?endforeach;?>

<?endif;?>


</ul><br>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>