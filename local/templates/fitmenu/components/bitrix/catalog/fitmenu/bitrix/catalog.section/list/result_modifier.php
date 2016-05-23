<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    //arshow($arResult["ITEMS"]);
    //Make all properties present in order
    //to prevent html table corruption
    $current_brend = null; $index = 0;

    $ucResizeImg = new C_ucResizeImg();
    $ucResizeImg->SetDefParams(array(
        'KEEP_SIZE' => true,
        'FILL_COLOR' => array('R'=>255,'G'=>255,'B'=>255), # ������� ����
    ));

    foreach($arResult["ITEMS"] as $key => $arElement)
    {

        $hide_propertys = array('stock', 'new');
        $arRes = array();
        foreach($arParams["PROPERTY_CODE"] as $pid)
        {
            if(! in_array($pid,$hide_propertys)){
                $arRes[$pid] = CIBlockFormatProperties::GetDisplayValue($arElement, $arElement["PROPERTIES"][$pid], "catalog_out");  
            }

        }
        $arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"] = $arRes;


        //print_r($arElement);

        $brend = ! empty($arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['VALUE']) ? $arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['VALUE'] : NULL;
        if($index == 0 AND $brend){
            $arResult["ITEMS"][$key]["BREND"] = array('ID' => $brend, 'SHOW' => 1, 'VIEW' => $arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['DISPLAY_VALUE']);
            $current_brend = $brend; 
        }
        if($index > 0 AND $current_brend !== $brend AND $brend){
            $arResult["ITEMS"][$key]["BREND"] = array('ID' => $brend, 'SHOW' => 1, 'VIEW' => $arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['DISPLAY_VALUE']);
            $current_brend = $brend; 
        }

        $CAN_BUY =  $arElement['CAN_BUY']; // 1 - ����� ������
        $CAN_BUY_OFFERS = array();
        foreach($arElement['OFFERS'] as $offer){

            if(! empty($offer['CAN_BUY'])){
                $CAN_BUY_OFFERS[] = $offer['CAN_BUY'];    
            }
            //print_r($offer['SUBSCRIBE_URL']);
            //print_r($offer);
            if(! empty($arElement['PRICES'])){
                foreach($arElement['PRICES'] as $price_title => $price){
                    if(! empty($offer['PRICES'][$price_title])){
                        //if($offer['PRICES'][$price_title]['VALUE'] > $price['VALUE']){
                        $arElement['PRICES'][$price_title] =  $offer['PRICES'][$price_title];
                        //$arElement['CAN_BUY'] = $offer['CAN_BUY'];

                        $arElement['ADD_URL'] = $offer['ADD_URL'];

                        $arElement['SUBSCRIBE_URL'] = $offer['SUBSCRIBE_URL'];             
                        // }
                    }
                }
            }else{
                $arElement['PRICES'] =  $offer['PRICES'];
                $arElement['CAN_BUY'] = $offer['CAN_BUY'];
                $arElement['ADD_URL'] = $offer['ADD_URL'];
                $arElement['SUBSCRIBE_URL'] = $offer['SUBSCRIBE_URL'];
            }
            //print_r($offer);    
        }


        if(empty($CAN_BUY_OFFERS)){
            $arElement['CAN_BUY'] = 0; 
        }else{
            $_CAN_BUY = (in_array(1,$CAN_BUY_OFFERS) ? 1 : 0); //
            if($_CAN_BUY){
                $arElement['CAN_BUY'] = 1;    
            }
        }


        /* RESIZE*/
        if(! empty($arElement['PREVIEW_PICTURE']['SRC'])){
            $arParams['PICTURE_WIDTH'] = intval($arParams['PICTURE_WIDTH']);
            $arParams['PICTURE_HEIGHT'] = intval($arParams['PICTURE_HEIGHT']);
            $arParams['PICTURE_WIDTH'] = $arParams['PICTURE_WIDTH'] ? $arParams['PICTURE_WIDTH'] : 150;
            $arParams['PICTURE_HEIGHT'] = $arParams['PICTURE_HEIGHT'] ? $arParams['PICTURE_HEIGHT'] : 150;
            $rszImg = $ucResizeImg->GetResized(array(
                'INPUT_FILE' => $arElement['PREVIEW_PICTURE']['SRC'],
                'WIDTH' => $arParams['PICTURE_WIDTH'],
                'HEIGHT' => $arParams['PICTURE_HEIGHT'],
                'RESIZE_MODE' => 'CLASSIC',
                'RETURN_COMPLEX' => true,
            ));
            $arResult["ITEMS"][$key]['PREVIEW_PICTURE']['SRC'] = $rszImg['OUTPUT_FILE']; 
        }
        $arResult["ITEMS"][$key]["PRICES"] = $arElement['PRICES'];
        $arResult["ITEMS"][$key]["CAN_BUY"] = $arElement['CAN_BUY'];
        $arResult["ITEMS"][$key]["ADD_URL"] = $arElement['ADD_URL'];
        $arResult["ITEMS"][$key]["SUBSCRIBE_URL"] = $arElement['SUBSCRIBE_URL'];
        $index++;
    }

    $arSection = CIblockSection::GetById($arResult["ID"])->GetNext();
    $arResult['SECTION_PAGE_URL'] = $arSection['SECTION_PAGE_URL'];
    $cp = $this->__component;
    if (is_object($cp))
        $cp->SetResultCacheKeys(array('SECTION_PAGE_URL'));

?>