<?php

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

function my_theme_pass_data_to_template() {
	if (is_singular('vnh_hotel_feature') || is_singular('vnh_booking')) {
        wp_redirect(home_url());
        exit;
    }
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
    require_once WP_PLUGIN_DIR . '/vnh-booking/models/Location.php';
	global $location;
	$location = new Location();
	$locations = $location->getAll();
	set_query_var('locations', $locations);
	if(is_page("reservation")){
		require_once WP_PLUGIN_DIR . '/vnh-booking/controllers/ClientController.php';
		$client_controller = new ClientController();
		return $client_controller->reservation();
	}
	if(get_post_type() == "vnh_hotel"){
		require_once WP_PLUGIN_DIR . '/vnh-booking/controllers/ClientController.php';
		set_query_var("gallery",get_post_meta(get_the_ID(),"gallery",true));
		$client_controller = new ClientController();
		return $client_controller->hotelRoomTypes();
	}
	if(get_post_type() == "vnh_location"){
		set_query_var("gallery",get_post_meta(get_the_ID(),"gallery",true));
		return;
	}
}
add_action('template_redirect', 'my_theme_pass_data_to_template');

function vnh_booking_setup() {

	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'vnh-booking' )
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'vnh_booking_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'vnh_booking_setup' );

function vnh_booking_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vnh_booking_content_width', 640 );
}
add_action( 'after_setup_theme', 'vnh_booking_content_width', 0 );

function vnh_booking_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'vnh-booking' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'vnh-booking' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'vnh_booking_widgets_init' );

function vnh_booking_scripts() {
	wp_enqueue_style( 'vnh-booking-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'base-css', get_template_directory_uri() . '/css/base.css');
	wp_enqueue_style( 'index-css', get_template_directory_uri() . '/css/index.css');
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.bundle.min.js');
	wp_enqueue_style( 'flatpickr-style', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css' );
	wp_enqueue_script( 'flatpickr-script', 'https://cdn.jsdelivr.net/npm/flatpickr' );
	wp_enqueue_script( 'vnh-booking-main-script', get_template_directory_uri() . '/js/main.js', array("jquery"), "1.0", true );
	wp_enqueue_style( 'slick-style', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
	wp_enqueue_script( 'slick-script', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js' );
	$localized_data = array("run-script"=>true);
	$localized_data["run-select-location"] = true;
	if(is_page("reservation")){
		$localized_data["reservation"] = true;
		$localized_data["ajax_url"] = admin_url('admin-ajax.php');
		$localized_data["reservation_nonce"] = wp_create_nonce('reservation');
	}
	wp_localize_script('vnh-booking-main-script', 'localizedData', $localized_data);
}
add_action( 'wp_enqueue_scripts', 'vnh_booking_scripts' );

function hide_admin_bar_from_front_end(){
  if (is_blog_admin()) {
    return true;
  }
  return false;
}
add_filter( 'show_admin_bar', 'hide_admin_bar_from_front_end' );

function get_location_mark($location = ""){
	switch($location){
		case "hcm":
			return array("class"=>"hochiminh hochiminh_home","name"=>"Hồ Chí Minh");
			break;
		case "hn":
			return array("class"=>"hanoi hanoi_home","name"=>"Hà Nội");
			break;
		case "dn":
			return array("class"=>"danang danang_home","name"=>"Đà Nẵng");
			break;
		case "hp":
			return array("class"=>"haiphong haiphong_home","name"=>"Hải Phòng");
			break;
		case "vn";
			return array("class"=>"allbranch allbranch_home","name"=>"Việt Nam");
	}
}

function checkBookingDate(){
	$format = "d-m-Y";
	if(!isset($_GET["check-in"]) || !isset($_GET["check-out"])){
		return false;
	}
	$check_in_date = DateTime::createFromFormat($format, $_GET["check-in"]);
	$check_out_date = DateTime::createFromFormat($format, $_GET["check-out"]);
	if(!($check_in_date && $check_in_date->format($format) == $_GET["check-in"])){
		return false;
	}
	if(!($check_out_date && $check_out_date->format($format) == $_GET["check-out"])){
		return false;
	}
	$current_date = new DateTime();
	if($check_in_date->format("Y-m-d") < $current_date->format("Y-m-d")){
		return false;
	}
	if($check_in_date->format("Y-m-d") > $check_out_date->format("Y-m-d")){
		return false;
	}
	$interval = $check_in_date->diff($check_out_date);
	return $interval->days;
}

function customize_row_actions($actions, $post) {
    if ($post->post_type === 'vnh_booking') {
        unset($actions['inline hide-if-no-js']);
		unset($actions['view']);
    }
    return $actions;
}
add_filter('post_row_actions', 'customize_row_actions', 10, 2);

function get_hotel_permalink() {
	if(isset($_GET["hotel"])){
		$post = get_post((int) $_GET["hotel"]);
		if($post && $post->post_type === "vnh_hotel"){
			return get_permalink($post->ID);
		}
		return null;
	}
	return null;
}

add_action( 'wp_ajax_reservation_submit', 'handle_reservation_submit');
add_action( 'wp_ajax_nopriv_reservation_submit', 'handle_reservation_submit');

function handle_reservation_submit() {
	require_once WP_PLUGIN_DIR . '/vnh-booking/controllers/ClientController.php';
	$client_controller = new ClientController();
	$client_controller->makeReservation();
}

function custom_breadcrumb() {
    echo '<ul class="breadcrumb__list">';
	echo '<li class="breadcrumb__item px-0">';
    echo '<a class="d-flex align-items-center gap-2" href="' . home_url() . '"><svg width="15px" viewBox="0 0 576 512"><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg> Home</a>';
	echo '</li>';
    if (is_category()) {
        echo '<li class="breadcrumb__item">/</li>' . single_cat_title('', false);
    } elseif (is_single()) {
        $category = get_the_category();
        if (!empty($category)) {
            echo '<li class="breadcrumb__item">/</li><a href="' . get_category_link($category[0]->term_id) . '">' . $category[0]->cat_name . '</a>';
        }
        echo '<li class="breadcrumb__item">/</li>' . get_the_title();
    } elseif (is_page() && !is_front_page()) {
        echo '<li class="breadcrumb__item">/</li>' . get_the_title();
    } elseif (is_archive()) {
        echo '<li class="breadcrumb__item">/</li>' . post_type_archive_title('', false);
    } 
    echo '</ul>';
}