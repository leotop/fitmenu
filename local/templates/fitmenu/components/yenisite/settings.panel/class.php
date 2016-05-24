<?php
use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;

class CYSSettingsPanel extends CBitrixComponent
{
	const CACHE_DIR = 'cache_romza';
	const CACHE_TIME = 31536000;

	static private $_module = FALSE;
	static private $_method = FALSE;
	static private $_asDefault = FALSE;

	public function onPrepareComponentParams($arParams) {
		$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 36000000;
		if (Loader::IncludeModule($arParams['SOLUTION'])) {
			self::$_module = $arParams['SOLUTION'];
		}
		if (!$arParams['GLOBAL_VAR'])
			$arParams['GLOBAL_VAR'] = "ys_options";

		if (!isset($arParams['EDIT_SETTINGS']) || !is_array($arParams['EDIT_SETTINGS']))
			$arParams['EDIT_SETTINGS'] = array();
		return $arParams;
	}

	static function getSettings($arSettings, $is_mobile = false) {
		if (!is_array($arSettings))
			return false;

		$options = self::loadFromCache();

		/* DELETE AFTER 12.11.2016 */
		/**/$bEmpty = false;
		/**/if (empty($options)) {
		/**/	$bEmpty = true;
		/**/	$con = Main\Application::getConnection();
		/**/	$sqlHelper = $con->getSqlHelper();

		/**/	$res = $con->query(
		/**/		"SELECT SITE_ID, NAME ".
		/**/		"FROM b_option ".
		/**/		"WHERE (SITE_ID = '".$sqlHelper->forSql(SITE_ID)."' OR SITE_ID IS NULL) ".
		/**/		"    AND MODULE_ID = '". $sqlHelper->forSql(self::$_module)."' ".
		/**/		"    AND NAME LIKE '". $sqlHelper->forSql('%_UID_%') ."' "
		/**/	);
		/**/	while ($ar = $res->fetch())
		/**/	{
		/**/		COption::RemoveOption(self::$_module, $ar['NAME'], SITE_ID);
		/**/	}
		/**/}
		/**/$cookiePrefix = COption::GetOptionString("main", "cookie_name", "BITRIX_SM") .'_'. SITE_ID .'_';
		/* DELETE AFTER 12.11.2016 */

		foreach ($arSettings as $key => $setting) {
			//DELETE AFTER 12.11.2016
			/**/if (isset($_COOKIE[$cookiePrefix.$key])) {
			/**/	self::setToCookies($key, '');
			/**/}
			//DELETE AFTER 12.11.2016
			if (isset($setting['hidden']) && $setting['hidden'] == true) continue;
			if (isset($setting['values']) && is_array($setting['values'])) {
				foreach ($setting['values'] as $k => $v) {
					if (is_array($v)) {
						$setting['values'] = array_merge($setting['values'], $v);
						unset($setting['values'][$k]);
					}
				}
			}
			if (!array_key_exists($key, $options) ||
				(isset($setting['values'])
					&& !isset($setting['values'][$options[$key]])
					&& !in_array($options[$key], $setting['values'])
				)
			) {
				$options[$key] = self::getSetting($key, $setting['default']);
			}
			if (strpos($setting['type'], '_MOBILE') !== false) {
				$keyMob = $key . '_MOBILE';
				$valMob = !empty($setting['values_MOBILE']) ? $setting['values_MOBILE'] : $setting['values'];
				if (!array_key_exists($keyMob, $options) || (is_array($valMob) && !in_array($options[$keyMob], $valMob))) {
					$defMob = !empty($setting['default_MOBILE']) ? $setting['default_MOBILE'] : $setting['default'];
					$options[$keyMob] = self::getSetting($keyMob, $defMob); //DELETE AFTER 12.11.2016
					//$options[$keyMob] = $defMob; //UNCOMMENT AFTER 12.11.2016
				}
				if ($is_mobile) {
					$bEmpty = false; //DELETE AFTER 12.11.2016
					$options[$key] = $options[$keyMob];
				}
				//DELETE AFTER 12.11.2016

				/**/if (isset($_COOKIE[$cookiePrefix . $keyMob])) {
				/**/	self::setToCookies($keyMob, '');
				/**/}
				//DELETE AFTER 12.11.2016
			}
		}

		/* DELETE AFTER 12.11.2016 */
		/**/if ($bEmpty) {
		/**/	$key = self::saveToCache($options);
		/**/	if (!empty($key)) {
		//  		foreach ($arSettings as $k => $value) {
		//  			COption::RemoveOption(self::$_module, $k, SITE_ID);
		//  			if (strpos($setting['type'], '_MOBILE') !== false) {
		//  				COption::RemoveOption(self::$_module, $k . '_MOBILE', SITE_ID);
		//  			}
		//  		}
		/**/		self::$_asDefault = TRUE;
		/**/		self::setKeyToOptions($key);
		/**/	}
		/**/}
		/* DELETE AFTER 12.11.2016 */

		return $options;
	}

