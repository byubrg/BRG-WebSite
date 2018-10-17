$ = jQuery

//key value pairs of capital letters and their corresponding int value in brand
var letter_values = new Array(26);

$( document ).ready(function () {
	// Build the Bubble Selectors

	//gets data for the initializes the letter_values, this list could be cached for speed,
	//but if it were to ever change it would break this whole page
	//for that reason it is being recalculated every time to avoid a horrible bug in the future
	$.ajax({
		dataType: 'json',
		url: 'https://' + document.domain + '/wp-json/wp/v2/letter?per_page=100',
	})
	.done(function ( object ) {
		//creates the key values pairs of Letter => Number that are used when clicking on bubble selectors
    for(var i =0; i < object.length; i++){
      letter_values[object[i].name.charCodeAt(0) - 65] = object[i].id;
    }
	});


	$( '.bubble-selector' ).each(function () {
		var mySelector = new PGSP_bubble_selector( this )
		mySelector.init();
	});

  	drop_down_change_listener();
});

function PGSP_bubble_selector (bubble_selector) {
	// Definitions
	this.variety = 'bubble_selector';

	// Elements
	this.bubble_selector = bubble_selector;
	this.items = null;
	this.bubbles = null;

	// General Data
	this.selected_bubble = -1;

	// Error Message
	this.error_message = 'Bubble Selector Errors:\n';
	this.error_number = 0;

	this.add_error = function (message) {
		this.error_number++;
		this.error_message += '(' + this.error_number + ') ' + message + '\n';
	};

	/*
    Post:
        Information regarding the object will be logged to the console

    Return:
        NONE
    */
	this.log_information = function () {
		console.log( '_____________' );
		console.log( '\n\nbubble_selector: ' );
		console.dir( this.bubble_selector );
		console.log( 'items: ' );
		console.dir( this.items );
		console.log( 'bubbles: ' );
		console.dir( this.bubbles );

		console.log( 'selected_bubble: ' + this.selected_bubble );
	};

	/*
    Post:
        this.bubble_selector = root of the bubble selector
        console.log("what went wrong in the initialization");

    Return:
        false if initialization was NOT successful
        true if initialization was succesful
    */
	this.init = function () {

		if (this.bubble_selector == null) {
			console.log( 'Object recieved is not a known element of a bubble Selector' );
			return false;
		}
		this.init_element_variables();

		if (this.error_number > 0) {
			console.log( this.error_message );
			return false;
		}

		this.init_click_events();
		$( this.bubble_selector ).css( 'height', 'inherit' );
		$( this.bubble_selector ).fadeIn();

		// this.log_information();
		return true;
	};

	/*
    Pre:
        Bubble Selector has exactly:
            0 bubble_selector (No nested bubble selectors)
            1 line_container
            1 line (if 0 then one will be added automatically)
            1 arrow_left (if 0 then one will be added automatically)
            1 arrow_right (if 0 then one will be added automatically)

    Post:
        this.line_container = element
        this.line = element
        this.arrow_left = element
        this.arrow_right = element

        if (errors occurs)
            this.error_message contains them
            this.error_number updates according to the number of errors found

    Return:
        NONE
    */
	this.init_element_variables = function () {
		// Element Quantity checks
		//  //  //  //  //  //  //  //  //  //  //  //  //
		// Bubble Selector
		bubble_selectors = $( this.bubble_selector ).find( '.bubble-selector' );
		if (bubble_selectors.length > 0) {
			this.add_error( "'bubble-selector's cannot be nested" );
		}
		// Add div with classes around item spans

		var raw_items = $( this.bubble_selector ).find( 'span' );
		$( raw_items ).wrap( '<div class="bubble-selector__bubble bubble-selector__item bubble-selector__bubble__not-selected"></div>' );
		console.log( raw_items );
		$( raw_items ).each(function () {
			if ($( this ).hasClass( 'not-selectable' )) {
				$( this ).parent().addClass( 'not-selectable' );
			}
		});

		// Items
		this.items = $( this.bubble_selector ).find( '.bubble-selector__item' );

		// Bubbles
		this.bubbles = $( this.bubble_selector ).find( '.bubble-selector__bubble' );

		// Element Nesting Checks
		//  //  //  //  //  //  //  //  //  //  //  //  //

	};

	/*
    Post:
        Sets up the click events for the bubbles, and paging arrows

    Return:
        NONE
    */
	this.init_click_events = function () {
		var bubble_selector_object = this;

		// NORMAL BUBBLES
		$( this.items ).click(function () {
			if ($( this ).hasClass( 'not-selectable' )) {
				return;
			}
			bubble_selector_object.select_item( this );
		});
		$( this.items ).click(function () {
            window.location.href = 'https://' + document.domain + '/editorial-style/byu-terms/?L=' + this.innerText;
		});
	};

	this.select_item = function (item_to_select) {
		var bubble_selector_object = this;
		$( item_to_select ).parent().find( '.bubble-selector__bubble__selected' ).each(function () {
			$( this ).removeClass( 'bubble-selector__bubble__selected' );
			$( this ).addClass( 'bubble-selector__bubble__not-selected' );

		});
		$( item_to_select ).addClass( 'bubble-selector__bubble__selected' );
		$( item_to_select ).removeClass( 'bubble-selector__bubble__not-selected' );
		$( item_to_select ).parent().find( '.bubble-selector__bubble' ).each(function (index) {
			if ($( this ).hasClass( 'bubble-selector__bubble__selected' )) {
				bubble_selector_object.show_selected_bubble( index );
			}
		});
	};
	this.show_selected_bubble = function (index) {
	};
}

