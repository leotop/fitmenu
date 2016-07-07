$(function () {

  function Accordeon(trigger) {
    var $this = trigger, item = $this.closest(".dropdown"), list = $this.closest(".sidebar-menu"), items = list.find(".dropdown"), content = item.find(".dropdown__list-inner"), otherContent = list.find(".dropdown__list-inner"), duration = 300;
    if (!item.hasClass("active")) {
      items.removeClass("active");
      item.addClass("active");
      otherContent.stop(true).slideUp(duration);
      content.stop(true).slideDown(duration);
    } else {
      item.removeClass("active");
      content.slideUp(duration);
    }
  };

  $(".dropdown .dropdown__trigger").on("click", function (e) {
    if (screen.width < 768) {
      e.preventDefault();
      var accordeon = new Accordeon($(this));
    }
  });

  function Dropdown(trigger) {
    var $this = trigger, menuWrap = $this.closest(".menu-open__wrapper"), menu = menuWrap.find(".menu-open");
    if (!menu.hasClass("active")) {
      menu.addClass("active");
      menu.stop(true, true).slideDown(300);
    } else {
      menu.removeClass("active");
      menu.stop(true, true).slideUp(300);
    }
  };

  $(".menu-open__trigger").on("click", function (e) {
    e.preventDefault();
    var dropdown = new Dropdown($(this));
  });
});

// Cart Popup Module
var cartBehavior = (function () {
  var cart = $('#shopCart'),
      modalCart = $('.modal'),
      body = $('body'),
      closeBtn = $('.modal-cross');

  function closeCart() {
    modalCart.hide();
    cart.hide();
  }

  function openCart() {
    modalCart.show();
  }

  function setUpListeners() {
    cart.on('click', openCart);
    closeBtn.on('click', closeCart);
  }

  return {
    init: function () {
      setUpListeners()
    }
  }
})();

if (screen.width < 480) {
  cartBehavior.init();
}

// Navbar Responsive Module
$(function () {

  function NavbarResponsive(elem) {
    this.elem = $(elem);
  }

  NavbarResponsive.prototype.elems = $('.rs-show');

  NavbarResponsive.prototype.clearElems = function () {
    this.elems.removeClass('active');
    this.elems.hide();
  }

  NavbarResponsive.prototype.toggle = function () {
    if (this.elem.hasClass('active')) {
      this.hide();
    } else {
      this.clearElems();
      this.show();
    }
  }

  NavbarResponsive.prototype.show = function () {
    this.elem.addClass('active');
    this.elem.show();
  }

  NavbarResponsive.prototype.hide = function () {
    this.elem.removeClass('active');
    this.elem.hide();
  }

  if (screen.width < 480) {
    $('.cart-trigger').on('click', function () {
      var cart = new NavbarResponsive('.cart');
      cart.toggle();
    });
    $('.main-menu-trigger').on('click', function () {
      var menu = new NavbarResponsive('.main-menu');
      menu.toggle();
    });
    $('.login-trigger').on('click', function () {
      var login = new NavbarResponsive('.bx_login_block');
      login.toggle();
    });
    $('.search-trigger').on('click', function () {
      var search = new NavbarResponsive('.search-box');
      search.toggle();
    });
  }

});

$(function () {
  function ScrollFix(options) {
    var element = $(options.element),
      showWhen = options.showWhen,
      duration = options.duration,
      scrollUp = options.scrollUp || false,
      className = options.className;

    this.init = function () {
      $(document).ready(function () {
        $(window).scroll(function () {
          if ($(this).scrollTop() > showWhen)element.addClass(className); else if ($(this).scrollTop() < showWhen)element.removeClass(className);
        });
        if (scrollUp) {
          element.on("click", function () {
            $("body, html").animate({scrollTop: 0}, duration);
          })
        }
      })
    }
  };
  var scrollBtnUp = new ScrollFix({
    element: ".btn-up",
    showWhen: 250,
    duration: 300,
    className: "visible",
    scrollUp: true
  });
  if ($("html").hasClass("bx-touch")) {
    scrollBtnUp.init();
  }
});

// Use In Responsive
$(function () {
  if (screen.width < 480)$(".bx_breadcrumbs li:last-child").hide();

  // hide discount block
  var loc = 'http://fitmenu.ru/about/stocks/';
  if (location.href === loc) {
    $('.discount_link').hide();
  }

  // Filter on discount page
  if (screen.width < 480) {
    var param = $('.ts-filter__params');
    var trigger = $('.ts-item');

    trigger.on('click', function () {
      if ($(this).hasClass('active')) {
        param.hide();
        $(this).removeClass('active');
      } else {
        param.hide();
        $(this).addClass('active').find(param).show();
      }
    })

    param.on('click', function (e) {
      e.stopImmediatePropagation();
    })


    // filter on category page, mobile
    function showDropInFilter(content, trigger) {
      if (trigger.hasClass('active')) {
        content.hide();
        trigger.removeClass('active');
      } else {
        content.show();
        trigger.addClass('active');
      }
    }

    // Right Sidebar
    $('.content-holder').after($('.right-sidebar'));

    function hideDropInFilter(content, trigger) {
      content.hide();
      trigger.removeClass('active');
    }

    var categoryFilter = $('.smartfilter');
    var categoryFilterTrigger = $('.bx-filter-title');
    var subCategories = $('.bx_catalog_text');
    var categoryName = $('h1.head');

    $('.bx-filter').append($('.category__head'));
    $('.bx-filter').append(subCategories);

    // Handlers
    categoryFilterTrigger.on('click', function () {
      var trigger = $(this);
      hideDropInFilter(subCategories, categoryName)
      showDropInFilter(categoryFilter, trigger);
    })

    categoryName.on('click', function () {
      var trigger = $(this);
      hideDropInFilter(categoryFilter, categoryFilterTrigger);
      showDropInFilter(subCategories, trigger);
    })

  }

});