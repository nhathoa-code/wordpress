<?php

class Vnh_Custom_Booking_Columns {
    
    public function columns($columns){
		$columns["hotel"] = "Hotel";
		$columns["bed_type"] = "Bed type";
		$columns["opacity"] = "Opacity";
		return $columns;
	}

    public function data($column,$post_id){
		$meta = get_post_meta($post_id,"vnh_room_type_meta",true);
		switch ($column) {
			case 'hotel' :
				$hotel = get_post(get_post_meta($post_id,"hotel",true));
				echo $hotel->post_title;
				break;
			case 'bed_type':
				$bt = get_post(get_post_meta($post_id,"bed_type",true));
				echo $bt->post_title;
				break;
			case 'opacity':
				echo "{$meta["opacity"]} people";
				break;
    	}
	}
}