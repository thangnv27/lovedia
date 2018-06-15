$(function(){
    function dragOver(){
        $("#drop a").addClass('drag-over').parent().addClass('drag-over');
    }
    function dragEnd(){
        $("#drop a").removeClass('drag-over').parent().removeClass('drag-over');
    }

    var ul = $('#upload ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });
    $('#drop').bind('dragover',function( event ){
        $( this ).addClass('drag-over').children('a').addClass('drag-over');
    }).bind('dragleave',function( event ){
        $( this ).removeClass('drag-over').children('a').removeClass('drag-over');
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({
        dataType: 'json',

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {

            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });
                
                $("#upload #img_url").val('').removeAttr('disabled');
                $('#drop a').show();
                dragEnd();

            });

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },
        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if(progress == 100){
                data.context.removeClass('working');
            }
            
            if(ul.find("li").length > 1){
                ul.find("li").each(function(index){
                    if(index != ul.find("li").length -1){
                        ul.find("li").eq(index).remove();
                    }
                });
            }
            $('#drop a').hide();
        },
        done: function (e, data) {
            if(data.result.status == "success"){
                $("#upload #img_url").val(data.result.tmp_url).attr("disabled", "disabled");
                $("#message").addClass('success').removeClass('warning').html("<p>File đã được tải lên thành công!</p>");
            }else if(data.result.status == "error"){
                $("#message").addClass('warning').removeClass('success').html(data.result.message);
                ul.find("li").each(function(index){
                    ul.find("li").eq(index).remove();
                });
                $('#img_url').removeAttr('disabled').val('');
                $('#drop a').show();
                dragEnd();
            }
            scrollToElement("#message");
        },
        fail:function(e, data){
            // Something has gone wrong!
            data.context.addClass('error');
            $('#drop a').show();
            dragEnd();
        }

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

});