$ = jQuery;
$(window).ready(function(){
    var base_url = '';
    var current_url = window.location.href;
    if(current_url.indexOf("localhost")){
        base_url = 'http://localhost/brand/';
    }
    var sign_in = $('a:contains("Sign In")')
    console.log(sign_in);
    $(sign_in).removeAttr("href");
    $(sign_in).css('cursor','pointer');
    $(sign_in).click(function(){
        console.log('click');
        var current_url = window.location.href
        var data =  new Object();
        data.url = window.location.href;
        data.downloadable = '';
        var json = JSON.stringify(data);
        var new_url = 'http://localhost/brand/pg-login?' + json;
        console.log(new_url);

        if (current_url.indexOf("logos") >= 0){
            new_url = 'http://localhost/brand/pg-login?' + json;
        }

        window.location.replace(new_url);
    });
    $()//download ables
});