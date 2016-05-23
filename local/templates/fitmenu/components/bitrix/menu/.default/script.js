$(function(){
    $('.left-menu .show').click(function(){
        var li = $(this);
        if(li.hasClass('a')){
            li.find('a').text('Показать все');
            li.removeClass('a');
        }else{
            li.addClass('a');
            li.find('a').text('Скрыть');
        }
        var ul = li.closest('.left-menu')
        ul.find('.hidden').toggle();
        ul.addClass('z');
        //li.hide();
        return !1;
    })
});