<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;

require_once 'class.php';

$arComponentParametersMerged['PARAMETERS'] = array(
	"COMPONENT_LIST" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("COMPONENT_LIST"),
		"TYPE" => "STRING",
		"MULTIPLE" => "Y",
		"REFRESH" => "Y",
		"SIZE" => "4",
	),
	"REMOVE_POSTFIX_IN_NAMES" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("REMOVE_POSTFIX_IN_NAMES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
);

if (!empty($arCurrentValues["COMPONENT_LIST"])) {
	$componentFolder = BX_ROOT . '/components';

	if (\Bitrix\Main\Application::GetInstance()->GetContext()->GetRequest()->IsAjaxRequest()
		&& !is_array($arCurrentValues["COMPONENT_LIST"])
	) {
		$arCurrentValues["COMPONENT_LIST"] = explode(',', $arCurrentValues["COMPONENT_LIST"]);
	}
	foreach ($arCurrentValues["COMPONENT_LIST"] as $componentName) {
		$clearCMPName = \YenisiteProxy::getComponentName($componentName);
		$path = $componentFolder . CComponentEngine::makeComponentPath($clearCMPName);

		if (CComponentUtil::isComponent($path)) {

			$arMainCurrentValues = $arCurrentValues;
			$arCurrentValues = \YenisiteProxy::unpackParamsForComponent($arCurrentValues, $componentName);

			Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . $path . '/.parameters.php');
			include $_SERVER['DOCUMENT_ROOT'] . $path . '/.parameters.php';

			$arCurrentValues = $arMainCurrentValues;

			$cmpKey = \YenisiteProxy::getComponentKey($componentName);
			foreach ($arComponentParameters['PARAMETERS'] as $oldKey => $arParam) {
				$newKey = $cmpKey . strtoupper($oldKey);
				if ($arCurrentValues['REMOVE_POSTFIX_IN_NAMES'] != 'Y') {
					$arParam['NAME'] = $arParam['NAME'] . "({$clearCMPName})";
				}
				$arComponentParameters['PARAMETERS'][$newKey] = $arParam;
				unset($arComponentParameters['PARAMETERS'][$oldKey]);
			}

			$arComponentParametersMerged = array_merge_recursive($arComponentParametersMerged, $arComponentParameters);
		}
	}
}

$arComponentParameters = $arComponentParametersMerged;