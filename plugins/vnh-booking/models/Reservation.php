<?php

class Reservation{
    public function makeReservation(array $data){
        $post_id = wp_insert_post(array (
            'post_type' => 'vnh_booking',
            'post_status' => 'publish'
        ));
        $guest_into = array(
            "g_firstName" => $data["g_firstName"],
            "g_lastName" => $data["g_lastName"],
            "g_email" => $data["g_email"],
            "g_phone" => $data["g_phone"],
        );
        $booking_meta = array(
            "quantity" => $data["quantity"],
            "guests" => 2,
            "check_in_time" => $data["check-in-time"],
            "check_out_time" => $data["check-out-time"],
            "guest_info" => $guest_into
        );
        update_post_meta($post_id,"check-in",DateTime::createFromFormat('d-m-Y', $data["check-in"])->format('Y-m-d'));
        update_post_meta($post_id,"check-out",DateTime::createFromFormat('d-m-Y', $data["check-out"])->format('Y-m-d'));
        update_post_meta($post_id,"status","spending");
        update_post_meta($post_id,"hotel",$data["hotel"]);
        update_post_meta($post_id,"room-type",$data["room_type"]);
        update_post_meta($post_id,"booking-meta",$booking_meta);
        update_post_meta($post_id,"log",[["event"=>"Đã đặt phòng","date-time"=>date("d-m-Y H:i")]]);
    }
}