<?php

class Vnh_Custom_Taxonomy {

    private function getLabels() {
        return array();
    }

    private function getArgs() {
        return array(
            'hierarchical' => true,
	    );
    }

    public function register_amenity_taxonomy() {
        $labels = $this->getLabels();
        $labels =  array(
            'singular_name'     => 'Amenity',
            'search_items'      => 'Search Amenities',
            'all_items'         => 'All Amenities',
            'parent_item'       => 'Parent Amenity',
            'parent_item_colon' => 'Parent Amenity:',
            'edit_item'         => 'Edit Amenity',
            'update_item'       => 'Update Amenity',
            'add_new_item'      => 'Add New Amenity',
            'new_item_name'     => 'New Amenity Name',
	    );
        $args = $this->getArgs();
        $labels["name"] = "Amenities";
        $labels["menu_name"] = "Amenities";
        $args["labels"] = $labels;
	 	register_taxonomy('amenity', [ 'vnh_room_type' ], $args );
    }

}