<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(function_exists('yenisite_GetCompositeLoader')){global $MESS;$MESS ['COMPOSITE_LOADING'] = yenisite_GetCompositeLoader();}?>

<?if(method_exists($this, 'createFrame')) $this->createFrame()->begin(GetMessage('COMPOSITE_LOADING')); ?><?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "ys-title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "ys-title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($this->__folder)
	$pathToTemplateFolder = $this->__folder ;
else
	$pathToTemplateFolder = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', dirname(__FILE__));

$before_search = "{$pathToTemplateFolder}/result_modifier.php";

if($arParams["SHOW_INPUT"] !== "N"):?>
	<div id="<?echo $CONTAINER_ID?>">
		<form action="<?=$before_search;?>" id="search_form">
			<input type="hidden" name="site_id" value="<?=SITE_ID;?>">
			<input type="hidden" name="ys_st_before" value="y">
			<input type="hidden" name="ys_st_ajax_call" value="y">
			<input type="text" class="txt" name="q" id="<?echo $INPUT_ID?>" autocomplete="off"  value="<?if (isset($_REQUEST["q"])) echo htmlspecialcharsbx($_REQUEST["q"])?>" placeholder="<?=GetMessage("SEARCH_PLACEHOLDER")?>"   />
			<?/*<input type="hidden" name="search_page" value="<?=$arResult["FORM_ACTION"];?>">*/?>
			<select id="search_select" name="search_category">
				<?if( $arParams["NUM_CATEGORIES"] > 1):?>
					<option value='all'><?=GetMessage('CATEGORY_ALL');?></option>
				<?endif;?>
				<?for($i = 0; $i < $arParams["NUM_CATEGORIES"]; $i++):
					$category_title = trim($arParams["CATEGORY_".$i."_TITLE"]);
					if(empty($category_title))
					{
						if(is_array($arParams["CATEGORY_".$i]))
							$category_title = implode(", ", $arParams["CATEGORY_".$i]);
						else
							$category_title = trim($arParams["CATEGORY_".$i]);
					}
					if(empty($category_title))
						continue;
				?>
					<option value='<?=$i;?>'><?=$category_title;?></option>
				<?endfor;?>
			</select>
			<div class="search__submit-wrapper"><a href="javascript:void(0);" class="s_submit">&#0035;</a></div>
		</form>
		<?if($arParams["EXAMPLE_ENABLE"] == "Y"):
			$list = $arParams["EXAMPLES"];
			if(!end($list))
				array_pop($list);
			$example = $list[array_rand($list)];
			if($example):
		?>
			<span class="example"><?=GetMessage('EXAMPLE');?><a href="javascript:void(0);"><?=$example;?></a></span>
		<?endif;endif;?>
	</div>
<?endif;?>
<script type="text/javascript">
var ys_st_jsControl = new ys_st_JCTitleSearch({
	//'WAIT_IMAGE': '/bitrix/themes/.default/images/wait.gif',
	'AJAX_PAGE' : '<?="{$pathToTemplateFolder}/result_modifier.php";?>',
	'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
	'INPUT_ID': '<?echo $INPUT_ID?>',
	'MIN_QUERY_LEN': 2,
	'SITE_ID': '<?=SITE_ID;?>',
	'CLEAR_CACHE': '<?=$_REQUEST['clear_cache'];?>'
});
</script>
