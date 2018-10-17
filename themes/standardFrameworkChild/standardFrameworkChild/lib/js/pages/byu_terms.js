$ = jQuery

//global variables needed by all functions
var current_ascii_top;
var current_ascii_bottom;
var bottom_loaded = false;
var top_loaded = false;
var processing = false;
var gone_down = false;
var mobile_factor = 0;
var mobile_going_up_factor = 10;

$( document ).ready(function () {
    var matches = (window.location.href).match(/L=/);
    if(matches){
        if (matches[0]) {
            $('byu-footer').css('display','none');
        }
    } else {
        return;
    }
    control_header_sizes();
    current_ascii_top = letter_to_ascii($('.solid__bubble-test-inner span').text());
    current_ascii_bottom = current_ascii_top;
    //starting_state_of_scrolling(true);
    //----added-----
    $('html,body').animate({
        scrollTop: $('.section__letter_content_nav').offset().top
    }, 2000, 'swing');
    gone_down = true;
    setTimeout(
        function()
        {
            $('.top_part').css('display','none');
            $('.page-header').css('display','none');
            $('.brand_page-header').css('display','none');
            $('.brand_page-header').css('display','none');
            $('.scroll_wrap').css('overflow','scroll');
        }, 2000);

    initilize_scorlling();
    //---------------------
    //define the height
    var window_height = $(window).height();
    //64 is the height the main letter header
    $('.scroll_wrap').css('height',(window_height - 84) + 'px');
});

function starting_state_of_scrolling(first){
    $('.scroll_wrap').css('overflow','hidden');
    $(window).scroll(function(){
        if ( $('.section__letter_content_nav').offset().top <= $(this).scrollTop() + mobile_factor ) {
            gone_down = true;
            $('.top_part').css('display','none');
            $('.page-header').css('display','none');
            $('.brand_page-header').css('display','none');
            $('.brand_page-header').css('display','none');
            $('.scroll_wrap').css('overflow','scroll');
            $(window).unbind('scroll');
            if(first){
                initilize_scorlling();
            }
        }
    });
}

function initilize_scorlling(){
    $('.scroll_wrap').scroll(function(){
        var scroll_top = $(this).scrollTop();
        var last_height = $('.section__speaker-letter-archive__listings>.container:last').height();
        if ( scroll_top > (( $('.section__speaker-letter-archive__listings').height() - last_height ) +
            (last_height * .6)) - $('.scroll_wrap').height() ) {
            rest_api_call(true);
        }
        track_top_letter(scroll_top);
    });
    //tracks if there is an attemp to scroll up while at the top of the currently loaded section
    $(window).bind('mousewheel', function(e){
        if(e.originalEvent.wheelDelta > 0) {
            //going up
            if ( $('.scroll_wrap').scrollTop() == 0  && current_ascii_top == 65 && !processing) {
                $('.top_part').css('display','block');
                $('.page-header').css('display','block');
                $('.brand_page-header').css('display','block');
                if(gone_down){
                    $(window).scrollTop( $('.section__letter_content_nav').offset().top - mobile_going_up_factor );
                    gone_down = false;
                }

                starting_state_of_scrolling(false);
            }
            if ( $('.scroll_wrap').scrollTop() == 0 ) {
                rest_api_call(false);
            }
        }
    });
}

/**
 * makes a call to the rest API, appends new info to the DOM
 * @param letter
 * */
function rest_api_call( append_to_bottom ){
    var letter = '';
    if((append_to_bottom && bottom_loaded) || (!append_to_bottom && top_loaded) || letter_values[0] == null || processing) {
        return;
    }else{
        processing = true;
    }
    var rest_data = [];
    var next_letter = '';
    if(current_ascii_top <= 65 && !append_to_bottom) {
        processing = false;
        return;
    }
    if ( append_to_bottom ) {
        current_ascii_bottom++;
        if(current_ascii_bottom >= 90 ) {
            bottom_loaded = true;
        }
        letter = letter_values[current_ascii_bottom - 65];
        next_letter = ascii_to_letter(current_ascii_bottom);
    } else {
        current_ascii_top--;
        if(current_ascii_top <= 65) {
            top_loaded = true;
        }
        letter = letter_values[current_ascii_top - 65];
        next_letter = ascii_to_letter(current_ascii_top);
    }
    var clicked_url = 'https://' + document.domain + '/wp-json/wp/v2/entry?letter=' + letter + '&per_page=100&orderby=title&order=asc';
    $.ajax({
        dataType: 'json',
        url: clicked_url,
    })
        .done(function ( object ) {
            for ( var i =0; i < object.length; i++ ) {
                var temp_object = {
                    'title': object[i].title.rendered,
                    'subtext': object[i].slug
                };
                rest_data.push(temp_object);
            }
            append_accordion_info( generate_accordion_html( rest_data, next_letter ) , append_to_bottom );
            drop_down_arrow_img_changer(); //declared in bubble-selector.js
            drop_down_change_listener(); //declared in bubble-selector.js
            control_header_sizes();
        })
        .fail(function (object) {
            append_accordion_info( generate_empty_accordion(next_letter), append_to_bottom );
        })
        .always(function(){
            processing = false;
        });
}

