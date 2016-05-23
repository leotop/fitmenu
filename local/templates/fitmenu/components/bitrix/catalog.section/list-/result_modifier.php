<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//Make all properties present in order
//to prevent html table corruption
$current_brend = null; $index = 0;
foreach($arResult["ITEMS"] as $key => $arElement)
{
	$arRes = array();
	foreach($arParams["PROPERTY_CODE"] as $pid)
	{
		$arRes[$pid] = CIBlockFormatProperties::GetDisplayValue($arElement, $arElement["PROPERTIES"][$pid], "catalog_out");
	}
	$arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"] = $arRes;
    
    $brend = ! empty($arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['VALUE']) ? $arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['VALUE'] : NULL;
    if($index == 0 AND $brend){
        $arResult["ITEMS"][$key]["BREND"] = array('ID' => $brend, 'SHOW' => 1, 'VIEW' => $arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['DISPLAY_VALUE']);
        $current_brend = $brend; 
    }
    if($index > 0 AND $current_brend !== $brend AND $brend){
        $arResult["ITEMS"][$key]["BREND"] = array('ID' => $brend, 'SHOW' => 1, 'VIEW' => $arElement['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['DISPLAY_VALUE']);
        $current_brend = $brend; 
    }
    
     
    foreach($arElement['OFFERS'] as $offer){
        if(! empty($arElement['PRICES'])){
            foreach($arElement['PRICES'] as $price_title => $price){
                if(! empty($offer['PRICES'][$price_title])){
                    if($offer['PRICES'][$price_title]['VALUE'] < $price['VALUE']){
                        $arElement['PRICES'][$price_title] =  $offer['PRICES'][$price_title];
                        $arElement['CAN_BUY'] = $offer['CAN_BUY'];
                        $arElement['ADD_URL'] = $offer['ADD_URL'];
                        $arElement['SUBSCRIBE_URL'] = $offer['SUBSCRIBE_URL'];             
                    }
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
    $arResult["ITEMS"][$key]["PRICES"] = $arElement['PRICES'];
    $arResult["ITEMS"][$key]["CAN_BUY"] = $arElement['CAN_BUY'];
    $arResult["ITEMS"][$key]["ADD_URL"] = $arElement['ADD_URL'];
    $arResult["ITEMS"][$key]["SUBSCRIBE_URL"] = $arElement['SUBSCRIBE_URL'];
    $index++;
}
?>