(function($) {

    "use strict";

    $(document).ready(function() {

        /* Logo check */

        vlog_logo_setup();

        /* Sticky header */

        if (vlog_js_settings.header_sticky) {

            var vlog_last_top;

            if ($('#wpadminbar').length && $('#wpadminbar').is(':visible')) {
                $('.vlog-sticky-header').css('top', $('#wpadminbar').height());
            }

            $(window).scroll(function() {

                var top = $(window).scrollTop();

                if (vlog_js_settings.header_sticky_up) {
                    if (vlog_last_top > top && top >= vlog_js_settings.header_sticky_offset) {
                        if (!$("body").hasClass('vlog-header-sticky-on')) {
                            $("body").addClass("vlog-sticky-header-on");
                        }
                    } else {
                        $("body").removeClass("vlog-sticky-header-on");
                        $('.vlog-sticky-header .vlog-action-search.active i').addClass('fv-search').removeClass('fv-close');
                        $('.vlog-sticky-header .vlog-actions-button').removeClass('active');

                    }
                } else {
                    if (top >= vlog_js_settings.header_sticky_offset) {
                        if (!$("body").hasClass('vlog-header-sticky-on')) {
                            $("body").addClass("vlog-sticky-header-on");
                        }
                    } else {
                        $("body").removeClass("vlog-sticky-header-on");
                        $('.vlog-sticky-header .vlog-action-search.active i').addClass('fv-search').removeClass('fv-close');
                        $('.vlog-sticky-header .vlog-actions-button').removeClass('active');

                    }

                }

                vlog_last_top = top;
            });
        }

        /* Top bar height check and admin bar fixes*/

        var vlog_admin_top_bar_height = 0;
        vlog_top_bar_check();

        function vlog_top_bar_check() {
            if ($('#wpadminbar').length && $('#wpadminbar').is(':visible')) {
                vlog_admin_top_bar_height = $('#wpadminbar').height();

            }

            vlog_responsive_header();

        }

        function vlog_responsive_header() {

            if ($('.vlog-responsive-header').length) {

                $('.vlog-responsive-header').css('top', vlog_admin_top_bar_height);



                if (vlog_admin_top_bar_height > 0 && $('#wpadminbar').css('position') == 'absolute') {

                    if ($(window).scrollTop() <= vlog_admin_top_bar_height) {
                        $('.vlog-responsive-header').css('position', 'absolute');
                    } else {
                        $('.vlog-responsive-header').css('position', 'fixed').css('top', 0);
                    }

                }

            }
        }

        $(window).scroll(function() {

            vlog_responsive_header();

        });


        /* Secondary menus in responsive menu */
        if (vlog_js_settings.rensponsive_secondary_nav) {

            var mobile_nav = $('.vlog-mob-nav');
            var secondary_navigation = $('.secondary-navigation');
            var secondary_nav_html = '';
            if (secondary_navigation.length) {

                secondary_navigation.each(function() {
                    secondary_nav_html += $(this).find('ul:first').html();
                });

                if (vlog_js_settings.responsive_more_link) {
                    secondary_nav_html = '<li class="menu-item menu-item-has-children"><a href="#" class="vlog-menu-forward"><a href="#">' + vlog_js_settings.responsive_more_link + '</a></a><ul class="sub-menu">' + secondary_nav_html + '</ul></li>';
                }

                mobile_nav.append(secondary_nav_html);
            }
        }

        if (vlog_js_settings.responsive_social_nav) {

            var mobile_nav = $('.vlog-mob-nav');
            var social_nav = $('.vlog-soc-menu:first li').clone();
            var soc_nav_html = '';
            if (social_nav.length) {
                social_nav.each(function() {
                    soc_nav_html += $(this).html();
                });
                mobile_nav.append('<li class="vlog-soc-menu vlog-soc-responive-menu menu-item">' + soc_nav_html + '</li>');
            }
        }

        /* Check if Device is android and hide self-hosted player */

        if (/Android/i.test(navigator.userAgent)) {

            $('body').on('click', '.mejs-playpause-button button, .mejs-overlay-play', function(event) {
                var target = $(event.target);

                if (target.is("button") || target.is("div")) {
                    $('body').toggleClass('player-android-on');
                }

            });
        }

        /* Responsive menu */

        $('#dl-menu').dlmenu({
            animationClasses: {
                classin: 'dl-animate-in-2',
                classout: 'dl-animate-out-2'
            }
        });

        var vlog_cover_slider;

        /* Featured area sliders */
        $(".vlog-featured-slider").each(function() {
            vlog_cover_slider = $(this);
            vlog_cover_slider.owlCarousel({
                loop: true,
                autoHeight: false,
                autoWidth: false,
                items: 1,
                margin: 0,
                nav: true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                center: false,
                fluidSpeed: 100,
                mouseDrag: false,
                autoplay: parseInt(vlog_js_settings.cover_autoplay) ? true : false,
                autoplayTimeout: parseInt(vlog_js_settings.cover_autoplay_time) * 1000,
                autoplayHoverPause: true,
                onChanged: function(elem) {

                    var current = this.$element.find('.owl-item.active');
                    var format_content = current.find('.vlog-format-content');

                    if (format_content !== undefined && format_content.children().length !== 0) {

                        var item_wrap = current.find('.vlog-featured-item');
                        var cover = item_wrap.find('.vlog-cover');

                        if (cover.attr('data-action') == 'audio' || cover.attr('data-action') == 'video') {

                            var cover_bg = current.find('.vlog-cover-bg');
                            var inplay = item_wrap.find('.vlog-format-inplay');

                            format_content.html('');
                            format_content.fadeOut(300);
                            inplay.fadeOut(300);
                            cover.fadeIn(300);
                            item_wrap.find('.vlog-f-hide').fadeIn(300);
                            cover_bg.removeAttr('style');


                        }
                    }

                },
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            });

        });


        $('.vlog-featured-slider-4').owlCarousel({
            stagePadding: 200,
            loop: true,
            margin: 0,
            items: 1,
            center: true,
            nav: true,
            autoWidth: true,
            autoplay: parseInt(vlog_js_settings.cover_autoplay) ? true : false,
            autoplayTimeout: parseInt(vlog_js_settings.cover_autoplay_time) * 1000,
            autoplayHoverPause: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 200
                },
                600: {
                    items: 1,
                    stagePadding: 200
                },
                990: {
                    items: 1,
                    stagePadding: 200
                },
                1200: {
                    items: 1,
                    stagePadding: 250
                },
                1400: {
                    items: 1,
                    stagePadding: 300
                },
                1600: {
                    items: 1,
                    stagePadding: 350
                },
                1800: {
                    items: 1,
                    stagePadding: 768
                }
            }
        });

        /* Module slider */

        $(".vlog-slider").each(function() {
            var controls = $(this).closest('.vlog-module').find('.vlog-slider-controls');
            var module_columns = $(this).closest('.vlog-module').attr('data-col');
            var layout_columns = controls.attr('data-col');
            var slider_items = module_columns / layout_columns;
            var autoplay = parseInt(controls.attr('data-autoplay')) ? true : false;
            var autoplay_time = parseInt(controls.attr('data-autoplay-time')) * 1000;

            $(this).owlCarousel({
                rtl: (vlog_js_settings.rtl_mode === "true"),
                loop: true,
                autoHeight: false,
                autoWidth: false,
                items: slider_items,
                margin: 40,
                nav: true,
                center: false,
                fluidSpeed: 100,
                autoplay: autoplay,
                autoplayTimeout: autoplay_time,
                autoplayHoverPause: true,
                navContainer: controls,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                responsive: {
                    0: {
                        margin: 0,
                        items: (layout_columns <= 2) ? 2 : 1
                    },
                    1023: {
                        margin: 36,
                        items: slider_items
                    }
                }
            });
        });

        /* Widget slider */

        $(".vlog-widget-slider").each(function() {
            var $controls = $(this).closest('.widget').find('.vlog-slider-controls');

            $(this).owlCarousel({
                rtl: (vlog_js_settings.rtl_mode === "true"),
                loop: true,
                autoHeight: false,
                autoWidth: false,
                items: 1,
                nav: true,
                center: false,
                fluidSpeed: 100,
                margin: 0,
                navContainer: $controls,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            });
        });


        /* On window resize-events */

        $(window).resize(function() {
            // Don't do anything in full screen mode
            if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
                return;
            }
            vlog_sticky_sidebar();
            vlog_logo_setup();
            vlog_sidebar_switch();
            vlog_cover_height_fix();
            set_sticky_height_classic_layout();
            align_full_fix();
        });


        /* Check if there is colored section below featured area */

        $(".vlog-featured-1").each(function() {
            var $featured = $(this);
            var $vlog_bg = $(this).next();
            var $vlog_bg_color = $vlog_bg.css('background-color');

            if ($vlog_bg.hasClass('vlog-bg')) {
                $featured.css('background-color', $vlog_bg_color);
            }
        });



        /* Fitvidjs functionality on single posts */

        vlog_fit_videos($('.vlog-single-content .entry-media, .entry-content-single, .vlog-single-cover .vlog-popup-wrapper'));


        /* Highlight area hovers */

        $('body').on('mouseenter', '.vlog-featured .vlog-highlight .entry-title a,.vlog-featured .vlog-highlight .action-item,.vlog-active-hover .entry-title,.vlog-active-hover .action-item', function() {

            $(this).siblings().stop().animate({
                opacity: 0.4
            }, 150);
            $(this).parent().siblings().stop().animate({
                opacity: 0.4
            }, 150);
            $(this).parent().parent().siblings().stop().animate({
                opacity: 0.4
            }, 150);
        });

        $('body').on('mouseleave', '.vlog-featured .vlog-highlight .entry-title a,.vlog-featured .vlog-highlight .action-item,.vlog-active-hover .entry-title,.vlog-active-hover .action-item', function() {

            $(this).siblings().stop().animate({
                opacity: 1
            }, 150);
            $(this).parent().siblings().stop().animate({
                opacity: 1
            }, 150);
            $(this).parent().parent().siblings().stop().animate({
                opacity: 1
            }, 150);
        });

        /* Header search */

        $('body').on('click', '.vlog-action-search span', function() {

            $(this).find('i').toggleClass('fv-close', 'fv-search');
            $(this).closest('.vlog-action-search').toggleClass('active');
            setTimeout(function() {
                $('.active input[type="text"]').focus();
            }, 150);

            if ($('.vlog-responsive-header .vlog-watch-later, .vlog-responsive-header .vlog-listen-later').hasClass('active')) {
                $('.vlog-responsive-header .vlog-watch-later, .vlog-responsive-header .vlog-listen-later').removeClass('active');
            }

        });

        $('body').on('click', '.vlog-responsive-header .vlog-watch-later span', function() {

            $(this).closest('.vlog-watch-later').toggleClass('active');
            $('body').toggleClass('vlog-watch-later-active');
            $('.vlog-responsive-header .vlog-action-search').removeClass('active').find('i').removeClass('fv-close');
            $('.vlog-responsive-header .vlog-watch-later.active .sub-menu').css('width', $(window).width()).css('height', $(window).height());


        });

        $('body').on('click', '.vlog-responsive-header .vlog-listen-later span', function() {

            $(this).closest('.vlog-listen-later').toggleClass('active');
            $('.vlog-responsive-header .vlog-action-search').removeClass('active').find('i').removeClass('fv-close');
            $('.vlog-responsive-header .vlog-listen-later.active .sub-menu').css('width', $(window).width()).css('height', $(window).height());


        });

        $(document).on('click', function(evt) {
            if (!$(evt.target).is('.vlog-responsive-header .vlog-action-search')) {
                if ($('.vlog-responsive-header').hasClass('vlog-res-open')) {
                    $(".vlog-responsive-header .dl-trigger").trigger("click");
                }

                $('.vlog-responsive-header .vlog-action-search.active .sub-menu').css('width', $(window).width());
            }
        });

        /* On images loaded events */

        $('body').imagesLoaded(function() {
            vlog_sticky_sidebar();
            vlog_sidebar_switch();

        });


        $('.vlog-cover-bg:first').imagesLoaded(function() {
            $('.vlog-cover').animate({
                opacity: 1
            }, 300);
        });


        /* Hendling url on ajax call for load more and infinite scroll case */
        if ($('.vlog-infinite-scroll').length || $('.vlog-load-more').length) {

            var vlog_url_pushes = [];
            var vlog_pushes_up = 0;
            var vlog_pushes_down = 0;

            var push_obj = {
                prev: window.location.href,
                next: '',
                offset: $(window).scrollTop(),
                prev_title: window.document.title,
                next_title: window.document.title
            };

            vlog_url_pushes.push(push_obj);
            window.history.pushState(push_obj, '', window.location.href);

            var last_up, last_down = 0;

            $(window).scroll(function() {
                if (vlog_url_pushes[vlog_pushes_up].offset != last_up && $(window).scrollTop() < vlog_url_pushes[vlog_pushes_up].offset) {

                    last_up = vlog_url_pushes[vlog_pushes_up].offset;
                    last_down = 0;
                    window.document.title = vlog_url_pushes[vlog_pushes_up].prev_title;
                    window.history.replaceState(vlog_url_pushes, '', vlog_url_pushes[vlog_pushes_up].prev); //1

                    vlog_pushes_down = vlog_pushes_up;
                    if (vlog_pushes_up != 0) {
                        vlog_pushes_up--;
                    }
                }
                if (vlog_url_pushes[vlog_pushes_down].offset != last_down && $(window).scrollTop() > vlog_url_pushes[vlog_pushes_down].offset) {

                    last_down = vlog_url_pushes[vlog_pushes_down].offset;
                    last_up = 0;

                    window.document.title = vlog_url_pushes[vlog_pushes_down].next_title;
                    window.history.replaceState(vlog_url_pushes, '', vlog_url_pushes[vlog_pushes_down].next);

                    vlog_pushes_up = vlog_pushes_down;
                    if (vlog_pushes_down < vlog_url_pushes.length - 1) {
                        vlog_pushes_down++;
                    }

                }
            });

        }


        /* Load more button handler */
        var vlog_load_ajax_new_count = 0;

        $("body").on('click', '.vlog-load-more a', function(e) {

            e.preventDefault();
            var start_url = window.location.href;
            var prev_title = window.document.title;
            var $link = $(this);
            var page_url = $link.attr("href");

            $link.addClass('vlog-loader-active');
            $('.vlog-loader').show();
            $("<div>").load(page_url, function() {
                var n = vlog_load_ajax_new_count.toString();
                var $wrap = $link.closest('.vlog-module').find('.vlog-posts');
                var $new = $(this).find('.vlog-module:last article').addClass('vlog-new-' + n);
                var $this_div = $(this);

                $new.imagesLoaded(function() {

                    $new.hide().appendTo($wrap).fadeIn(400);

                    if ($this_div.find('.vlog-load-more').length) {
                        $('.vlog-load-more').html($this_div.find('.vlog-load-more').html());
                        $('.vlog-loader').hide();
                        $link.removeClass('vlog-loader-active');
                    } else {
                        $('.vlog-load-more').fadeOut('fast').remove();
                    }

                    vlog_sticky_sidebar();

                    if (page_url != window.location) {

                        vlog_pushes_up++;
                        vlog_pushes_down++;
                        var next_title = $this_div.find('title').text();

                        var push_obj = {
                            prev: start_url,
                            next: page_url,
                            offset: $(window).scrollTop(),
                            prev_title: prev_title,
                            next_title: next_title
                        };

                        vlog_url_pushes.push(push_obj);
                        window.document.title = next_title;
                        window.history.pushState(push_obj, '', page_url);

                    }

                    vlog_load_ajax_new_count++;

                    return false;
                });

            });

        });


        /* Infinite scroll handler */
        var vlog_infinite_allow = true;

        if ($('.vlog-infinite-scroll').length) {
            $(window).scroll(function() {
                if (vlog_infinite_allow && $('.vlog-infinite-scroll').length && ($(this).scrollTop() > ($('.vlog-infinite-scroll').offset().top) - $(this).height() - 200)) {

                    var $link = $('.vlog-infinite-scroll a');
                    var page_url = $link.attr("href");
                    var start_url = window.location.href;
                    var prev_title = window.document.title;

                    if (page_url != undefined) {
                        vlog_infinite_allow = false;
                        $('.vlog-loader').show();
                        $("<div>").load(page_url, function() {
                            var n = vlog_load_ajax_new_count.toString();
                            var $wrap = $link.closest('.vlog-module').find('.vlog-posts');
                            var $new = $(this).find('.vlog-module:last article').addClass('vlog-new-' + n);
                            var $this_div = $(this);

                            $new.imagesLoaded(function() {

                                $new.hide().appendTo($wrap).fadeIn(400);

                                if ($this_div.find('.vlog-infinite-scroll').length) {
                                    $('.vlog-infinite-scroll').html($this_div.find('.vlog-infinite-scroll').html());
                                    $('.vlog-loader').hide();
                                    vlog_infinite_allow = true;
                                } else {
                                    $('.vlog-infinite-scroll').fadeOut('fast').remove();
                                }

                                vlog_sticky_sidebar();

                                if (page_url != window.location) {

                                    vlog_pushes_up++;
                                    vlog_pushes_down++;
                                    var next_title = $this_div.find('title').text();

                                    var push_obj = {
                                        prev: start_url,
                                        next: page_url,
                                        offset: $(window).scrollTop(),
                                        prev_title: prev_title,
                                        next_title: next_title
                                    };

                                    vlog_url_pushes.push(push_obj);
                                    window.document.title = next_title;
                                    window.history.pushState(push_obj, '', page_url);

                                }

                                vlog_load_ajax_new_count++;

                                return false;
                            });

                        });
                    }
                }
            });
        }

        /**
         * Check if is set some other laguage and return his language key to fix ajax request
         * @type mixed Sting or Null
         */
        var wpml_current_lang = vlog_js_settings.ajax_wpml_current_lang !== null ? '?wpml_lang=' + vlog_js_settings.ajax_wpml_current_lang : '';

        /* Cover format actions */

        var vlog_action_active = false;

        $("body").on('click', '.vlog-cover', function(e) {

            if( vlog_action_active ){
                return;
            }

            
            var action = $(this).attr('data-action');
            var container = $(this).closest('.vlog-cover-bg').find('.vlog-format-content');
            var item_wrap = $(this).closest('.vlog-featured-item');
            var cover_bg = $(this).closest('.vlog-cover-bg');
            var inplay = item_wrap.find('.vlog-format-inplay');

            if (action == 'video') {
                vlog_action_active = true;

                if (item_wrap.parent().hasClass('owl-item')) {
                    vlog_cover_slider.trigger('stop.owl.autoplay');
                }

                var data = {
                    action: 'vlog_format_content',
                    format: 'video',
                    display_playlist: $('.vlog-single-cover').length ? true : false,
                    id: $(this).attr('data-id')
                };

                var opener = $(this);

                opener.fadeOut(300, function() {
                    container.append('<div class="vlog-format-loader"><div class="uil-ripple-css"><div></div><div></div></div></div>');
                    container.fadeIn(300);


                    inplay.find('.container').html('');
                    inplay.find('.container').append(item_wrap.find('.entry-header').clone()).append(item_wrap.find('.entry-actions').clone());

                    $.post(vlog_js_settings.ajax_url + wpml_current_lang, data, function(response) {

                        container.find('.vlog-format-loader').remove();

                        container.append('<div class="vlog-popup-wrapper">' + response + '</div>');

                        vlog_fit_videos(container);

                        vlog_try_autoplay(container);

                        vlog_disable_related_videos(container);

                        item_wrap.find('.vlog-f-hide').fadeOut(300);

                        $('body').addClass('vlog-in-play');

                        setTimeout(function() {

                            var $playlist_list = $('.vlog-playlist');

                            if ($(window).width() > 768) {

                                var set_height = parseInt(container.find('.vlog-popup-wrapper').outerHeight()) + 72;

                                if (!$('.vlog-popup-wrapper > .vlog-cover-playlist-active').length) {
                                    set_height = set_height > vlog_js_settings.cover_height ? set_height : vlog_js_settings.cover_height;
                                    cover_bg.animate({
                                        height: set_height
                                    }, 300);
                                } else {
                                    cover_bg.css('height', 'auto');
                                    cover_bg.addClass('vlog-cover-playlist-active');
                                    item_wrap.addClass('vlog-playlist-mode-acitve');
                                }


                                var $video = cover_bg.find('.vlog-playlist-video iframe'),
                                    $script = cover_bg.find('.vlog-playlist-video script');

                                if (!$video.length && !$script.length) {
                                    $video = cover_bg.find('.vlog-playlist-video video');
                                }

                                // Fix for playwire
                                if ($script.length) {
                                    $(document).on('playwire-ready', function() {
                                        $playlist_list.find('.vlog-posts').css('height', $script.parent().height() - $playlist_list.find('.vlog-mod-head').height() - 25); // Fix for margin bottom
                                    });
                                } else {
                                    $playlist_list.find('.vlog-posts').css('height', $video.height() - $playlist_list.find('.vlog-mod-head').height() - 25); // Fix for margin bottom
                                }

                            } else {
                                cover_bg.css('height', 'auto');
                                cover_bg.parent().css('height', 'auto');
                                $playlist_list.css('height', 460);
                            }

                        }, 50);

                        inplay.slideDown(300);

                        vlog_action_active = false;

                    });

                });

            }

            if (action == 'audio') {

                vlog_action_active = true;

                if (item_wrap.parent().hasClass('owl-item')) {
                    vlog_cover_slider.trigger('stop.owl.autoplay');
                }

                var data = {
                    action: 'vlog_format_content',
                    format: 'audio',
                    id: $(this).attr('data-id')
                };

                var opener = $(this);


                opener.fadeOut(300, function() {
                    container.append('<div class="vlog-format-loader"><div class="uil-ripple-css"><div></div><div></div></div></div>');
                    container.fadeIn(300);

                    item_wrap.find('.vlog-f-hide').fadeOut(300);
                    $('body').addClass('vlog-in-play');

                    inplay.find('.container').html('');
                    inplay.find('.container').append(item_wrap.find('.entry-header').clone()).append(item_wrap.find('.entry-actions').clone());

                    $.post(vlog_js_settings.ajax_url + wpml_current_lang, data, function(response) {

                        //var $response = $($.parseHTML(response));
                        container.find('.vlog-format-loader').remove();
                        container.append('<div class="vlog-popup-wrapper">' + response + '</div>');
                        vlog_fit_videos(container);
                        vlog_try_autoplay(container);

                        setTimeout(function() {

                            if ($(window).width() > 768) {

                                var set_height = parseInt(container.find('.vlog-popup-wrapper').outerHeight()) + 72;

                                if (!$('.vlog-popup-wrapper > .vlog-cover-playlist-active').length) {
                                    set_height = set_height > vlog_js_settings.cover_height ? set_height : vlog_js_settings.cover_height;
                                }

                                cover_bg.animate({
                                    height: set_height
                                }, 300);
                            } else {
                                cover_bg.css('height', 'auto');
                                cover_bg.parent().css('height', 'auto');
                            }

                        }, 50);

                        inplay.slideDown(300);

                        vlog_action_active = false;

                    });

                });



            }

            if (action == 'gallery') {

                var items = [];

                container.find('.gallery-item, .blocks-gallery-item').each(function() {
                    items.push({
                        src: $(this).find('a').attr('href'),
                        caption: $(this).find('.wp-caption-text.gallery-caption').text()
                    });
                });


                $.magnificPopup.open({
                    items: items,
                    gallery: {
                        enabled: true
                    },
                    type: 'image',
                    image: {
                        titleSrc: function(item) {
                            var $caption = item.data.caption;
                            if ($caption != 'undefined') {
                                return $caption;
                            }
                            return '';
                        }
                    },
                    removalDelay: 300,
                    mainClass: 'mfp-with-fade',
                    closeBtnInside: false,
                    closeMarkup: '<button title="%title%" type="button" class="mfp-close"><i class="fv fv-close"></i></button>',
                    callbacks: {
                        open: function() {
                            $.magnificPopup.instance.next = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.next.call(self);
                                }, 120);
                            };
                            $.magnificPopup.instance.prev = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.prev.call(self);
                                }, 120);
                            };
                        },
                        imageLoadComplete: function() {
                            var self = this;
                            setTimeout(function() {
                                self.wrap.addClass('mfp-image-loaded');
                            }, 16);
                        }
                    }
                });

            }

            if (action == 'image') {

                var image = $(this).attr('data-image');
                var link = $(this);
                $.magnificPopup.open({
                    items: {
                        src: image,
                    },
                    type: 'image',
                    image: {
                        titleSrc: function(item) {
                            var $caption = link.parent().find('.wp-caption-text');
                            if ($caption !== undefined) {
                                return $caption.text();
                            }
                            return '';
                        }
                    },
                    removalDelay: 300,
                    mainClass: 'mfp-with-fade',
                    closeBtnInside: false,
                    closeMarkup: '<button title="%title%" type="button" class="mfp-close"><i class="fv fv-close"></i></button>',
                    callbacks: {
                        open: function() {
                            //overwrite default prev + next function. Add timeout for css3 crossfade animation
                            $.magnificPopup.instance.next = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.next.call(self);
                                }, 120);
                            };
                            $.magnificPopup.instance.prev = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.prev.call(self);
                                }, 120);
                            };
                        },
                        imageLoadComplete: function() {
                            var self = this;
                            setTimeout(function() {
                                self.wrap.addClass('mfp-image-loaded vlog-f-img');
                            }, 16);
                        }
                    }
                });
            }

        });


        /* Watch Later */

        $("body").on('click', '.action-item.watch-later', function(e) {
            e.preventDefault();

            var container = $('.vlog-watch-later');
            var counter = container.find('.vlog-watch-later-count');
            var posts = container.find('.vlog-menu-posts');
            var empty = container.find('.vlog-wl-empty');
            var what = $(this).attr('data-action');

            if (what == 'add') {

                $(this).find('i.fv').removeClass('fv-watch-later').addClass('fv-added');
                counter.text(parseInt(counter.first().text()) + 1);
                $(this).attr('data-action', 'remove');

            } else {

                $(this).find('i.fv').removeClass('fv-added').addClass('fv-watch-later');
                counter.text(parseInt(counter.first().text()) - 1);
                $(this).attr('data-action', 'add');
            }

            if (parseInt(counter.text()) > 0) {
                counter.fadeIn(300);
                empty.fadeOut(300);
            } else {
                counter.fadeOut(300);
                empty.fadeIn(300);
            }

            $(this).find('span').removeClass('hidden');
            $(this).find('span.' + what).addClass('hidden');

            var data = {
                action: 'vlog_watch_later',
                what: what,
                id: $(this).attr('data-id')
            };

            $.post(vlog_js_settings.ajax_url + wpml_current_lang, data, function(response) {
                posts.html(response);
            });

        });

        $("body").on('click', '.vlog-remove-wl', function(e) {
            e.preventDefault();

            var container = $('.vlog-watch-later');
            var counter = container.find('.vlog-watch-later-count');
            var empty = container.find('.vlog-wl-empty');
            var clicked_id = $(this).attr('data-id');
            var action_btn =  $('.action-item.watch-later');
            var post_id =  $('.action-item.watch-later').attr('data-id');

            counter.text(parseInt(counter.first().text()) - 1);
            container.find('[data-id="'+ clicked_id +'"]').closest('.wl-post').fadeOut(300).remove(); 

            if ( post_id == clicked_id ) {
                action_btn.attr('data-action','add');
                action_btn.find('i.fv').removeClass('fv-added').addClass('fv-watch-later');
                action_btn.find('span.add').removeClass('hidden');
                action_btn.find('span.remove').addClass('hidden');
            }  

            if (parseInt(counter.text()) == 0) {
                counter.fadeOut(300);
                empty.fadeIn(300);
            }

            var data = {
                action: 'vlog_watch_later',
                what: 'remove',
                id: $(this).attr('data-id')
            };

            $.post(vlog_js_settings.ajax_url + wpml_current_lang, data, function(response) {
                //posts.html(response);
            });

        });

        if (vlog_js_settings.watch_later_ajax && $('.vlog-watch-later').length) {
            $.post(vlog_js_settings.ajax_url + wpml_current_lang, {
                action: 'vlog_load_watch_later'
            }, function(response) {
                $('.vlog-watch-later').html(response);
            });
        }

        /* Listen Later */

        $("body").on('click', '.action-item.listen-later', function(e) {
            e.preventDefault();

            var container = $('.vlog-listen-later');
            var counter = container.find('.vlog-listen-later-count');
            var posts = container.find('.vlog-menu-posts');
            var empty = container.find('.vlog-ll-empty');
            var what = $(this).attr('data-action');

            if (what == 'add') {

                $(this).find('i.fv').removeClass('fv-listen-later').addClass('fv-listen-close');
                counter.text(parseInt(counter.first().text()) + 1);
                $(this).attr('data-action', 'remove');

            } else {

                $(this).find('i.fv').removeClass('fv-listen-close').addClass('fv-listen-later');
                counter.text(parseInt(counter.first().text()) - 1);
                $(this).attr('data-action', 'add');
            }

            if (parseInt(counter.text()) > 0) {
                counter.fadeIn(300);
                empty.fadeOut(300);
            } else {
                counter.fadeOut(300);
                empty.fadeIn(300);
            }

            $(this).find('span').removeClass('hidden');
            $(this).find('span.' + what).addClass('hidden');

            var data = {
                action: 'vlog_listen_later',
                what: what,
                id: $(this).attr('data-id')
            };

            $.post(vlog_js_settings.ajax_url + wpml_current_lang, data, function(response) {
                posts.html(response);
            });

        });

        $("body").on('click', '.vlog-remove-ll', function(e) {
            e.preventDefault();

            var container = $('.vlog-listen-later');
            var counter = container.find('.vlog-listen-later-count');
            var empty = container.find('.vlog-ll-empty');
            var clicked_id = $(this).attr('data-id');
            var action_btn =  $('.action-item.listen-later');
            var post_id =  $('.action-item.listen-later').attr('data-id');

            counter.text(parseInt(counter.first().text()) - 1);

            //$(this).closest('.vlog-menu-posts').fadeOut(300).remove();
            container.find('[data-id="'+ clicked_id +'"]').closest('.wl-post').fadeOut(300).remove(); 

            if ( post_id == clicked_id ) {
                action_btn.attr('data-action','add');
                action_btn.find('i.fv').removeClass('fv-listen-close').addClass('fv-listen-later');
                action_btn.find('span.add').removeClass('hidden');
                action_btn.find('span.remove').addClass('hidden');
            }  

            if (parseInt(counter.text()) == 0) {
                counter.fadeOut(300);
                empty.fadeIn(300);
            }

            var data = {
                action: 'vlog_listen_later',
                what: 'remove',
                id: $(this).attr('data-id')
            };

            $.post(vlog_js_settings.ajax_url + wpml_current_lang, data, function(response) {
                //posts.html(response);
            });

        });

        if (vlog_js_settings.listen_later_ajax && $('.vlog-listen-later').length) {
            $.post(vlog_js_settings.ajax_url + wpml_current_lang, {
                action: 'vlog_load_listen_later'
            }, function(response) {
                $('.vlog-listen-later').html(response);
            });
        }


        /* Cinema mode */

        var vlog_before_cinema_height;
        var vlog_before_cinema_width;

        $("body").on('click', '.action-item.cinema-mode', function(e) {
            e.preventDefault();

            var current_video = $(this).closest('.vlog-featured-item').find('.vlog-format-content');

            $(window).scrollTop(0);

            $('body').addClass('vlog-popup-on');
            current_video.addClass('vlog-popup');


            if ($('.vlog-featured-slider').length) {
                vlog_before_cinema_height = current_video.height();
                vlog_before_cinema_width = current_video.width();



                if ($(window).width() > 990) {
                    current_video.height($(window).height()).width($(window).width()).css('top', -$('.vlog-site-header').height()).css('marginTop', -$('.vlog-site-header').height() / 2);
                } else {
                    current_video.height($(window).height()).width($(window).width()).css('top', 0).css('marginTop', -$('.vlog-site-header').height() / 2);
                    $('.vlog-responsive-header').css('z-index', 0);
                    $('.owl-carousel').addClass('disable-owl-swipe');
                    $('body').on('touchmove', '.disable-owl-swipe', function(e) { e.stopPropagation(); });
                }

                var current_slide = $('.vlog-popup').parent().parent().parent();
                current_slide.attr('data-width', current_slide.width()).height($(window).height()).width($(window).width());

                $('.vlog-header-wrapper').css('z-index', 0);

            }

            if ($('.vlog-single-content .vlog-format-content').length && $(window).width() < 1367) {
                vlog_before_cinema_height = current_video.height();
                vlog_before_cinema_width = current_video.width();
                current_video.height($(window).height()).width($(window).width());
            }

            if (!current_video.find('.vlog-popup-wrapper').length) {
                current_video.closest('.vlog-cover-bg').find('.vlog-cover').click();
            }

            current_video.append('<a class="vlog-popup-close" href="javascript:void(0);"><i class="fv fv-close"></i></a>');
            if ($('.vlog-featured-slider').length) {
                $('.vlog-popup-close').css('top', $('.vlog-site-header').height() - 20);
            }

        });

        /* Quick view */
        $("body").on('click', '.vlog-quick-view', function(e) {
            e.preventDefault();

            var $this = $(this),
                id = $this.data('id');
            $('body').append('<div id="vlog-format-content-for-' + id + '" class="vlog-format-content video"><div class="vlog-popup-wrapper"></div></div>');
            var $icon = $this.find('.vlog-format-action'),
                $popup_content = $('body').find('#vlog-format-content-for-' + id),
                $popup_wrapper = $popup_content.find('.vlog-popup-wrapper'),
                data = {
                    action: 'vlog_format_content',
                    format: 'video',
                    id: id
                };

            $popup_wrapper.append('<div class="vlog-format-loader"><div class="uil-ripple-css"><div></div><div></div></div></div>');
            $('body').addClass('vlog-popup-on');

            $popup_content.addClass('vlog-popup');
            $popup_content.append('<a class="vlog-popup-close vlog-quick-view-close" href="javascript:void(0);" data-id="' + id + '"><i class="fv fv-close"></i></a>');

            $icon.fadeOut(300, function() {

                $.post(vlog_js_settings.ajax_url + wpml_current_lang, data, function(response) {

                    $popup_wrapper.append(response);

                    vlog_fit_videos($popup_content);
                    vlog_try_autoplay($popup_wrapper);
                    vlog_disable_related_videos($popup_content);

                    $icon.show();
                    $this.find('.vlog-format-loader').remove();

                    if ($popup_wrapper.find('script').length) {
                        $(document).on('playwire-ready', function() {
                            $playlist_list.find('.vlog-posts').css('height', $script.parent().height() - $playlist_list.find('.vlog-mod-head').height() - 25); // Fix for margin bottom
                        });
                    }

                });
            });

        });

        /* Close popup */

        $("body").on('click', '.vlog-popup-close', function(e) {

            if ($(this).hasClass('vlog-quick-view-close')) {

                var $this = $(this),
                    id = $this.data('id');

                $('#vlog-format-content-for-' + id + '.vlog-popup').removeClass('vlog-popup');
                $('body').removeClass('vlog-popup-on');
                $('body').find('> #vlog-format-content-for-' + id).remove();
                $('#vlog-format-content-for-' + id + ' > .vlog-popup-wrapper').html('');
                return;
            }

            var cover_bg = $(this).closest('.vlog-cover-bg');

            if ($('.vlog-featured-slider').length) {

                $(this).closest('.vlog-format-content').removeAttr('style');
                $('.vlog-header-wrapper').css('z-index', 10);
                var current_slide = $('.vlog-popup').parent().parent().parent();
                current_slide.removeAttr('style').css('width', current_slide.attr('data-width'));


            }

            if ($('.vlog-single-content .vlog-format-content').length && $(window).width() < 1367) {
                $(this).closest('.vlog-format-content').removeAttr('style');
            }

            $(this).closest('.vlog-format-content').removeClass('vlog-popup');

            $('body').removeClass('vlog-popup-on');
            $('.action-item, .entry-header').removeAttr('style');
            $(this).remove();
            $('.disable-owl-swipe').off('touchmove');
            $('.owl-carousel').removeClass('disable-owl-swipe');



            setTimeout(function() {
                var isFF = !!window.sidebar;
                if (isFF == true) {
                    cover_bg.removeAttr('style');
                }

                var height = cover_bg.get(0).scrollHeight;

                if( cover_bg.find('.flowplayer').length ) {
                    height = cover_bg.height();
                } 

                cover_bg.animate({
                    height: height
                }, 300);

            }, 50);

            if ($(window).width() < 990) {
                $('.vlog-responsive-header').removeAttr('style');
            }


        });

        /* Close popup on Escape */

        $(document).keyup(function(ev) {
            if (ev.keyCode == 27 && $('body').hasClass('vlog-popup-on')) {

                $('.vlog-popup-close').click();

            }
        });


        /* Cover in play mode */
        if ((vlog_js_settings.cover_inplay && $('.vlog-cover-bg').length && $('.vlog-cover-bg').hasClass('video')) || (vlog_js_settings.cover_inplay_audio && $('.vlog-cover-bg').length && $('.vlog-cover-bg').hasClass('audio'))) {

            var cover_bg = $('.vlog-cover-bg');
            vlog_fit_videos($('.vlog-format-content'));
            vlog_disable_related_videos(cover_bg);



            var $playlist_list = $('.vlog-playlist');

            if ($playlist_list.length) {

                setTimeout(function() {
                    var $video = cover_bg.find('.vlog-playlist-video iframe'),
                        $script = cover_bg.find('.vlog-playlist-video script');

                    if (!$video.length && !$script.length) {
                        $video = cover_bg.find('.vlog-playlist-video video');
                    }

                    // Fix for playwire
                    if (!$script.length) {
                        $playlist_list.find('.vlog-posts').css('height', $video.height() - $playlist_list.find('.vlog-mod-head').height() - 25);
                    } else {
                        $playlist_list.find('.vlog-posts').css('height', $script.parent().height() - $playlist_list.find('.vlog-mod-head').height() - 25); // Fix for margin bottom
                    }

                    $('.vlog-cover-bg').animate({
                        height: cover_bg.get(0).scrollHeight
                    }, 300);
                    $('.vlog-format-inplay').slideDown(300);

                }, 500);
            } else {
                $('.vlog-cover-bg').animate({
                    height: cover_bg.get(0).scrollHeight
                }, 300);
                $('.vlog-format-inplay').slideDown(300);
            }

            /* playwire support */
            setTimeout(function() {
                if (cover_bg.find('iframe').hasClass('zeus_iframe') && $(window).width() > 1240) {
                    var h = cover_bg.find('.vlog-popup-wrapper div').height();
                    if (h > 500) {
                        cover_bg.css('height', h + 70);
                    }
                }
            }, 1000);
        }


        $(document).on('playwire-ready', function() {
            $('.vlog-cover-playlist-active').css('margin-bottom', '40px');
            $playlist_list.find('.vlog-posts').css('height', $script.parent().height() - $playlist_list.find('.vlog-mod-head').height()); // Fix for margin bottom
        });

        /* Reverse submenu ul if out of the screen */

        $('.vlog-main-nav', 'mouseenter', 'li', function(e) {
            if ($(this).closest('body').width() < $(document).width()) {

                $(this).find('ul').addClass('vlog-rev');
            }
        });

        /* Scroll to comments */

        $('body').on('click', '.vlog-single-cover .entry-actions a.comments, .vlog-single-cover .meta-comments a, .vlog-single-content .meta-comments a:first', function(e) {

            e.preventDefault();
            var target = this.hash,
                $target = $(target);


            $('html, body').stop().animate({
                'scrollTop': $target.offset().top
            }, 900, 'swing', function() {
                window.location.hash = target;
            });

        });


        /* Initialize gallery pop-up */

        vlog_popup_gallery($('.vlog-site-content'));

        /* Initialize image popup  */

        vlog_popup_image($('.vlog-content'));


        /* Sticky sidebar */

        function vlog_sticky_sidebar() {
            if (window.matchMedia('(min-width: 992px)').matches) {
                if ($('.vlog-sticky').length) {
                    $('.vlog-sidebar').each(function() {
                        var $section = $(this).closest('.vlog-section');
                        if ($section.find('.vlog-ignore-sticky-height').length) {
                            var section_height = $section.height() - $section.find('.vlog-ignore-sticky-height').height();
                        } else {
                            var section_height = $section.height();
                        }

                        $(this).css('min-height', section_height);
                    });
                }
            } else {
                $('.vlog-sidebar').each(function() {
                    $(this).css('height', 'auto');
                    $(this).css('min-height', '1px');
                });
            }
            $(".vlog-sticky").stick_in_parent({
                parent: ".vlog-sidebar",
                inner_scrolling: false,
                offset_top: 99
            });
            if (window.matchMedia('(max-width: 991px)').matches) {
                $(".vlog-sticky").trigger("sticky_kit:detach");
            }
        }

        /* Put sidebars below content in responsive mode */
        function vlog_sidebar_switch() {
            $('.vlog-sidebar-left').each(function() {
                if (window.matchMedia('(max-width: 991px)').matches) {
                    $(this).insertAfter($(this).next());
                } else {
                    $(this).insertBefore($(this).prev());
                }
            });
        }

        /* Switch to retina logo */

        var vlog_retina_logo_done = false,
            vlog_retina_mini_logo_done = false;

        function vlog_logo_setup() {

            //Retina logo
            if (window.devicePixelRatio > 1) {

                if (vlog_js_settings.logo_retina && !vlog_retina_logo_done && $('.vlog-logo').length) {
                    $('.vlog-logo').imagesLoaded(function() {

                        $('.vlog-logo').each(function() {
                            if ($(this).is(':visible')) {
                                var width = $(this).width();
                                $(this).attr('src', vlog_js_settings.logo_retina).css('width', width + 'px');
                            }
                        });
                    });

                    vlog_retina_logo_done = true;
                }

                if (vlog_js_settings.logo_mini_retina && !vlog_retina_mini_logo_done && $('.vlog-logo-mini').length) {
                    $('.vlog-logo-mini').imagesLoaded(function() {
                        $('.vlog-logo-mini').each(function() {
                            if ($(this).is(':visible')) {
                                var width = $(this).width();
                                $(this).attr('src', vlog_js_settings.logo_mini_retina).css('width', width + 'px');
                            }
                        });
                    });

                    vlog_retina_mini_logo_done = true;
                }
            }
        }


        /* Pop-up gallery function */

        function vlog_popup_gallery(obj) {
            obj.find('.gallery, .wp-block-gallery').each(function() {
                var gallery = $(this);
                var selector = gallery.hasClass('wp-block-gallery') ? '.blocks-gallery-item a' : '.gallery-icon a';
                $(this).find(selector).magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    },

                    image: {
                        titleSrc: function(item) {
                            var $caption = gallery.hasClass('wp-block-gallery') ? item.el.closest('figure').find('figcaption') : item.el.closest('.gallery-item').find('.gallery-caption');
                            if ($caption != 'undefined') {
                                return $caption.text();
                            }
                            return '';
                        }
                    },
                    removalDelay: 300,
                    mainClass: 'mfp-with-fade',
                    closeBtnInside: false,
                    closeMarkup: '<button title="%title%" type="button" class="mfp-close"><i class="fv fv-close"></i></button>',
                    callbacks: {
                        open: function() {
                            $.magnificPopup.instance.next = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.next.call(self);
                                }, 120);
                            };
                            $.magnificPopup.instance.prev = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.prev.call(self);
                                }, 120);
                            };
                        },
                        imageLoadComplete: function() {
                            var self = this;
                            setTimeout(function() {
                                self.wrap.addClass('mfp-image-loaded');
                            }, 16);
                        }
                    }
                });
            });
        }

        /* Popup image function */

        function vlog_popup_image(obj) {

            if (obj.find("a.vlog-popup-img").length) {

                var popupImg = obj.find("a.vlog-popup-img");

                popupImg.find('img').each(function() {
                    var $that = $(this);
                    if ($that.hasClass('alignright')) {
                        $that.removeClass('alignright').parent().addClass('alignright');
                    }
                    if ($that.hasClass('alignleft')) {
                        $that.removeClass('alignleft').parent().addClass('alignleft');
                    }
                });

                popupImg.magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    image: {
                        titleSrc: function(item) {
                            return item.el.closest('.wp-caption').find('figcaption').text();
                        }
                    },
                    removalDelay: 300,
                    mainClass: 'mfp-with-fade',
                    closeBtnInside: false,
                    closeMarkup: '<button title="%title%" type="button" class="mfp-close"><i class="fv fv-close"></i></button>',
                    callbacks: {
                        open: function() {
                            $.magnificPopup.instance.next = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.next.call(self);
                                }, 120);
                            };
                            $.magnificPopup.instance.prev = function() {
                                var self = this;
                                self.wrap.removeClass('mfp-image-loaded');
                                setTimeout(function() {
                                    $.magnificPopup.proto.prev.call(self);
                                }, 120);
                            };
                        },
                        imageLoadComplete: function() {
                            var self = this;
                            setTimeout(function() {
                                self.wrap.addClass('mfp-image-loaded');
                            }, 16);
                        }
                    }
                });
            }

        }


        /* Fitvidjs function */
        function vlog_fit_videos(obj) {
            //obj.find('iframe').removeAttr('width').removeAttr('height');
            var iframes = [
                "iframe[src*='www.dailymotion.com']",
                "iframe[src*='player.twitch.tv']",
                "iframe[src*='vine.co']",
                "iframe[src*='videopress.com']",
                "iframe[src*='www.facebook.com']",
                "iframe[src*='jwplatform.com']",
                "iframe[src*='wistia.net']",
                "iframe[src*='vooplayer.com']",
                "iframe[src*='zetatv.com.uy']",
                "iframe[src*='wirewax.com']",
                "iframe[src*='playwire.com']",
                "iframe[src*='liveleak.com']",
                "iframe[src*='drive.google.com']",
                "iframe[src*='wistia.com']",
                "iframe[src*='sproutvideo.com']",
                "iframe[src*='xhamster.com']",
                "iframe[src*='pornhub.com']",
                "iframe[src*='rumble.com']",
                "iframe[src*='aparat.com']",
                "iframe[src*='flowplayer.com']",
                "iframe[src*='vod.infomaniak.com']",
                "iframe[src*='ustream.tv']",
                "iframe[src*='vrgtrvideos.click']",
                "iframe[src*='bitchute.com']",
                "iframe[src*='themediacdn.com']",
            ];

            obj.fitVids({
                customSelector: iframes.join(',')
            });
        }

        /* Video tweaks to force autoplay if possible */
        function vlog_try_autoplay(container) {

            if (!vlog_js_settings.force_autoplay) {
                return false;
            }



            if (container.find('video').length) {
                var video = container.find('video');
                video.attr('autoplay', 'true');
                if (typeof mediaelementplayer === 'function') {
                    video.mediaelementplayer();
                }

            } else if (container.find('.flowplayer').length) {
                var video = container.find('.flowplayer');
                video.attr('data-fvautoplay', 'true');

            } else if (container.find('iframe').length) {
                var video = container.find('iframe');
                if (video.attr('src').match(/\?/gi)) {
                    video.attr('src', video.attr('src') + '&autoplay=1&auto_play=1');
                } else {
                    video.attr('src', video.attr('src') + '?autoplay=1&auto_play=1');
                }

                video.attr('allow', 'autoplay; encrypted-media');

            } else if (container.find('script').length) {
                var video = container.find('script');
                video.attr('data-onready', 'vlog_playwire');
                video.attr('data-id', 'vlog_playwire');

            } else if (container.find('audio').length) {
                var audio = container.find('audio');
                audio.attr('autoplay', 'true');
                if (typeof mediaelementplayer === 'function') {
                    audio.mediaelementplayer();
                }
            }

        }

        function vlog_disable_related_videos(container) {
            if (container.find('iframe').length) {
                var video = container.find('iframe');
                if (video.attr('src').match(/\?/gi)) {
                    video.attr('src', video.attr('src') + '&rel=0');
                } else {
                    video.attr('src', video.attr('src') + '?rel=0');
                }
            }
        }


        if (vlog_js_settings.video_display_sticky && $('.vlog-format-content.video').length) {

            var $formatContent = $('.vlog-format-content.video');
            $formatContent.prepend(
                '<div class="vlog-video-sticky-header clearfix">\n' +
                '    <span class="widget-title h5">' + vlog_js_settings.video_sticky_title + '</span>\n' +
                '    <a id="vlog-video-sticky-close" href="javascript:void(0)"><span class="fv fv-close"></span></a>\n' +
                '</div>');

            var sticky_video_state = false;

            $(window).scroll(function() {

                var $iframe = $('.vlog-format-content.video iframe, .vlog-format-content.video video');
                if ($iframe.length < 1 || $(window).width() < 1200 || $formatContent.hasClass('vlog-ignore-sticky')) return;

                var bottom = $iframe.position().top + $iframe.outerHeight(true),
                    scroll = $(window).scrollTop();

                if (!sticky_video_state && bottom < scroll) {
                    $formatContent.addClass('vlog-sticky-video');
                    sticky_video_state = true;
                    setTimeout(function() {
                        $formatContent.addClass('vlog-sticky-animation');
                    }, 300);
                }

                if (sticky_video_state && bottom > scroll) {
                    $formatContent.removeClass('vlog-sticky-video').removeClass('vlog-sticky-animation');
                    sticky_video_state = false;
                }
            });
        }

        $('body').on('click', '#vlog-video-sticky-close', function(e) {
            e.preventDefault();
            $('.vlog-format-content').removeClass('vlog-sticky-video').addClass('vlog-ignore-sticky');
        });


        align_full_fix();

        function align_full_fix() {

            if (!$('.vlog-body-box').length) {
                var style = '.vlog-single-no-sid .alignfull { width: ' + $(window).width() + 'px; margin-left: -' + $(window).width() / 2 + 'px; margin-right: -' + $(window).width() / 2 + 'px; left:50%; right:50%; max-width: initial; }';
            } else {
                var style = '.vlog-single-no-sid .alignfull { width: ' + $('.vlog-body-box').width() + 'px; margin-left: -' + $('.vlog-body-box').width() / 2 + 'px; margin-right: -' + $('.vlog-body-box').width() / 2 + 'px; left:50%; right:50%; max-width: initial; }';
            }
            if ($('#vlog-align-fix').length) {
                $('#vlog-align-fix').html(style);
            } else {
                $('head').append('<style id="vlog-align-fix" type="text/css">' + style + '</style>');
            }


        }


        /* Sticky video height */

        set_sticky_height_classic_layout();

        function set_sticky_height_classic_layout() {

            if (!vlog_js_settings.video_display_sticky) {
                return;
            }

            var classic_layout = $('.vlog-single-content .entry-media.video');

            if (classic_layout.length) {
                var height = $('.vlog-popup-wrapper').height() - 1;
                classic_layout.css('min-height', height);
            }
        }

        /* Cover Area - custom content layout wrapper height improvements */

        vlog_cover_height_fix();

        function vlog_cover_height_fix() {

            if (!$('.vlog-featured-custom').length) return;

            var custom_area = $('.vlog-featured-custom .vlog-featured-item');
            var custom_area_height = custom_area.height();
            var custom_content_height = custom_area.find('.vlog-featured-info-custom').height();

            if (custom_content_height + 140 > custom_area_height) {
                custom_area.attr('style', 'height: ' + (custom_content_height + 140) + 'px !important');
                custom_area.find('.vlog-cover-bg').attr('style', 'height: ' + (custom_content_height + 140) + 'px !important');
            }
        }

        function vlog_prevent_header_elements_overlapping(args) {
            if (vlog_empty(args)) {
                return false;
            }

            $.each(args, function(i, overlapping_args) {

                if (vlog_empty(overlapping_args.main_element)) {
                    return true;
                }

                var defaults = {
                    menu_selector: '#header .vlog-header-1 .vlog-main-nav'
                };

                var opts = {};
                $.extend(opts, defaults, overlapping_args);

                if (vlog_empty($(opts.menu_selector + ' > #vlog-menu-item-more'))) {
                    return false;
                }

                if (!$('#vlog-responsive-header').is(':visible')) {
                    calculate_collision(opts);
                }

                $(window).resize(function() {
                    if ($('#vlog-responsive-header').is(':visible') || window.matchMedia('(max-width: 991px)').matches) {
                        return false;
                    }
                    calculate_collision(opts);
                    return_elements_to_main_menu(opts);
                });
            });

            function calculate_collision(opts) {
                if (!has_collision(opts.main_element, opts.elements_to_compare)) {
                    return false;
                }

                move_last_element_to_more_list(opts);
                calculate_collision(opts);
            }

            function has_collision($compare, with_elements, offset_left, offset_right) {

                if (typeof offset_left === "undefined") {
                    offset_left = 0;
                }
                if (typeof offset_right === "undefined") {
                    offset_right = 0;
                }

                var compare_left = $compare.offset().left - offset_left,
                    compare_width = $compare.outerWidth(true),
                    compare_right = compare_left + compare_width + offset_right,
                    collision_detected = false;

                $.each(with_elements, function() {
                    var current_left = $(this).offset().left,
                        current_width = $(this).outerWidth(true),
                        current_right = current_left + current_width;

                    if (collision_detected) {
                        return false;
                    }

                    collision_detected = !(compare_right < current_left || compare_left > current_right);
                });

                return collision_detected;
            }

            function move_last_element_to_more_list(opts) {
                $(opts.menu_selector + ' > #vlog-menu-item-more').show();
                var $menu_items = $(opts.menu_selector + ' > li:not(#vlog-menu-item-more)'),
                    $last_menu_item = $menu_items.last();

                $last_menu_item.data('breakopint', $(window).width());
                $(opts.menu_selector + ' #vlog-menu-item-more > .sub-menu').prepend($last_menu_item);
                return true;
            }

            function return_elements_to_main_menu(opts) {

                var $first_element = $(opts.menu_selector + ' > #vlog-menu-item-more > .sub-menu > li:first');

                var breakpoint = $first_element.data('breakopint');
                if (breakpoint < $(window).width()) {
                    $first_element.insertBefore($(opts.menu_selector + ' > #vlog-menu-item-more'));
                }

                if (vlog_empty($(opts.menu_selector + ' > #vlog-menu-item-more > .sub-menu').children())) {
                    $(opts.menu_selector + ' > #vlog-menu-item-more').hide();
                }

                setTimeout(function() {
                    if (has_collision(opts.main_element, opts.elements_to_compare)) {
                        move_last_element_to_more_list(opts);
                    }
                }, 200);
            }
        }

        $('body').imagesLoaded(function() {

            vlog_prevent_header_elements_overlapping([{
                    main_element: $('#header .vlog-header-1 .vlog-main-nav'),
                    elements_to_compare: [$('#header .vlog-header-1 .vlog-slot-r'), $('#header .vlog-header-1 .vlog-slot-l')],
                    menu_selector: '#header .vlog-header-1 .vlog-main-nav'
                },
                {
                    main_element: $('#header .vlog-header-2 .vlog-slot-r'),
                    elements_to_compare: [$('#header .vlog-header-2 .vlog-slot-l')],
                    menu_selector: '#header .vlog-header-2 .vlog-main-nav'
                },
                {
                    main_element: $('#header .vlog-header-3 .vlog-slot-l'),
                    elements_to_compare: [$('#header .vlog-header-3 .vlog-slot-r')],
                    menu_selector: '#header .vlog-header-3 .vlog-main-nav'
                },
                {
                    main_element: $('#header .vlog-header-4 .vlog-main-navigation'),
                    elements_to_compare: [$('#header .vlog-header-4 .vlog-actions-menu')],
                    menu_selector: '#header .vlog-header-4 .vlog-main-nav'
                },
                {
                    main_element: $('#header .vlog-header-5 .vlog-header-bottom .vlog-slot-l'),
                    elements_to_compare: [$('#header .vlog-header-5 .vlog-header-bottom .vlog-slot-r')],
                    menu_selector: '#header .vlog-header-5 .vlog-main-nav'
                },
                {
                    main_element: $('#header .vlog-header-6 .vlog-main-navigation'),
                    elements_to_compare: [$('#header .vlog-header-6 .vlog-actions-menu')],
                    menu_selector: '#header .vlog-header-6 .vlog-main-nav'
                },
                {
                    main_element: $('#vlog-sticky-header .vlog-main-navigation'),
                    elements_to_compare: [$('#vlog-sticky-header .vlog-slot-l'), $('#vlog-sticky-header .vlog-slot-r')],
                    menu_selector: '#vlog-sticky-header .vlog-main-navigation .vlog-main-nav'
                },
                {
                    main_element: $('#vlog-sticky-header-2 .vlog-slot-r'),
                    elements_to_compare: [$('#vlog-sticky-header-2 .vlog-slot-l')],
                    menu_selector: '#vlog-sticky-header-2 .vlog-main-nav'
                }
            ]);

        });

        /**
         * Checks if variable is empty or not
         *
         * @param variable
         * @returns {boolean}
         */
        function vlog_empty(variable) {

            if (typeof variable === 'undefined') {
                return true;
            }

            if (variable === null) {
                return true;
            }

            if (variable.length === 0) {
                return true;
            }

            if (variable === "") {
                return true;
            }

            if (typeof variable === 'object' && $.isEmptyObject(variable)) {
                return true;
            }

            return false;
        }
    }); //document ready end



})(jQuery);

function vlog_playwire() {
    Bolt.playMedia('vlog_playwire');
    $(document).trigger('playwire-ready');
}