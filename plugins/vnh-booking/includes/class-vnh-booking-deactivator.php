<?php

class Vnh_Booking_Deactivator {

	public static function deactivate() {
		 global $wpdb;

    	$table_name = $wpdb->prefix . 'vnh_booking_history';

    	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}

}
