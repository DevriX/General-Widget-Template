jQuery(document).ready(function( $ ) {
    //Image Uploader as per wordpress version
    $( document ).on('click', '.generic-template-image', function( event ) {
    	
        var file_frame;
        var target_field = event.target.id;
        // If the media frame already exists, reopen it.
        if ( file_frame ) { 
            file_frame.open();
            return;
        }
        
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            frame: 'post',
            state: 'insert',
            multiple: false  // Set to true to allow multiple files to be selected
        });
        
        file_frame.on( 'menu:render:default', function(view) {
            // Store our views in an object.
            var views = {};
            
            // Unset default menu items
            view.unset('library-separator');
            view.unset('gallery');
            view.unset('featured-image');
            view.unset('embed');

            // Initialize the views in our view object.
            view.set(views);
        });

        // When an image is selected, run a callback.
        file_frame.on( 'insert', function($) {
        	
            // Get selected size from media uploader
            // var selected_size = jQuery('.attachment-display-settings .size').val();		
            var selection = file_frame.state().get('selection');
            selection.each( function( attachment, index ) {
            attachment = attachment.toJSON();
            
            // Selected attachment url from media uploader
            var attachment_url = attachment['url'];
            $( '#'+target_field ).prev('.img-holder').val( attachment_url );
        });
    });

    // Finally, open the modal
    file_frame.open();

    });
});