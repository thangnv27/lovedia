var User = function(){
    return {
        login:function(){
            $("form#loginform").submit(function(){
                var valid = true;
                var msg = "<p>Các trường có dấu * là bắt buộc!</p>";
                
                $("form#loginform input[type='text'], form#loginform input[type='password']").each(function(){
                    if($(this).val().length == 0){
                        $(this).parent('span.input-text').css({
                            'border': '1px solid red'
                        });
                        valid = false;
                    }else{
                        $(this).parent('span.input-text').css({
                            'border': '1px solid #CCCCCC'
                        });
                    }
                });
                
                if(!valid){
                    $("#message").html(msg).addClass('warning');
                    return false;
                }
            });
        },
        register:function(){
            $("form#registerform").submit(function(){
                var valid = true;
                var msg = "<p>Các trường có dấu * là bắt buộc!</p>";
                var emailField = $("form#registerform #user_email");
                var pwd1 = $("form#registerform #user_pass");
                var pwd2 = $("form#registerform #user_pass2");
                
                $("form#registerform input[type='text'], form#registerform input[type='password']").each(function(){
                    if($(this).attr('name') != 'user_dob_year'){
                        if($(this).val().length == 0){
                            $(this).parent('span.input-text').css({
                                'border': '1px solid red'
                            });
                            valid = false;
                        }else{
                            $(this).parent('span.input-text').css({
                                'border': '1px solid #CCCCCC'
                            });
                        }
                    }
                });
                if(pwd2.val() != pwd1.val()){
                    pwd2.parent('span.input-text').css({
                        'border': '1px solid red'
                    });
                    valid = false;
                    msg += "<p>Xác nhận mật khẩu không chính xác!</p>";
                }else{
                    pwd2.parent('span.input-text').css({
                        'border': '1px solid #CCCCCC'
                    });
                }
                if(!isValidEmail(emailField.val())){
                    emailField.parent('span.input-text').css({
                        'border': '1px solid red'
                    });
                    valid = false;
                    msg += "<p>Địa chỉ email không hợp lệ!</p>";
                }else{
                    emailField.parent('span.input-text').css({
                        'border': '1px solid #CCCCCC'
                    });
                }
                
                if(!valid){
                    $("#message").html(msg).addClass('warning');
                    return false;
                }
            });
        }
    }
}();
var TSlider = function(){
    return {
        home:function(){
            $(window).load(function() {
                $('#home_slider').nivoSlider({
                    directionNav: false,
                    controlNavThumbs: true,
                    pauseTime: 6000
                });
            });
        }
    }
}();
var Lightbox = function(){
    return {
        detailPost: function(){
            $('#post_main .post .post-content img').each(function(){
                $(this).attr('href', $(this).attr('src')).css({
                    'cursor': 'pointer'
                });
            }).lightBox({
                imageLoading: themeUrl + '/images/lightbox-ico-loading.gif',
                imageBtnPrev: themeUrl + '/images/lightbox-btn-prev.gif',
                imageBtnNext: themeUrl + '/images/lightbox-btn-next.gif',
                imageBtnClose: themeUrl + '/images/lightbox-btn-close.gif',
                imageBlank: themeUrl + '/images/lightbox-blank.gif'
            });
        }
    }
}();
var FixedColumn = function(){
    return {
        pageQA:function(){
            var summaries = $('#main_qa .entries .entry .content');
            summaries.each(function(i) {
                var summary = $(summaries[i]);
                var next = summaries[i + 1];

                summary.scrollToFixed({
                    marginTop: $('#wpadminbar').outerHeight(true),
                    limit: function() {
                        var limit = 0;
                        if (next) {
                            limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                        } else {
                            // footer offset top
                            limit = $('#main_qa .entries .entry_bottom').offset().top - $(this).outerHeight(true) - 10;
                        }
                        return limit;
                    },
                    zIndex: 999
                });
            });
        },
        singleQA:function(){
            var summaries = $('#post_main .post_bar');
            summaries.each(function(i) {
                var summary = $(summaries[i]);
                var next = summaries[i + 1];

                summary.scrollToFixed({
                    marginTop: $('#wpadminbar').outerHeight(true),
                    limit: function() {
                        var limit = 0;
                        if (next) {
                            limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                        } else {
                            // footer offset top
                            limit = $('#footer').offset().top - $(this).outerHeight(true) - 10;
                        }
                        return limit;
                    },
                    zIndex: 999
                });
            });
        }
    }
}();

// Run
$(function(){
    $("#menu-top-menu li.last").css({
        'background': 'none',
        'padding-right': 0
    });
    $("#menu-top-menu li ul.sub-menu").each(function(){
        var left = $(this).parent().offset().left - $(".top-nav").offset().left;
        $(this).css({
            'padding-left': left,
            'width': 940 - left
        });
    });
    
    $("#tabs_news").tabs();
    $("#sidebar .most-posts").tabs();
    //$("#tabs_post_question").tabs();
    
    $("#backToTop").click(function(){
        scrollToElement("#top_content");
    });
});