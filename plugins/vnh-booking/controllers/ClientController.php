<?php

class ClientController{
    public function makeReservation(){
        if (!isset($_POST['reservation_nonce']) || !wp_verify_nonce($_POST['reservation_nonce'], 'reservation')) {
            wp_die('Nonce verification failed.');
        }
        global $prevent_save_post;
        $prevent_save_post = false;
        require_once WP_PLUGIN_DIR . '/vnh-booking/includes/class-vnh-validator.php';
        $validator = new Validator();
        $current_date = (new DateTime())->format("d-m-Y");
        $validated = $validator->validate([
            "check-in" => "bail|required|date|date_format:d-m-Y|min:{$current_date}",
            "check-out" => "bail|required|date|date_format:d-m-Y|after:check-in",
            "hotel" => "bail|required|postTypeExists:vnh_hotel",
            "check-in-time" => "required",
            "check-out-time" => "required",
            "room_type" => "bail|required|postTypeExists:vnh_room_type",
            "quantity" => "bail|required|integer|min:1|max:5",
            "guests" => "bail|required|integer|min:1|max:2",
            "g_firstName" => "required",    
            "g_lastName" => "required",
            "g_gender" => "required",
            "g_email" => "bail|required|email",
            "g_phone" => "bail|required|regex:/^0[0-9]{9}$/",
            "payment_method" => "required"
        ],[
            "g_phone.regex" => "Số điện thoại không hợp lệ"
        ]);
        require_once WP_PLUGIN_DIR . '/vnh-booking/models/Hotel.php';
        $hotel = new Hotel($validated["hotel"]);
        $check = $hotel->checkAvailability($validated["check-in"],$validated["check-out"],$validated["quantity"],$validated["room_type"]);
        if(!$check){
            wp_send_json_error(array("unavailable"=>true),400);
            exit;
        }
        require_once WP_PLUGIN_DIR . '/vnh-booking/models/Reservation.php';
        $reservation = new Reservation();
        $reservation->makeReservation($validated);
    }

    public function reservation() {
        require_once WP_PLUGIN_DIR . '/vnh-booking/models/Hotel.php';
        $hotel = new Hotel(isset($_GET["hotel"]) ? $_GET["hotel"] : 0);
        set_query_var("hotel",$hotel);
    }

    public function hotelRoomTypes() {
        require_once WP_PLUGIN_DIR . '/vnh-booking/models/Hotel.php';
        $hotel = new Hotel(get_the_ID());
        $room_types = $hotel->getRoomTypes();
        global $count_arr;
        set_query_var("room_types",$room_types);
        set_query_var("count_arr",$count_arr);
    }
}