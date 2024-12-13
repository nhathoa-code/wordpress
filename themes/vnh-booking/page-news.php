<?php
    get_header();
?>
<main id="primary" class="site-main">
    <div class="policies__header" style="background:url('<?php echo wp_get_attachment_url(444,'full'); ?>') 50% / cover no-repeat">
        <div class="container">
            <div class="row">
            <div class="col-md-12"><h1>Thông Báo</h1></div>
            </div>
        </div>
    </div>
    <div class="container">
<div class="row">
    <div class="col-md-12">
        <div class="re__breadcrumb">
            <?php custom_breadcrumb(); ?>
        </div>
    </div>
    </div>
</div>
<div class="container">
  <div class="row">
    <div class="new_container col-md-12">
        <?php
            $args = array(
                'post_type' => 'post',
            );
            $custom_query = new WP_Query($args);
            if ( $custom_query->have_posts() ) : ?>
            <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
                <div class="row news_block">
                    <div class="col-md-2 mt-1">
                    <div class="news_box1">
                        <div class="news_time">
                           	<?php echo get_the_date();?>
                        </div>
                       	<?php
                            $tags = get_the_tags();
                            if($tags):
                            $name = $tags[0]->name;
                            $location = get_location_mark($name);
                        ?>
                            <div class="<?php echo $location['class']; ?>"><?php echo $location['name']; ?></div>
                        <?php endif; ?>
                        
                    </div>
                    </div>
                    <div class="col-md-10">
                    <div>
                        <a class="news_title" href="<?php the_permalink(get_the_ID()); ?>">
                            <div>
                                <?php the_title(); ?>
                            </div>
                        </a>
                        <p class="news_content">
                          <?php echo wp_trim_words(get_the_content(), 50, '...'); ?>
                        </p>
                    </div>
                    <div class="continue_read">
                        <a
                        class="continue_link"
                        href="<?php the_permalink(get_the_ID()); ?>"
                        >Xem tiếp <i class="fa-solid fa-arrow-right"></i
                        ></a>
                    </div>
                    </div>
                </div>
            <?php	endwhile; 
            wp_reset_postdata();
            endif;
        ?>
    </div>

  </div>
</div>
</main>   
<?php
get_footer();