<?php

class Vnh_Admin_Menu{

    private $config_menu_page = array(
                "page_title" => "",
                "menu_title" => "",
                "capability" => "",
                "menu_slug" => "",
                "callback" => null,
                "icon_url" => "",
                "position" => null,
            );

    private $config_submenu_page = array();

    public function add_menu_page() {
        $config = $this->config_menu_page;
        $config["page_title"] = "";
    }

    public function add_location_taxonomy_to_menu() {
        add_submenu_page(
            'edit.php?post_type=vnh_room_type',
            'Locations',
            'Locations',
            'manage_categories',
            'edit-tags.php?taxonomy=location&post_type=vnh_room_type'
        );
    }

    public function booking_history_page() {
        global $supporthost_sample_page;
        $supporthost_sample_page = add_submenu_page(
            'edit.php?post_type=vnh_booking',
            'Booking history',
            'Booking history',
            'manage_categories',
            'booking-history',
            [$this,'booking_history_html']
        );
        add_action("load-$supporthost_sample_page", [$this,"supporthost_sample_screen_options"]);
    }

    function supporthost_sample_screen_options() {
        global $supporthost_sample_page;
        global $table;
        $screen = get_current_screen();
        if(!is_object($screen) || $screen->id != $supporthost_sample_page)
            return;
    
        $args = array(
            'label' => __('Elements per page', 'supporthost-admin-table'),
            'default' => 1,
            'option' => 'elements_per_page'
        );
        add_screen_option( 'per_page', $args );
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-booking-history-table.php';
        $table = new Booking_History_Table_List();

    }

    public function booking_history_html() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vnh-custom-booking-history-table.php';
        echo '<div class="wrap">';
        echo '<h1 class="wp-heading-inline">Booking History</h1>';
        if(isset($_GET['s']) && !empty($_GET['s'])){
            echo '<span class="subtitle">Search results for: <strong>' . $_GET['s'] . '</strong></span>';
        }
        //echo '<a href="' . esc_url("") . '" class="page-title-action">Add New</a>';
        $table = new Booking_History_Table_List();
        $table->prepare_items();
        echo '<hr class="wp-header-end">';
        //$table->views();
        echo '<form method="get">';
        echo '<input type="hidden" name="post_type" class="post_type_page" value="vnh_booking">';
        echo '<input type="hidden" name="page" class="post_type_page" value="booking-history">';
        $table->search_box('search', 'search_id');
        $table->display();
        echo '</form>';
        echo '</div>';
    }
}