<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?> 
<?

    if($_POST["id"]){  
        $dbLocs = CSaleLocation::GetLocationZIP($_POST["id"]);
        $arLocs = $dbLocs->Fetch();
        echo $arLocs["ZIP"];
    } 
?>