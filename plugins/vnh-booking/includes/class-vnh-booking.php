<?php

class Vnh_Booking {

	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {
		if ( defined( 'VNH_BOOKING_VERSION' ) ) {
			$this->version = VNH_BOOKING_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'vnh-booking';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vnh-booking-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-booking-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-vnh-booking-public.php';

		$this->loader = new Vnh_Booking_Loader();

	}

	private function define_admin_hooks() {

		$plugin_admin = new Vnh_Booking_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action('admin_init', $plugin_admin, 'admin_init');
		$this->loader->add_action('admin_init', $plugin_admin, 'add_custom_role');

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_admin, 'custom_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'custom_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin, 'init' );
		$this->loader->add_action( 'admin_menu' , $plugin_admin , 'submenu_page');
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin , 'custom_meta_box' );
		$this->loader->add_action( 'save_post_vnh_room_type', $plugin_admin , 'save_room_type_post');
		$this->loader->add_action( 'save_post_vnh_hotel', $plugin_admin , 'save_hotel_post');
		$this->loader->add_action( 'save_post_vnh_location', $plugin_admin , 'save_location_post');
		$this->loader->add_action( 'save_post_vnh_booking', $plugin_admin , 'save_booking_post',10,3);
		$this->loader->add_filter( 'manage_vnh_room_type_posts_columns', $plugin_admin , 'custom_room_type_columns');
		$this->loader->add_action( 'manage_vnh_room_type_posts_custom_column', $plugin_admin, 'custom_room_type_columns_data',10,2);
		$this->loader->add_filter( 'manage_vnh_booking_posts_columns', $plugin_admin, 'custom_booking_columns');
		$this->loader->add_action( 'manage_vnh_booking_posts_custom_column', $plugin_admin, 'custom_booking_columns_data',10,2);

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'custom_admin_notices');
		
		$this->loader->add_action( 'wp_ajax_get_room_types', $plugin_admin, 'handle_get_room_types');
		$this->loader->add_action( 'wp_ajax_nopriv_get_room_types', $plugin_admin, 'handle_get_room_types');

		$this->loader->add_action( 'wp_ajax_check_availability', $plugin_admin, 'handle_check_availability');
	}

	private function define_public_hooks() {

		$plugin_public = new Vnh_Booking_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_public, 'handleClientRequests');

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
