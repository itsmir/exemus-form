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
            if ( e.target.id == 'forminator-module-1560' ) { //Please change the form ID
                var next_date = $('#date-2 input').datepicker('getDate');
                var disabled_dates = $('#date-2 input').attr('data-disable-range');
                var dis_arr = disabled_dates.split(',');
                next_date.setDate(next_date.getDate() + 10);
                var dis_dates = [];
                var range_dates = [];
                var day, month, year, yy;
                var week_day = next_date.getDay();
                if ( week_day === 6 ) {
                    next_date.setDate(next_date.getDate() + 2);
                } else if ( week_day === 0 ) {
                    next_date.setDate(next_date.getDate() + 1);
                }

                $('#date-2 input').datepicker('setDate', next_date);
                for (let i = 0; i < dis_arr.length; i++) {
                    dis_dates.push(dis_arr[i].split('-'));
                }

                for (let j = 0; j < dis_dates.length; j++) {
                    var date1 = new Date(dis_dates[j][0]);
                    var date2 = new Date(dis_dates[j][1]);
                    while (date1 <= date2) {
                        var yy = new Date(date1);
                        day = (yy.getDate() < 10 ? '0' : '') + yy.getDate();
                        month = ( (yy.getMonth()+1) < 10 ? '0' : '') + (yy.getMonth()+1);
                        year = yy.getFullYear();
                        range_dates.push(day+'-'+month+'-'+year);
                        date1.setDate(date1.getDate() + 1);
                    }
                }

                for (let l = 0; l < range_dates.length; l++) {
                    var current_date = $('#date-2 input').val();
                    if ( current_date == range_dates[l] ) {
                        next_date = $('#date-2 input').datepicker('getDate');
                        next_date.setDate(next_date.getDate() + 1);
                        $('#date-2 input').datepicker('setDate', next_date);
                    }
                }

                var weeks_day = next_date.getDay();
                if ( weeks_day === 6 ) {
                    next_date.setDate(next_date.getDate() + 2);
                    $('#date-2 input').datepicker('setDate', next_date);
                } else if ( weeks_day === 0 ) {
                    next_date.setDate(next_date.getDate() + 1);
                    $('#date-2 input').datepicker('setDate', next_date);
                }
            }
        });
    });
    </script>
<?php
}