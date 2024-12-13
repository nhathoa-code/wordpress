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
            <div class="position-relative">
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
    <?php 
        get_template_part( 'template-parts/content-hotel', 'rooms', array("room_types"=>get_query_var("room_types"),"count_arr"=>get_query_var("count_arr")));
    ?>
</main>
<?php
get_footer();
