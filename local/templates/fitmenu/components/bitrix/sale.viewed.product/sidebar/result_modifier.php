<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
foreach($arResult as $key => $val)
{
	$img = "";
	if ($val["DETAIL_PICTURE"] > 0)
		$img = $val["DETAIL_PICTURE"];
	elseif ($val["PREVIEW_PICTURE"] > 0)
		$img = $val["PREVIEW_PICTURE"];

	$file = CFile::ResizeImageGet($img, array('width'=>$arParams["VIEWED_IMG_WIDTH"], 'height'=>$arParams["VIEWED_IMG_HEIGHT"]), BX_RESIZE_IMAGE_PROPORTIONAL, true);

	$val["PICTURE"] = $file;
    
    if($val["OFFERS"]){
         if($val["CATALOG_QUANTITY"] >= 0){
             $val["CAN_BUY"] = "Y";
         }else{
             $val["CAN_BUY"] = "";
         }
    }else{
        $val["CAN_BUY"] = "";
    }
	$arResult[$key] = $val;
}


      /*  
    */

?>