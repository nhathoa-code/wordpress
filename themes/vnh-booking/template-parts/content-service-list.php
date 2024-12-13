<div class="feature__type-list">
  <div class="container" id="containerID">
    <?php 
      $feature_lists = get_posts(array(
        "post_type" => "vnh_hotel_service",
        "nopaging" => true,
        "orderby" => array(
          "date" => "ASC"
        )
      ));
      foreach($feature_lists as $item):
    ?>
      <div class="animated fadeInUp" style="animation-duration: 1s">
        <div class="feature__type-item" id="1">
          <div class="card mb-3" style="border: none">
            <div class="row g-4">
              <div class="col">
                <a href="<?php echo get_the_permalink($item->ID); ?>">
                    <img
                    class="img-fluid"
                    src="<?php echo get_the_post_thumbnail_url($item->ID); ?>"
                    alt=""
                    />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
