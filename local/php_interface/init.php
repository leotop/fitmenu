<?
    $include_path = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/';

    require_once($include_path.'iblock.class.php');
    require_once($include_path.'ucresizeimg.class.php');

    AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("MyIblock", "OnBeforeIBlockElementAddHandler"));
    AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("MyIblock", "OnBeforeIBlockElementUpdateHandler"));

    AddEventHandler("iblock", "OnAfterIBlockElementDelete", Array("MyIblock", "OnAfterIBlockElementDeleteHandler"));

    AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MyIblock", "OnAfterIBlockElementAddHandler"));
    AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MyIblock", "OnAfterIBlockElementUpdateHandler"));

    AddEventHandler("sale", "OnSaleComponentOrderOneStepProcess", Array("MyOrderProcessor", "OnSaleComponentOrderOneStepProcess"));

    AddEventHandler("sale", "OnOrderUpdate", "BUY_NUM_ADD");

    CModule::IncludeModule("main");
    CModule::IncludeModule("sale");
    CModule::IncludeModule("catalog");

    //Define constants
    define("COMPOSITION_IBLOCK_CODE", 'composition_data');
    define("ID_LETTER_TEMPLATE", 22);
    define("ID_DELIVERY_SERVICE", 2);


    function arshow($array, $adminCheck = false){
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    function BUY_NUM_ADD($ID, $arFields){

        if(CModule::IncludeModule("iblock") && CModule::IncludeModule("sale")){

            $dbBasketItems = CSaleBasket::GetList(
                array("NAME" => "ASC"),
                array("LID" => SITE_ID, "ORDER_ID" => $ID),
                false,
                false,
                array("*")
            );


            while ($arItems = $dbBasketItems->Fetch())
            {

                $arBasketItems[] = $arItems[PRODUCT_ID];
            }

            if(!empty($arBasketItems)){

                $arFilter = Array("ID"=>$arBasketItems);
                $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, array("IBLOCK_ID", "ID", "PROPERTY_CML2_LINK"));

                while($ar_fields = $res->GetNext())
                {

                    $db_props = CIBlockElement::GetProperty(CIBlockElement::GetIBlockByID($ar_fields["PROPERTY_CML2_LINK_VALUE"]), $ar_fields["PROPERTY_CML2_LINK_VALUE"], "sort", "asc", Array("CODE"=>"BUY_NUM"));

                    while ($ob = $db_props->GetNext())
                    {

                        if(isset($ob[VALUE]))
                            $newval = 1 + $ob[VALUE];
                        else
                            $newval = 1;

                        if(CIBlockElement::SetPropertyValues($ar_fields["PROPERTY_CML2_LINK_VALUE"], CIBlockElement::GetIBlockByID($ar_fields["PROPERTY_CML2_LINK_VALUE"]), $newval, "BUY_NUM")){
                            mail('v.e.sorokin@gmail.com', 'товар '.$ar_fields["PROPERTY_CML2_LINK_VALUE"], 'Изменен');
                        };

                    }
                }

            }


            //if(CModule::IncludeModule("iblock"))
            //CIBlockElement::CounterInc($arItems[]);

            /*$res = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $ID), false, false, array("*"));
            while ($arItem = $res->Fetch()) {
            mail('v.e.sorokin@gmail.com', 'заказ '.$ID, print_r($arItem, true));
            //$arResult['PROPERTIES']['COUNTER']['VALUE']+=1;
            //CIBlockElement::SetPropertyValues($arResult['ID'], $arResult["IBLOCK_ID"], $arResult['PROPERTIES']['COUNTER']['VALUE'], 'COUNTER');
            }*/
        }
    }

    function get_filter_brend($CODE = NULL){
        if(! $CODE){
            $CODE = (! empty($_REQUEST['CODE']) ? $_REQUEST['CODE'] : NULL);
        }
        if(CModule::IncludeModule("iblock")){
            $IBLOCK_BREND = 9;//references
            $arSelect = Array("ID", "NAME", "DETAIL_TEXT");
            $arFilter = Array("IBLOCK_ID"=>$IBLOCK_BREND, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "CODE" => $CODE);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            $brend =  $res->Fetch();
            if(! empty($brend)){
                return $brend;
            }
            return FALSE;
        }
    }

    function is_home(){
        global $APPLICATION;
        $page = $APPLICATION->GetCurPage();
        if($page == '/'){
            return TRUE;
        }
        return FALSE;
    }


    function is_ajax(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return TRUE;
        }
        return FALSE;
    }

    function label_product($PROPERTY = array()){
        //print_r($PROPERTY);
        $allow_porperty = array('stock', 'new', 'hit');
        $classes = array();
        foreach($allow_porperty as $p){
            if(! empty($PROPERTY[$p]['VALUE_XML_ID'])){

                if($PROPERTY[$p]['VALUE_XML_ID'] == 'Y'){
                    $classes[] = $p;
                }
            }
        }
        if(! empty($classes)){
            $return = '<div class="product-label '.implode(' ', $classes).'">';
            foreach($classes as $classe){
                $return .= '<div class="'.$classe.'"></div>';
            }
            $return .= '</div>';
            return $return;
        }
    }

    function it_pager($request = array()){
        if(empty($request)){
            $request = $_GET;
        }
        $current = 10; //default
        if(! empty($request['page_count'])){
            $_current = intval($request['page_count']);
            if($_current > 0){
                $current = $_current;
            }
        }
        return $current;
    }

    if(! function_exists('list_class')){
        function Arr_get($array = array(),$key = NULL, $default = NULL){
            if(! is_array($array)){
                return $default;
            }
            if(isset($array[$key])){
                return $array[$key];
            }
            return $default;
        }
        function _list_class($index, $count, $total, $type = NULL, $row = 2){
            $_classes = array();
            $option = array('first' => 'first',
                'last'  => 'last',
                'even'  => 'even',
                'odd'  => 'odd',
                'end_row'  => 'end_row',
            );
            if(! $type){
                $type = array('first');
            }
            $last = ($total == $index OR $count == $index);
            if(in_array('first', $type)){
                $_classes[] = (($index == 1) ? Arr_get($option,'first','first') : ($last ? Arr_get($option,'last','last'): ''));
                if($index == 1 and $total == 1)
                {
                    $_classes[] = Arr_get($option,'last','last');
                }
            }
            if(in_array('even', $type)){
                $_classes[] = $index % 2 == 0 ? Arr_get($option,'even','even'): NULL;
                $_classes[] = $index % 2 == 1 ? Arr_get($option,'odd','odd'): NULL;
            }
            if(in_array('end_row', $type)){
                $_classes[] = ($index % $row == 0 OR $last) ? Arr::get($option,'end_row','end_row'): NULL;
            }
            return $_classes;
        }

        function list_class($index, $count, $total, $type = NULL, $row = 2){
            $_classes = _list_class($index, $count, $total, $type, $row);
            return implode(' ', $_classes);
        }

        function echo_class($_classes){
            return implode(' ', $_classes);
        }
    }


    function class_content($side_l = FALSE,$side_r = FALSE){
        $classes = array();
        if(! $side_r AND ! $side_l){
            $classes[] = 'full';
        }
        if($side_l AND $side_r){
            $classes[] = 'small';
        }
        if(! empty($classes)){
            return ' class="'.implode(' ',$classes).'"';
        }
    }

    function Itdebug($var = NULL){
        echo $view = '<div style="display:none;">';
        print_R($var);
        echo $view = '</div>';

    }

    class MyOrderProcessor {
        function OnSaleComponentOrderOneStepProcess(&$arResult, &$arUserResult, $arParams) {
            global $USER;

            if (!($arUserResult["CONFIRM_ORDER"] == "Y" && empty($arResult["ERROR"]))) {
                return;
            }

            if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] != "Y") {
                return;
            }

            if (strlen($arUserResult["USER_EMAIL"]) == 0) {
                $arResult["ERROR"][] = GetMessage("STOF_ERROR_EMAIL");
                return;
            }

            $NEW_LOGIN = $arUserResult["USER_EMAIL"];
            $NEW_EMAIL = $arUserResult["USER_EMAIL"];
            $NEW_NAME = "";
            $NEW_LAST_NAME = "";

            if(strlen($arUserResult["PAYER_NAME"]) > 0) {
                $arNames = explode(" ", $arUserResult["PAYER_NAME"]);
                $NEW_NAME = $arNames[1];
                $NEW_LAST_NAME = $arNames[0];
            }

            $dbUserLogin = CUser::GetByLogin($NEW_LOGIN);
            if ($arUserLogin = $dbUserLogin->Fetch()) {
                $arResult["ERROR"][] = "Пользователь с логином ".htmlspecialchars($NEW_LOGIN)." уже существует. Пожалуйста авторизуйтесь.";
                return;
            }


            $GROUP_ID = array(2);
            $def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
            if($def_group!="") {
                $GROUP_ID = explode(",", $def_group);
                $arPolicy = $USER->GetGroupPolicy($GROUP_ID);
            }
            else {
                $arPolicy = $USER->GetGroupPolicy(array());
            }

            $password_min_length = intval($arPolicy["PASSWORD_LENGTH"]);
            if ($password_min_length <= 0) {
                $password_min_length = 6;
            }

            $password_chars = array(
                "abcdefghijklnmopqrstuvwxyz",
                "ABCDEFGHIJKLNMOPQRSTUVWXYZ",
                "0123456789",
            );

            if($arPolicy["PASSWORD_PUNCTUATION"] === "Y") {
                $password_chars[] = ",.<>/?;:'\"[]{}\|`~!@#\$%^&*()-_+=";
            }
            $NEW_PASSWORD = $NEW_PASSWORD_CONFIRM = randString($password_min_length+2, $password_chars);

            $user = new CUser;
            $arAuthResult = $user->Add(Array(
                "LOGIN" => $NEW_LOGIN,
                "NAME" => $NEW_NAME,
                "LAST_NAME" => $NEW_LAST_NAME,
                "PASSWORD" => $NEW_PASSWORD,
                "CONFIRM_PASSWORD" => $NEW_PASSWORD_CONFIRM,
                "EMAIL" => $NEW_EMAIL,
                "GROUP_ID" => $GROUP_ID,
                "ACTIVE" => "Y",
                "LID" => SITE_ID,
                )
            );

            if (IntVal($arAuthResult) <= 0) {
                $arResult["ERROR"][] = GetMessage("STOF_ERROR_REG").((strlen($user->LAST_ERROR) > 0) ? ": ".$user->LAST_ERROR : "" );
            }
            else {
                $USER->Authorize($arAuthResult);
                if ($USER->IsAuthorized()) {
                    if ($arParams["SEND_NEW_USER_NOTIFY"] == "Y") {
                        self::SendUserInfoWithPass($USER->GetID(), SITE_ID, GetMessage("INFO_REQ"), true, $NEW_PASSWORD);
                    }
                    else {
                        $arResult["ERROR"][] = GetMessage("STOF_ERROR_REG_CONFIRM");
                    }
                }
            }
        }

        static function SendUserInfoWithPass($ID, $SITE_ID, $MSG, $bImmediate, $password, $eventName="USER_INFO_PASS")
        {
            global $DB;

            // change CHECKWORD
            $ID = intval($ID);

            $res = $DB->Query(
                "SELECT u.* ".
                "FROM b_user u ".
                "WHERE ID='".$ID."'".
                "	AND (EXTERNAL_AUTH_ID IS NULL OR EXTERNAL_AUTH_ID='') "
            );

            if($res_array = $res->Fetch()) {
                $event = new CEvent;
                $arFields = array(
                    "USER_ID"=>$res_array["ID"],
                    "STATUS"=>($res_array["ACTIVE"]=="Y"?GetMessage("STATUS_ACTIVE"):GetMessage("STATUS_BLOCKED")),
                    "MESSAGE"=>$MSG,
                    "LOGIN"=>$res_array["LOGIN"],
                    "PASSWORD"=>$password,
                    "NAME"=>$res_array["NAME"],
                    "LAST_NAME"=>$res_array["LAST_NAME"],
                    "EMAIL"=>$res_array["EMAIL"]
                );

                if (!$bImmediate) {
                    $event->Send($eventName, $SITE_ID, $arFields);
                }
                else {
                    $event->SendImmediate($eventName, $SITE_ID, $arFields);
                }
            }
        }
    }

    // Функция проверяет товары на наличие цен если их нет то выводит из торговых предложений и добавляет к товарам
    function OnPriceUbdate(){
        //если есть ТП
        $ar_item_id = Array();
        $mxResult = CCatalogSKU::GetInfoByProductIBlock(23);
        if (is_array($mxResult))
        {
            $rsOffers = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $mxResult['IBLOCK_ID']));
            if ($rsOffers->SelectedRowsCount() > 0) {
                while ($arOffer = $rsOffers->GetNext())
                {


                    $ar_price = GetCatalogProductPrice($arOffer["ID"], 1);
                    //
                    $db_res = CIBlockElement::GetList(array(),array('IBLOCK_ID' => 24, "ID"=>$ar_price["PRODUCT_ID"]), false, false, Array('ID',"PROPERTY_CML2_LINK"))->Fetch();

                    /* if($res = CCatalogDiscount::GetDiscountProductsList(array(), array(">=DISCOUNT_ID" => 1), false, false, array())){
                    while($ob = $res->GetNext()){
                    $arDiscountElementID[] = $db_res["PROPERTY_CML2_LINK_VALUE"];
                    }}    */

                    // Где DISCOUNT_ID - ID скидки
                    // Далее подаём в компонент массив $arDiscountElementID для фильтрации по ID элемента


                    $arFields = array(
                        "PRODUCT_ID" => $db_res["PROPERTY_CML2_LINK_VALUE"],
                        "PRICE" => $ar_price["PRICE"],
                        "CURRENCY" => "RUB",
                        "CATALOG_GROUP_ID" => 1,
                    );
                    $res = CPrice::GetList(
                        array(),
                        array(
                            "PRODUCT_ID" => $db_res["PROPERTY_CML2_LINK_VALUE"],
                            "CATALOG_GROUP_ID" => 1,
                        )
                    );
                    if ($arr = $res->Fetch())
                    {
                        CPrice::Update($arr["ID"], $arFields);
                    }
                    else
                    {
                        if(!in_array($ar_price["PRODUCT_ID"],$ar_item_id))
                        {
                            $obPrice = CPrice::Add($arFields);

                            $ar_item_id[] =  $ar_price["PRODUCT_ID"];
                        }
                    }
                }
            }
        }
    }

    //Handler for composition custom property
    AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("ProductDataComposition", "GetUserTypeDescription"));

    //Class for composition custom property
    class ProductDataComposition {

        /***************
        *
        * The method returns an array describing the behavior of custom property
        *
        *************/
        function GetUserTypeDescription() {
            return array(
                "PROPERTY_TYPE" => "E",
                "USER_TYPE" => "ProductDataComposition",
                "DESCRIPTION" => "Состав продукта",
                "GetPropertyFieldHtmlMulty" => array("ProductDataComposition", "GetPropertyFieldHtmlMulty"),
                "ConvertToDB" => array("ProductDataComposition", "ConvertToDB"),
                "GetSettingsHTML" => array("ProductDataComposition", "GetSettingsHTML"),
                "PrepareSettings" => array("ProductDataComposition", "PrepareSettings"),
            );
        }

        /***************
        *
        * Output form edit multiple property
        *
        * @param array() $arProperty
        * @param array() $value
        * @param array() $strHTMLControlName
        * @return string $result
        *
        *************/
        function GetPropertyFieldHtmlMulty($arProperty, $value, $strHTMLControlName) {
            $linkBlockId = intval($arProperty["LINK_IBLOCK_ID"]);
            $productId = intval($_REQUEST["ID"]);
            if ($linkBlockId && $productId) {
                $rsElement = CIBlockElement::GetList(array("ID" => "ASC"), array("IBLOCK_ID" => $linkBlockId,
                    "PROPERTY_ID_PRODUCT" => $productId), false, false, array("ID", "NAME", "PROPERTY_WEIGHT_PACK", "PROPERTY_DESCRIPTION_COMPLEX"));

                while ($arElement = $rsElement->Fetch()) {
                    $result .= '<tr>
                    <td>
                    </br>
                    Название:
                    <input type="text" size="'.$arProperty["COL_COUNT"].'" value="'.$arElement["NAME"].'" name="'.$strHTMLControlName["VALUE"].'['.$arElement["ID"].'][VALUE][ITEM][VALUE]"/>
                    <input type="hidden" value="'.$arElement["ID"].'" name="'.$strHTMLControlName["VALUE"].'['.$arElement["ID"].'][VALUE][ITEM][ID]"/>
                    Вес на порцию:
                    <input type="text" size="5" value="'.$arElement["PROPERTY_WEIGHT_PACK_VALUE"].'" name="'.$strHTMLControlName["VALUE"].'['.$arElement["ID"].'][VALUE][ITEM][WEIGHT]"/></br>
                    Описание комплекса:
                    </br>
                    <textarea style="width: 100%; height: 100px;" class="typearea" name="'.$strHTMLControlName["VALUE"].'['.$arElement["ID"].'][VALUE][ITEM][DESCRIPTION]">'.$arElement["PROPERTY_DESCRIPTION_COMPLEX_VALUE"].'</textarea>
                    </br>
                    </td>
                    </tr>';
                }

                if (!empty($arProperty["MULTIPLE_CNT"])) {
                    for ($i = 0; $i <= $arProperty["MULTIPLE_CNT"]-1; $i++) {
                        $result .= '<tr>
                        <td>
                        </br>
                        Название:
                        <input type="text" size="'.$arProperty["COL_COUNT"].'" name="'.$strHTMLControlName["VALUE"].'[n'.$i.'][VALUE][ITEM][VALUE]"/>
                        Вес на порцию:
                        <input type="text" size="5" name="'.$strHTMLControlName["VALUE"].'[n'.$i.'][VALUE][ITEM][WEIGHT]"/></br>
                        Описание комплекса:
                        </br>
                        <textarea style="width: 100%; height: 100px;" class="typearea" name="'.$strHTMLControlName["VALUE"].'[n'.$i.'][VALUE][ITEM][DESCRIPTION]"></textarea>
                        </br>
                        </td>
                        </tr>';
                    }
                }

                $name = $strHTMLControlName["VALUE"];
                $result .= '<tr><td><input type="button" value="Добавить" onClick="addNewRow(\'tb'.md5($name).'\')"></td></tr>';
                return $result;
            } else {
                return "Ошибка настройки свойства. Укажите инфоблок в котором будут храниться данные.";
            }
        }

        /***************
        *
        * The method for saving, updating, and deleting of a custom property values.
        *
        * @param array() $arProperty
        * @param array() $value
        * @return string $arResult
        *
        *************/
        function ConvertToDB($arProperty, $value) {
            $linkBlockId = intval($arProperty["LINK_IBLOCK_ID"]);
            if ($linkBlockId) {
                //Add new property data
                if (is_array($value["VALUE"]["ITEM"]) && !empty($value["VALUE"]["ITEM"]["VALUE"]) && empty($value["VALUE"]["ITEM"]["ID"])) {
                    $obElement = new CIBlockElement;
                    $propComposition = array();
                    $propComposition["WEIGHT_PACK"] = $value["VALUE"]["ITEM"]["WEIGHT"];
                    $propComposition["DESCRIPTION_COMPLEX"] = $value["VALUE"]["ITEM"]["DESCRIPTION"];
                    $propComposition["ID_PRODUCT"] = $arProperty["ELEMENT_ID"];
                    $arResult["VALUE"] = $obElement->Add(array(
                        "IBLOCK_ID" => $linkBlockId,
                        "NAME" => $value["VALUE"]["ITEM"]["VALUE"],
                        "PROPERTY_VALUES" => $propComposition
                        ), false, false, true);
                }
                //Update property data
                elseif (is_array($value["VALUE"]["ITEM"]) && !empty($value["VALUE"]["ITEM"]["VALUE"]) && !empty($value["VALUE"]["ITEM"]["ID"])) {
                    $obElement = new CIBlockElement;
                    $propComposition = array();
                    $propComposition["WEIGHT_PACK"] = $value["VALUE"]["ITEM"]["WEIGHT"];
                    $propComposition["DESCRIPTION_COMPLEX"] = $value["VALUE"]["ITEM"]["DESCRIPTION"];
                    $propComposition["ID_PRODUCT"] = $arProperty["ELEMENT_ID"];
                    $result = $obElement->Update(
                        $value["VALUE"]["ITEM"]["ID"],
                        array(
                            "NAME" => $value["VALUE"]["ITEM"]["VALUE"],
                            "PROPERTY_VALUES" => $propComposition
                        ), false, false, true);
                    if ($result == true) {
                        $arResult["VALUE"] = $value["VALUE"]["ITEM"]["ID"];
                    }
                }
                //Delete property data
                elseif (empty($value["VALUE"]["ITEM"]["VALUE"])) {
                    $obElement = new CIBlockElement;
                    $obElement->Delete($value["VALUE"]["ITEM"]["ID"]);
                } else {
                    $arResult["VALUE"] = $value["VALUE"];
                }
            }
            return $arResult;
        }
    }

