<select name="location">
    <?php
        $args = array(
            'post_type' => 'vnh_location',
            'orderby'   => array(
                'date' =>'ASC'
            )
        );
        $custom_query = new WP_Query($args);
        if ( $custom_query->have_posts() ) : ?>
        <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
            <option <?php selected(get_the_ID() == $location) ?> value="<?php echo get_the_ID(); ?>"><?php echo the_title(); ?></option>		
        <?php	endwhile; 
        wp_reset_postdata();
        endif;
    ?>
</select>