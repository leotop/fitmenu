$(function(){
    $('.full-filter .icon').click(function(){
        $(this).closest('.it-radio').find('input').click();
    })
})

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
          data: $('#arrFilter_form').serialize(),
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
