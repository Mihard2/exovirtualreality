function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}
function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}

(function ($) {
    $(document).ready(function () {

        $('#btn-like-yes').on('click',function(e){
            e.preventDefault();
            $('#container-like-y').show();
            $('#like-question').hide();

            var coockie_expire = new Date();
            coockie_expire.setDate(coockie_expire.getDate() + 10);
            setCookie('like_answer','y',{expires:coockie_expire,path:'/'});
            if (typeof exovirtual_account != 'undefined'){
                if (exovirtual_account.account_id!=0){
                    setCookie('account',exovirtual_account.account_id,{expires:coockie_expire,path:'/'});
                    if (exovirtual_account.subscription) window.location.href=exovirtual_account.subscription;
                }
            }
        });

        /*setTimeout(function () {
            $('.fusion-faq-shortcode .fusion-panel').first().find('a.collapsed').trigger('click');
        },1000);*/

        $('.fusion-faq-shortcode .fusion-panel').first().find('a.collapsed').removeClass('collapsed').addClass('active');
        $('.fusion-faq-shortcode .fusion-panel').first().find('.panel-collapse').addClass('in').css('height','auto');
    })
})(jQuery);