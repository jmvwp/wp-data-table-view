<?php
get_header();
do_action(MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'template_render_before');
?>
    <div class="wp-data-table-template" id="wp-data-table-template"></div>
<?php
do_action(MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'template_render_after');
get_footer();
