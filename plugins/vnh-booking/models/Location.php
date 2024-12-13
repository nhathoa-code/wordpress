<?php

class Location{

    private $locations = array();

    public function __construct(private $id = 0){
        $this->id = $id;
    }

    public function getAll(){
        $location_objs = get_posts(array(
            "post_type" => "vnh_location",
            "orderby" => "date",
            "order" => "ASC"
        ));
        $results = array();
        foreach($location_objs as $item){
            $results[] = array("id"=>$item->ID,"name"=>$item->post_title,"hotels"=>$this->getHotels($item->ID));
        }
        $this->locations = $results;
        return $results;
    }

    public function getHotels($location_id){
        if(!empty($this->locations)){
            $indexed_array = array_column($this->locations,null,'id');
            if(isset($indexed_array[$location_id])){
                return $indexed_array[$location_id]["hotels"];
            }
            return $this->locations[0]["hotels"];
        }else{
            $results = get_posts(array(
                    "post_type" => "vnh_hotel",
                    "meta_query" => array(
                        [
                            "key" => "location",
                            "value" => $location_id,
                            "compare" => "="
                        ]
                    ),
                    'orderby'   => 'date',             
                    'order'     => 'ASC' 
                ));
                $results = array_map(function($item){
                    return array(
                        "id" => $item->ID,
                        "name" => $item->post_title,
                        "permalink" => get_the_permalink($item->ID)
                    );
                },$results);
            return $results;
        }
    }

}