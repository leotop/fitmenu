<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
    
    CModule::IncludeModule("iblock");
    $name = $_POST["fName"];
    $phone = $_POST["fPhone"];
    $email = $_POST["fEmail"];
    
    
    $IBLOCK_ID = 23;
    $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID,));
    while($enum_fields = $property_enums->GetNext())
    {     // Делаем выборку из свойств формы
        foreach($_POST["arrFilter_pf"] as $code=>$id_property ){
            // записываем название свойств в пересменную
            if($enum_fields["ID"] == $id_property[0]){  
                  $property_stock[$code] = $enum_fields["VALUE"]; 
            }
        }
    }
    $block_id = CIBlock::GetList(array(), array("ID" => 62))->Fetch();
                      
    If ($name && $phone && $email) {
        $data=array("NAME"=>$name, "PHONE"=>$phone, "EMAIL"=>$email, "SEX"=>$property_stock["sex"],"MISSION"=>$property_stock["mission"], "INDICATOR" => $property_stock["indicator"], "SPORTS" => $property_stock["sports"]);
        $el = new CIBlockElement;
        $arLoadProductArray = Array(
        //    "MODIFIED_BY"    => $USER->GetID(), 
            "IBLOCK_SECTION_ID" => false,          
            "IBLOCK_ID"      => 62,
            "PROPERTY_VALUES" => $data,
            "NAME"           => $name,            

        ); 
        $PRODUCT_ID = $el->Add($arLoadProductArray);    
    };
      
    //$date = date("m.d.y H:i:s");
    $arFields=array("NAME"=>$name,"PHONE"=>$phone,"EMAIL"=>$email,"SEX"=>$property_stock["sex"],"MISSION"=>$property_stock["mission"], "INDICATOR" => $property_stock["indicator"], "SPORTS" => $property_stock["sports"]);

    CEvent::Send(
     "INDIVIDUAL_COMPLEX",
     "s1",
     $arFields,
     "N",
     46
    );  
?>