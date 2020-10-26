jQuery(document).ready(function($) {

    "use strict";

    /**
     * Preloader
     */
    if($('#preloader-background').length > 0) {
        setTimeout(function(){$('#preloader-background').hide();}, 600);
    }

    var grid = document.querySelector(
            '.saaya-content-masonry'
        ),
        masonry;

    if (
        grid &&
        typeof Masonry !== undefined &&
        typeof imagesLoaded !== undefined
    ) {
        imagesLoaded( grid, function( instance ) {
            masonry = new Masonry( grid, {
                itemSelector: '.hentry'
            } );
        } );
    }


    /**
     * Header Search script
     */
    $('.mt-menu-search .mt-search-icon').click(function() {
        $('.mt-menu-search .mt-form-wrap').toggleClass('search-activate');
    });

    $('.mt-menu-search .mt-form-close').click(function() {
        $('.mt-menu-search .mt-form-wrap').removeClass('search-activate');
    });


    /**
     * Settings about WOW animation
     */
    var wowOption = saayaBlogObject.wow_effect;
    if( wowOption === 'on' ) {
        new WOW().init();
    }

    /**
     * Settings about sticky menu
     */
    var stickyOption = saayaBlogObject.menu_sticky;
    if( stickyOption === 'on' ) {
        var windowWidth = $( window ).width();
        if( windowWidth < 500 ) {
            var wpAdminBar = 0;
        } else {
            var wpAdminBar = $('#wpadminbar');
        }
        if ( wpAdminBar.length ) {
          $(".mt-social-menu-wrapper").sticky({topSpacing:wpAdminBar.height()});
        } else {
          $(".mt-social-menu-wrapper").sticky({topSpacing:0});
        }
    }
    
    /**
     * Scroll To Top
     */
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1000) {
            $('#mt-scrollup').fadeIn('slow');
        } else {
            $('#mt-scrollup').fadeOut('slow');
        }
    });
    $('#mt-scrollup').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
    
    /**
     * Responsive
     */
    $('.menu-toggle').click(function(event) {
        $('#site-navigation').slideToggle('slow');
    });

    /**
     * responsive sub menu toggle
     */
    $('#site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');
    $('#site-navigation .page_item_has_children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');
    

    $('#site-navigation .sub-toggle').click(function() {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).parent('.page_item_has_children').children('ul.children').first().slideToggle('1000');
        $(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
    });


});