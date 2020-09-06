(function($) {

    "use strict";

    $(document).ready(function($) {

        /* Image select option */

        $('body').on('click', 'img.vlog-img-select', function(e) {
            e.preventDefault();
            var this_img = $(this);
            this_img.closest('ul').find('img.vlog-img-select').removeClass('selected');
            this_img.addClass('selected');
            this_img.closest('ul').find('input').prop('checked', false).removeAttr('checked');
            this_img.closest('li').find('input').prop('checked', true).attr('checked', 'checked');

        });


        /* Layout toggle */

        vlog_toggle_category_layout();

        $("body").on("click", "input.layout-type", function(e) {
            vlog_toggle_category_layout();
        });

        /* Sidebar toggle */

        vlog_toggle_category_sidebar();

        $("body").on("click", "input.layout-sidebar", function(e) {
            vlog_toggle_category_sidebar();
        });


        function vlog_toggle_category_layout() {
            var layout_type = $('input.layout-type:checked').val();

            if (layout_type == 'custom') {
                $('.vlog-layout-opt').show();
            } else {
                $('.vlog-layout-opt').hide();
            }

        }

        function vlog_toggle_category_sidebar() {
            var layout_type = $('input.layout-sidebar:checked').val();

            if (layout_type == 'custom') {
                $('.vlog-sidebar-opt').show();
            } else {
                $('.vlog-sidebar-opt').hide();
            }

        }

        /* Image upload */
        var meta_image_frame;

        $('body').on('click', '#vlog-image-upload', function(e) {

            e.preventDefault();

            if (meta_image_frame) {
                meta_image_frame.open();
                return;
            }

            meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                title: 'Choose your image',
                button: {
                    text: 'Set image'
                },
                library: {
                    type: 'image'
                }
            });

            meta_image_frame.on('select', function() {

                var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
                $('#vlog-image-url').val(media_attachment.url);
                $('#vlog-image-preview').attr('src', media_attachment.url);
                $('#vlog-image-preview').show();
                $('#vlog-image-clear').show();

            });

            meta_image_frame.open();
        });


        $('body').on('click', '#vlog-image-clear', function(e) {
            $('#vlog-image-preview').hide();
            $('#vlog-image-url').val('');
            $(this).hide();
        });

    });

})(jQuery);