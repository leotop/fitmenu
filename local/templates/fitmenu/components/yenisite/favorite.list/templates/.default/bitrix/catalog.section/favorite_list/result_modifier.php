<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
require_once(__DIR__ . '/functions.php');
use Yenisite\Favorite\Template\Tools;

$arParams['RESIZER_SET'] = intval($arParams['RESIZER_SET']) > 0 ? $arParams['RESIZER_SET'] : 5;
foreach($arResult['ITEMS'] as $index => $arItem)
{
	if(!empty($arItem['IPROPERTY_VALUES']['SECTION_PICTURE_FILE_ALT']))
	{
		$imgAlt = $arItem['IPROPERTY_VALUES']['SECTION_PICTURE_FILE_ALT'];
	}
	else
	{
		$imgAlt = $arItem['NAME'];
	}
	$arItem['PICTURE_PRINT']['ALT'] = $imgAlt;
	$arItem['PICTURE_PRINT']['SRC'] = Tools::getElementPictureById($arItem['ID'], $arParams['RESIZER_SET']);

	if(isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
	{
		$minNotAvailPrice = false;
		$can_buy_find = false;
		$arItem['bOffers'] = true;
		foreach($arItem['OFFERS'] as $arOffer)
		{
			$minNotAvailPrice = (
				$arOffer['MIN_PRICE']['DISCOUNT_VALUE'] < $minNotAvailPrice['DISCOUNT_VALUE'] || !$minNotAvailPrice
				? $arOffer['MIN_PRICE']
				: $minNotAvailPrice
			);
			if(!$can_buy_find && $arOffer['CAN_BUY'])
			{
				$arItem['CAN_BUY'] = $arItem['CAN_BUY'] = $arOffer['CAN_BUY'];
				$can_buy_find = true;
			}
		}
		if($arItem['CAN_BUY'])
		{
			$arItem['MIN_PRICE'] = CIBlockPriceTools::getMinPriceFromOffers(
				$arItem['OFFERS'],
				$boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency
			);
		}
		else
		{
			$arItem['MIN_PRICE'] = $minNotAvailPrice;
		}
	}
	
	$arResult['ITEMS'][$index] = $arItem;
}

