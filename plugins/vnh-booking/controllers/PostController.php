<?php

class PostController{
    public function saveRoomType($post_id){
        if ('auto-draft' === get_post_status($post_id)) {
        	return;
    	}
        if (get_post_type($post_id) !== "vnh_room_type") {
			return;
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		if (!current_user_can('edit_post',$post_id)) {
        	wp_die('You do not have permission to edit this post.');
    	}
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vnh-validator.php';
        $validator = new Validator();
		$validationCheck = $validator->dontRedirect()->validate(
		array(
			"hotel" => "bail|required|postTypeExists:vnh_hotel",
			"bed_type" => "bail|required|postTypeExists:vnh_hotel_bed_type",
			"room_size" => "bail|required|numeric",
			"price" => "bail|required|numeric",
			"opacity" => "bail|required|integer",
			"quantity" => "bail|required|integer",
			"services" => "bail|nullable|array|postTypeExists:vnh_hotel_service",
			"floor_plan" => "bail|nullable|string",
			"gallery" => "bail|required|array|string"
		),
		array(
			"room_size.required" => "Vui lòng nhập kích cỡ phòng",
			"price.required" => "Vui lòng nhập giá",
			"quantity.required"=>"Vui lòng nhập số lượng",
			"gallery.required" => "Vui lòng tải sưu tập ảnh"
		)
		);
		if($validationCheck === false){
			if(!get_post_meta($post_id,"hotel",true)){
				wp_delete_post($post_id);
			}
			wp_redirect(wp_get_referer());
            exit;
		}
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/post.php';
        $post = new Post();
		$data = array(
			"hotel" => $_POST["hotel"],
			"bed_type" => $_POST["bed_type"],
			"room_size" => $_POST["room_size"],
			"opacity" => $_POST["opacity"],
			"price" => $_POST["price"],
			"quantity" => $_POST["quantity"],
			"services" => isset($_POST["services"]) ? $_POST["services"] : [],
			"floor_plan" => $_POST["floor_plan"],
			"gallery" => isset($_POST["gallery"]) ? $_POST["gallery"] : []
		);
        $post->saveRoomType($post_id,$data); 
    }

	public function saveHotel($post_id){
        if ('auto-draft' === get_post_status($post_id)) {
        	return;
    	}
        if (get_post_type($post_id) !== "vnh_hotel") {
			return;
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
    	$post_status = get_post_status($post_id);
		if ($post_status === 'trash') {
			return;
		}
		if (!current_user_can('edit_post',$post_id)) {
        	wp_die('You do not have permission to edit this post.');
    	}
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/post.php';
        $post = new Post();
		$data = array(
			"location" => $_POST["location"],
			"gallery" => $_POST["gallery"]
		);
        $post->saveHotel($post_id,$data);
    }

	public function saveLocation($post_id){
		if (!current_user_can('edit_post',$post_id)) {
        	wp_die('You do not have permission to edit this post.');
    	}
		update_post_meta($post_id,"gallery",$_POST["gallery"]);
	}

	public function updateBooking($post_id,$update){
        if ('auto-draft' === get_post_status($post_id)) {
        	return;
    	}
        if (get_post_type($post_id) !== "vnh_booking") {
			return;
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		$post_status = get_post_status($post_id);
		if ($post_status === 'trash') {
			return;
		}
		if (!current_user_can('edit_post',$post_id)) {
        	wp_die('You do not have permission to edit this post.');
    	}
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/Booking.php';
        $booking = new Booking();
		if(!empty(get_post_meta($post_id,"booking-meta",true))){
			$booking->updateBooking($post_id);
		}else{
			require_once WP_PLUGIN_DIR . '/vnh-booking/includes/class-vnh-validator.php';
			$validator = new Validator();
			$current_date = (new DateTime())->format("d-m-Y");
			$validated = $validator->dontRedirect()->validate([
				"check-in" => "bail|required|date|date_format:d-m-Y|min:{$current_date}",
				"check-out" => "bail|required|date|date_format:d-m-Y|after:check-in",
				"hotel" => "bail|required|postTypeExists:vnh_hotel",
				"check-in-time" => "required",
				"check-out-time" => "required",
				"room_type" => "bail|required|postTypeExists:vnh_room_type",
				"quantity" => "required|integer|max:5",
				"guests" => "required|integer",
				"g_firstName" => "required",
				"g_lastName" => "required",    
				"g_gender" => "required",
				"g_email" => "bail|required|email",
				"g_phone" => "bail|required|regex:/^0[0-9]{9}$/",
				"payment_method" => "required"
			],[
				"check-in.required" => "Vui lòng nhập thời gian nhận phòng",
				"check-in.required" => "Vui lòng nhập thời gian trả phòng",
				"g_phone.regex" => "Số điện thoại không hợp lệ"
			]);
			if($validated === false){
				wp_delete_post($post_id);
				wp_redirect(wp_get_referer());
				exit;
			}
        	require_once WP_PLUGIN_DIR . '/vnh-booking/models/Hotel.php';
			$hotel = new Hotel($validated["hotel"]);
			$check = $hotel->checkAvailability($validated["check-in"],$validated["check-out"],$validated["room_type"]);
			if(!$check){
				session_start();
				wp_delete_post($post_id);
				wp_redirect(wp_get_referer());
				exit;
			}
			$booking->addNewBooking($post_id,$validated);
		}
    }
}