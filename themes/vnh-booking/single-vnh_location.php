<?php
get_header();
?>
<main id="primary" class="site-main">
    <section id="banner">
        <div id="banner-slider">
            <?php 
                $gallery = get_query_var("gallery");
                foreach($gallery as $item):
            ?>
            <div class="position-relative awssld__content" style="height:120%">
                <img style="width:100%" src="<?php echo wp_get_attachment_url($item,'full'); ?>">
                <div class="banner position-absolute hotel-title">
                    <?php the_title(); ?> 
                </div>
            </div>			
            <?php endforeach; ?> 		
        </div>
    </section>  
    <?php
		get_template_part( 'template-parts/looking-booking', 'form',array("locations"=>get_query_var("locations")));
	?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="re__breadcrumb">
                    <?php custom_breadcrumb(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="branch__container">
        <div class="container">
            <?php
                $args = array(
                    'post_type' => 'vnh_hotel',
                    'meta_query' => array(
                        array(
                            'key' => 'location',
                            'value' => get_the_ID(),
                            'compare' => '='
                        )
                    )
                );
                $custom_query = new WP_Query($args);
                if ( $custom_query->have_posts() ) : ?>
                    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
                        <div class="animated fadeInUp" style="animation-duration: 1s">
                            <div class="feature__type-item">
                                <div class="card">
                                    <div class="row p-0">
                                        <div class="col-md-5">
                                        <div
                                            class="brand-img"
                                            style="
                                            background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>');
                                            "
                                        ></div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="card-body">
                                            <div class="card-title"><h2><?php the_title(); ?></h2></div>
                                            <div class="card-text">
                                                <?php the_content(); ?>
                                            </div>
                                        </div>
                                        <div class="btn-holder">
                                            <div class="btn__detail control-position">
                                            <a href="<?php echo get_the_permalink(); ?>"
                                                >Nhấn để xem chi tiết</a
                                            >
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php	endwhile; 
                    wp_reset_postdata();
                endif;
	        ?>
        </div>
    </div>

</main>
<?php
get_footer();
