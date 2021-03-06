$(function(){
    $('.offers-select').change(function(){
        var v = $(this).val(), tr = $(this).closest('tr');
        var offers = $('.offers', tr), offer = $('.offer', offers);
        offer.hide();
        var active = $('#_offer_'+v);
        var price = active.find('.price b').html(); 
        $('.product-price .p').html(price);
        active.show();
    })
});

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

$(function () {
    var listTrigger = $("#catalog-list"),
      gridTrigger = $("#catalog-grid"),
      triggers = $(".catalog-view__triggers"),
      catalog = $("table.category"),
      categoryPriceOld = $(".category__price .old");

    var catalogView = {
        init: function () {
            this.setUpListeners();
        }, setUpListeners: function () {
            $(gridTrigger).on("click", this.setGridClass);
            $(listTrigger).on("click", this.removeGridClass);
        }, setGridClass: function () {
            if (!catalog.hasClass("grid-active")) {
                document.cookie = "gridClass=true";
                triggers.removeClass("is_active");
                gridTrigger.addClass("is_active");
                catalog.addClass("grid-active");
                $(".category-item").wrapInner("<td class='category-item__inner-td'><table class='category-item__inner-table'><tr class='category-item__inner-tr'></tr></table></td>");
                categoryPriceOld.closest(".category__price").find(".product-price").css("color", "#922229");
                categoryPriceOld.closest(".category__price").find(".rub b").css("background", "#922229");
            }
        }, removeGridClass: function (e) {
            e.preventDefault();
            document.cookie = "gridClass=false";
            window.location.reload();
        }
    };
    if ($(".catalog-view")) {
        catalogView.init()
    }
    if (getCookie("gridClass") === "true") {
        catalogView.setGridClass();
    }
});