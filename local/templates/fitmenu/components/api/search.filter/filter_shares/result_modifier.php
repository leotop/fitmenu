<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>
<?//arshow($arResult);

    $arSelect = Array("ID", "IBLOCK_ID", "NAME","PROPERTY_CML2_MANUFACTURER","PROPERTY_stock");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array("IBLOCK_ID"=> 23);                                              //выводим элементы каталога
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($arFields = $res->Fetch()){ 
        if($arFields["PROPERTY_STOCK_VALUE"] == "Да"){            //если товар входит в свойство акции STOCK
             $new_array = array(); 
            ?>
            <?foreach($arResult["arrProp"][192]["VALUE_LIST"] as $pid=>$arProperty):?> 
            <?if($arFields["PROPERTY_CML2_MANUFACTURER_VALUE"] == $pid){
                $id_element[$pid] = $arProperty;                         // переформировываем свойство производителей(CML2_MANUFACTURER) для фильтрации в разделе Акции
            }      
            ?>  
            <?endforeach;  
        }   
    }          //   Пересобираем select производителей
            $input = '<select name="arrFilter_pf[CML2_MANUFACTURER]" class="chosen-select chosen-select-deselect" data-placeholder="Производитель" style="width:220px;">';                        
                    $input .= '<option value="">Все</option>';
               foreach($id_element as $id=>$name){
                    $input .= '<option value="'.$id.'">'.$name.'</option>';
               }                
            $input .= '</select>';
              //   Пересобираем select производителей
?>
   
<?     
    $arResult['ITEMS']["PROPERTY_192"]["INPUT"] = $input;    // записываем новый select в массив $arResult
?>