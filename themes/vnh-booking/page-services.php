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
    <div class="feature__characteristic">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <div class="feature__content-title">
                <h2>3 dịch vụ của Khách sạn VNH</h2>
                </div>
                <div class="feature__content-background" style="background: linear-gradient(#00000080, #00000080), url(<?php echo wp_get_attachment_url(590); ?>) 50% / cover no-repeat">
                <p class="highlight__text">
                    Cảm ơn Quý khách hàng đã quan tâm đến dịch vụ Khách sạn VNH.
                    Chúng tôi là thương hiệu khách sạn mang phong cách Nhật Bản dành cho
                    các thương gia sang công tác tại Việt Nam và hoạt động với mục tiêu
                    tạo cho khách hàng sự thoải mái và cảm giác an toàn như ở nhà, bằng
                    những tiện nghi mang phong cách Nhật Bản. Chi nhánh đầu tiên của
                    VNH được mở cửa tại con đường Thái Văn Lung, thành phố Hồ Chí
                    Minh từ năm 2011 và hiện tại chúng tôi đã mở rộng với 4 chi nhánh
                    tại Hà Nội, 1 tại Hải Phòng, 1 tại Đà Nẵng và 4 chi nhánh tại Hồ Chí
                    Minh. Chúng tôi mang đến cho khách hàng 3 dịch vụ với chất 
                    lượng tiêu chuẩn cao ở tất cả các chi nhánh.
                </p>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php
        get_template_part( 'template-parts/content-service', 'list');
    ?>
</main>   
<?php
get_footer();