<?php

class Vnh_Booking_Activator {

	public static function activate() {
		global $table_prefix, $wpdb;

		$tblname = 'hotel_room_type';
		$wp_track_table = $table_prefix . "$tblname ";
 		$charset_collate = $wpdb->get_charset_collate();

		$tblname = 'vnh_booking_history';
		$wp_track_table = $table_prefix . "$tblname";
		if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) {
			$sql = "CREATE TABLE $wp_track_table (
				ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                g_name VARCHAR(20) NOT NULL,
                g_email VARCHAR(20) NOT NULL,
				g_phone VARCHAR(20) NOT NULL,
				check_in DATE NOT NULL,
				check_out DATE NOT NULL,
				hotel_id BIGINT(20) UNSIGNED NOT NULL,
				room_type_id BIGINT(20) UNSIGNED NOT NULL,
				log TEXT NOT NULL,
				room_no TEXT NOT NULL,
                PRIMARY KEY (ID),
				FOREIGN KEY (hotel_id) REFERENCES wp_posts(ID),
				FOREIGN KEY (room_type_id) REFERENCES wp_posts(ID)
        	) $charset_collate;";
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			dbDelta($sql);
		}
	}

}
