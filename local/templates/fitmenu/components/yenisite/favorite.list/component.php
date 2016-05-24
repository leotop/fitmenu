<?
use \Bitrix\Main\Loader;
use \Yenisite\Core\Tools;
use \Yenisite\Favorite\Favorite;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) { // isAjax
		if (isset($_REQUEST['URL'])) { // hack SITE_ID and SITE_TEMPLATE_PATH
			$_SERVER["REQUEST_URI"] = $_REQUEST['URL'];
		}
		require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
		global $APPLICATION;

		if (!Loader::includeModule('yenisite.favorite')) {
			die(GetMessage('RZ_ERR_NO_FAVORITE_MODULE_INSTALLED'));
		}
		if (!Loader::includeModule('yenisite.core')) {
			die(GetMessage('RZ_ERR_NO_CORE_MODULE_INSTALLED'));
		}

		Tools::encodeAjaxRequest($_REQUEST);
		$APPLICATION->IncludeComponent('yenisite:favorite.list', $_REQUEST['template'], Tools::GetDecodedArParams($_REQUEST['arparams']));
		die();
	} else {
		die();
	}
};

if (!Loader::includeModule('yenisite.favorite')) {
	die(GetMessage('RZ_ERR_NO_FAVORITE_MODULE_INSTALLED'));
}
if (!Loader::includeModule('iblock')) {
	die(GetMessage('RZ_ERR_NO_IBLOCK_MODULE_INSTALLED'));
}
if (!Loader::includeModule('yenisite.core')) {
	die(GetMessage('RZ_ERR_NO_CORE_MODULE_INSTALLED'));
}
global $APPLICATION;

if (!empty($_REQUEST['ACTION'])) {
	$arResult = array(
		'result' => '',
		'msg' => '',
	);
	switch ($_REQUEST['ACTION']) {
		case 'ADD':
			if (!Favorite::add($_REQUEST['ID'])) {
				$arResult['msg'] = implode('<br>', Favorite::getErrors());
				$arResult['result'] = 'error';
			} else {
				$arResult['result'] = 'success';
				$arResult['msg'] = '';
			}
			break;
		case 'FLUSH':
			if (!Favorite::flush()) {
				$arResult['msg'] = implode('<br>', Favorite::getErrors());
				$arResult['result'] = 'error';
			} else {
				$arResult['result'] = 'success';
				$arResult['msg'] = '';
			}
			break;
		case 'DELETE':
			if (!Favorite::delete($_REQUEST['ID'])) {
				$arResult['msg'] = implode('<br>', Favorite::getErrors());
				$arResult['result'] = 'error';
			} else {
				$arResult['result'] = 'success';
				$arResult['msg'] = '';
			}
			break;
		default:
			return;
	}
	$isNeedEnc = (($curEnc = Tools::getLogicalEncoding()) != 'utf-8');
	if ($isNeedEnc) {
		Tools::encodeArray($arResult, $curEnc, 'utf-8');
	}
	$APPLICATION->RestartBuffer();
	echo json_encode($arResult);
	die();
}

if (empty($arParams['FILTER_NAME'])) {
	$arParams['FILTER_NAME'] = 'arrFavoriteList';
}
$arParams['BY_LINK'] = 'Y';
$globalNameConvert = empty($arParams['CONVERT_GLOBAL_NAME']) ? 'rz_b2_options' : $arParams['CONVERT_GLOBAL_NAME'];

global $$globalNameConvert;
$arGlobalConvert = &$$globalNameConvert;
if (isset($arGlobalConvert['currency-switcher'])
	&& $arGlobalConvert['currency-switcher'] == 'Y'
	&& isset($arGlobalConvert['active-currency'])
) {
	$arParams['CONVERT_CURRENCY'] = 'Y';
	$arParams['CURRENCY_ID'] = $arGlobalConvert['active-currency'];
}

$arParams['CATALOG_TEMPLATE'] = empty($arParams['CATALOG_TEMPLATE']) ? 'favorite_list' : $arParams['CATALOG_TEMPLATE'];
unset($arParams['CONVERT_GLOBAL_NAME']);

global $$arParams['FILTER_NAME'];
$arrFilter = &$$arParams['FILTER_NAME'];
$arrFilter = array();

$arProductID = Favorite::getProducts();
$arrFilter['ID'] = $arProductID;
$arParams['IBLOCK_ID'] = CIBlockElement::GetIBlockByID(reset($arProductID));
$this->IncludeComponentTemplate('template');