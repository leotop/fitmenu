<? $page_counter = array(12, 24, 36);$arResult['pages_counter'] = array();$arResult['current_page_counter'] = $arResult['NavPageSize'];$prev = 0;foreach($page_counter as $c){    if($c < $arResult['NavRecordCount']){        $arResult['pages_counter'][] = $c;            }    if($prev < $arResult['NavRecordCount'] AND $c > $arResult['NavRecordCount']){        $arResult['pages_counter'][] = $c;    }    $prev = $c; }if(empty($arResult['pages_counter'])){    $arResult['pages_counter'][] = $page_counter[0];}?>