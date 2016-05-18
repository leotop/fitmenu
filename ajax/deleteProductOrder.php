<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?> 
<?

    if($_POST["delDataId"] && $_POST["action"] == "delete"){  
        CSaleBasket::Delete($_POST["delDataId"]);
    } 
    echo 123;
?>