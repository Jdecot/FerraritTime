(function($) {

    "use strict";

    $(document).ready(function() {

        /* Image opts selection */
        $('body').on('click', 'img.vlog-img-select', function(e) {
            e.preventDefault();

            if (!$(this).parent().hasClass('vlog-disabled')) {
                $(this).closest('ul').find('img.vlog-img-select').removeClass('selected');
                $(this).addClass('selected');
                $(this).closest('ul').find('input').prop('checked', false).removeAttr('checked');
                $(this).closest('li').find('input').prop('checked', true).attr('checked', 'checked');
            }

            if ($(this).closest('ul').hasClass('vlog-col-dep-control')) {

                var $wrap = $(this).closest('.vlog-opt').parent();
                var col_dep = $(this).closest('li').find('input').val();

                $wrap.find('.vlog-col-dep').each(function() {
                    var reset_layout = false;
                    $(this).find('img.vlog-img-select').each(function() {
                        var col = $(this).attr('data-col');
                        $(this).parent().removeClass('vlog-disabled');
                        if (col && col_dep % col) {
                            $(this).parent().addClass('vlog-disabled');
                            if ($(this).hasClass('selected')) {
                                $(this).removeClass('selected');
                                reset_layout = true;
                            }
                        }
                    });

                    if (reset_layout) {
                        $(this).find('img.vlog-img-select').each(function() {
                            var col = $(this).attr('data-col');
                            if (col_dep % col == false) {
                                //alert($( this ).html());
                                $(this).click();
                                return false;
                            }
                        });
                    }
                });
            }

        }); 

        /* Hack to dynamicaly apply select value */
        $('body').on('change', '.vlog-opt-select', function(e) {
            //e.preventDefault();
            var sel = $(this).val();
            $(this).find('option').removeAttr('selected');
            $(this).find('option[value=' + sel + ']').attr('selected', 'selected');
        });

        /* Module form tabs */
        $('body').on('click', '.vlog-opt-tabs a', function(e) {
            e.preventDefault();
            $(this).parent().find('a').removeClass('active');
            $(this).addClass('active');
            $(this).closest('.vlog-module-form').find('.vlog-tab').hide();
            $(this).closest('.vlog-module-form').find('.vlog-tab').eq($(this).index()).show();

        });

        /* Show/hide */
        $('body').on('click', '.vlog-next-hide', function(e) {

            if ($(this).is(':checked')) {
                $(this).closest('.vlog-opt').next().fadeIn(400);
            } else {
                $(this).closest('.vlog-opt').next().fadeOut(400);
            }
        });


        /* Make sections sortable */
        $("#vlog-sections").sortable({
            revert: false,
            cursor: "move",
            placeholder: "vlog-section-drop"
        });

        /* Make modules sortable */
        $(".vlog-modules").sortable({
            revert: false,
            cursor: "move",
            placeholder: "vlog-module-drop"
        });


        var vlog_current_section;
        var vlog_current_module;
        var vlog_module_type;


        /* Add new section */
        $('body').on('click', '.vlog-add-section', function(e) {
            e.preventDefault();
            var $modal = $($.parseHTML('<div class="vlog-section-form">' + $("#vlog-section-clone .vlog-section-form").html() + '</div>'));
            vlog_dialog($modal, 'Add New Section', 'vlog-save-section');

        });

        /* Edit section */
        $('body').on('click', '.vlog-edit-section', function(e) {
            e.preventDefault();
            vlog_current_section = parseInt($(this).closest('.vlog-section').attr('data-section'));
            var $modal = $(this).closest('.vlog-section').find('.vlog-section-form').clone();
            vlog_dialog($modal, 'Edit Section', 'vlog-save-section');



        });

        /* Remove section */
        $('body').on('click', '.vlog-remove-section', function(e) {
            e.preventDefault();
            var remove = vlog_confirm();
            if (remove) {
                $(this).closest('.vlog-section').fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });


        /* Save section */

        $('body').on('click', 'button.vlog-save-section', function(e) {

            e.preventDefault();

            var $vlog_form = $(this).closest('.wp-dialog').find('.vlog-section-form').clone();

            if ($vlog_form.hasClass('edit')) {
                $vlog_form = vlog_fill_form_fields($vlog_form);
                var $section = $('#vlog-sections .vlog-section-' + vlog_current_section);
                $section.find('.vlog-section-form').html($vlog_form.html());
                $section.find('.vlog-sidebar').text($vlog_form.find('.sec-sidebar:checked').val());

            } else {
                var count = $('#vlog-sections-count').attr('data-count');
                $vlog_form = vlog_fill_form_fields($vlog_form, 'vlog[sections][' + count + ']');
                $('#vlog-sections').append($('#vlog-section-clone').html());
                var $new_section = $('#vlog-sections .vlog-section').last();
                $new_section.addClass('vlog-section-' + parseInt(count)).attr('data-section', parseInt(count)).find('.vlog-section-form').addClass('edit').html($vlog_form.html());
                $new_section.find('.vlog-sidebar').text($vlog_form.find('.sec-sidebar:checked').val());
                $('#vlog-sections-count').attr('data-count', (parseInt(count) + 1));

                $("#vlog-sections .vlog-section-" + count + " .vlog-modules").sortable({
                    revert: false,
                    cursor: "move",
                    placeholder: "vlog-module-drop"
                });
            }

        });


        /* Add new module */
        $('body').on('click', '.vlog-add-module', function(e) {
            e.preventDefault();
            vlog_module_type = $(this).attr('data-type');
            vlog_current_section = parseInt($(this).closest('.vlog-section').attr('data-section'));
            var $modal = $($.parseHTML('<div class="vlog-module-form">' + $('#vlog-module-clone .' + vlog_module_type + ' .vlog-module-form').html() + '</div>'));
            vlog_dialog($modal, 'Add New Module', 'vlog-save-module');

            /* Make some options sortable */
            vlog_sort_items($(".vlog-opt-content .sortable"));
            vlog_sort_searched_items();
        });

        /* Edit module */
        $('body').on('click', '.vlog-edit-module', function(e) {
            e.preventDefault();
            vlog_current_section = parseInt($(this).closest('.vlog-section').attr('data-section'));
            vlog_current_module = parseInt($(this).closest('.vlog-module').attr('data-module'));
            var $modal = $(this).closest('.vlog-module').find('.vlog-module-form').clone();
            vlog_dialog($modal, 'Edit Module', 'vlog-save-module');

            /* Make some options sortable */
            vlog_sort_items($(".vlog-opt-content .sortable"));
            vlog_sort_searched_items();
        });

        $('body').on('click', '.vlog-deactivate-module', function(e) {
            e.preventDefault();
            var _self = $(this);
            var parent_el = _self.closest('.vlog-module');
            var h_data = parent_el.find('.vlog-module-deactivate').val();

            _self.find('span').toggleClass('vlog-hidden');

            if (h_data == 1) {
                parent_el.find('.vlog-module-deactivate').val('0');
                parent_el.addClass('vlog-module-disabled');
            } else {
                parent_el.find('.vlog-module-deactivate').val('1');
                parent_el.removeClass('vlog-module-disabled');
            }

        });

        /* Remove module */
        $('body').on('click', '.vlog-remove-module', function(e) {
            e.preventDefault();
            var remove = vlog_confirm();
            if (remove) {
                $(this).closest('.vlog-module').fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });

        /* Save module */

        $('body').on('click', 'button.vlog-save-module', function(e) {

            e.preventDefault();

            var $vlog_form = $(this).closest('.wp-dialog').find('.vlog-module-form').clone();

            /* Nah, jQuery clone bug, clone text area manually */
            var txt_content = $(this).closest('.wp-dialog').find('.vlog-module-form').find("textarea").first().val();
            if (txt_content !== undefined) {
                $vlog_form.find("textarea").first().val(txt_content);
            }

            if ($vlog_form.hasClass('edit')) {
                $vlog_form = vlog_fill_form_fields($vlog_form);
                var $module = $('.vlog-section-' + vlog_current_section + ' .vlog-module-' + vlog_current_module);
                $module.find('.vlog-module-form').html($vlog_form.html());
                $module.find('.vlog-module-title').text($vlog_form.find('.mod-title').val());
                $module.find('.vlog-module-columns').text($vlog_form.find('.mod-columns:checked').closest('li').find('span').text());
            } else {
                var $section = $('.vlog-section-' + vlog_current_section);
                var count = $section.find('.vlog-modules-count').attr('data-count');
                $vlog_form = vlog_fill_form_fields($vlog_form, 'vlog[sections][' + vlog_current_section + '][modules][' + count + ']');
                $section.find('.vlog-modules').append($('#vlog-module-clone .' + vlog_module_type).html());
                var $new_module = $section.find('.vlog-modules .vlog-module').last();
                $new_module.addClass('vlog-module-' + parseInt(count)).attr('data-module', parseInt(count)).find('.vlog-module-form').addClass('edit').html($vlog_form.html());
                $new_module.find('.vlog-module-title').text($vlog_form.find('.mod-title').val());
                $new_module.find('.vlog-module-columns').text($vlog_form.find('.mod-columns:checked').closest('li').find('span').text());
                $section.find('.vlog-modules-count').attr('data-count', parseInt(count) + 1);
            }

        });

        /* Open our dialog modal */
        function vlog_dialog(obj, title, action) {

            obj.dialog({
                'dialogClass': 'wp-dialog',
                'appendTo': false,
                'modal': true,
                'autoOpen': false,
                'closeOnEscape': true,
                'draggable': false,
                'resizable': false,
                'width': 800,
                'height': $(window).height() - 60,
                'title': title,
                'close': function(event, ui) { $('body').removeClass('modal-open'); },
                'buttons': [{ 'text': "Save", 'class': 'button-primary ' + action, 'click': function() { $(this).dialog('close'); } }]
            });

            obj.dialog('open');

            $('body').addClass('modal-open');
        }


        /* Fill form fields dynamically */
        function vlog_fill_form_fields($obj, name) {

            $obj.find('.vlog-count-me').each(function(index) {

                if (name !== undefined && !$(this).is('option')) {
                    $(this).attr('name', name + $(this).attr('name'));
                }

                if ($(this).is('textarea')) {
                    $(this).html($(this).val());
                }


                if (!$(this).is('select')) {
                    $(this).attr('value', $(this).val());
                }



                if ($(this).is(":checked")) {
                    $(this).attr('checked', 'checked');
                    $(this).prop('checked', true);
                } else {
                    $(this).removeAttr('checked');
                    $(this).prop('checked', false);
                }

            });

            return $obj;
        }

        function vlog_confirm() {
            var ret_val = confirm("Are you sure?");
            return ret_val;
        }

        /* Metabox switch - do not show every metabox for every template */

        var vlog_is_gutenberg = vlog_js_settings.is_gutenberg && typeof wp.apiFetch !== 'undefined';
        var vlog_template_selector = vlog_js_settings.is_gutenberg ? '.editor-page-attributes__template select' : '#page_template';

        if (vlog_is_gutenberg) {

            var post_id = $('#post_ID').val();
            wp.apiFetch({ path: '/wp/v2/pages/' + post_id, method: 'GET' }).then(function(obj) {
                vlog_template_metaboxes(false, obj.template);
            });

        } else {
            vlog_template_metaboxes(false);
        }

        $('body').on('change', vlog_template_selector, function(e) {
            vlog_template_metaboxes(true);
        });

        function vlog_template_metaboxes(scroll, t) {

            var template = t ? t : $(vlog_template_selector).val();

            if (template == 'template-modules.php') {
                $('#vlog_sidebar').fadeOut(300);
                $('#vlog_blank_page_template').fadeOut(300);
                $('#vlog_modules').fadeIn(300);
                $('#vlog_pagination').fadeIn(300);
                $('#vlog_fa').fadeIn(300);
                if (scroll) {
                    var target = $('#vlog_modules').attr('id');
                    $('html, body').stop().animate({
                        'scrollTop': $('#' + target).offset().top
                    }, 900, 'swing', function() {
                        window.location.hash = target;
                    });
                }
            } else if (template == 'template-blank.php') {
                $('#vlog_sidebar').fadeOut(300);
                $('#vlog_modules').fadeOut(300);
                $('#vlog_pagination').fadeOut(300);
                $('#vlog_fa').fadeOut(300, function() {
                    $('#vlog_blank_page_template').fadeIn(300);
                });
            } else if (template == 'template-full-width.php') {
                $('#vlog_sidebar').fadeOut(300);
                $('#vlog_blank_page_template').fadeOut(300);
                $('#vlog_modules').fadeOut(300);
                $('#vlog_pagination').fadeOut(300);
                $('#vlog_fa').fadeOut(300);
            } else {
                $('#vlog_sidebar').fadeIn(300);
                $('#vlog_blank_page_template').fadeOut(300);
                $('#vlog_modules').fadeOut(300);
                $('#vlog_pagination').fadeOut(300);
                $('#vlog_fa').fadeOut(300);
            }

        }

        /* Cover switch */
        vlog_cover_options('#vlog_fa');

        function vlog_cover_options(wrap) {

            var hidden_class = $('#vlog_fa').find('.vlog-show-hide');
            var show_class = $(wrap).find('.vlog-show-hide-custom');
            var imgs = $(wrap).find('.vlog-img-select-wrap li img');

            imgs.each(function() {

                var _this = $(this);
                var val = _this.siblings('input').val();

                _this.on('click', function() {

                    if (val != 'none' && val != 'custom') {
                        hidden_class.each(function() {
                            $(this).removeClass('vlog-hidden-custom');
                        });
                        show_class.addClass('vlog-hidden-custom').removeClass('vlog-show-custom');
                    } else if (val == 'custom') {
                        hidden_class.each(function() {
                            $(this).addClass('vlog-hidden-custom');
                        });
                        show_class.removeClass('vlog-hidden-custom').addClass('vlog-show-custom');
                    } else if (val == 'none') {
                        hidden_class.each(function() {
                            $(this).addClass('vlog-hidden-custom');
                        });
                        show_class.addClass('vlog-hidden-custom').removeClass('vlog-show-custom');
                    }
                });
            });
        }

        /* Add background image on custom cover area layout from media file */
        var thumbImage;
        $("body").on("click", "a.vlog-select-bg-image", function(e) {
            e.preventDefault();
            var this_btn = $(this);
            var image = wp.media({
                    title: 'Upload Image',
                }).open()
                .on('select', function(e) {
                    var uploaded_image = image.state().get('selection').first();
                    var thumbImage = uploaded_image.toJSON().url;
                    this_btn.siblings('input').val(thumbImage);
                });
        });



        /* Call live search */
        vlog_live_search('vlog_ajax_search');

        /* Live search functionality */
        function vlog_live_search(search_ajax_action) {

            $('body').on('focus', '.vlog-live-search', function() {

                var $this = $(this),
                    get_module_type = 'posts';

                if ($this.hasClass('vlog-live-search-with-cpts')) {
                    get_module_type = $this.closest('.vlog-opt-box').find('.vlog-fa-post-type').val();
                    if (get_module_type === 'post') {
                        get_module_type = 'cover';
                    }
                } else {
                    get_module_type = $this.closest('.vlog-live-search-opt').find('.vlog-live-search-hidden').data('type');
                }

                $this.autocomplete({
                    source: function(req, response) {
                        $.getJSON(vlog_js_settings.ajax_url + '?callback=?&action=' + search_ajax_action + '&type=' + get_module_type, req, response);
                    },
                    delay: 300,
                    minLength: 4,
                    select: function(event, ui) {

                        var $this = $(this);
                        var wrap = $this.closest('.vlog-live-search-opt');

                        wrap.find('.vlog-live-search-items').append('<span><button type="button" class="ntdelbutton" data-id="' + ui.item.id + '"><span class="remove-tag-icon"></span></button><span class="vlog-searched-title">' + ui.item.label + '</span></span>');
                        vlog_update_items($this);
                        wrap.find('.vlog-live-search').val('');

                        return false;
                    }
                });

            });

            vlog_sort_searched_items();
            vlog_remove_all_search_items_on_post_type_change();
            vlog_remove_searched_items();


        }

        /**
         * Sort/reorder searched items from list 
         */
        function vlog_sort_searched_items() {
            $('.vlog-live-search-items.tagchecklist').sortable({
                revert: false,
                cursor: "move",
                containment: "parent",
                opacity: 0.8,
                update: function(event, ui) {
                    vlog_update_items($(this));
                }
            });
        }

        /**
         * Remove searched item from list 
         */
        function vlog_remove_searched_items() {
            $('body').on('click', '.vlog-live-search-opt .ntdelbutton', function(e) {
                var $this = $(this);
                var parent = $this.closest('.vlog-live-search-items');
                $this.parent().remove();
                vlog_update_items(parent);
            });
        }

        /**
         * Remove searched item from list
         */
        function vlog_remove_all_search_items_on_post_type_change() {
            $('body').on('change', '.vlog-fa-post-type', function() {
                var $searched_items = $('.vlog-live-search-items'),
                    $search = $('.vlog-live-search-hidden');

                $searched_items.html('');
                $search.val('');
            });
        }

        /**
         * Sync/update hander function for list items on add, reorder or remove actions
         */
        function vlog_update_items(object) {

            var wrapper = object.closest('.vlog-live-search-opt');
            var hidden_field = wrapper.find('.vlog-live-search-hidden');
            var hidden_val = [];

            wrapper.find('.ntdelbutton').each(function() {
                hidden_val.push($(this).attr('data-id'));
            });

            hidden_field.val(hidden_val.toString());
        }

        /* Sortable functionality */
        function vlog_sort_items(object) {
            object.sortable({
                revert: false,
                cursor: "move",
                opacity: 0.8
            });
        }

        var vlog_watch_for_changes = {

            init: function() {
                var $watchers = $('.vlog-watch-for-changes');

                if (vlog_empty($watchers)) {
                    return;
                }

                $watchers.each(this.initWatching);
            },

            initWatching: function(i, elem) {
                var $elem = $(elem),
                    watchedElemClass = $elem.data('watch'),
                    showOnValue = $elem.data('show-on-value'),
                    hideOnValue = $elem.data('hide-on-value');

                if (!vlog_empty(showOnValue)) {
                    $('body').on('change', '.' + watchedElemClass, showByValue);
                } else {
                    $('body').on('change', '.' + watchedElemClass, hideByValue);
                }

                function hideByValue() {
                    var $this = $(this);

                    if (!$this.hasClass(watchedElemClass)) {
                        $this = $('.' + watchedElemClass + ':checked, ' + '.' + watchedElemClass + ':checked, ' + '.' + watchedElemClass + ':selected');
                    }

                    if (vlog_empty($this)) {
                        return false;
                    }

                    var val = $this.val();

                    if (val === hideOnValue) {
                        $elem.hide();
                        return true;
                    }

                    $elem.show();
                    return false;
                }

                function showByValue() {
                    var $this = $(this);

                    if (!$this.hasClass(watchedElemClass)) {
                        $this = $('.' + watchedElemClass + ':checked, ' + '.' + watchedElemClass + ':checked, ' + '.' + watchedElemClass + ' > option:selected');
                    }

                    if (vlog_empty($this)) {
                        return false;
                    }

                    var val = $this.val();

                    if (val === showOnValue) {
                        $elem.show();
                        return true;
                    }

                    $elem.hide();
                    return false;
                }

                showByValue();
                hideByValue();
            }

        };

        vlog_watch_for_changes.init();
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

            if (variable === 0 || variable === '0') {
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

            if (variable === false) {
                return true;
            }

            if (typeof variable === 'object' && $.isEmptyObject(variable)) {
                return true;
            }

            return false;
        }
    });
})(jQuery);