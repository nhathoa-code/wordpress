<?php
get_header();
?>
<style>
.content__booking-branch-select,
.content__booking-hotel-name-select {
    border:solid 1px #c5c5c5;
    background-color: inherit;
    color: inherit;
}
</style>
<main id="primary" class="site-main">
    <section id="banner">
        <div class="position-relative">
            <?php echo get_the_post_thumbnail(get_the_ID(),'full',array("class"=>"post-banner hotel-banner")); ?>
            <div class="banner position-absolute hotel-title">
                <?php the_title(); ?> 
            </div>
        </div>			
    </section>  
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="re__breadcrumb">
                <?php custom_breadcrumb(); ?>
            </div>
            </div>
        </div>
    </div>
    <?php
		get_template_part('template-parts/reservation','form',
            [
                "locations"=>get_query_var("locations"),
                "hotel"=>get_query_var("hotel"),
            ]
        );
	?>
    <script>
        var locations = <?php echo json_encode(get_query_var("locations")); ?>;
    </script>
</main>
<?php
get_footer();