function append_accordion_info(html, append_to_bottom){
    if (append_to_bottom) {
        $(html).insertAfter( $('.section__speaker-letter-archive__listings>.container:last') );
    } else {
        $('.section__speaker-letter-archive__listings').prepend(html);
        //adjust for the extra space at the top
        //68 is the height of a single term
        $('.scroll_wrap').scrollTop($('.section__speaker-letter-archive__listings>.container:first').height() - 68);
    }
}

/**
 * @param rest_data the information from the REST API
 * @return html code for an accordion containing the REST API info
 * */
function generate_accordion_html ( rest_data, selected_letter ) {
    var html =
        '<div class="container">';

    html += '				<div class="terms_section_header">'
        + '                    <div class="solid__bubble-test'
        + '                                xlg-col-1'
        + '                                 lg-col-1'
        + '                                 mlg-col-1'
        + '                                 med-col-1'
        + '                                 sm-hidden'
        + '                                 ssm-hidden" ';
    if (selected_letter == 'A') {
        html += 'id="first_letter_header"';
    }
    html +='>'
        + '                        <div class="solid__bubble-test-inner bubble_header">'
        + '                            <span id="current_letter_display" data-letter="' + selected_letter + '">' + selected_letter + '</span>'
        + '                        </div>'
        + '                    </div>'

    html += '</div>';

    html += ' <div class="row">'
        +'	    <div class="speaker-letter-archive__listings">'
        +'		    <div class="accordion accordion--skin-1 accordion--select-any">';
    //add the accordion items to the html
    for ( var i =0; i < rest_data.length; i++ ) {
        html += individual_part_of_accordian(rest_data[i]); //this function is defined in bubble-selector.js
    }
    html +=
        '    		</div>'
        +'  	</div>'
        +'	</div>';
    html +='</div>';
    return html;
}

/**
 * creates the html code for a letter section with no content
 * @return html code for an accordion containing the empty content message
 * */
function generate_empty_accordion(selected_letter) {
    var html =
        '<div class="container">';

    html += '<div class="terms_section_header">'
        + '     <div class="solid__bubble-test'
        + '         xlg-col-1'
        + '         lg-col-1'
        + '         mlg-col-1'
        + '         med-col-1'
        + '         sm-hidden'
        + '         ssm-hidden" ';
    if (selected_letter == 'A') {
        html += 'id="first_letter_header"';
    }
    html +='>'
        +'	    <div class="solid__bubble-test-inner bubble_header">'
        +'	    	<span data-letter="'+selected_letter+'">'+selected_letter+'</span>'
        +'	    </div>'
        +'	</div>';

    html += '</div>'

    html += ' <div class="row">'
        +'	    <div class="speaker-letter-archive__listings">'
        +'		    <div class="accordion accordion--skin-1 accordion--select-any">'
        +'              <div class="accordion__item no-content">'
        +'	                <div class="accordion__item__title-bar">'
        +'                      <div class="accordion__item__main-toggle accordion__item__toggle"></div>'
        +'		                <div class="accordion__item__title-area no-content">'
        +'			                <h3 class="accordion__item__toggle">There are no terms for this letter</h3>'
        +'		                </div>'
        +'	                </div>'
        +'	                <div class="accordion__item__content"></div>'
        +'              </div>'
        +'    		</div>'
        +'  	</div>'
        +'	</div>';
    html +='</div>';
    return html;
}

/**
 * returns the ascii value of the given letter in upper case
 * @param letter, to converted to ascii character
 * @return the ascii value of the given letter in upper case
 * */
function letter_to_ascii (letter) {
    return letter.toUpperCase().charCodeAt(0);
}

/**
 * returns the string value of the given ascii in upper case
 * @param ascii, to converted to string in upper case
 * @return the upper case string of the given ascii code
 * */
function ascii_to_letter (ascii) {
    return String.fromCharCode(ascii);
}

function track_top_letter(scroll_top){
    //print the
    //the last one to be less than 277
    var letter = '';
    $('.bubble_header span').each(function(){
        if ( $(this).offset().top < ($('.section__letter_content_nav').offset().top + 87) ) {
            letter = $(this).text();
        }
    });
    if(letter == ''){
        letter = ascii_to_letter(current_ascii_top);
    }
    if($('#current_letter_display').text() != letter){
        $('#current_letter_display').text(letter);
        $('option').removeAttr('selected');
        letter = letter.replace(/\s/g, '');
        $('option:contains('+letter+')').attr('selected','');
    }
}

function control_header_sizes(){
    $(window).off('resize');
    $(window).resize(function(){
        $('.terms_section_header').css('width',$('.section__letter_content_nav .row').width() + 'px');
        control_mobile_factor()
    });
    $('.terms_section_header').css('width',$('.section__letter_content_nav .row').width() + 'px');
    control_mobile_factor()
    function control_mobile_factor(){
        if( $(window).width() < 600 ){
            mobile_factor = 20;
            mobile_going_up_factor = 30;
        } else {
            mobile_factor = 10;
            mobile_going_up_factor = 30;
        }
    }
}
