<?php
$protocol = is_ssl() ? 'https://' : 'http://';
$vlog_ajax_url = admin_url( 'admin-ajax.php', $protocol );
?>
<script>
    (function($) {
        $(document).ready(function() {
            $("body").on('click', '#vlog-meks-video-importer-onetime-notice',function(e){
                e.preventDefault();
                $.post('<?php echo esc_url($vlog_ajax_url); ?>', {action: 'vlog_remove_meks_video_importer_admin_notice'}, function(response) {});
            });
        });
    })(jQuery);

</script>
<div id="vlog-meks-video-importer-onetime-notice" class="notice notice-info is-dismissible">
    <p><?php esc_html_e( 'New Meks Video Importer plugin for importing Youtube and Vimeo videos is available! ', 'vlog' ); ?><a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&amp;plugin=meks-video-importer&amp;TB_iframe=true&amp;width=772&amp;height=142')?>" class="thickbox open-plugin-details-modal" aria-label="More information about Meks Video Importer" data-title="Meks Video Importer">Click here to install</a></p>
</div>