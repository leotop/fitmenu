<? 
$ucResizeImg = new C_ucResizeImg();
$ucResizeImg->SetDefParams(array(
        'KEEP_SIZE' => true,
        'FILL_COLOR' => array('R'=>255,'G'=>255,'B'=>255), # Красный цвет
    ));
foreach ($arResult["GRID"]["ROWS"] as $k => $arItem){
    /* RESIZE*/
    
    $arParams['PICTURE_WIDTH'] = intval($arParams['PICTURE_WIDTH']);
    $arParams['PICTURE_HEIGHT'] = intval($arParams['PICTURE_HEIGHT']);
    $arParams['PICTURE_WIDTH'] = $arParams['PICTURE_WIDTH'] ? $arParams['PICTURE_WIDTH'] : 80;
    $arParams['PICTURE_HEIGHT'] = $arParams['PICTURE_HEIGHT'] ? $arParams['PICTURE_HEIGHT'] : 80;
    if(! empty($arItem['PREVIEW_PICTURE_SRC'])){
    /*$renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array(
       "width" => $arParams['PICTURE_WIDTH'],  // новая ширина
       "height" => $arParams['PICTURE_HEIGHT'] // новая высота
      ),
      BX_RESIZE_IMAGE_EXACT // метод масштабирования. обрезать прямоугольник без учета пропорций
      );
     */ 
    $rszImg = $ucResizeImg->GetResized(array(
        'INPUT_FILE' => $arItem['PREVIEW_PICTURE_SRC'],
        'WIDTH' => $arParams['PICTURE_WIDTH'],
        'HEIGHT' => $arParams['PICTURE_HEIGHT'],
        'RESIZE_MODE' => 'CLASSIC',
        'RETURN_COMPLEX' => true,
    ));
    $arItem['PREVIEW_PICTURE_SRC'] = $rszImg['OUTPUT_FILE'];
    
    
    }
    
    if(empty($arItem['DETAIL_PAGE_URL']) AND ! empty($arItem['PRODUCT_ID'])){
        $product = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
        if(! empty($product)){
            $rsProduct = CIBlockElement::GetByID($product['ID']);
            $product = $rsProduct->GetNext();
            if(! empty($product)){
                $arItem['DETAIL_PAGE_URL'] = $product['DETAIL_PAGE_URL'];
                //$arResult["GRID"]["ROWS"][$k] = $arItem;
            }
        }
    }
    $arResult["GRID"]["ROWS"][$k] = $arItem;
}
?>