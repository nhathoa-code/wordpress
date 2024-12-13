<?php

class Vnh_Booking_Admin {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function init(){
		remove_post_type_support( "vnh_booking", "title" );
		remove_post_type_support( "vnh_booking", "editor" );
	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vnh-booking-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {
		$screen = get_current_screen();
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vnh-booking-admin.js', array( 'jquery' ), $this->version, false );

		if($screen->post_type === "vnh_booking" && $screen->action === "add"){
			wp_enqueue_style( 'flatpickr-style', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css' );
			wp_enqueue_script( 'flatpickr-script', 'https://cdn.jsdelivr.net/npm/flatpickr' );
			wp_localize_script( $this->plugin_name, 'localizedData', array(
				"add_new_booking"=>true,
				"ajax_url" => admin_url('admin-ajax.php'),
				"nonce" => wp_create_nonce('my_ajax_nonce'),
			));
		}
    
		if ($screen->post_type === 'vnh_room_type' && ($screen->base === 'post' || $screen->base === 'edit')) { 
			wp_enqueue_media();
		}
	}
	
	public function custom_taxonomy() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-taxonomy.php';
		$custom_taxonomy = new Vnh_Custom_Taxonomy();
		$custom_taxonomy->register_amenity_taxonomy();
	}

	public function custom_post_type() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-post-type.php';
		$custom_post_type = new Vnh_Custom_Post_Type();
		$custom_post_type->register_room_type_post_type();
		$custom_post_type->register_hotel_post_type();
		$custom_post_type->register_service_post_type();
		$custom_post_type->register_bed_type_post_type();
		$custom_post_type->register_booking_post_type();
		$custom_post_type->register_banner_post_type();
		$custom_post_type->register_location_post_type();
		$custom_post_type->register_feature_post_type();
	}

