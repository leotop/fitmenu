<? 

    class MyIblock
    {
        function OnBeforeIBlockElementAddHandler(&$arFields)
        {

            /*if(! empty($arFields['XML_ID'])){
            $p = explode('#',$arFields['XML_ID']);
            // print_r($p);
            // exit();

            if(count($p) == 2){
            list($xml_id_tovar, $xml_id_offer) = $p;
            if(! CModule::IncludeModule("catalog")){
            exit('NO module catalog');
            }
            if(CModule::IncludeModule("iblock")){
            $rsCatalog = CCatalog::GetList(array(), array('PRODUCT_IBLOCK_ID' => 0));
            //$aCatalog = $rsCatalog->Fetch();
            //$CATALOG_IBLOCK_ID = $aCatalog['IBLOCK_ID'];

            while($aCatalog = $rsCatalog->GetNext()){
            //print_r($aCatalog);
            // exit();
            $CATALOG_IBLOCK_ID = $aCatalog['IBLOCK_ID'];  
            }   
            $arSelect = Array("ID");
            $arFilter = Array("IBLOCK_ID"=>$CATALOG_IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "XML_ID" => $xml_id_tovar);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            $aTovar = $res->Fetch();
            if(empty($aTovar)){

            $el = new CIBlockElement;
            $arFields['XML_ID'] = $xml_id_tovar;
            $arFields['IBLOCK_ID'] = $CATALOG_IBLOCK_ID;
            $arLoadProductArray = $arFields;
            if($PRODUCT_ID = $el->Add($arLoadProductArray)){

            } else{
            print_R($arFields);
            exit('error');
            }
            }


            } 
            }
            }
            */


            $arFields = MyIblock::translit($arFields);
            $IBLOCK_ID = $arFields['IBLOCK_ID'];
            $res = CIBlock::GetProperties($IBLOCK_ID, Array());
            $arPropertys = array();
            while($arProperty = $res->Fetch()){
                $arPropertys[$arProperty['CODE']] = $arProperty['ID'];   
            }


            $ch_prop_id = $arPropertys['CML2_ATTRIBUTES'];
            $brend_prop_id =  $arPropertys['CML2_MANUFACTURER'];

            if(! empty($arFields['PROPERTY_VALUES'][$ch_prop_id])){
                foreach($arFields['PROPERTY_VALUES'][$ch_prop_id] as $k_id => $character){
                    //if(empty($arFields['PROPERTY_VALUES'][$brend_prop_id]['n0'])){
                    //if($k_id != 'n0'){
                    if($character['DESCRIPTION'] == 'Бренд'){
                        $brend = $character['VALUE']; 
                        //  }

                    }
                }
            }
            if(! empty($brend)){
                if(! MyIblock::check_brend($arFields['PROPERTY_VALUES'][$brend_prop_id])){
                    $brend_id = MyIblock::add_brend($brend);
                    if($brend_id){
                        $arFields['PROPERTY_VALUES'][$brend_prop_id]['n0'] = array('VALUE' => $brend_id);
                    }            
                }
            }
            /*print_r($arFields);

            exit();
            */ 
        }


        function OnBeforeIBlockElementUpdateHandler(&$arFields)
        {
            $arFields = MyIblock::translit($arFields);
            $IBLOCK_ID = $arFields['IBLOCK_ID'];

            $res = CIBlock::GetProperties($IBLOCK_ID, Array());
            $arPropertys = array();
            while($arProperty = $res->Fetch()){
                $arPropertys[$arProperty['CODE']] = $arProperty['ID'];   
            }


            $ch_prop_id = $arPropertys['CML2_ATTRIBUTES'];
            $brend_prop_id =  $arPropertys['CML2_MANUFACTURER'];



            if(! empty($arFields['PROPERTY_VALUES'][$ch_prop_id])){
                foreach($arFields['PROPERTY_VALUES'][$ch_prop_id] as $k_id => $character){
                    if($k_id != 'n0'){
                        if($character['DESCRIPTION'] == 'Бренд'){
                            $brend = $character['VALUE']; 
                        }

                    }
                }
            }
            if(! empty($brend)){
                if(! MyIblock::check_brend($arFields['PROPERTY_VALUES'][$brend_prop_id])){
                    $brend_id = MyIblock::add_brend($brend);
                    if($brend_id){
                        $arFields['PROPERTY_VALUES'][$brend_prop_id]['n0'] = array('VALUE' => $brend_id);
                    }            
                }
            }
        }

        function OnAfterIBlockElementDeleteHandler(&$arFields)
        {

        }

        static public function translit($arFields = array(), $iBlocks = array()){
            $params = array(
                "max_len" => "100", 
                "change_case" => "L", 
                "replace_space" => "_", 
                "replace_other" => "_", 
                "delete_repeat_replace" => "true", 
                "use_google" => "false", 
            );
            $translit = 1;
            if(! empty($iBlocks)){
                if(! in_array($arFields["IBLOCK_ID"], $iBlocks)){
                    $translit = NULL;
                }
            }
            if (mb_strlen($arFields["NAME"])>0 && mb_strlen($arFields["CODE"])<=0 && $translit) {
                $translit = 1;    
            }else{
                $translit = NULL;
            }
            if($translit){
                $arFields['CODE'] = CUtil::translit($arFields["NAME"], "ru", $params); 
            }
            return $arFields;
        }

        static public function add_brend($brend_name = NULL, $brend_iblock_id = 9){
            if(CModule::IncludeModule("iblock")){

            }
            $arSelect = Array("ID","ACTIVE");
            $arFilter = Array("IBLOCK_ID" => intval($brend_iblock_id), "NAME" => $brend_name);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            $arBrend = $res->Fetch();
            if(! empty($arBrend)){
                return $arBrend['ID'];
            }else{
                /**
                * Add Brend
                */
                global $USER;
                $el = new CIBlockElement;
                $arLoadProductArray = Array(
                    "MODIFIED_BY"    => $USER->GetID(), 
                    "IBLOCK_SECTION_ID" => false,       
                    "IBLOCK_ID"      => $brend_iblock_id,
                    "NAME"           => $brend_name,
                    "ACTIVE"         => "Y",            // активен
                    "PREVIEW_TEXT"   => "",
                    "DETAIL_TEXT"    => "",
                    //"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
                );
                if($PRODUCT_ID = $el->Add($arLoadProductArray)){
                    return $PRODUCT_ID;  
                }
                else{
                    echo "Error: ".$el->LAST_ERROR;  
                }
            }
        }

        public static function check_brend($prop = array()){
            if(count($prop) == 1){
                if(! empty($prop['n0']['VALUE'])){
                    return TRUE;
                }
            }
            return FALSE;
        }

        function OnAfterIBlockElementAddHandler(&$arFields){

            if (CModule::IncludeModule("catalog")){
                $mxResult = CCatalogSku::GetProductInfo($arFields['ID']);
                $nobrend = FALSE;
                if (is_array($mxResult))
                {
                    $tovar_ID =  $mxResult['ID'];
                    $IBLOCK_ID = $arFields['IBLOCK_ID'];

                    $res = CIBlock::GetProperties($IBLOCK_ID, Array());
                    $arPropertys = array();
                    while($arProperty = $res->Fetch()){
                        $arPropertys[$arProperty['CODE']] = $arProperty['ID'];   
                    }
                    $ch_prop_id = $arPropertys['CML2_ATTRIBUTES'];
                    $brend_prop_id =  $arPropertys['CML2_MANUFACTURER'];
                    if(! empty($arFields['PROPERTY_VALUES'][$ch_prop_id])){
                        foreach($arFields['PROPERTY_VALUES'][$ch_prop_id] as $k_id => $character){
                            if($k_id != 'n0'){
                                if($character['DESCRIPTION'] == 'Бренд'){
                                    $brend = $character['VALUE']; 
                                }
                            }
                        }
                    }
                    if(! empty($brend)){
                        $brend_id = MyIblock::add_brend($brend);
                        CIBlockElement::SetPropertyValuesEx($tovar_ID, false, array('CML2_MANUFACTURER' => $brend_id));
                    }else{
                        $nobrend = TRUE;
                    }
                    if($nobrend){

                        /*UPDATE CATALOG PRODUCT */
                        /*
                        $dbProductPrice = CPrice::GetListEx(
                        array(),
                        array("PRODUCT_ID" => $tovar_ID),
                        false,
                        false,
                        array("ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY", "QUANTITY_FROM", "QUANTITY_TO")
                        );
                        $price = $arFields['PRICES'][0]['ЦенаЗаЕдиницу'];
                        $arF = array('PRODUCT_ID'=>$tovar_ID,'CATALOG_GROUP_ID'=>1,'PRICE'=>$price,'CURRENCY'=>'RUB', "EXTRA_ID" => '');
                        print_r($arF);
                        if ($arr = $dbProductPrice->Fetch()){
                        print_r($arr);
                        $u =  CPrice::Update($arr["ID"], $arF);
                        }
                        else{
                        $obPrice = new CPrice();
                        $u =  $obPrice->Add($arF);
                        }
                        var_dump($u);
                        $pr = CPrice::GetByID($u);
                        print_r($pr);
                        exit();*/
                    }

                }
                else
                {
                    // echo 'Это не торговое предложение';
                    //exit();
                }
                // exit();
            }
        }

        function OnAfterIBlockElementUpdateHandler(&$arFields){
            if (CModule::IncludeModule("catalog")) 
            { 
                $res = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array(), array());
                //$element = CIBlockElement::GetByID($arFields['ID'])->Fetch();
                $min_price = CPrice::GetBasePrice($arFields['ID']);

                while($arProperty = $res->Fetch()){
                    if($arProperty["CODE"] == "COUNT_PACK"){
                        $pack = $arProperty["VALUE"];
                    };

                    $arPropertys[$arProperty['CODE']] = $arProperty['ID'];  
                }  
                $summ_price_portion = $min_price["PRICE"]/$pack; 
                if(! empty($summ_price_portion)){
                    // обновляем сумму товара за 1 упаковку
                    CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('PRICE_PORTION' => $summ_price_portion));
                };  

                $mxResult = CCatalogSKU::GetInfoByProductIBlock($arFields['IBLOCK_ID']); 

                if (is_array($mxResult)){ 
                    $rsOffers = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $mxResult['IBLOCK_ID'],'PROPERTY_'.$mxResult['SKU_PROPERTY_ID'] => $arFields['ID'])); 
                    while ($arOffer = $rsOffers->GetNext()) 
                    { 
                        $product = CCatalogProduct::GetByID($arOffer["ID"]); 
                        if($product["QUANTITY"] > 0){
                            $quantity_product = $product["QUANTITY"]; 
                        }
                    } 
                } 
                if($quantity_product > 0){
                    // обновляем и устанавливаем ДА с id 66
                    CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('CATALOG_AVAILABLE' => array("XML_ID" => 66))); 
                }else{
                    CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('CATALOG_AVAILABLE' => array("XML_ID" => 67))); 
                }

                $element = CIBlockElement::GetByID($arFields['ID'])->Fetch();

                $section = CIBlockSection::GetByID($element["IBLOCK_SECTION_ID"])->Fetch();
                if(empty($section["IBLOCK_SECTION_ID"])){
                    $section_id = $section["NAME"];
                }else{
                    $section_path = CIBlockSection::GetByID($section["IBLOCK_SECTION_ID"])->Fetch(); 
                    $section_id = $section_path["NAME"];
                }
                if(!empty($section_id)){
                    CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('CATEGORY_PRODUCT' => $section_id)); 
                }
            } 

        }

}