	/**
	 * Get settings key from needed storage
	 * @return string Settings cache id
	 */
	static function getKey()
	{
		$func = "getKeyFrom" . self::_method();
		return self::$func();
	}

	static function setSettings($arOptions, $asDefault = FALSE)
	{
		$key = self::saveToCache($arOptions);
		$func = 'setKeyTo' . self::_method();

		if ($asDefault == TRUE) {
			global $USER;
			if ($USER->IsAdmin())
				self::$_asDefault = $asDefault;
			
			// for save default params in b_options
			foreach ($arOptions as $key => $setting) {
				self::setSetting($key, $setting, $asDefault);
			}
		}

		self::$func($key);
	}

	/**
	 * Save array with options to PHP Cache
	 * @param array $arOptions
	 */
	protected static function saveToCache(array $arOptions)
	{
		$key = md5(serialize($arOptions));
		$cachePath = self::_cachePath();

		$obCache = new \CPHPCache;
		if ($obCache->InitCache(self::CACHE_TIME, $key, $cachePath, self::CACHE_DIR)) {
			if ($arOptions != $obCache->GetVars()) {
				\CPHPCache::Clean($key, $cachePath, self::CACHE_DIR);
			}
		}
		if ($obCache->StartDataCache(self::CACHE_TIME, $key, $cachePath, array(), self::CACHE_DIR)) {
			$obCache->EndDataCache($arOptions);
		}
		return $key;
	}

	protected static function loadFromCache()
	{
		$key = self::getKey();
		if (empty($key)) return array();

		// =========== TURN OFF CLEAR_CACHE ===========
		$clearCache = Cache::setClearCache(false);
		$clearCacheSession = (isset($_SESSION["SESS_CLEAR_CACHE"]) && $_SESSION["SESS_CLEAR_CACHE"] === "Y");
		Cache::setClearCacheSession(false);
		if ($clearCacheSession) unset($_SESSION["SESS_CLEAR_CACHE"]);
		// ============================================

		$arCache = array();
		$obCache = new \CPHPCache;
		$cachePath = self::_cachePath();
		if ($obCache->InitCache(self::CACHE_TIME, $key, $cachePath, self::CACHE_DIR)) {
			$arCache = $obCache->GetVars();
		}

		// ============ TURN ON CLEAR_CACHE BACK IF NEEDED ===============
		if ($clearCache) Cache::setClearCache(true);
		if ($clearCacheSession) {
			Cache::setClearCacheSession(true);
			$_SESSION["SESS_CLEAR_CACHE"] = "Y";
		}
		// ===============================================================
		return $arCache;
	}

	protected static function _cachePath()
	{
		$path = '/' . SITE_ID . '/settings/';
		if (self::$_module) {
			$path .= self::$_module . '/';
		}
		return $path;
	}

	protected static function _method()
	{
		if (self::$_method == FALSE) {
			global $USER;
			self::$_method = $USER->IsAuthorized() ? "Options" : "Cookies";
		}
		return self::$_method;
	}

	/**
	 * Get settings key from Options
	 * @return string Settings cache id
	 */
	private static function getKeyFromOptions()
	{
		global $USER;
		$optionDef = 'SETTINGS_KEY_DEFAULT';
		$option = 'SETTINGS_KEY_UID_' . $USER->GetID();

		$value = COption::GetOptionString(self::$_module, $option, FALSE, SITE_ID);
		if (!$value)
			$value = COption::GetOptionString(self::$_module, $optionDef, '', SITE_ID);

		return $value;
	}

	/**
	 * @noinspection PhpUnusedPrivateMethodInspection
	 * Get settings key from Cookies. If there is nothing - get from Options
	 * @return string Settings cache id
	 */
	private static function getKeyFromCookies()
	{
		global $APPLICATION;
		$cookie = SITE_ID . '_SETTINGS_KEY';
		$value = $APPLICATION->get_cookie($cookie);
		if (empty($value)) {
			$value = self::getKeyFromOptions();
		}
		return $value;
	}

