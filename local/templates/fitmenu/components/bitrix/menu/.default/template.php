<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<?php // var_dump($arResult);
?>

<ul class="left-menu">
<?
$i = 0;
$y = 0; // Для подсчета брендов
$brendName = '';
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
	
	$i++;
	
	if($arItem["SELECTED"]):
		if ($brendName !== $arItem['TEXT'][0]): 
			$y = 0;
			$brendName = $arItem['TEXT'][0];
		else: $y++;
		endif; 
	
		if ($y == 0): ?>
		<li><a href="<?=$arItem["LINK"]?>" class="selected"><?=$arItem["TEXT"]?></a></li>
		<?php endif; ?>
	<?php else:
		if ($brendName !== $arItem['TEXT'][0]): 
			$y = 0;
			$brendName = $arItem['TEXT'][0];
		else: $y++;
		endif;
					 
		if ($y == 0): ?>
			<li><?php echo $brendName; ?></li>
			<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
		<?php else: ?>
			<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
		<?php endif; ?>
	<?endif?>
	
	
<? if($i > 21): 
	  break;
	endif ?>
	
<?endforeach?>

<? if($i > 21): ?>
<!--    <li class="show"><a href="" title="Показать все">Показать все</a> </li>-->
<? endif ?>

</ul>

<ul class="left-menu left-menu_column">
	<?php if ($i > 21) {
		for ($i; $i < count($arResult); $i++) { ?>
			<?php if(($i % 22) == 0) { ?>
			</ul><ul class="left-menu left-menu_column">
			
			<?php 
			if ($brendName !== $arResult[$i]['TEXT'][0]) {
					$y = 0;
					$brendName = $arResult[$i]['TEXT'][0];
				} else {
					$y++;
				} 
				
				if ($y == 0): ?>
					<li><?php echo $brendName; ?></li>
					<li><a href="<?=$arResult[$i]["LINK"]?>"><?=$arResult[$i]["TEXT"]?></a></li>
				<?php else: ?>
					<li><a href="<?=$arResult[$i]["LINK"]?>"><?=$arResult[$i]["TEXT"]?></a></li>
				<?php endif; ?>
			<?php } else { 
				if ($brendName !== iconv("KOI8-U", "UTF-8", $arResult[$i]['TEXT'][0])) {
					$y = 0;
					$brendName = iconv("KOI8-U", "UTF-8", $arResult[$i]['TEXT'][0]);
				} else {
					$y++;
				} 
				
				if ($y == 0): ?>
					<li><?php echo $brendName; ?></li>
					<li><a href="<?=$arResult[$i]["LINK"]?>"><?=$arResult[$i]["TEXT"]?></a></li>
				<?php else: ?>
					<li><a href="<?=$arResult[$i]["LINK"]?>"><?=$arResult[$i]["TEXT"]?></a></li>
				<?php endif; ?>
			<?php } ?>
		<?php } ?>
	<?php } ?>
</ul>


<?endif?>