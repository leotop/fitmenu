<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$ucResizeImg = new C_ucResizeImg();
$ucResizeImg->SetDefParams(array(
        'KEEP_SIZE' => true,
        'FILL_COLOR' => array('R'=>255,'G'=>255,'B'=>255), # Красный цвет
    ));
     

foreach($arResult["ITEMS"] as $key => $arElement){
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
}
     
     ?>