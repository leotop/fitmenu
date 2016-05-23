<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//Check params
if (!isset($arParams['CURRENCY_LIST']) || !is_array($arParams['CURRENCY_LIST'])) {
	$arParams['CURRENCY_LIST'] = array();
}
if (empty($arParams['DEFAULT_CURRENCY'])) {
	$arParams['DEFAULT_CURRENCY'] = 'BASE';
}


if (!CModule::IncludeModule('currency') && !CModule::IncludeModule('sale')) {
	$arResult = array(
		'ACTIVE_CURRENCY' => 'RUB',
		'CURRENCIES'      => array('RUB')
	);
}
else
//Work with cache
if ($this->StartResultCache()) {

	$arCurrencies = array();

	$db_cur = CCurrency::GetList(($by="sort"), ($order="asc"));
	while($arCur = $db_cur->Fetch())
	{
		$arCurrencies[] = $arCur['CURRENCY'];
		if ($arCur['BASE'] === 'Y') {
			$baseCurrency = $arCur['CURRENCY'];
		}
	}

	if (!empty($arParams['CURRENCY_LIST'])) {
		$arCurrencies = array_intersect($arCurrencies, $arParams['CURRENCY_LIST']);
	}

	if (empty($arCurrencies)) {
		$arCurrencies = array('RUB');
	}
	if (empty($baseCurrency)) {
		$baseCurrency = $arCurrencies[0];
	}

	$activeCurrency = in_array($arParams['GEOIP_CURRENCY'], $arCurrencies)
	                ? $arParams['GEOIP_CURRENCY']
	                : (
	                	in_array($arParams['DEFAULT_CURRENCY'], $arCurrencies)
	                	? $arParams['DEFAULT_CURRENCY']
	                	: $baseCurrency
	                );

	$arResult = array(
		'ACTIVE_CURRENCY' => $activeCurrency,
		'CURRENCIES'      => $arCurrencies
	);

	$this->EndResultCache();
}

//Work with Cookies
if(!empty($_COOKIE['RZ_CURRENCY'])
&& ($key = array_search($_COOKIE['RZ_CURRENCY'], $arResult['CURRENCIES'])) !== false) {
	$arResult['ACTIVE_CURRENCY'] = $arResult['CURRENCIES'][$key];
}

//Work with Request
if(!empty($_REQUEST['RZ_CURRENCY_NEW'])
&& ($key = array_search($_REQUEST['RZ_CURRENCY_NEW'], $arResult['CURRENCIES'])) !== false) {
	$arResult['ACTIVE_CURRENCY'] = $arResult['CURRENCIES'][$key];
	$APPLICATION->set_cookie(
		$name   = 'CURRENCY',
		$value  = $_REQUEST['RZ_CURRENCY_NEW'],
		$time   = false,
		$path   = '/',
		$domain = false,
		$secure = false,
		$spread = true,
		$name_prefix = 'RZ'
	);
	if (!isset($_GET['RZ_CURRENCY_NEW'])) {
		LocalRedirect($_SERVER['REQUEST_URI']);
	}
}

//Template
$this->IncludeComponentTemplate();

return $arResult['ACTIVE_CURRENCY'];
?>
