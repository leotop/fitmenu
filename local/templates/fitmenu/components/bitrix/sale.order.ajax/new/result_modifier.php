<?
$ucResizeImg = new C_ucResizeImg();
$ucResizeImg->SetDefParams(array(
        'KEEP_SIZE' => true,
        'FILL_COLOR' => array('R'=>255,'G'=>255,'B'=>255), # Красный цвет
    ));
    
$arResult['FULL_DISCOUNT'] = 0;
foreach ($arResult["GRID"]["ROWS"] as $k => $arData){
    $arParams['PICTURE_WIDTH'] = intval($arParams['PICTURE_WIDTH']);
    $arParams['PICTURE_HEIGHT'] = intval($arParams['PICTURE_HEIGHT']);
    $arParams['PICTURE_WIDTH'] = $arParams['PICTURE_WIDTH'] ? $arParams['PICTURE_WIDTH'] : 80;
    
    $arParams['PICTURE_HEIGHT'] = $arParams['PICTURE_HEIGHT'] ? $arParams['PICTURE_HEIGHT'] : 80;
    if (strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0){
        $url = $arData["data"]["PREVIEW_PICTURE_SRC"];
    }
    elseif (strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0){
        $url = $arData["data"]["DETAIL_PICTURE_SRC"];
    }
    else{
        $url = $templateFolder."/images/no_photo.png";
    }
    if(! empty($url)){
        $rszImg = $ucResizeImg->GetResized(array(
            'INPUT_FILE' => $url,
            'WIDTH' => $arParams['PICTURE_WIDTH'],
            'HEIGHT' => $arParams['PICTURE_HEIGHT'],
            'RESIZE_MODE' => 'CLASSIC',
            'RETURN_COMPLEX' => true,
        ));
        $arData["data"]["PREVIEW_PICTURE_SRC"] = $rszImg['OUTPUT_FILE'];
        $arResult["GRID"]["ROWS"][$k] = $arData;
    }
    else{
        echo 'NOIMG';
    }
}
 ?>