$(document).ready(function(){
    
    $('.cart-open, .bay_basket').click(function() {
        /*$.ajax({
        url: "/basketajax.php",
        success:    function(data) {
                     $('.hiddencart').html(data);
                }
        });*/
           //$('.hiddencart').load('/basketajax.php');
        $('.hiddencart').fadeIn(500);
        return false;
    });
    
    $('.modal-cross').click(function() {
         $(this).parents('.modal').fadeOut(500);
    });
    
    
    initSlider();
    tabs();
    
    $('.rub').append('<b></b>');
    
    $('.btnmodal').bind('click', function(e){          
      $('body').append('<div id="modalbox"><span class="b-close"></span><div class="mcontent"></div></div>');
        
      e.preventDefault();
      var urlmodal = $(this).attr("href");
    
      $('#modalbox').bPopup({
          content:'ajax',
          contentContainer:'.mcontent',
          loadUrl: urlmodal,
          loadCallback: function(){
                            
          },
          onClose: function() {
              $(".mcontent").empty();
              $("#modalbox").remove();
          }
      });
    });
    
        var tab = $('.tab');
        $('body').on('click', '.nav a', function(){
            var link = $(this), _id = link.attr('id'), _pid = _id.split('_'), p = link.closest('.tab');
            _id = _pid[1];
            if(! link.hasClass('a')){
                $('.nav a', tab).removeClass('a');
                link.addClass('a');
            }
            var t_block = $('#tab_'+_id);
            if(! t_block.hasClass('a')){
                $('.wrapper .block', p).hide();
                t_block.show();
            }
            return !1;
        })
        
        tab.each(function(i, it){
            var hash = window.location.hash;
            hash = hash.replace('#','');
            var h = $('#nav_'+hash);
            if(h.length > 0){
                h.click();
            }
            else
            {
               var act = $(it).find('.nav .a');
               if(act.length > 0){
                    act.click();
               }else{
                   $(it).find('.nav A').eq(0).click();                
               }
             }
        })
        
        /*
        $('.priceCat .count').each(function(index, counter){
            var c = $(counter), input = c.find('input'), minus = c.find('.minus'), plus = c.find('.plus');
            minus.click(function(){
                var inp = $(this).closest('.count').find('input');
                var value = inp.val();
                value = +value;
                value = parseInt(value);
                if(value > 2){
                    value = value - 1;
                }else{
                    value = 1;
                }
                inp.val(value);
                return !1;
            })
            plus.click(function(){
                var inp = $(this).closest('.count').find('input');
                var value = inp.val();
                value = +value;
                value = parseInt(value);
                if(value > 0){
                    value = value + 1;
                }else{
                    value = 1;
                }
                inp.val(value);
                return !1;
            })
            input.change(function(){
                var value = $(this).val();
                value = +value;
                value = parseInt(value);
                if(value == 'NaN'){
                    value = 1;
                }
                if(value <= 0){
                    value = 1
                }
                $(this).val(value);
            })
            input.keyup(function(){
                var value = $(this).val();
                value = +value;
                value = parseInt(value);
                if(isNaN(value) == true){
                    value = 1;
                }
                if(value <= 0){
                    value = 1;
                }
                $(this).val(value);
            })
        });
        */
        
        $(window).scroll();
        /*
         $('.appears form').validate({
        rules: {
             email: {
                required: true,
                email: true
            },
        },
        messages: {
            email: "Выберите E-mail",
        }
    });
    
    $(".appears form").ajaxForm(function() {
        $('.appears').html("<p class='sussses'>Мы сообщим Вам о появлении товара</p>");
    });
    */
    var in_stock_filter = $('.in_stock_filter input:checked');
    
    if(in_stock_filter.hasClass('set')){
        $('.in_stock_filter A').text('Показать').addClass('active');
    }else{
        $('.in_stock_filter A').text('Скрыть').removeClass('active');
    } 
       
    $('.in_stock_filter A').click(function(){
        var link = $(this), block = link.closest('.in_stock_filter');//, checkbox = block.find('input'), check = false;
        var form = block.find('form');
        
        /*
        if(checkbox[0].checked){
           check = true; 
        }
        console.log(checkbox[0].checked);
        */
        if(link.hasClass('active')){
            link.removeClass('active');
            $('.reset',form).click();
            link.text('Показать');
        }
        else{
            link.addClass('active');
            link.text('Скрыть');
            $('.set',form).click();
        }

        /*
        if(! check){
          checkbox.attr('checked', 'checked');  
        }
        else{
            checkbox.attr('checked', '');
        }*/
        //checkbox.click();
        form.submit();
        return !1;
    });    
    
});

function initSlider() {
    var _slider = $('.slider');
    if(_slider.length != 0) {
        _slider.justSlider({
            effect: "slide",
            autoHeight: true,
            navigation: false
        });
    }
    
    var _slider2 = $('.slider-s');
    if(_slider2.length != 0) {
        _slider2.justSlider({
            effect: "slide",
            autoHeight: true,
            navigation: true,
            prevNext:false
        });
    }
}

function tabs(){
    $('.tabs-container').justTabs({
        nav: $('.tab-nav')
    });
}

$(function() { 
  $('#id_prop_33').click(function() {
      $('#f_prop_34 .icon').removeClass('filter__background-women');
      $('#f_prop_33 .icon').addClass('filter__background-men');
  });
});

$(function() { 
  $('#id_prop_34').click(function() {
      $('#f_prop_33 .icon').removeClass('filter__background-men');
      $('#f_prop_34 .icon').addClass('filter__background-women');
  });
});

$(function() {
  
  if (screen.width > 980 && !document.querySelector('#bx-panel')) {
    var menu = $(".main-menu");
    
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100 && !menu.hasClass("main-menu--fixed")) {
        menu.addClass("main-menu--fixed");
      } else if ($(this).scrollTop() <= 100 && menu.hasClass("main-menu--fixed")) {
        menu.removeClass("main-menu--fixed");
      }
    });
  } else {
    $('#footer').css({'margin-bottom': 0});
  }
  
});
					
$(function() {
	
	var textNums = $(".bx_small_cart").find(".t").text();
	var num = parseInt(textNums[textNums.length - 1]);
	var wrapperNum = $(".num-goods");
	
	if (isNaN(num)) {
		wrapperNum.hide();
	} else {
		wrapperNum.show();
		wrapperNum.text(num);
	}
	
});

$(function () {

  function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }


  function setPopup(popup, type) {
    if (getCookie('popup') === 'closed') return false;

    $.magnificPopup.open({
      preloader: true,

      items: {
        src: popup,
        type: type
      },

      callbacks: {
        close: function() {
          document.cookie = 'popup=closed';
        }
      }
    });
  }
  /*
  if (screen.width > 768) {
      setTimeout(function () {
        setPopup($('.popup_discount'), 'inline')
      }, 3000);
      
      $('.popup_discount-trigger').on('click', function() {
        document.cookie = 'popup=closed';
      })
  }*/
});