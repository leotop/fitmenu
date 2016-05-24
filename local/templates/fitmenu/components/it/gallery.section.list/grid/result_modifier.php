<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arViewModeList = array('LIST', 'LINE', 'TEXT', 'TILE');

$arDefaultParams = array(
	'VIEW_MODE' => 'LIST',
	'SHOW_PARENT_NAME' => 'Y',
	'HIDE_SECTION_NAME' => 'N'
);

$arParams = array_merge($arDefaultParams, $arParams);

if (!in_array($arParams['VIEW_MODE'], $arViewModeList))
	$arParams['VIEW_MODE'] = 'LIST';
if ('N' != $arParams['SHOW_PARENT_NAME'])
	$arParams['SHOW_PARENT_NAME'] = 'Y';
if ('Y' != $arParams['HIDE_SECTION_NAME'])
	$arParams['HIDE_SECTION_NAME'] = 'N';

$arResult['VIEW_MODE_LIST'] = $arViewModeList;

if (0 < $arResult['SECTIONS_COUNT'])
{
	if ('LIST' != $arParams['VIEW_MODE'])
	{
		$boolClear = false;
		$arNewSections = array();
		foreach ($arResult['SECTIONS'] as &$arOneSection)
		{
			if (1 < $arOneSection['RELATIVE_DEPTH_LEVEL'])
			{
				$boolClear = true;
				continue;
			}
			$arNewSections[] = $arOneSection;
		}
		unset($arOneSection);
		if ($boolClear)
		{
			$arResult['SECTIONS'] = $arNewSections;
			$arResult['SECTIONS_COUNT'] = count($arNewSections);
		}
		unset($arNewSections);
	}
}

if (0 < $arResult['SECTIONS_COUNT'])
{
    $boolPicture = false;
	$boolDescr = false;
	$arSelect = array('ID');
	$arMap = array();
	if ('LINE' == $arParams['VIEW_MODE'] || 'TILE' == $arParams['VIEW_MODE'])
	{
        reset($arResult['SECTIONS']);
		$arCurrent = current($arResult['SECTIONS']);
		if (!isset($arCurrent['PICTURE']))
		{
            $boolPicture = true;
			$arSelect[] = 'PICTURE';
		}
		if ('LINE' == $arParams['VIEW_MODE'] && !array_key_exists('DESCRIPTION', $arCurrent))
		{
			$boolDescr = true;
			$arSelect[] = 'DESCRIPTION';
			$arSelect[] = 'DESCRIPTION_TYPE';
		}
	}
	if ($boolPicture || $boolDescr)
	{
        foreach ($arResult['SECTIONS'] as $key => $arSection)
		{
			$arMap[$arSection['ID']] = $key;
		}
		$rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
		while ($arSection = $rsSections->GetNext())
		{
            if (!isset($arMap[$arSection['ID']]))
				continue;
			$key = $arMap[$arSection['ID']];
			if ($boolPicture)
			{
				$arSection['PICTURE'] = intval($arSection['PICTURE']);
				$arSection['PICTURE'] = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);
				$arResult['SECTIONS'][$key]['PICTURE'] = $arSection['PICTURE'];
				$arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
			}
			if ($boolDescr)
			{
				$arResult['SECTIONS'][$key]['DESCRIPTION'] = $arSection['DESCRIPTION'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION'] = $arSection['~DESCRIPTION'];
				$arResult['SECTIONS'][$key]['DESCRIPTION_TYPE'] = $arSection['DESCRIPTION_TYPE'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
			}
		}
	}
    
    $ucResizeImg = new C_ucResizeImg();
    $ucResizeImg->SetDefParams(array(
            'KEEP_SIZE' => true,
            'FILL_COLOR' => array('R'=>255,'G'=>255,'B'=>255), # Красный цвет
        ));
     $arParams['PICTURE_WIDTH'] = intval($arParams['PICTURE_WIDTH']);
        $arParams['PICTURE_HEIGHT'] = intval($arParams['PICTURE_HEIGHT']);
        $arParams['PICTURE_WIDTH'] = $arParams['PICTURE_WIDTH'] ? $arParams['PICTURE_WIDTH'] : 150;
        $arParams['PICTURE_HEIGHT'] = $arParams['PICTURE_HEIGHT'] ? $arParams['PICTURE_HEIGHT'] : 150;    
    
    if($arParams['SHOW_GALLERY_SECTIONS'] == 'Y'){
        // будет отображаться 
        foreach($arResult['SECTIONS'] as $key => $arSection){
            
            
            
            $images = array();
            if($arSection['ELEMENT_CNT'] > 0){
                $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PICTURE","PREVIEW_PICTURE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
                $arFilter = Array("IBLOCK_ID"=>$arSection['IBLOCK_ID'], 'SECTION_ID' => $arSection['ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
                
                while($ob = $res->GetNextElement()){ 
                    $arFields = $ob->GetFields();  
                    $_images = array('NAME' => $arFields['NAME']);
                    if(! empty($arFields['PREVIEW_PICTURE'])){
                        $_images['PREVIEW_PICTURE'] = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
                    }
                    if(! empty($arFields['DETAIL_PICTURE'])){
                        $_images['DETAIL_PICTURE'] = CFile::GetFileArray($arFields['DETAIL_PICTURE']);
                    } 
                    $images[]  = $_images;     
                }
            }
            /**
            * Resize
            */
            //if(! empty($arSection['PICTURE'])){
            if(! empty($images)){
                $cover = $images[0]; 
                $rszImg = $ucResizeImg->GetResized(array(
                    'INPUT_FILE' => $cover['DETAIL_PICTURE']['SRC'],
                    'WIDTH' => $arParams['PICTURE_WIDTH'],
                    'HEIGHT' => $arParams['PICTURE_HEIGHT'],
                    'RESIZE_MODE' => 'CLASSIC',
                    'RETURN_COMPLEX' => true,
                ));
                $arResult["SECTIONS"][$key]['DETAIL_PICTURE'] = $cover['DETAIL_PICTURE'];
                $arResult["SECTIONS"][$key]['PICTURE']['SRC'] = $rszImg['OUTPUT_FILE'];
                unset($images[0]);
            }
            $arResult['SECTIONS'][$key]['IMAGES_SECTION'] = $images;
        }        
    }
    
    
    
     

foreach($arResult["ITEMS"] as $key => $arElement){
    /* RESIZE*/
    if(! empty($arElement['PREVIEW_PICTURE']['SRC'])){
        $arParams['PICTURE_WIDTH'] = intval($arParams['PICTURE_WIDTH']);
        $arParams['PICTURE_HEIGHT'] = intval($arParams['PICTURE_HEIGHT']);
        $arParams['PICTURE_WIDTH'] = $arParams['PICTURE_WIDTH'] ? $arParams['PICTURE_WIDTH'] : 150;
        $arParams['PICTURE_HEIGHT'] = $arParams['PICTURE_HEIGHT'] ? $arParams['PICTURE_HEIGHT'] : 150;
          
    }
}
     
    
}
?>