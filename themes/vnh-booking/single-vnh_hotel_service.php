<?php
    get_header();
?>
<main id="primary" class="site-main">
    <div class="policies__header" style="background:url('<?php echo wp_get_attachment_url(444,'full'); ?>') 50% / cover no-repeat">
        <div class="container">
            <div class="row">
            <div class="col-md-12"><h1>Dịch vụ</h1></div>
            </div>
        </div>
    </div>
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
    <?php
		get_template_part( 'template-parts/content-hotel', 'service');
	?>
</main>   
<?php
get_footer();