<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$ucResizeImg = new C_ucResizeImg();
$ucResizeImg->SetDefParams(array(
        'KEEP_SIZE' => true,
        'FILL_COLOR' => array('R'=>255,'G'=>255,'B'=>255), 
    ));

if(! function_exists('gray_scale_img')){
function gray_scale_img($source = NULL,$reinstall = false){
    if(! $source){
        return false;
    }
    if($source{0} == '/'){
        $source = substr($source, 1);
    }
    $_source = $_SERVER['DOCUMENT_ROOT'].$source;
    $pathinfo = pathinfo($source);
    $_ext = $pathinfo['extension'];
    $ext = strtolower($_ext);
    $name_path = str_replace('.'.$_ext, '', $source);
    $gray_path = $name_path.'_gray.'.$ext;
    $_gray_path = $_SERVER['DOCUMENT_ROOT'].$gray_path;
    $error = 0;
    switch($ext){
        case 'jpg':
            $im = imagecreatefromjpeg($_source);
            if ($im && imagefilter($im, IMG_FILTER_GRAYSCALE)) {
                if(! file_exists($_gray_path) AND ! $reinstall){
                     $img =  imagejpeg($im, $_gray_path, 100);
                }
            } else {
                $error = 1;
            }
        break;
        
        case 'png':
            $im = imagecreatefrompng($_source);
            if ($im && imagefilter($im, IMG_FILTER_GRAYSCALE)) {
                if(! file_exists($_gray_path) AND ! $reinstall){
                    $img =  imagepng($im, $_gray_path, 100);
              }
            } else {
                $error = 1;
            }
        break;
        
        default:
        
        break;
                
    }
    if(!$error){
        return $gray_path;    
    }
    return FALSE;
}
}

$arParams1 = array(
	"MAX_VOTE" => intval($arParams["MAX_VOTE"])<=0? 5: intval($arParams["MAX_VOTE"]),
	"VOTE_NAMES" => is_array($arParams["VOTE_NAMES"])? $arParams["VOTE_NAMES"]: array(),
	"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"]);
$arResult["VOTE_NAMES"] = array();
foreach($arParams1["VOTE_NAMES"] as $k=>$v)
{
	if(strlen($v)>0)
		$arResult["VOTE_NAMES"][]=htmlspecialcharsbx($v);
	if(count($arResult["VOTE_NAMES"])>=$arParams1["MAX_VOTE"])
		break;
}
foreach ($arResult["ELEMENTS_LIST"] as $key => $arItem){
   $gray = gray_scale_img($arItem["PREVIEW_PICTURE"]["SRC"]);
  $arItem["PREVIEW_PICTURE"]["GRAY_SRC"] = $arItem["PREVIEW_PICTURE"]["SRC"];
  if(! empty($gray)){
    $arItem["PREVIEW_PICTURE"]["GRAY_SRC"] = $gray;  
  }
  
  $arResult["ELEMENTS_LIST"][$key]  = $arItem;
}
 
?>