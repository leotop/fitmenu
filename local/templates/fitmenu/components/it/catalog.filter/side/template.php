<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global CDatabase $DB */
    /** @var CBitrixComponentTemplate $this */
    /** @var string $templateName */
    /** @var string $templateFile */
    /** @var string $templateFolder */
    /** @var string $componentPath */
    /** @var CBitrixComponent $component */
    $this->setFrameMode(true);
?>
<div class="side_filter">
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" id="arrFilter_form_right" action="<?// echo '/filter/'//$arResult["FORM_ACTION"]?>" method="post">
        <?foreach($arResult["ITEMS"] as $arItem):
            if(array_key_exists("HIDDEN", $arItem)):
                echo $arItem["INPUT"];
                endif;
            endforeach;?>

        <div class="side-full-filter">
            <div class="side_filter__title">
                <p>Подбор спортпита - БЕСПЛАТНО!</p>
                <p>Просто заполни эту форму!</p>
            </div>
            <div class="versions">
                <? $i_index = 1; ?>
                <?foreach($arResult["ITEMS"] as $prop => $arItem):?>
                    <?if(!array_key_exists("HIDDEN", $arItem)):?>
                        <? $prop_id = str_replace('PROPERTY_','',$prop); $prop_id = intval($prop_id);
                            $property = ! empty($arResult['arrProp'][$prop_id]) ? $arResult['arrProp'][$prop_id] : array();
                            $class = ! empty($property['CODE']) ? $property['CODE'] : NULL;
                        ?>
                        <div class="version <?= $class ?>">
                            <div class="h"><span><?= $i_index ?>.</span><?=$arItem["NAME"]?></div>
                            <div class="values">
                                <?=$arItem["INPUT"]?>
                            </div>
                        </div>
                        <? $i_index++; ?>
                        <?endif?>
                    <?endforeach;?>
            </div>
            <div class="last">
                <div class="button form_class">Выбрать</div>
                <!--            <button type="submit" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" class="button">Выбрать<? //=GetMessage("IBLOCK_SET_FILTER")?></button>
                -->            <input type="hidden" name="set_filter" value="Y" />  
                <!--<input type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" />-->
            </div>
        </div>   
        <div class="form_filter">
            <span class="close_form">X</span>
            <div>
                <div class="form_filter__title">Оставь свои контакты, и мы в ближайшее время свяжемся с тобой, чтобы разработать индивидуальный комплекс</div>
                <label>Имя</label><input type="text" class="fName" name="fName" value="" placeholder="обязательное поле">   
                <label>Тел.</label><input type="text" class="fPhone" name="fPhone"value="" placeholder="обязательное поле">  
                <label>E-mail</label><input type="email" class="fEmail" name="fEmail" value="" placeholder="обязательное поле"> 
                <span class="error_form">Заполните все поля</span>
                <a href="javascript:void(0)" class="submit_filter">Отправить</a>  
            </div>
            <span class="success_form"></span>
        </div> 
    </form>
</div>
