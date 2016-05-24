var oneClickEvent;
$(function(){$('body').on('click','.slad_empty, .slad_empty_stock, .vopros_one_click p > a',function(e){$('.order_one_click').show('slow');$(this).find('input').attr('name','id_order');})
$('body').on('click','.close_order_form',function(){$('.order_one_click, .vopros_one_click').hide('slow');$('.slad_empty, .slad_empty_stock').find('input').attr('name','');})
$('body').on('click','.vopros, .vopros_2',function(){$('.vopros_one_click').show('slow');$(this).find('input').attr('name','id_order');})
$("body").on("click",".one-click-buy span",function(event){oneClickEvent=event.target;$(".popup-oneClick").show();$("body, html").addClass("no-scroll");})
$(".close-trigger").on("click",function(){$(".popup-oneClick").hide();$("body, html").removeClass("no-scroll");})});

$(function(){
    $('body').on('hover','.panel_delivery li ',function(){
        $(this).find('.delivery_text').toggle();
        return false;
    })

$('.buy a').click(function(){
    $('.alert_buy').show('slow');
    $('.fon_buy').show('slow');
});
$('.bay_basket').click(function(){
    $('.alert_buy').hide('slow');
    $('.fon_buy').hide('slow');
});
});

$(function(){
    $('body').on('change','.offers-select',function(){
        var el=$(this).val();
        $('.shk-item .offer').hide();
        $('#_offer_'+el).show();
    });
});

$(function(){
    fxSlider('fxslide','bx_slide_left','bx_slide_right',false,200,3);
})

$(function(){
    $('.hide-cart-trigger').click(function(){
        console.log($(this).attr('data-id'));
        $('#id_order').val($(this).attr('data-id'));
    });
})

function sendData(){
    var name_order=$("#name_order").val();
    if(name_order==''){
        $("#name_order").css('border','1px solid red')
    }else{
        $("#name_order").css('border','none')
    }
    var phone_order=$("#phone_order").val();
    if(phone_order==''){
        $("#phone_order").css('border','1px solid red')
    }else{
        $("#phone_order").css('border','none')
    }
    if(name_order&&phone_order){
        var msg=$('#order_one_click_new').serialize();
        $.ajax({type:'POST',
        url:'/ajax/order_form.php',
        data:msg,
        success:function(data){
            $('.slad_empty, .slad_empty_stock').find('input').attr('name','');
            $("#order_one_click_new").css("display","none");
            $(".form_alert").css("display","block");
            $(".form_alert").html("Ваша заявка принята!");
        },
        error:function(xhr,str){
            $(".form_alert").html("Заполните все поля!");
            $(".form_alert").css("color","red");
            $(".form_alert").css("display","block");
        }
        });
        setTimeout(function(){
            $(".order_one_click").hide("slow"),
            $(".form_alert").hide("slow"),
            $("#order_one_click").css("display","block")},4000);
    }
}
$('#order_one_click-1').on('submit',sendData_2);function sendData_2(event){event.preventDefault();var eventTarget=event.target,name_order=$(eventTarget).find("#name_order").val(),nameElement=$(eventTarget).closest(".slad_empty_stock").find("input").val();if(name_order==''){$("#name_order").css('border','1px solid red')}else{$("#name_order").css('border','none')}var phone_order=$("#order_one_click-1").find("#phone_order").val();if(phone_order==''){$("#phone_order").css('border','1px solid red')}else{$("#phone_order").css('border','none')};if(name_order&&phone_order){var msg=$('#order_one_click-1').serialize();$.ajax({type:'POST',url:'/ajax/order_form_on_click.php',data:msg,success:function(data){console.log(data);$('.slad_empty, .slad_empty_stock').find('input').attr('name','');$("#order_one_click-1").css("display","none");$("#order_one_click").css("display","none");$(".form_alert").css("display","block");$(".form_alert").html("Ваша заявка принята!");},error:function(xhr,str){$(".form_alert").html("Заполните все поля!");$(".form_alert").css("color","red");$(".form_alert").css("display","block");}});setTimeout(function(){$(".order_one_click").hide("slow"),$(".form_alert").hide("slow"),$("#order_one_click").css("display","block")},4000);}}function ajaxSlider(url){$('.bx_item_container').load(url+' .bx_item_container > *');};$('.one-click-buy span').click(function(){$('#one_click_id').val($(this).attr('data-id'));})
function sendOneClick(){var name_order=$("#newOneClick").find("#name").val(),phone_order=$("#newOneClick").find("#phone").val(),eventTarget=$(oneClickEvent),nameElement=eventTarget.closest(".one-click-buy").find(".nameElement").text();if(name_order&&phone_order){var msg=$('#newOneClick').serialize()+"&nameElement="+nameElement;$.ajax({type:'POST',url:'/ajax/newOneClick.php',data:msg,}).done(function(data){$(".popup-oneClick").hide();$("#newOneClick input").val("");$(".popup-answer-wrapper").show();setTimeout(function(){$(".popup-answer-wrapper").hide();$("body, html").removeClass("no-scroll");},2000);}).fail(function(){$(".popup-oneClick").hide();$(".popup-answer-wrapper").show();$(".popup-answer-wrapper").html("<h4>И тут что-то пошло не так :(</h4>");$("#newOneClick input").val("");setTimeout(function(){$(".popup-answer-wrapper").hide();$("body, html").removeClass("no-scroll");},3000);})}}