<?php

class Vnh_Booking_Public {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vnh-booking-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vnh-booking-public.js', array( 'jquery' ), $this->version, false );
	}

	public function handleClientRequests() {
		if(isset($_POST["submit_make_reservation"])){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'controllers/ClientController.php';
			$client_controller = new ClientController();
			$client_controller->makeReservation();
		}
	}
}
