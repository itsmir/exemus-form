<?php
/**
* Plugin Name: Forminator Custom Code
* Description: Generates Return Date as today + 10 days
* Author: Miriam Michalak
*/

add_action( 'wp_footer', 'wpmudev_autoset_date', 9999 );
function wpmudev_autoset_date() {
	global $post;
    if ( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'forminator_form' ) ) {
        return;
    }
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		setTimeout(function() {
			$('.forminator-custom-form').trigger('after.load.forminator');
		},100);

		$(document).on('after.load.forminator', function(e, form_id) {
			if ( e.target.id == 'forminator-module-1560' ) {
				var next_date = $('#date-2 input').datepicker('getDate');
				next_date.setDate(next_date.getDate() + 10);
				$('#date-2 input').datepicker('setDate', next_date);
			}
		});
	});
	</script>
	<?php
}