// отправка кастомного письма об оформлении заказа
// обработка события OnSaleComponentOrderOneStepComplete вызывается в bitrix:sale.order.ajax
AddEventHandler('sale', 'OnSaleComponentOrderOneStepComplete', Array('customEvents', 'OnOrderAddHandler'));

/*
class customEvents
{
    function OnOrderAddHandler($ID, &$arFields)
    {
        GLOBAL $USER;
        // свойства заказа
        $arProps = array();
        $res = CSaleOrderPropsValue::GetOrderProps($arFields['ID']);
        while ($prop = $res->Fetch())
            $arProps[$prop['CODE']] = $prop;
        // состав заказа
        $strBasket = '';
        $res = CSaleBasket::GetList(
          array('NAME' => 'ASC'),
          array('ORDER_ID' => $arFields['ID']),
          false,
          false,
          array('ID', 'NAME', 'QUANTITY', 'PRICE', 'CURRENCY')
        );
        while ($el = $res->GetNext())
            $strBasket .= ' * '.$el['NAME'].' ('.strval((int)$el['QUANTITY']).') - '.SaleFormatCurrency($el['PRICE'], $el['CURRENCY'])."\n";
        // платежная система
        if ($arFields['PAY_SYSTEM_ID'])
            $arPaySystem = CSalePaySystem::GetByID($arFields['PAY_SYSTEM_ID']);
        // служба доставки
        if ($arFields['DELIVERY_ID'])
            $arDelivery = CSaleDelivery::GetByID($arFields['DELIVERY_ID']);
        // адрес
        $arAddress = array();
        if (strlen($arProps['INDEX']['VALUE']))
            $arAddress[] = $arProps['INDEX']['VALUE'];
        if ($arProps['COUNTRY']['VALUE'])
        {
            $arLocation = CSaleLocation::GetByID($arProps['COUNTRY']['VALUE']);
            if (strlen($arLocation['COUNTRY_NAME']))
                $arAddress[] = $arLocation['COUNTRY_NAME'];
            if (strlen($arLocation['CITY_NAME']))
                $arAddress[] = $arLocation['CITY_NAME'];
        }
        if (strlen($arProps['LOCATION']['VALUE']))
            $arAddress[] = $arProps['LOCATION']['VALUE'];
        // отправка сообщения
        $arEventFields = array(
          'ORDER_ID' => $arFields['ID'],
          'ORDER_DATE' => $arFields['DATE_INSERT_FORMAT'],
          'USER_NAME' => $arProps['CONTACT_PERSON']['VALUE'],
          'USER_PHONE' => $arProps['PHONE']['VALUE'],
          'PRICE' => SaleFormatCurrency($arFields['PRICE'], $arFields['CURRENCY']),
          'ORDER_LIST' => $strBasket,
          'PAY_SYSTEM' => $arPaySystem['NAME'],
          'DELIVERY' => $arDelivery['NAME'],
          'ADDRESS' => implode(', ', $arAddress),
          'COMPANY_NAME' => (isset($arProps['F_COMPANY_NAME']) ? 'Организация: '.$arProps['F_COMPANY_NAME']['VALUE']."\n" : ''),
          'BCC' => COption::GetOptionString('sale', 'order_email', 'order@'.$SERVER_NAME),
          'EMAIL' => (strlen($arProps['EMAIL']['VALUE']) ? $arProps['EMAIL']['VALUE'] : $USER->GetEmail()),
          'SALE_EMAIL' => COption::GetOptionString('sale', 'order_email', 'order@'.$SERVER_NAME),
        );
        CEvent::Send('CUSTOM_SALE_NEW_ORDER', SITE_ID, $arEventFields);
    }
}*/

 //добавляем в письмо о заказе дополнительную информацию
    AddEventHandler('main', 'OnBeforeEventSend', Array("newOrder", "orderDataChange"));

    class newOrder{
        function orderDataChange(&$arFields, &$arTemplate){
            if ($arFields["ORDER_ID"] > 0 && $arTemplate["ID"] == ID_LETTER_TEMPLATE) {
                //общая инфо о зказе
                $order = CSaleOrder::GetById($arFields["ORDER_ID"]);

                //служба доставки
                $delivery = CSaleDelivery::GetById($order["DELIVERY_ID"]);

                //платежная система
                $paysystem = CSalePaysystem::GetById($order["PAY_SYSTEM_ID"]);

                $arFields["PAYSYSTEM"] = $paysystem['NAME'];

                //свойства заказа
                $orderProps = array();
                $db_props = CSaleOrderPropsValue::GetList(array(),array("ORDER_ID" => $order["ID"]));
                while($orderProp = $db_props->Fetch()) {
                    if ($orderProp["CODE"] == "STREET") {
                        $orderProps["STREET"] = $orderProp["NAME"] . ':' . $orderProp["VALUE"];
                    } elseif ($orderProp["CODE"] == "HOUSE") {
                        $orderProps["HOUSE"] = ", " . $orderProp["NAME"] . ':' . $orderProp["VALUE"];
                    } elseif ($orderProp["CODE"] == "CORPUS") {
                        $orderProps["CORPUS"] = ", " . $orderProp["NAME"] . ':' . $orderProp["VALUE"];
                    } elseif ($orderProp["CODE"] == "LEVEL") {
                        $orderProps["LEVEL"] = ", " . $orderProp["NAME"] . ':' . $orderProp["VALUE"];
                    } elseif ($orderProp["CODE"] == "KVARTIRA") {
                        $orderProps["KVARTIRA"] = ", " . $orderProp["NAME"] . ':' . $orderProp["VALUE"];
                    } elseif ($orderProp["CODE"] == "PICKUP") {
                        $arVal = CSaleOrderPropsVariant::GetByValue($orderProp["ORDER_PROPS_ID"], $orderProp["VALUE"]);
                        if($delivery["ID"] == ID_DELIVERY_SERVICE){
                            $delivery["NAME"] .= ', ' . $arVal["NAME"];
                        }
                    } else {
                        $orderProps[$orderProp["CODE"]] = $orderProp["VALUE"];
                    }

                }

                //местоположение
                $location = CSaleLocation::GetByID($orderProps["LOCATION"]);
                //собираем полученные данные
                $arFields["DELIVERY_TYPE"] = $delivery["NAME"];
                $arFields["PHONE"] = $orderProps["PHONE"];
                $arFields["ZIP"] = $orderProps["ZIP"];
                $arFields["ADDRESS"] = $location["COUNTRY_NAME"] . ", " . $location["CITY_NAME"] . ", " . $orderProps["STREET"] . $orderProps["HOUSE"] . $orderProps["CORPUS"] . $orderProps["LEVEL"] . $orderProps["KVARTIRA"];
                $arFields["ORDER_LIST"] = str_replace(".00 шт.", " шт.", $arFields["ORDER_LIST"]);
                $arFields["CPMMENT"] = $order["USER_DESCRIPTION"];
            }

        }
    }