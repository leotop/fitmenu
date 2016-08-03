$(document).ready(function () {

  $('.cart-open, .bay_basket').click(function () {
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

  $('.modal-cross').click(function () {
    $(this).parents('.modal').fadeOut(500);
  });


  initSlider();
  tabs();

  $('.rub').append('<b></b>');

  $('.btnmodal').bind('click', function (e) {
    $('body').append('<div id="modalbox"><span class="b-close"></span><div class="mcontent"></div></div>');

    e.preventDefault();
    var urlmodal = $(this).attr("href");

    $('#modalbox').bPopup({
      content: 'ajax',
      contentContainer: '.mcontent',
      loadUrl: urlmodal,
      loadCallback: function () {

      },
      onClose: function () {
        $(".mcontent").empty();
        $("#modalbox").remove();
      }
    });
  });

  var tab = $('.tab');
  $('body').on('click', '.nav a', function () {
    var link = $(this), _id = link.attr('id'), _pid = _id.split('_'), p = link.closest('.tab');
    _id = _pid[1];
    if (!link.hasClass('a')) {
      $('.nav a', tab).removeClass('a');
      link.addClass('a');
    }
    var t_block = $('#tab_' + _id);
    if (!t_block.hasClass('a')) {
      $('.wrapper .block', p).hide();
      t_block.show();
    }
    return !1;
  })

  tab.each(function (i, it) {
    var hash = window.location.hash;
    hash = hash.replace('#', '');
    var h = $('#nav_' + hash);
    if (h.length > 0) {
      h.click();
    }
    else {
      var act = $(it).find('.nav .a');
      if (act.length > 0) {
        act.click();
      } else {
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

  if (in_stock_filter.hasClass('set')) {
    $('.in_stock_filter A').text('Показать').addClass('active');
  } else {
    $('.in_stock_filter A').text('Скрыть').removeClass('active');
  }

  $('.in_stock_filter A').click(function () {
    var link = $(this), block = link.closest('.in_stock_filter');//, checkbox = block.find('input'), check = false;
    var form = block.find('form');

    /*
     if(checkbox[0].checked){
     check = true;
     }
     console.log(checkbox[0].checked);
     */
    if (link.hasClass('active')) {
      link.removeClass('active');
      $('.reset', form).click();
      link.text('Показать');
    }
    else {
      link.addClass('active');
      link.text('Скрыть');
      $('.set', form).click();
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
  if (_slider.length != 0) {
    _slider.justSlider({
      effect: "slide",
      autoHeight: true,
      navigation: false
    });
  }

  var _slider2 = $('.slider-s');
  if (_slider2.length != 0) {
    _slider2.justSlider({
      effect: "slide",
      autoHeight: true,
      navigation: true,
      prevNext: false
    });
  }
}

function tabs() {
  $('.tabs-container').justTabs({
    nav: $('.tab-nav')
  });
}

$(function () {
  $('#id_prop_33').click(function () {
    $('#f_prop_34 .icon').removeClass('filter__background-women');
    $('#f_prop_33 .icon').addClass('filter__background-men');
  });
});

$(function () {
  $('#id_prop_34').click(function () {
    $('#f_prop_33 .icon').removeClass('filter__background-men');
    $('#f_prop_34 .icon').addClass('filter__background-women');
  });
});

// Sticky to Top with Scroll
function StickyTop(element, offset) {
  var element = element;
  var offset = offset;

  this.listeners = function () {
    $(window).on('scroll', this.setFixPos);
  }

  this.setFixPos = function () {
    if (window.scrollY > offset) {
      element.addClass('fixed');
    } else {
      element.removeClass('fixed');
    }
  }
}

if (screen.width > 1024) {
  var fixedMenu = new StickyTop($('.main-menu'), 100);
  fixedMenu.listeners();

  var fixedFilter = new StickyTop($('.bx-filter'), 700);
  fixedFilter.listeners();
}

// Amout Products in the cart
var cartAmoutProducts = (function () {
  var box = $('.num-goods');

  function updateAmount() {
    var amountProducts = $('.basket__main-row').length;
    amountProducts <= 0 ? box.html('') : box.html(amountProducts);
  }

  return {
    update: updateAmount
  }
})();

cartAmoutProducts.update();

// Work with Cookie
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
        close: function () {
          document.cookie = 'popup=closed';
        }
      }
    });
  }

  /*
   if (screen.width > 768 && $('.popup_discount').length > 0) {
     setPopup($('.popup_discount'), 'inline');

     $('.popup_discount-trigger').on('click', function() {
       var date = new Date;
       date.setMinutes(20);
       document.cookie = 'popup=closed; expires=' + date.toUTCString();
     });
   }
*/
});


/**
 * Создает экземпляр класса GetEmailAjax
 *
 * @param {object} options
 * @this {GetEmailAjax}
 * @constructor
 */

function GetEmailAjax(options) {
  this.form = options.form;
  this.input = options.input;
  this.btn = options.submit;
  this.path = options.path;
  this.success = options.ansSuccess;
}

GetEmailAjax.prototype.setAjax = function () {
  var msg = this.form.serialize();

  return $.ajax({
    type: 'POST',
    url: this.path,
    data: msg,
    success: this.success.bind(this),
    error: function (xhr, str) {
      console.log('Что-то пошло не так :(');
    }
  });
}

GetEmailAjax.prototype.validationEmail = function () {
  var inputVal = this.input.val();
  var input = this.input;

  if (~inputVal.indexOf('@')) {
    input.css({'border': 'none'});
    return true;
  } else {
    input.css({'border': '1px solid red'});
    return false;
  }
}

GetEmailAjax.prototype.sendEmail = function () {
  console.log(this.validationEmail);
  if (this.validationEmail(this.input)) {
    this.setAjax();
  }
};

/**
 * Объекты для передачи в options
 * @type {Object}
 */

var subscribeEmailOptions = {
  form: $('#subscribe'),
  input: $('#sub_email'),
  submit: $('.subscribe__submit'),
  ansSuccess: function () {
    this.form.html('Мы получили Ваш Email!');
  },
  path: '/ajax/subscribe.php'
}

var optEmail = {
  form: $('.p-opt__price-form'),
  input: $('.p-opt__input'),
  submit: $('.p-opt__submit'),
  ansSuccess: function () {
    this.form.html('Мы отправим наш прайс Вам на Email');
  },
  path: '/ajax/opt_email.php'
}

/**
 * Обработчики событий
 *
 */

if ($('#subscribe').length > 0) {
  var subscribeEmail = new GetEmailAjax(subscribeEmailOptions);

  // Установка обработчиков на subscribe
  subscribeEmail.btn.on('click', function (e) {
    e.preventDefault();
    subscribeEmail.sendEmail();
  });
  subscribeEmail.input.on('input', subscribeEmail.validationEmail.bind(subscribeEmail));
}

if ($('.p-opt__price-form').length > 0) {
  var getOptEmail = new GetEmailAjax(optEmail);

  // Установка обработчиков на опт
  getOptEmail.btn.on('click', function (e) {
    e.preventDefault();
    getOptEmail.sendEmail();
  });
  getOptEmail.input.on('input', getOptEmail.validationEmail.bind(getOptEmail));
}






