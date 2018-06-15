var disabledConfirm_exit=false;
var Post = function(){
    return {
        QAInsertPostContent:function($, title, content, tags){
            scrollToElement("#message");
            
            var message = $("#message");
            message.addClass('ajax-loading');
            
            $.ajax({  
                type: 'POST',  
                url: siteUrl + '/wp-admin/admin-ajax.php?action=QA_insert_post_content',  
                data: $("#frmPostContent").serialize(),
                dataType: 'json',
                cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status == 'success'){
                        message.addClass('success').removeClass('warning').html("<p>Đăng bài thành công!</p>");
                        
                        setTimeout(function(){
                            window.location = pageQAUrl;
                        }, 3000);
                    }else if(response.status == 'error'){
                        message.addClass('warning').removeClass('success').html("<p>"+response.message+"</p>");
                        $("#captcha_content_img").attr('src', themeUrl + '/includes/captcha.php'+'?'+Math.random());
                    }
                },  
                error: function(MLHttpRequest, textStatus, errorThrown){
                    message.addClass('warning').removeClass('success').html("<p>" + errorThrown + "</p>");
                },
                complete:function(){
                    message.removeClass('ajax-loading');
                    // empty value
                    title.val('');
                    tags.val('');
                    $("#captcha_content").val('');
                }
            }); 
        },
        QAInsertPostPhoto:function($, title, img_url, img_tags){
            scrollToElement("#message");
            
            var ul = $('#upload ul');
            var message = $("#message");
            message.addClass('ajax-loading');
            
            $.ajax({  
                type: 'POST',  
                url: siteUrl + '/wp-admin/admin-ajax.php',  
                data: {
                    action: 'QA_insert_post_photo',
                    title: title,
                    img_url: img_url,
                    img_tags: img_tags,
                    captcha: $("#captcha_photo").val()
                },
                dataType: 'json',
                cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status == 'success'){
                        message.addClass('success').removeClass('warning').html("<p>Đăng bài thành công!</p>");
                        
                        ul.find("li").each(function(index){
                            ul.find("li").eq(index).remove();
                        });
                        
                        setTimeout(function(){
                            window.location = pageQAUrl;
                        }, 3000);
                    }else if(response.status == 'error'){
                        message.addClass('warning').removeClass('success').html("<p>"+response.message+"</p>");
                        $("#captcha_photo_img").attr('src', themeUrl + '/includes/captcha.php'+'?'+Math.random());
                    }
                },  
                error: function(MLHttpRequest, textStatus, errorThrown){
                    message.addClass('warning').removeClass('success').html("<p>" + errorThrown + "</p>");
                },
                complete:function(){
                    message.removeClass('ajax-loading');
                    // empty value
                    title.val('');
                    img_url.removeAttr('disabled').val('');
                    img_tags.val('');
                    $("#captcha_photo").val('');
                }
            }); 
        },
        QAPostCancel:function($){
            scrollToElement("#message");
            
            var message = $("#message");
            message.addClass('ajax-loading');
            
            $.ajax({  
                type: 'POST',  
                url: siteUrl + '/wp-admin/admin-ajax.php',  
                data: {
                    action: 'QA_post_cancel'
                },
                dataType: 'json',
                cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                },  
                error: function(MLHttpRequest, textStatus, errorThrown){
                },
                complete:function(){
                    window.location = pageQAUrl;
                }
            }); 
        },
        leavePagePostQA:function(){
            $.ajax({  
                type: 'POST',  
                url: siteUrl + '/wp-admin/admin-ajax.php',  
                data: {
                    action: 'QA_post_cancel'
                },
                dataType: 'json',
                cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                },  
                error: function(MLHttpRequest, textStatus, errorThrown){
                },
                complete:function(){
                }
            }); 
        },
        addNewPostQA:function($){
            scrollToElement("#message");
            var title = $('#post_title');
            var img_url = $('#img_url');
            var post_content = $('#post_content');
            var post_tags = $('#post_tags');
            var captcha = $('#captcha');
            var ul = $('#upload ul');
            var message = $("#message");
            message.addClass('ajax-loading');
            
            $.ajax({  
                type: 'POST',  
                url: siteUrl + '/wp-admin/admin-ajax.php',  
                data: {
                    action: 'QA_insert_new_post',
                    title: title.val(),
                    img_url: img_url.val(),
                    post_content: post_content.val(),
                    post_tags: post_tags.val(),
                    captcha: captcha.val()
                },
                dataType: 'json',
                cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                    if(response && response.status == 'success'){
                        message.addClass('success').removeClass('warning').html("<p>Đăng bài thành công!</p>");
                        
                        ul.find("li").each(function(index){
                            ul.find("li").eq(index).remove();
                        });
                        
                        disabledConfirm_exit=true;
                        
                        // empty value
                        title.val('');
                        img_url.removeAttr('disabled').val('');
                        post_content.val('');
                        post_tags.val('');
                        
                        setTimeout(function(){
                            window.location = pageQAUrl;
                        }, 3000);
                    }else if(response.status == 'error'){
                        message.addClass('warning').removeClass('success').html(response.message);
                        $("#captcha_img").attr('src', themeUrl + '/includes/captcha.php'+'?'+Math.random());
                    }
                },  
                error: function(MLHttpRequest, textStatus, errorThrown){
                    message.addClass('warning').removeClass('success').html("<p>" + errorThrown + "</p>");
                },
                complete:function(){
                    message.removeClass('ajax-loading');
                    // empty value
                    captcha.val('');
                }
            }); 
        }
    }
}();

jQuery(document).ready(function($) {  
    /*$("#btnPostContent").click(function(){
        tinyMCE.triggerSave();
        Post.QAInsertPostContent($, $("#post_title"), $("#post_content"), $("#post_tags"));
    });
        
    $("#btnPostPhoto").click(function(){
        Post.QAInsertPostPhoto($, $("#photo_title").val(), $("#img_url").val(), $("#img_tags").val());
    });
    
    $("#tabs_post_question .btnCancel").click(function(){
        Post.QAPostCancel($);
    }); */
    
    $("#post_qa input.btn-cancel").click(function(){
        Post.QAPostCancel($);
    });
    
    $("#post_qa input.btn-submit").click(function(){
        tinyMCE.triggerSave();
        Post.addNewPostQA($);
    });
}); 