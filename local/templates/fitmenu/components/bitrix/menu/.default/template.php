<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

	<?php

	function getArrayBrends($array) {
		$letterState = '';
		$result = [];

		foreach ($array as $value) {
			$letter = substr($value['TEXT'], 0, 1);

			if ($letter !== $letterState) {
				$result[] = $letter;
				$letterState = $letter;
			}

			$result[] = $value;
		}

		return $result;
	}

	$brendsCols = array_chunk(getArrayBrends($arResult), 25);

	?>

	<?php foreach ($brendsCols as $brends) { ?>

		<ul class="left-menu left-menu__brends">
			<?php foreach ($brends as $value) { ?>
				<?php if (count($value) === 1) { ?>
					<li class="left-menu__brends-head"><b><?php echo $value; ?></b></li>
				<?php } else { ?>
					<li class="left-menu__brends-item"><a class="left-menu__brends-link" href="<?php echo $value['LINK']; ?>"><?php echo $value['TEXT']; ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>

	<?php } ?>

<?endif?>