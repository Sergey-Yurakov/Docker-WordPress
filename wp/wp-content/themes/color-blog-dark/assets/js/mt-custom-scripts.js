jQuery(document).ready(function($) {

    "use strict";

    /**
     * Color Blog Dark Preloader
     */
    if($('#preloader-background').length > 0) {
        setTimeout(function(){$('#preloader-background').hide();}, 600);
    }

    var grid = document.querySelector(
            '.color-blog-dark-content-masonry'
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
        $('.mt-form-wrap').toggleClass('search-activate');
        $('.mt-form-wrap .search-field').focus();
        var element = document.querySelector( '.mt-form-wrap.search-activate' );
        if( element ) {
            $(document).on('keydown', function(e) {
                var focusable = element.querySelectorAll( 'input, button, [href], select, textarea, [tabindex]:not([tabindex="-1"])');
                var firstFocusable = focusable[0];
                var lastFocusable = focusable[focusable.length - 1];
                color_blog_dark_focus_trap( firstFocusable, lastFocusable, e );
            })
        }
    });

    /**
     * Focus trap in popup.
     */
    var KEYCODE_TAB = 9;
    function color_blog_dark_focus_trap( firstFocusable, lastFocusable, e ) {
        if (e.key === 'Tab' || e.keyCode === KEYCODE_TAB) {
            if ( e.shiftKey ) /* shift + tab */ {
                if (document.activeElement === firstFocusable) {
                    lastFocusable.focus();
                    e.preventDefault();
                }
            } else /* tab */ {
                if ( document.activeElement === lastFocusable ) {
                    firstFocusable.focus();
                    e.preventDefault();
                }
            }
        }
    }

    $('.mt-form-wrap .mt-form-close').click(function() {
        $('.mt-form-wrap').toggleClass('search-activate');
        $(this).parents('.mt-menu-search').find('.mt-search-icon a').focus();
    });

    /**
     * Close popups on escape key.
     */
    $( document ).on( 'keydown', function( event ) {
        if ( event.keyCode === 27 ) {
            event.preventDefault();
            //$( '.primary-menu-wrap' ).removeClass( 'menu-active' );
            $( '.mt-menu-search .mt-form-wrap' ).removeClass( 'search-activate' );
        }
    });

    /**
     * Settings about WOW animation
     */
    var wowOption = color_blog_darkObject.wow_effect;
    if( wowOption === 'on' ) {
        new WOW().init();
    }

    /**
     * Settings about sticky menu
     */
    var stickyOption = color_blog_darkObject.menu_sticky;
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
     * Slider scripts
     */
    $('.front-slider').lightSlider({
        pager: false,
        auto: false,
        loop: true,
        item: 1,
        controls: true,
        slideMargin:0,
        rtl:true,
        nextHtml: '<span class="icon-prev"><i class="fa fa-angle-left"></i></span>',
        prevHtml: '<span class="icon-next"><i class="fa fa-angle-right"></i></span>',

        onSliderLoad: function() {
            $('.front-slider').removeClass('cS-hidden');
        }
        
    });

    /**
     * Slider scripts
     */
    $('.mt-gallery-slider').lightSlider({
        pager: false,
        auto: false,
        loop: true,
        item: 1,
        controls: true,
    });

    /**
     * Responsive menu
     */

    $('.mt-social-menu-wrapper .menu-toggle').click(function(event) {
        $('.mt-social-menu-wrapper #site-navigation').toggleClass( 'isActive' ).slideToggle('slow');
        var element = document.querySelector( '.mt-header-menu-wrap' );
        if( element ) {
            $(document).on('keydown', function(e) {
                if( element.querySelectorAll( '.mt-social-menu-wrapper #site-navigation.isActive' ).length === 1 ) {
                    var focusable = element.querySelectorAll( 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                    var firstFocusable = focusable[0];
                    var lastFocusable = focusable[focusable.length - 1];
                    color_blog_dark_focus_trap( firstFocusable, lastFocusable, e );
                }
            })
        }
    });

    /**
     * responsive sub menu toggle
     */
    $('<a href="javascript:void(0);" class="sub-toggle"><i class="fa fa-angle-right"></i></a>').insertAfter('#site-navigation .menu-item-has-children>a, #site-navigation .page_item_has_children>a');

    $('#site-navigation .sub-toggle').click(function() {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).parent('.page_item_has_children').children('ul.children').first().slideToggle('1000');
        $(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
    });

    /**
     * Slider Section dynamic height script
     */
    $(window).on('load', function() {
        if ($(window).width() > 839) {
            $(".front-slider-wrapper").each(function() {
                var imageHeight = $(this).height();
                $(this).find(".slider-post-wrap").css('height', imageHeight);
                $(this).find(".front-slider ").css('height', imageHeight);
            });
        }
    });

});