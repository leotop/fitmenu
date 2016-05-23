<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y")
{
?><?
	if ($arResult["READY"]=="Y")
	{
		?>
<h2 class="smallbasket-title"><? echo GetMessage("TSBS_READY"); ?></h2>

		<ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"]; ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?>
				&nbsp;<?echo $v["PRICE_FORMATED"]?> x <?echo $v["QUANTITY"]?>
				</li>
				<?
			}
		}
		if (isset($v))
			unset($v);
		?></ul><?
		if ('' != $arParams["PATH_TO_BASKET"])
		{
			?><form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
				<input type="submit" class="bx_medium" value="<?= GetMessage("TSBS_2BASKET") ?>">
			</form><?
		}
		if ('' != $arParams["PATH_TO_ORDER"])
		{
			?><form method="get" action="<?= $arParams["PATH_TO_ORDER"] ?>">
				<input type="submit" class="bx_big" value="<?= GetMessage("TSBS_2ORDER") ?>">
			</form><?
		}
	}
	if ($arResult["DELAY"]=="Y")
	{
		?><h2 class="smallbasket-title"><?= GetMessage("TSBS_DELAY") ?></h2>
		
		<ul>
		<?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="Y" && $v["CAN_BUY"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?><br />
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				</li>
				<?
			}
		}
		if (isset($v))
			unset($v);
		?></ul><?
		if ('' != $arParams["PATH_TO_BASKET"])
		{
			?><form method="get" action="<?=$arParams["PATH_TO_BASKET"]?>">
			<input type="submit" value="<?= GetMessage("TSBS_2BASKET") ?>">
			</form><?
		}
	}
	if ($arResult["SUBSCRIBE"]=="Y")
	{
		?><h2 class="smallbasket-title"><?= GetMessage("TSBS_SUBSCRIBE") ?></h2>
		<ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="Y")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?></li><?
			}
		}
		if (isset($v))
			unset($v);
		?></ul><?
	}
	if ($arResult["NOTAVAIL"]=="Y")
	{
		?><h2 class="smallbasket-title"><?= GetMessage("TSBS_UNAVAIL") ?></h2>
		
		<ul><?
		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["CAN_BUY"]=="N" && $v["SUBSCRIBE"]=="N")
			{
				?><li><?
				if ('' != $v["DETAIL_PAGE_URL"])
				{
					?><a href="<?echo $v["DETAIL_PAGE_URL"] ?>"><b><?echo $v["NAME"]?></b></a><?
				}
				else
				{
					?><b><?echo $v["NAME"]?></b><?
				}
				?><br />
				<?= GetMessage("TSBS_PRICE") ?>&nbsp;<b><?echo $v["PRICE_FORMATED"]?></b><br />
				<?= GetMessage("TSBS_QUANTITY") ?>&nbsp;<?echo $v["QUANTITY"]?>
				</li><?
			}
		}
		if (isset($v))
			unset($v);
		?></ul><?
	}
	?><?
}
?>