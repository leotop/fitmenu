<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="grid-row">
    <div class="w50 grid-ceil">
        <?if($arResult["AUTH_SERVICES"]):?>
        	<div class="bx-auth-title"><h2><?echo GetMessage("AUTH_TITLE")?></h2></div>
        <?endif?>
	   <div class="bx-auth-note"><?=GetMessage("AUTH_PLEASE_AUTH")?></div>
        <?php if(! empty($arParams["~AUTH_RESULT"])) :  ?>
        <div class="it-asses">
        <?php elseif(! empty($arResult['ERROR_MESSAGE'])):  ?>
        <div class="it-error">
        <?php else : ?>
        <div>
        <?php endif ?>
        <?
        ShowMessage($arParams["~AUTH_RESULT"]);
        ShowMessage($arResult['ERROR_MESSAGE']);
        ?>
        </div>
	<form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
	
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>
        <div class="it-row">
		         <label for="login-id"><?=GetMessage("AUTH_LOGIN")?></label>
    		<div class="it-text">
                 <input class="bx-auth-input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" /></td>
			</div>
	    </div>
	    <div class="it-row">
		        <label for="password-id"><?=GetMessage("AUTH_PASSWORD")?></label>
				<div class="it-text">
                       <input class="bx-auth-input" type="password" name="USER_PASSWORD" maxlength="255" /></div>
         </div>
<?if($arResult["SECURE_AUTH"]):?>
          <div class="it-row">
				<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
          </div>      
<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = 'inline-block';
</script>
<?endif?>
			<?if($arResult["CAPTCHA_CODE"]):?>
				<div class="it-row">  
		             <label for="captcha-id"><?echo GetMessage("AUTH_CAPTCHA_PROMT")?></label>
                     <div class="security">
				        <div class="it-text">
                             <input class="bx-auth-input" type="text" name="captcha_word" maxlength="50" value="" size="15" />
                        </div>  
                     <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></td>
				</div>
			<?endif;?>
<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
				<div class="it-row">
           <label for="USER_REMEMBER_frm" class="it-checkbox inline">
                <input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /><?php echo GetMessage("AUTH_REMEMBER_SHORT")?>
           </label>
          </div>
<?endif?>
    <div class="it-row last">
                <div class="links">
                      <noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex>
               </div>
    	<button type="submit" name="Login" class="it-button" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>"><?=GetMessage("AUTH_LOGIN_BUTTON")?></button>
    </div>

	</form>
<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
		"AUTH_URL"=>$arResult["AUTH_URL"],
		"POST"=>$arResult["POST"],
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>
</div>
 <div class="w50 grid-ceil">
       <?$APPLICATION->IncludeComponent(
        	"bitrix:main.register",
        	"light",
        	Array(
        		"SHOW_FIELDS" => array("NAME"),
        		//"REQUIRED_FIELDS" => array("NAME"),
        		"AUTH" => "Y",
        		"USE_BACKURL" => "Y",
        		"SUCCESS_PAGE" => "/",
        		"SET_TITLE" => "Y",
        		"USER_PROPERTY" => array()
        	),
        false
        );?>
    </div>
</div>