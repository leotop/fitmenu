<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    if(!empty($_REQUEST[mailE])){
        $filter = Array
        (
            "EMAIL"               => $_REQUEST[mailE],
        );
        $rsUsers = CUser::GetList(($by="EMAIL"), ($order="desc"), $filter); 

        while($arUser = $rsUsers->Fetch()):
            if($flag != 1){
                $isReg=true;
            }

            endwhile;
        if ($isReg==true) {
            echo "<a href='http://fitmenu.ru/personal/profile/'>Войти в Личный кабинет<a/>";
        }

    }
?>