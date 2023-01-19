/**
 * Load media uploader on pages with our custom metabox
 */
jQuery(document).ready(function($){

	'use strict';

	// Instantiates the variable that holds the media library frame.
	var metaImageFrame;

	// Runs when the media button is clicked.
	$( 'body' ).click(function(e) {

		// Get the btn
		var btn = e.target;

		// Check if it's the upload button
		if ( !btn || !$( btn ).attr( 'data-media-uploader-target' ) ) return;

		// Get the field target
		var field   = $( btn ).data( 'media-uploader-target' );
        var fieldid = $(btn).data( 'media-uploader-id' );

		// Prevents the default action from occuring.
		e.preventDefault();

		// Sets up the media library frame
		metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
			title: preload_lcp.title,
			button: { text:  'Use this file' },
		});

		// Runs when an image is selected.
		metaImageFrame.on('select', function() {

			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = metaImageFrame.state().get('selection').first().toJSON();
            

			// Sends the attachment URL to our custom image input field.
			$( field ).val(media_attachment.url);
            $( fieldid ).val(media_attachment.id);

		});

		// Opens the media library frame.
		metaImageFrame.open();

	});


    $('#lcp_url_preload').on( 'change', function(e) {
        $('#lcp_id_preload').val('');
    });
});
