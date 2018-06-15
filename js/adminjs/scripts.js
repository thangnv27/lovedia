/* 
 * @Author: Ngo Van Thang
 * @Email: ngothangit@gmail.com
 */

var CustomJS = function(){
    return {
        uploadSingleImage: function($){
            var fields = new Array("favicon", "sitelogo", "logo2", "banner_top");
            
            $.each(fields, function(index, field){
                var custom_uploader;
                $('#upload_' + field + '_button').click(function(e) {
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
                        $('#' + field).val(attachment.url);
                    });

                    //Open the uploader dialog
                    custom_uploader.open();
                });
            });
        },
        uploadAds: function($){
            $('#upload_media_button').click(function(e) {
                var custom_uploader;
                e.preventDefault();
 
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
 
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    frame: 'select', // 'post'
                    state: 'upload_media',
                    multiple: false,
                    //library: { type : 'image' },
                    button: { text: 'Close' }
                });
                custom_uploader.states.add([
                    new wp.media.controller.Library({
                        id: 'upload_media',
                        title:  'Upload Media',
                        priority:   20,
                        toolbar:    'select',
                        filterable: 'uploaded',
                        library:    wp.media.query( custom_uploader.options.library ),
                        multiple:   custom_uploader.options.multiple ? 'reset' : false,
                        editable:   true,
                        displayUserSettings: false,
                        displaySettings: true,
                        allowLocalEdits: true
                        //AttachmentView: ?
                    }),
                ]);
 
                //Open the uploader dialog
                custom_uploader.open();
            });
            
            var fields = new Array("ad_home_category", "ad_home_category2", "ad_above_footer", "ad_archive");
            
            $.each(fields, function(index, field){
                var custom_uploader;
                $('#upload_' + field + '_button').click(function(e) {
                    e.preventDefault();

                    //If the uploader object has already been created, reopen the dialog
                    if (custom_uploader) {
                        custom_uploader.open();
                        return;
                    }

                    //Extend the wp.media object
                    custom_uploader = wp.media.frames.file_frame = wp.media({
                        frame: 'select', // 'post'
                        state: 'choose_file',
                        button: {
                            text: 'Choose File'
                        },
                        multiple: false
                    });
                    custom_uploader.states.add([
                        new wp.media.controller.Library({
                            id: 'choose_file',
                            title:  'Choose File',
                            priority:   20,
                            toolbar:    'select',
                            filterable: 'uploaded',
                            library:    wp.media.query( custom_uploader.options.library ),
                            multiple:   custom_uploader.options.multiple ? 'reset' : false,
                            editable:   true,
                            displayUserSettings: false,
                            displaySettings: true,
                            allowLocalEdits: true
                            //AttachmentView: ?
                        }),
                    ]);

                    //When a file is selected, grab the URL and set it as the text field's value
                    custom_uploader.on('select', function() {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        var url = attachment.url;
                        var embed = "";
                        if(url.lastIndexOf('.swf', url) != -1){
                            embed = '<object class="flash" width="100%" height="90"\
                                classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"\
                                codebase="http://fpdownload.macromedia.com/\
                                pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">\
                                <param name="SRC" value="' + url + '">\
                                <embed class="flash" src="' + url + '" width="100%" height="90"></embed>\
                                </object>';
                        }else{
                            embed = '<a href="target_link"><img src="' + url + '" /></a>';
                        }
                        $('#' + field).val(embed);
                    });

                    //Open the uploader dialog
                    custom_uploader.open();
                });
            });
        }
    }
}();

// Run
jQuery(document).ready(function($){
    CustomJS.uploadSingleImage($);
    CustomJS.uploadAds($);
});