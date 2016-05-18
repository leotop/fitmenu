<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
    

    $block_id=CIBlock::GetList(array(), array("CODE"=>"APPLICATION"));
    $block = $block_id->Fetch();
    
    $name_order = $_POST["name_order"];
    $phone_order = $_POST["phone_order"];
    $email_order = $_POST["email_order"];
    $coment_order = $_POST["coment_order"];
    $id_order = $_POST["id_order"];
  
 
  //  echo $_POST["name"]." "; 
    If ($_POST["name_order"] && $_POST["phone_order"] && $_POST["email_order"]) {
        $data=array("NAME"=>$name_order, "PHONE"=>$phone_order, "EMAIL"=>$email_order, "COMMENT"=>$coment_order, "APPLICATION_ID"=>$id_order);
        $el = new CIBlockElement;
        $arLoadProductArray = Array(
        //    "MODIFIED_BY"    => $USER->GetID(), 
            "IBLOCK_SECTION_ID" => false,          
            "IBLOCK_ID"      => 60,
            "PROPERTY_VALUES" => $data,
            "NAME"           => $name_order,            

        ); 
        $PRODUCT_ID = $el->Add($arLoadProductArray);    
    };

    $Element=CIBlockElement::GetList(array(), array("IBLOCK_ID"=>23, "ID" => $id_order), false, Array(), Array("NAME"))->Fetch();
    $name_element = $Element["NAME"];
    $date = date("m.d.y H:i:s");
    $arFields=array("NAME"=>$name_order,"PHONE"=>$phone_order,"EMAIL"=>$email_order,"COMMENT"=>$coment_order,"NAME_ELEMENT"=>$name_element, "ID" => $PRODUCT_ID, "DATA" => $date);
    
    CEvent::Send(
     "APPLICATION_ORDER",
     "s1",
     $arFields,
     "N",
     44
    ); 
?>