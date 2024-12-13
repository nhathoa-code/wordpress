<?php 
  $booking_date = checkBookingDate();
?>
<div class="room__title">
  Giới thiệu phòng
  <img
    class="style-line"
    src="https://azumayavietnam.com/image/logo/style-line.png"
    alt=""
  />
</div>

<div class="container my-5">
  <div class="row">
    <?php foreach($room_types as $rt): ?>
      <div class="col-md-12 col-lg-6">
        <div class="room-item">
          <div class="carousel-root">
            <?php echo get_the_post_thumbnail($rt->ID); ?>
            <?php 
              $count_arr = get_query_var("count_arr");
              $meta = get_post_meta($rt->ID,"vnh_room_type_meta",true);
              $bed_type = get_post(get_post_meta($rt->ID,"bed_type",true));
              $gallery = $meta["gallery"];
              foreach($gallery as $item): 
            ?>
              <?php echo wp_get_attachment_image($item,'full'); ?>
            <?php endforeach; ?>
          </div>
          <div class="card" style="border: none">
            <div class="row p-0">
              <div class="col-md-12"></div>
              <div class="col-md-12">
                <div class="card-body">
                  <div class="card-title room-name"><?php echo $rt->post_title; ?></div>
                  <table class="room__des-table">
                    <tbody>
                      <tr>
                        <th>Kích thước</th>
                        <td class="installation"><?php echo $meta["room_size"] ?>m²</td>
                      </tr>
                      <tr>
                        <th>Giường</th>
                        <td class="installation"><?php echo $bed_type->post_title; ?></td>
                      </tr>
                      <tr>
                        <th>Trang thiết bị</th>
                        <td class="installation">
                          <?php 
                            $aminities = wp_get_post_terms($rt->ID,"amenity");
                            foreach($aminities as $item):
                          ?>
                            <svg style="fill:#482979;height:15px;width:15px;margin-right:10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg><?php echo $item->name; ?><br />
                          <?php endforeach; ?>
                        </td>
                      </tr>
                      <?php if($booking_date): ?>
                        <tr>
                          <th>Còn</th>
                          <td class="installation"><?php echo isset($count_arr[$rt->ID]) ? $meta["quantity"] - $count_arr[$rt->ID] : $meta["quantity"]; ?> phòng</td>
                        </tr>
                      <?php endif; ?>
                      <tr>
                        <th>Giá</th>
                        <td class="installation bold"><?php echo number_format($meta["price"],0,"",".") ?>VNĐ+</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <form method="GET" action="reservation">
              <input type="hidden" name="check-in" value="<?php echo $booking_date ? $_GET["check-in"] : date("d-m-Y"); ?>">
              <input type="hidden" name="check-out" value="<?php echo $booking_date ? $_GET["check-out"] : date("d-m-Y",strtotime("+1 day")); ?>">
              <input type="hidden" name="location" value="<?php echo $_GET["location"] ?? ""; ?>">
              <input type="hidden" name="hotel" value="<?php echo get_the_ID(); ?>">
              <input type="hidden" name="room_type" value="<?php echo $rt->ID; ?>">
              <button class="btn__reserve p-0">Đặt phòng</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<script>
  jQuery(document).ready(function ($) {
     $(".room-item .carousel-root").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      dots: true,
      prevArrow: `<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style=""><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
  </svg></button>`,
      nextArrow: `<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi        bi-chevron-right" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
    </svg></button>`,
    });
  });
</script>