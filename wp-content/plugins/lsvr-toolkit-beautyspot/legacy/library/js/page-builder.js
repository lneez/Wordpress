/* -----------------------------------------------------------------------------

    WYSIWYG EDITOR FIELD

----------------------------------------------------------------------------- */

// TOOLBAR SHORTCODES BUTTON
var lsvr_editor_field_add_sc_btn = {

    css: 'addshortcode',
    text: 'Add Shortcode',
    action: function ( btn ) {
		if ( typeof lsvr_sg_show_modal === 'function' ) {
			lsvr_sg_show_modal( 'page-builder-editor', this );
		}
    }

}

// WYSIWYG EDITOR ARGS
var lsvr_editor_field_args = [
    [ 'html' ],
    [ 'bold', 'italic', 'underline', 'strikethrough', '|', 'superscript', 'subscript' ],
    [ 'p', '|', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ],
    [ 'orderedList', 'unorderedList' ],
    [ 'justifyleft', 'justifycenter', 'justifyright' ],
    [ 'link', 'unlink' ],
    [ 'forecolor' ],
    [ lsvr_editor_field_add_sc_btn ]
];

// ADD CUSTOM COLORS FROM THEME OPTIONS TO COLORPICKER
if ( typeof lsvr_custom_colors !== 'undefined' && lsvr_custom_colors.length > 0 ) {
    var lsvr_editor_colors = jHtmlAreaColorPickerMenu.defaultOptions.colors;
    lsvr_editor_colors = lsvr_editor_colors.concat( lsvr_custom_colors );
    jHtmlAreaColorPickerMenu.defaultOptions.colors = lsvr_editor_colors;
}

// CREATE WYSIWYG EDITOR
function lsvr_create_editor_field( editor_field ){

    var parent = editor_field;
    var textarea = editor_field.find( '> textarea' );
    parent.addClass( 'init' );
    textarea.htmlarea({ toolbar: lsvr_editor_field_args });
    parent.find( '.jHtmlArea, iframe' ).css( 'width', '100%' );
    parent.find( 'iframe' ).css( 'height', '200px' );
    parent.find( '.ToolBar' ).addClass( 'clearfix' ).css( 'width', 'auto' );

}

(function($){
    $(document).ready(function(){

        // INITIAL CREATION
        $( '#page-builder .lsvr-field-editor' ).each(function(){
            lsvr_create_editor_field( $(this) );
        });

        // REINIT AFTER SORT UDPATED
        $( 'ul.blocks' ).bind( 'sortupdate', function( event, ui ){

            var self = $(this);
            self.animate({ 'opacity' : 1 }, 100, function(){
                self.find( '.lsvr-field-editor:not(.init)' ).each(function(){
                    var editor_to_init = $(this);
                    lsvr_create_editor_field( editor_to_init );
                });
            });

        });

        // REINIT AFTER SORTING
        $( 'ul.blocks' ).bind( 'sortstop', function( event, ui ){
            ui.item.find( '.lsvr-field-editor' ).each(function(){

                if ( $(this).hasClass( 'init' ) ){
                    $(this).find( 'textarea' ).htmlarea( 'dispose' );
                    lsvr_create_editor_field( $(this) );
                }

            });
        });

    });
})(jQuery);


/* -----------------------------------------------------------------------------

    COLOR PICKER FIELD

----------------------------------------------------------------------------- */

function lsvr_create_colorpicker_field( parent ) {
(function($){

    if ( typeof lsvr_custom_colors !== 'undefined' && lsvr_custom_colors.length > 0 ) {

        parent.find( '.input-color-picker:not(.init)' ).each(function(){
            $(this).addClass( 'init' );
            $(this).wpColorPicker({
                palettes: lsvr_custom_colors
            });
        });

    }

})(jQuery);
}

(function($){
    $(document).ready(function(){

        if ( typeof lsvr_custom_colors !== 'undefined' && lsvr_custom_colors.length > 0 ) {

            // INITIAL CREATION
            $( '#page-builder .input-color-picker' ).each(function(){
                lsvr_create_colorpicker_field( $(this).parent() );
            });

            // REINIT AFTER SORT UDPATED
            $( 'ul.blocks' ).bind( 'sortupdate', function( event, ui ){

                var self = $(this);
                self.animate({ 'opacity' : 1 }, 100, function(){
                    self.find( '.input-color-picker:not(.init)' ).each(function(){
                       lsvr_create_colorpicker_field( $(this).parent() );
                    });
                });

            });

        }

    });
})(jQuery);


/* -----------------------------------------------------------------------------

    OVERRIDES FOR AQUA PAGE BUILDER

----------------------------------------------------------------------------- */

(function($){
    $(document).ready(function(){

	// ALTERED ADD NEW ITEM FUNCTION
	function lsvr_sortable_list_add_item(action_id, items) {

		var blockID = items.attr('rel'),
			numArr = items.find('li').map(function(i, e){
				return $(e).attr("rel");
			});

		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;

		var data = {
			action: 'aq_block_'+action_id+'_add_new',
			security: $('#aqpb-nonce').val(),
			count: newNum,
			block_id: blockID
		};

		$.post(ajaxurl, data, function(response) {
			var check = response.charAt(response.length - 1);

			//check nonce
			if(check == '-1') {
				alert('An unknown error has occurred');
			} else {

                items.append(response);

                // actions after append
                lsvr_create_colorpicker_field( items );

                items.find( '.lsvr-field-editor:not(.init)' ).each(function(){
                    var editor_to_init = $(this);
                    lsvr_create_editor_field( editor_to_init );
                });

			}

		});
	};

	function lsvr_sortable_list_init() {
		$('.aq-sortable-list').sortable({
			containment: "parent",
			placeholder: "ui-state-highlight"
		});
	}
	lsvr_sortable_list_init();

	$(document).on('click', 'a.lsvr-sortable-add-new', function() {
		var action_id = $(this).attr('rel'),
			items = $(this).parent().children('ul.aq-sortable-list');

		lsvr_sortable_list_add_item(action_id, items);
		lsvr_sortable_list_init();
		return false;
	});

	// ALTERED UPLOAD MEDIA
	$( '.aq_upload_button' ).click(function( event ){

		var $clicked = $(this), frame,
			hidden_id = $clicked.parent().find( '.image-id' ).length > 0 && $clicked.parent().find( '.image-id' ).attr( 'id' ) ? $clicked.parent().find( '.image-id' ).attr('id') : false,
			input_id = $clicked.parent().find( '.image-url' ).length > 0 && $clicked.parent().find( '.image-url' ).attr('id') ? $clicked.parent().find( '.image-url' ).attr('id') : false,
			media_type = $clicked.attr('rel') ? $clicked.attr('rel') : false;

		if ( hidden_id && input_id && media_type ) {

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( frame ) {
				frame.open();
				return;
			}

			// Create the media frame.
			frame = wp.media.frames.aq_media_uploader = wp.media({
				// Set the media type
				library: {
					type: media_type
				},
				view: {

				}
			});

			// When an image is selected, run a callback.
			frame.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first();

				$('#' + input_id).val(attachment.attributes.url);
				$('#' + hidden_id).val(attachment.attributes.id);

				if(media_type == 'image') $('#' + input_id).parent().find('img.screenshot').attr('src', attachment.attributes.url);

			});

			frame.open();

			return false;

		}

	});

    });
})(jQuery);