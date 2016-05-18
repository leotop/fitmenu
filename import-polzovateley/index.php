<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Импорт пользователей");
?>

<?
$filter = Array
(
    ">ID"                  => 350,
);

$send = FALSE;

//37
$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter); // выбираем пользователей
while($arUser = $rsUsers->Fetch()){
    if( $send){
        print_r($arUser['ID']. '= '.$arUser['EMAIL'].' = '.$arUser['NAME'].' = '.$arUser['LAST_NAME']);
        echo "<br />";
        
        $USER = new CUser;
        $arResult = $USER->SendPassword($arUser['LOGIN'], $arUser['EMAIL']);
        if($arResult["TYPE"] == "OK"){
          echo "Контрольная строка для смены пароля выслана. на ".$arUser['EMAIL'];  
        } 
        else{
            echo "Введенные логин ".$arUser['LOGIN']." (email) не найдены.<br />";    
        } 
        
    }
}

if(! $send){
    echo 'Задайте значение $send = 1  для рассылки новых паролей';
}

 ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>