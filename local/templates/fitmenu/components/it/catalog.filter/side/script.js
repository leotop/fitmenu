$(function(){
    $('.full-filter .icon').click(function(){
        $(this).closest('.it-radio').find('input').click();
    })

    $('.form_class').click(function(){
        $('.form_filter').show();
    })
    $('.close_form').click(function(){
        $('.form_filter').hide();
    })
    $('.submit_filter').click(function(){
        var name = $('.fName').val();
        var phone = $('.fPhone').val();
        var emmail = $('.fEmail').val();

        if(name && phone && emmail){ 
            $.ajax({
              type: "POST",
              url: "/ajax/filter_individual_complex.php",
              data: $('#arrFilter_form_right').serialize(),
              success: function(data){
                $('.form_filter > div').hide();
                $('.form_filter .success_form').text('Ваша заявка отправлена! Мы в ближайшее время свяжемся с тобой, чтобы разработать индивидуальный комплекс.');  
              }   
            }); 
         }else{
             $('.error_form').show();
         }
    })
});