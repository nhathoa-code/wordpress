<?php

class Post{

    public function saveRoomType($post_id,$data){
        update_post_meta($post_id,'hotel',$data['hotel']);
        update_post_meta($post_id,'bed_type',$data['bed_type']);
        update_post_meta($post_id,'services',$data['services']);
		update_post_meta($post_id, 'vnh_room_type_meta', $data);
    }
    
    public function saveHotel($post_id,$data){
        update_post_meta($post_id,'gallery',$data['gallery']);
        update_post_meta($post_id,'location',$data['location']);
    }

    public function getServices(){
        return get_posts(array(
            "post_type" => "vnh_hotel_service"
        ));
    }

    public function getHotels(){
        return get_posts(array(
            "post_type" => "vnh_hotel",
            "nopaging" => true
        ));
    }

    public function getBedTypes(){
        return get_posts(array(
            "post_type" => "vnh_hotel_bed_type" 
        ));
    }
}