	/**
	 * @noinspection PhpUnusedPrivateMethodInspection
	 * @param $key
	 */
	private static function setKeyToOptions($key)
	{
		global $USER;
		if ($USER->IsAuthorized()) {
			$option = 'SETTINGS_KEY_UID_' . $USER->GetID();
			COption::SetOptionString(self::$_module, $option, $key, false, SITE_ID);
		}
		if (self::$_asDefault == TRUE) {
			$option = 'SETTINGS_KEY_DEFAULT';
			COption::SetOptionString(self::$_module, $option, $key, false, SITE_ID);
		}
	}

	/**
	 * @noinspection PhpUnusedPrivateMethodInspection
	 * @param $key
	 */
	private static function setKeyToCookies($key)
	{
		global $APPLICATION;
		$cookie = SITE_ID . '_SETTINGS_KEY';
		$domain = $APPLICATION->GetCookieDomain();
		if ($domain) {
			$domain = '.' . $domain;
		} else {
			$domain = false;
		}
		$APPLICATION->set_cookie($cookie, $key, false, "/", $domain);
	}

	/**************************************************************************
	 *     DEPRECATED - delete all this after 12.11.2016                      *
	 **************************************************************************/

	/**
	 * Тянет настройки из разных движков в зависимости от $method
	 * @param string $option нужная опция (настройка)
	 * @param string $default
	 * @param array $values
	 * @return string значение опции (настройки)
	 * @deprecated
	 */
	static function getSetting($option, $default = "", $values = array())
	{
		//$func = "getFrom" . self::_method();
		//return self::$func($option, $default, $values);
		return self::getFromOptions($option, $default);
	}

	/**
	 * Метод устанавливает Значение использую разные методы (cookies или options)
	 * @param string $option Название опции
	 * @param string $value Значение опции
	 * @param bool $asDefault
	 * @deprecated
	 */
	static function setSetting($option, $value, $asDefault = FALSE) {
		$func = "setTo" . self::_method();

		if ($asDefault == TRUE) {
			global $USER;
			if ($USER->IsAdmin())
				self::$_asDefault = $asDefault;
		}

		self::$func($option, $value);
	}

	/**
	 * Тянет настройки из options (БД)
	 * @param string $option нужная опция (настройка)
	 * @param string $default
	 * @return string Значение опции (настройки)
	 * @deprecated
	 */
	private static function getFromOptions($option, $default = "") {
		global $USER;
		$k = $option;
		//$key = $option . "_UID_" . $USER->GetID();

		//$value = COption::GetOptionString(self::$_module, $key, FALSE, SITE_ID);
		//if ($value === FALSE) {
			$value = COption::GetOptionString(self::$_module, $k, $default, SITE_ID);
		//}

		return $value;
	}

	/**
	 * @noinspection PhpUnusedPrivateMethodInspection
	 * Тянет настройки из Cookies. Если в Cookie ничего не найдено - лезем в Options
	 * @param string $option нужная опция (настройка)
	 * @param string $default
	 * @param array $values
	 * @return string Значение опции (настройки)
	 * @deprecated
	 */
	private static function getFromCookies($option, $default = "", $values = array()) {
		global $APPLICATION;
		$cookiePrefix = SITE_ID . '_';
		$key = $cookiePrefix . $option;
		$value = $APPLICATION->get_cookie($key);
		if (!$value || (!empty($values) && !in_array($value, $values))) {
			if(!isset($values[$value])) {
				$value = self::getFromOptions($option, $default);
			}
		}

		return $value;
	}

	/**
	 * @noinspection PhpUnusedPrivateMethodInspection
	 * @param $option
	 * @param $value
	 * @deprecated
	 */
	private static function setToOptions($option, $value) {
		global $USER;
		$key = $option . "_UID_" . $USER->GetID();
		COption::SetOptionString(self::$_module, $key, $value, false, SITE_ID);
		if (self::$_asDefault == TRUE) {
			$key = $option;
			COption::SetOptionString(self::$_module, $key, $value, false, SITE_ID);
		}
	}

	/**
	 * @noinspection PhpUnusedPrivateMethodInspection
	 * @param $option
	 * @param $value
	 * @deprecated
	 */
	private static function setToCookies($option, $value) {
		global $APPLICATION;
		$cookiePrefix = SITE_ID . '_';
		$key = $cookiePrefix . $option;
		$domain = $APPLICATION->GetCookieDomain();
		if ($domain) {
			$domain = '.' . $domain;
		} else {
			$domain = false;
		}/*
		$APPLICATION->set_cookie($key, $value, false, "/", $domain);*/
		$APPLICATION->set_cookie($key, $value, 0, '/', $domain); //delete cookie
	}
}