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
})