<?php

class Vnh_Custom_Booking_Columns {
    
    public function columns($columns){
		unset( $columns['title'] );
		$date_column = $columns['date'];
    	unset($columns['date']);
		$columns["id"] = "ID";
		$columns["status"] = "Status";
		$columns["booking-date"] = "Check-in/Check-out";
		$columns["guests"] = "Guests";
		$columns["customer_info"] = "Customer info";
		$columns["price"] = "Price";
		$columns["hotel"] = "Hotel";
		$columns["room_type"] = "Room type";
		$columns["quantity"] = "Quantity";
		$columns["date"] = $date_column;
		return $columns;
	}

    public function data($column,$post_id){
		$check_in = get_post_meta($post_id,"check-in",true);
		$check_out = get_post_meta($post_id,"check-out",true);
		$meta = get_post_meta($post_id,"booking-meta",true);
		$status = get_post_meta($post_id,"status",true);
		$hotel = get_post(get_post_meta($post_id,"hotel",true));
		$room_type = get_post(get_post_meta($post_id,"room-type",true));
		$guest_info = $meta["guest_info"];
		switch ($column) {
			case 'id':
				echo sprintf('<strong><a class="row-title" href="%s" aria-label="“DELUXE GROUND” (Edit)">%s</a></strong>',get_edit_post_link($post_id),"Booking #{$post_id}");
				break;
			case 'booking-date':
				echo "{$check_in} {$meta["check_in_time"]} | {$check_out} {$meta["check_out_time"]}";
				break;
			case 'guests':
				echo $meta["guests"];
				break;
			case 'customer_info':
				echo "<p>{$guest_info["g_firstName"]} {$guest_info["g_lastName"]}</p>";
				echo "<p>{$guest_info["g_email"]}</p>";
				echo "<p>{$guest_info["g_phone"]}</p>";
				break;
			case 'price':
				$room_type_meta = get_post_meta($room_type->ID,'vnh_room_type_meta',true);
				echo number_format($room_type_meta['price'],0,"",".") ."vnd";
				break;
			case 'hotel':
				echo sprintf('<strong><a class="row-title" href="%s" (Edit)">%s</a></strong>',get_edit_post_link($hotel->ID),$hotel->post_title);
				break;
			case 'room_type':
				echo sprintf('<strong><a class="row-title" href="%s" (Edit)">%s</a></strong>',get_edit_post_link($room_type->ID),$room_type->post_title);
				break;
			case 'status' :
				echo $status;
				break;
			case 'quantity' :
				echo $meta['quantity'];
				break;
    	}
	}
}