<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
    $name_order = $_POST["name"];
    $phone_order = $_POST["phone"];
	//$name_element = $_POST["nameElement"];
    $id_order =  $_POST["id_order"];
    
    /*$id_order = $_POST["id_order"];
		$nameElementCategory = $_POST["name_element"];
 
    echo $_POST["name"]." ";  
    If ($name_order && $phone_order) {
        $data=array("NAME"=>$name_order, "PHONE"=>$phone_order, "APPLICATION_ID"=>$id_order);
        $el = new CIBlockElement;
        $arLoadProductArray = Array(
        //    "MODIFIED_BY"    => $USER->GetID(), 
            "IBLOCK_SECTION_ID" => false,          
            "IBLOCK_ID"      => $block["ID"],
            "PROPERTY_VALUES" => $data,
            "NAME"           => $name_order,            

        ); 
      //  arshow($arLoadProductArray);
        $PRODUCT_ID = $el->Add($arLoadProductArray);    
    };  */

    $Element=CIBlockElement::GetList(array(), array("IBLOCK_ID"=>23, "ID" => $id_order), false, Array(), Array("NAME"))->Fetch();
    $name_element = $Element["NAME"];
    
    $date = date("m.d.y H:i:s");
    $arFields=array("NAME"=>$name_order,"PHONE"=>$phone_order,"EMAIL"=>$email_order,"COMMENT"=>$coment_order,"NAME_ELEMENT"=>$name_element, "ID" => $PRODUCT_ID, "DATA" => $date);
    
    CEvent::Send(
     "APPLICATION_ORDER",
     "s1",
     $arFields,
     "N",
     45
    ); 
?>