	public function submenu_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-admin-menu.php';
		$admin_menu = new Vnh_Admin_Menu();
		$admin_menu->booking_history_page();
	}

	public function custom_meta_box() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-meta-box.php';
		$meta_box = new Vnh_Custom_Meta_Box();
		$screen = get_current_screen();
		if($screen->action == ''){
			$meta_box->remove_public_booking_box();
			$meta_box->add_booking_info_box();
			$meta_box->add_custom_publish_booking_box();
			$meta_box->add_custom_events_log_box();
			$meta_box->add_room_type_info_box();
			$meta_box->add_guest_info_box();
		}
		if($screen->action == 'add'){
			$meta_box->add_new_booking_info_box();
			$meta_box->add_new_guest_info_box();
		}
		$meta_box->add_room_type_meta_box();
		$meta_box->add_room_type_images_box();
		$meta_box->add_hotel_location_box();
		$meta_box->add_hotel_images_box();
		$meta_box->add_location_images_box();
	}

	public function save_room_type_post($post_id){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'controllers/PostController.php';
		$post_controller = new PostController();
		$post_controller->saveRoomType($post_id);
	}

	public function save_hotel_post($post_id){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'controllers/PostController.php';
		$post_controller = new PostController();
		$post_controller->saveHotel($post_id);
	}

	public function save_location_post($post_id){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'controllers/PostController.php';
		$post_controller = new PostController();
		$post_controller->saveLocation($post_id);
	}

	public function save_booking_post($post_id,$post,$update){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'controllers/PostController.php';
		$post_controller = new PostController();
		$post_controller->updateBooking($post_id,$update);
	}

	public function custom_room_type_columns($columns){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-room-type-columns.php';
		$custom_booking_columns = new Vnh_Custom_Booking_Columns();
		return $custom_booking_columns->columns($columns);
	}

	public function custom_room_type_columns_data($column,$post_id){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-room-type-columns.php';
		$custom_booking_columns = new Vnh_Custom_Booking_Columns();
		$custom_booking_columns->data($column,$post_id);
	}

	public function custom_booking_columns($columns){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-booking-columns.php';
		$custom_booking_columns = new Vnh_Custom_Booking_Columns();
		return $custom_booking_columns->columns($columns);
	}

	public function custom_booking_columns_data($column,$post_id){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-booking-columns.php';
		$custom_booking_columns = new Vnh_Custom_Booking_Columns();
		$custom_booking_columns->data($column,$post_id);
	}

	public function admin_init(){
		if(!session_id()){
			session_start();
		}
		if(isset($_SESSION["errors"])){
			global $errors;
			global $old;
			$errors = $_SESSION["errors"];
			$old = $_SESSION["old"];
			unset($_SESSION["errors"],$_SESSION["old"]);
		}
	}

	public function add_custom_role(){
		$admin_role = get_role('administrator');
    	$admin_capabilities = $admin_role->capabilities;
		$excluded_capabilities = [
			'edit_users',
			'create_users',
			'delete_users',
			'promote_users',
			'delete_published_posts'
		];
		foreach ($excluded_capabilities as $capability) {
			unset($admin_capabilities[$capability]);
		}
		if (!get_role('custom_admin_no_users')) {
			add_role('guest', 'Guest', $admin_capabilities);
		}
	}

	public function custom_admin_notices(){
		global $errors;
		if(isset($errors)){
			foreach($errors as $er){
				echo '<div class="notice notice-error is-dismissible"><p>' . array_values($er)[0] . '</p></div>';
			}
		}
	}

	public function handle_get_room_types(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/Hotel.php';
		$hotel_id = $_GET["hotel_id"];
		$hotel = new Hotel($hotel_id);
		$room_types = $hotel->getRoomTypes();
		foreach($room_types as $item){
			$meta = get_post_meta($item->ID,"vnh_room_type_meta",true);
			$item->price = (int) $meta["price"];
		}
		wp_send_json_success($room_types);
	}


	public function handle_check_availability(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/Hotel.php';
		$hotel = $_GET['hotel'] ?? null;
		$check_in = $_GET['check_in'] ?? null;
		$check_out = $_GET['check_out'] ?? null;
		$Hotel = new Hotel($hotel);
		$x = $Hotel->checkAvailability($check_in,$check_out);
		wp_send_json_success($x);
	}

	public function filter_bookings_by_status($query) {
		if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'vnh_booking') {
			$status = isset($_GET['status']) ? $_GET['status'] : '';
			if ($status) {
				$query->set('meta_query', [
					[
						'key'   => 'status', 
						'value' => $status,
						'compare' => '=', 
					],
				]);
			}
    	}
	}

	public function customize_post_type_views($views) {
		global $post_type;
		if ($post_type === 'vnh_booking') {
			unset($views['publish']);
			$views['spending'] = sprintf(
				'<a href="%s" class="%s">%s</a>',
				admin_url("edit.php?post_type=vnh_booking&status=spending"), 
				isset($_GET['custom_param']) ? 'current' : '',
				'Chờ xác nhận (' . $this->get_posts_count_by_meta("status","spending") . ')' 
			);
			$views['confirmed'] = sprintf(
				'<a href="%s" class="%s">%s</a>',
				admin_url("edit.php?post_type=vnh_booking&status=confirmed"), 
				isset($_GET['custom_param']) ? 'current' : '',
				'Đã xác nhận (' . $this->get_posts_count_by_meta("status","confirmed") . ')' 
			);
			$views['checked-in'] = sprintf(
				'<a href="%s" class="%s">%s</a>',
				admin_url("edit.php?post_type=vnh_booking&status=checked-in"), 
				isset($_GET['custom_param']) ? 'current' : '',
				'Đã nhận phòng (' . $this->get_posts_count_by_meta("status","checked-in") . ')'
			);
		}
		return $views;
	}

	public function get_posts_count_by_meta($meta_key, $meta_value) {
		$query = new WP_Query([
			'post_type'  => 'vnh_booking',
			'meta_key'   => $meta_key,
			'meta_value' => $meta_value,
		]);
		return $query->found_posts;
	}
}