function individual_part_of_accordian(object){
	var content = 'accordion__item--closed';
	if(object.subtext === null || object.subtext === '' || object.subtext === ' '){
		content = 'no-content';
	}
	var html = '<div class="accordion__item ' + content + '">'
    +'	<div class="accordion__item__title-bar">';
	if ( content === 'accordion__item--closed' ) {
        html += '<div class="icon icon--state-one js-icon  icon--outlined icon--circle icon--turn-clockwise accordion__item__main-toggle accordion__item__toggle icon--std-two-state icon--no-click" >'
        +'	<img class="icon__image  icon__image1" src="' + 'https://' + document.domain + '/wp-content/themes/standardframeworkparent/images/elements/icon/icon__arrow2--blue.svg" alt="More">'
        +'	<img class="icon__image  icon__image2" src="' + 'https://' + document.domain + '/wp-content/themes/standardframeworkparent/images/elements/icon/icon__arrow2--white.svg" alt="More not Available">'
        +'</div>';
    } else {
		html += '<div class="accordion__item__main-toggle accordion__item__toggle"></div> '
	}
  	html +='		<div class="accordion__item__title-area no-content">'
    +'			<h3 class="accordion__item__toggle">' + object.title + '</h3>'
    +'		</div>'
    +'	</div>'
    +'	<div class="accordion__item__content">' + object.subtext + '</div>'
    +'</div>';
	return html;
}
/*
 * when you click on the drop down arrow this will switch the class governing it's coloring and images
 * */
function drop_down_arrow_img_changer(){
	$('.js-icon').click(function(){
		if( $(this).hasClass('icon--state-one') ) {
			$(this).removeClass('icon--state-one');
			$(this).addClass('icon--state-two');
		} else {
      $(this).removeClass('icon--state-two');
      $(this).addClass('icon--state-one');
		}
	});
}

/*
* listens for when the drop down selector changes selection
* calls update_the_page to change the page content to match the newly selected letter
* */
function drop_down_change_listener() {
	$('#entry-letter-archive__letter-selection').change(function(){
        window.location.href = 'https://' + document.domain + '/editorial-style/byu-terms/?L=' + $(this).val();
  });
}

