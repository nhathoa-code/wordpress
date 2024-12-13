<?php

class Vnh_Custom_Post_Type {

    private $config = array(
        'public'      => true,
        'has_archive' => true,
    );

    public function register_room_type_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Room types",
            'singular_name' => "Room type",
            'add_new' => "Add new room type",
            "add_new_item" => "Add new room type"
        );
        $config['rewrite'] =  array( 'slug' => 'room-types' );
        $config['supports'] = array( 'title' ,'thumbnail' );
        $config['menu_icon'] = 'dashicons-list-view';
        register_post_type('vnh_room_type',$config);
    }

    public function register_hotel_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Hotels",
            'singular_name' => "hotel",
            'add_new' => "Add new hotel",
            "add_new_item" => "Add new hotel"
        );
        $config['rewrite'] =  array( 'slug' => 'hotels' );
        $config['supports'] = array( 'editor', 'title', 'thumbnail' );
        $config['show_in_menu'] = "edit.php?post_type=vnh_room_type";
        register_post_type('vnh_hotel',$config);
    }

    public function register_service_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Services",
            'singular_name' => "Service",
            'add_new' => "Add new service",
            "add_new_item" => "Add new service"
        );
        $config['rewrite'] =  array( 'slug' => 'service' );
        $config['supports'] = array( 'title', 'editor', 'thumbnail' );
        $config['show_in_menu'] = "edit.php?post_type=vnh_room_type";
        register_post_type('vnh_hotel_service',$config);
    }

    public function register_bed_type_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Bed types",
            'singular_name' => "Bed type",
            'add_new' => "Add new Bed type",
            "add_new_item" => "Add new bed type"
        );
        $config['rewrite'] =  array( 'slug' => 'bed-types' );
        $config['supports'] = array( 'title' ,'thumbnail' );
        $config['show_in_menu'] = "edit.php?post_type=vnh_room_type";
        register_post_type('vnh_hotel_bed_type',$config);
    }

    public function register_location_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Locations",
            'singular_name' => "location",
            'add_new' => "New Location",
            "add_new_item" => "New Location",
        );
        $config['show_in_menu'] = "edit.php?post_type=vnh_room_type";
        $config['rewrite'] =  array( 'slug' => 'hotel-location' );
        $config['supports'] = array( 'title', 'thumbnail' );
        register_post_type('vnh_location',$config);
    }


    public function register_booking_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Vnh Bookings",
            'singular_name' => "vnh booking",
            'add_new' => "New Booking",
            "add_new_item" => "New Booking",
            'edit_item' => "Edit Booking"
        );
        $config['has_archive'] = false;
        $config['rewrite'] =  false;
        $config['supports'] = array();
        $config['menu_icon'] = 'dashicons-calendar-alt';
        register_post_type('vnh_booking',$config);
    }

    public function register_banner_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Banners",
            'singular_name' => "banner",
            'add_new' => "New Banner",
            "add_new_item" => "New Banner",
        );
        $config['show_in_menu'] = "edit.php?post_type=vnh_booking";
        $config['rewrite'] =  array( 'slug' => 'vnh-bookings' );
        $config['supports'] = array( 'editor' , 'title', 'thumbnail' );
        register_post_type('vnh_banner',$config);
    }

    public function register_feature_post_type() {
        $config = $this->config;
        $config['labels'] = array(
            'name'          => "Features",
            'singular_name' => "feature",
            'add_new' => "New Feature",
            "add_new_item" => "New Feature",
        );
        $config['show_in_menu'] = "edit.php?post_type=vnh_booking";
        $config['supports'] = array( 'editor' , 'title', 'thumbnail' );
        register_post_type('vnh_hotel_feature',$config);
    }

}