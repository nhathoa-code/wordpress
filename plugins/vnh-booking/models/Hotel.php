<?php

class Hotel{

    private $id;

    public function __construct($id = 0){
        $this->id = $id;
    }

    public function setId($id){
        $this->id = (int) $id;
    }

    public function getRoomTypeIds(){
        $room_types = $this->getRoomTypes();
        return array_map(function($item){
            return $item->ID;
        },$room_types);
    }

    public function getRoomTypes(){
        $results = array();
        $results = get_posts(array(
                "post_type" => "vnh_room_type",
                "meta_query" => array(
                    [
                        "key" => "hotel",
                        "value" => $this->id,
                        "compare" => "="
                    ]
                ),
                'orderby'   => 'date',             
                'order'     => 'ASC' 
            ));
        return $results;
    }

    public function checkAvailability($check_in,$check_out,$quantity = null,$room_type = null){
        $checkInDate = DateTime::createFromFormat("d-m-Y",$check_in)->format("Y-m-d");
        $checkOutDate = DateTime::createFromFormat("d-m-Y",$check_out)->format("Y-m-d");
        $room_type_ids = $this->getRoomTypeIds($this->id);
        if(!empty($room_type_ids)){
            $meta_query = [
                'relation' => 'AND',
                [
                    'key' => 'check-in',
                    'value' => $checkOutDate,
                    'compare' => '<',
                    'type' => 'DATE'
                ],
                [
                    'key' => 'check-out',
                    'value' => $checkInDate,
                    'compare' => '>',
                    'type' => 'DATE'
                ],
                [
                    'key' => 'hotel',
                    'value' => $this->id,
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ]
            ];
            if($room_type){
                $meta_query[] = [
                    'key' => 'room-type',
                    'value' => $room_type,
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ];
            }
            $booked_rooms = get_posts(array(
                "post_type" => "vnh_booking",
                'meta_query' => $meta_query,
                'fields' => 'ids'
            ));
            foreach($booked_rooms as $b_id){
                $booked_room_type = get_post_meta($b_id, 'room-type', true);
                $quantity = (int) get_post_meta($b_id,'booking-meta',true)['quantity'];
                $booked_room_type_arr[$booked_room_type] = $quantity;
            }
            $count_arr = [];
            foreach ($booked_room_type_arr as $key => $value) {
                if (isset($count_arr[$key])) {
                    $count_arr[$key] += $value;
                } else {
                    $count_arr[$key] = $value;
                }
            }
            if($room_type){
                $room_type_quantity = get_post_meta($room_type,"vnh_room_type_meta",true)["quantity"];
                if(!isset($count_arr[$room_type])){
                    if($quantity > $room_type_quantity){
                        return false;
                    }
                }else{
                    if(($count_arr[$room_type] >= $room_type_quantity) || ($quantity > ($room_type_quantity - $count_arr[$room_type]))){
                        return false;
                    }
                }
                return true;
            }
            foreach($room_type_ids as $key => $item){
                $room_type_quantity = get_post_meta($item,"vnh_room_type_meta",true)["quantity"];
                if(isset($count_arr[$item])){
                    if($count_arr[$item] >= $room_type_quantity){
                        unset($room_type_ids[$key]);
                    }
                }
            }
            $available_rooms = get_posts(array(
                "post_type" => "vnh_room_type",
                "post__in" => $room_type_ids,
                'orderby'   => 'date',             
                'order'     => 'ASC' 
            ));
            foreach($available_rooms as $item){
                $item->meta = get_post_meta($item->ID,"vnh_room_type_meta",true);
            }
            return array($available_rooms,$count_arr);
        }
        return false;
    }
}