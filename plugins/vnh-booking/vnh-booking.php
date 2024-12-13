<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'VNH_BOOKING_VERSION', '1.0.0' );

function activate_vnh_booking() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vnh-booking-activator.php';
	Vnh_Booking_Activator::activate();
}

function deactivate_vnh_booking() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vnh-booking-deactivator.php';
	Vnh_Booking_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vnh_booking' );
register_deactivation_hook( __FILE__, 'deactivate_vnh_booking' );

require plugin_dir_path( __FILE__ ) . 'includes/class-vnh-booking.php';

function run_vnh_booking() {

	$plugin = new Vnh_Booking();
	$plugin->run();

}
run_vnh_booking();
