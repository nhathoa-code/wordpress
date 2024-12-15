<?php

class ClientController{
    public function makeReservation(){
        if(!wp_doing_ajax()){
            wp_die("Yêu cầu không hợp lệ");
        }
        if (!isset($_POST['reservation_nonce']) || !wp_verify_nonce($_POST['reservation_nonce'], 'reservation')) {
           wp_send_json_error(["error_nonce"=>true],400);
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
        if(checkBookingDate()){
            $arr = $hotel->checkAvailability($_GET['check-in'],$_GET['check-out']);
            $room_types = $arr[0];
            $count_arr = $arr[1];
            set_query_var("count_arr",$count_arr);
        }else{
            $room_types = $hotel->getRoomTypes();
        }
        set_query_var("room_types",$room_types);
        
    }
}