<?php

class Vnh_Custom_Meta_Box {
    
    public function add_room_type_meta_box() {
        add_meta_box(
			'room_type_meta_box',
			'Room type\'s meta information',
            [$this,'html_room_type_meta_box'],
			'vnh_room_type'
		);
    }

    public function html_room_type_meta_box($room_type) {
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/Post.php';
        $post = new Post();
        $hotels = $post->getHotels();
        $bed_types = $post->getBedTypes();
        $services = $post->getServices();
        $meta = get_post_meta($room_type->ID,"vnh_room_type_meta",true);
        $hotel = get_post_meta($room_type->ID,"hotel",true);
        $bed_type = get_post_meta($room_type->ID,"bed_type",true);
        $room_type_services = get_post_meta($room_type->ID,"services",true);
        $floor_plan = !empty($meta["floor_plan"]) ? get_post($meta["floor_plan"]) : null;
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/room-type-meta-box.php';
    }

    public function add_room_type_images_box() {
        add_meta_box(
			'room_type_images_box', 
			'Room type\'s images',
            [$this,'html_room_type_images_box'],
			'vnh_room_type'
		);
    }

    public function html_room_type_images_box($room_type) {
        $meta = get_post_meta($room_type->ID,"vnh_room_type_meta",true);
        $urls = array();
        if(isset($meta["gallery"]) && is_array($meta["gallery"])){
            foreach($meta["gallery"] as $item){
                $urls[] = get_post($item);
            }
        }
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/room-type-images-box.php';
    }

    public function add_hotel_location_box() {
        add_meta_box(
			'hotel_location_box', 
			'Hotel\'s location',
            [$this,'html_hotel_location_box'],
			'vnh_hotel'
		);
    }

    public function html_hotel_location_box($hotel) {
        $location = get_post_meta($hotel->ID,"location",true);
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/hotel-location-box.php';
    }

    public function add_hotel_images_box() {
        add_meta_box(
			'hotel_images_box', 
			'Hotel\'s images',
            [$this,'html_hotel_images_box'],
			'vnh_hotel'
		);
    }

    public function html_hotel_images_box($hotel) {
        $images = !empty(get_post_meta($hotel->ID,"gallery",true)) ? 
        get_post_meta($hotel->ID,"gallery",true) 
        : [];
        $urls = array();
        foreach($images as $item){
            $urls[] = get_post($item);
        }
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/hotel-images-box.php';
    }

    public function add_booking_info_box() {
        add_meta_box(
			'booking_info_box', 
			'Booking\'s Information',
            [$this,'html_booking_info_box'],
			'vnh_booking'
		);
    }

    public function html_booking_info_box($booking) {
        $check_in = get_post_meta($booking->ID,"check-in",true);
        $check_out = get_post_meta($booking->ID,"check-out",true);
        $meta = get_post_meta($booking->ID,"booking-meta",true);
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/booking-info-box.php';
    }

    public function add_room_type_info_box() {
        add_meta_box(
			'room_type_info_box', 
			'Room type\'s Information',
            [$this,'html_room_type_info_box'],
			'vnh_booking'
		);
    }

    public function html_room_type_info_box($booking) {
        $meta = get_post_meta($booking->ID,"booking-meta",true);
        $hotel = get_post(get_post_meta($booking->ID,"hotel",true));
		$room_type = get_post(get_post_meta($booking->ID,"room-type",true));
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/room-type-info-box.php';
    }

    public function add_guest_info_box() {
        add_meta_box(
			'guest_info_box', 
			'Guest\'s Information',
            [$this,'html_guest_info_box'],
			'vnh_booking'
		);
    }

    public function html_guest_info_box($booking) {
        $meta = get_post_meta($booking->ID,"booking-meta",true);
        $guest = $meta["guest_info"];
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/guest-info-box.php';
    }

    public function remove_public_booking_box() {
       remove_meta_box('submitdiv', 'vnh_booking', 'side');
    }

    public function add_custom_publish_booking_box() {
        add_meta_box(
            'custom_submitdiv',         
            'Update Booking',  
            [$this,'html_custom_publish_booking_box'], 
            'vnh_booking',            
            'side',                    
            'high'                   
        );
        
    }

    public function html_custom_publish_booking_box($booking) {
        $meta = get_post_meta($booking->ID,"booking-meta",true);
        $delete_link = get_delete_post_link($booking);
        $status_arr = array("spending","confirmed","checked-in","checked-out");
        $status = get_post_meta($booking->ID,"status",true);
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/custom-publish-booking-box.php';
    }

    public function add_custom_events_log_box() {
        add_meta_box(
            'events_log_box',         
            'Events log',  
            [$this,'html_custom_event_log_box'], 
            'vnh_booking',            
            'side',                    
            'low'                   
        );
    }

    public function html_custom_event_log_box($booking) {
        $log = get_post_meta($booking->ID,"log",true);
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/events-log-box.php';
    }

    public function add_new_booking_info_box() {
        add_meta_box(
            'new_booking_info_box', 
			'Booking\'s Information',
            [$this,'html_add_new_booking_info_box'],
			'vnh_booking' 
        );
    }

    public function html_add_new_booking_info_box($booking) {
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/Post.php';
        $post = new Post();
        $hotels = $post->getHotels();
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/add-new-booking-info-box.php';
    }

    public function add_new_guest_info_box() {
        add_meta_box(
            'new_guest_info_box', 
			'Guest\'s Information',
            [$this,'html_add_new_guest_info_box'],
			'vnh_booking' 
        );
    }

    public function html_add_new_guest_info_box($booking) {
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/add-new-guest-info-box.php';
    }

    public function add_location_images_box() {
        add_meta_box(
			'location_images_box', 
			'Location\'s images',
            [$this,'html_location_images_box'],
			'vnh_location'
		);
    }

    public function html_location_images_box($location) {
        $images = !empty(get_post_meta($location->ID,"gallery",true)) ? 
        get_post_meta($location->ID,"gallery",true) 
        : [];
        $urls = array();
        foreach($images as $item){
            $urls[] = get_post($item);
        }
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/location-images-box.php';
    }
}