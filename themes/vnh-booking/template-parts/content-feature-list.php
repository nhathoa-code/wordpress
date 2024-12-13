<div class="feature__type-list">
  <div class="container" id="containerID">
    <?php 
      $feature_lists = get_posts(array(
        "post_type" => "vnh_hotel_feature",
        "nopaging" => true,
        "orderby" => array(
          "date" => "ASC"
        )
      ));
      foreach($feature_lists as $index => $item):
    ?>
      <div class="animated fadeInUp" style="animation-duration: 1s">
        <div class="feature__type-item" id="1">
          <div class="card mb-3" style="border: none">
            <div class="row g-4">
              <div class="col-md-4">
                <img
                  class="img-fluid"
                  src="<?php echo get_the_post_thumbnail_url($item->ID); ?>"
                  alt=""
                />
                <div class="feature__number"><span><?php echo $index + 1; ?></span></div>
              </div>
              <div class="col-md-8">
                <div class="card-body" style="padding: 0px">
                  <?php
                    echo $item->post_content; 
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
