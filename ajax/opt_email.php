<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

CModule::IncludeModule("iblock");
$email = $_POST["emailOpt"];

$IBLOCK_ID = 23;
$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID,));
while($enum_fields = $property_enums->GetNext())
{     // ������ ������� �� ������� �����
  foreach($_POST["arrFilter_pf"] as $code=>$id_property ){
    // ���������� �������� ������� � �����������
    if($enum_fields["ID"] == $id_property[0]){
      $property_stock[$code] = $enum_fields["VALUE"];
    }
  }
}

$block_id = CIBlock::GetList(array(), array("ID" => 67))->Fetch();

If ($email) {
  $data = ['EMAIL' => $email];
  $el = new CIBlockElement;
  $arLoadProductArray = Array(
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID"      => 67,
    "PROPERTY_VALUES" => $data,
    "NAME"           => $email,
  );
  $PRODUCT_ID = $el->Add($arLoadProductArray);
};

//$date = date("m.d.y H:i:s");
$arFields = array("EMAIL"=>$email);

CEvent::Send(
  "SUBSCRIBE_EMAIL",
  "s1",
  $arFields,
  "N",
  55
);