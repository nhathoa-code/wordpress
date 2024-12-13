<div class="container p-0" data-rttabs="true">
  <h1 style="font-size: 4rem;" class="text-center mb-5"><?php echo the_title(); ?></h1>
  <div class="col-md-12 p-0" data-rttabs="true" style="margin-top: 20px">
    <ul class="service__list" style="margin-top:10px;height:0" role="tablist">
    </ul>
    <div
      class="react-tabs__tab-panel react-tabs__tab-panel--selected"
      role="tabpanel"
      id="panel0"
      aria-labelledby="tab0"
    >
      <div class="service__content pt-0">
        <div class="row justify-content-center">
          <a class="image-holder p-0" href="/vi/service/"
            ><img
              src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>"
          /></a>
          <?php the_content(); ?>
        </div>
      </div>
    </div>
    <div
      class="react-tabs__tab-panel"
      role="tabpanel"
      id="panel1"
      aria-labelledby="tab1"
    ></div>
    <div
      class="react-tabs__tab-panel"
      role="tabpanel"
      id="panel2"
      aria-labelledby="tab2"
    ></div>
  </div>
</div>
