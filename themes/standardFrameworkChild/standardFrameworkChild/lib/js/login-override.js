$ = jQuery

$(window).ready(function(){
    $('.admin_login_button').click(function(){
        $('.input').css('display','block');
        $('#loginform p label').css('display','block');
        $('#auth-external-service-login h3').css('display','block');
        $('.submit').css('display','block');
        $('.admin_login_button').css('display','none');
    });
});