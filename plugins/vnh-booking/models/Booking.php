<?php

class Booking{
    public function updateBooking($post_id){
        global $prevent_save_post;
        if (isset($prevent_save_post) && $prevent_save_post == false) {
            return;
        }
        $current_user = wp_get_current_user();
        if (!in_array('administrator', $current_user->roles)) {
            return;
        }
        require_once WP_PLUGIN_DIR . '/vnh-booking/includes/class-vnh-validator.php';
        $validator = new Validator();
        $validated = $validator->validate([
            "status" => "required|in:confirmed,checked-in,checked-out"
        ]);
        if($validated["status"] == "checked-in"){
            $meta = get_post_meta($post_id,"booking-meta",true);
            $validation_arr = array();
            for($i=1;$i<=$meta["quantity"];$i++){
                $validation_arr["room-no-{$i}"] = "required";
            }
            $validated_room_no = $validator->validate($validation_arr);
            $room_no = array();
            for($i=1;$i<=$meta["quantity"];$i++){
                $room_no[] = $validated_room_no["room-no-{$i}"];
            }
            $meta["room-no"] = $room_no;
            update_post_meta($post_id,"booking-meta",$meta);
        }
        $arr = array(
            "confirmed" => "Đã xác nhận",
            "checked-in" => "Đã nhận phòng",
            "checked-out" => "Đã trả phòng"
        );
        $log = get_post_meta($post_id,"log",true);
        $log[] = ["event"=>$arr[$validated["status"]],"date-time"=>date("d-m-Y H:i")];
        if($validated["status"] == "checked-out"){
            $meta = get_post_meta($post_id,"booking-meta",true);
            $guest_info = $meta['guest_info'];
            global $wpdb;
            $table_name = $wpdb->prefix . 'vnh_booking_history';
            $data = array(
                'g_name'  => "{$guest_info['g_firstName']} {$guest_info['g_lastName']}",
                'g_email' => $guest_info['g_email'],
                'g_phone' => $guest_info['g_phone'],
                'check_in' => get_post_meta($post_id,"check-in",true),
                'check_out' => get_post_meta($post_id,"check-out",true),
                'hotel' => get_post_meta($post_id,"hotel",true),
                'room_type' => get_post_meta($post_id,"room-type",true),
                'log' => serialize($log),
                'room_no' => serialize($meta["room-no"])
            );
            $format = array('%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s');
            $wpdb->insert($table_name, $data, $format);
            wp_delete_post($post_id);
        }
        update_post_meta($post_id,"log",$log);
        update_post_meta($post_id,"status",$_POST["status"]);
    }

    public function addNewBooking($post_id,$data){
        $guest_into = array(
            "g_firstName" => $data["g_firstName"],
            "g_lastName" => $data["g_lastName"],
            "g_email" => $data["g_email"],
            "g_phone" => $data["g_phone"],
        );
        $booking_meta = array(
            "quantity" => $data["quantity"],
            "guests" => $data['guests'],
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