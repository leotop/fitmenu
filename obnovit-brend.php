<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обновить бренд");
?> 
<?
if (CModule::IncludeModule("catalog")){}

$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID" => 23, 'PROPERTY_CML2_MANUFACTURER' => false,);
$rs = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
echo $rs->SelectedRowsCount();
$i = 0;
$arIds = array();
while($arProduct = $rs->Fetch())
{
    $arIds[] = $arProduct['ID'];
}
$arBrend = array();
$arSelect = Array("ID", "NAME","PROPERTY_CML2_LINK", "PROPERTY_CML2_ATTRIBUTES");
$arFilter = Array("IBLOCK_ID" => 24, "NAME"=> $arNames,'PROPERTY_CML2_LINK' => $arIds,);
$rs = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($aroffer = $rs->Fetch())
{
    
    print_r($aroffer);
    if(empty($arBrend[$aroffer['PROPERTY_CML2_LINK_VALUE']])){
       $brend = NULL;
       $product_id = $aroffer['PROPERTY_CML2_LINK_VALUE'];
       if(! empty($aroffer['PROPERTY_CML2_ATTRIBUTES_VALUE'])){
            if(is_array($aroffer['PROPERTY_CML2_ATTRIBUTES_VALUE'])){
                foreach($aroffer['PROPERTY_CML2_ATTRIBUTES_VALUE'] as $k_id => $character){
                    if($character['DESCRIPTION'] == 'Бренд'){
                                $brend = $character['VALUE']; 
                            
                        }
                    }    
            }else{
                $brend = $aroffer['PROPERTY_CML2_ATTRIBUTES_VALUE'];
            }
            
       }
       if(! empty($brend)){
          
            $brend_id = MyIblock::add_brend($brend);
            if($brend_id){
                $arFields['PROPERTY_VALUES'][$brend_prop_id]['n0'] = array('VALUE' => $brend_id);
                CIBlockElement::SetPropertyValueCode($product_id, "CML2_MANUFACTURER",$brend_id);
            }
                        
       }
       $arBrend[$aroffer['PROPERTY_CML2_LINK_VALUE']] =  $brend_id;   
    }
    
    //CIBlockElement::SetPropertyValueCode($brend_id, "URL", $Manufactur['URL']);
}   
 ?>

 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>