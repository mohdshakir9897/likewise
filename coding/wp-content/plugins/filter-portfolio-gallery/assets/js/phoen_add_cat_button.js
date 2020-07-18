jQuery(document).ready(function(jQuery){
    var custom_uploader;
    jQuery('#upload_image_button').click(function(e) {
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
			var we_value = jQuery('#upload_image').val(attachment.url);	 
			alert(ajax_url);
			jQuery.post(
					ajax_url, 
					{
						'action': 'phoen_action',
						'data':   we_value
					}, 
					function(response){
						alert('The server responded: ' + response);
					}
				);

			
			/* var data1='hdhsdjhjdhd'; */
			/* var data = {
				'action': 'ajax_phoen_action',
				'we_value': we_value,    // We pass php values differently!
			};
			 /* console.log(data);  */
			 /* alert(data); */
			/*jQuery.post(ajax_object.ajax_url, data, function(response) {
					
			}); */
			
        });
        //Open the uploader dialog
        custom_uploader.open();
   });
});