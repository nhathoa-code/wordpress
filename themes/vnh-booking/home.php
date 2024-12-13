<?php
get_header();
?>
	<main id="primary" class="site-main">
		<section id="banner">
			<div id="banner-slider">
				<?php
					$args = array(
						'post_type' => 'vnh_banner',
						'orderby'   => 'date',
        				'order' => 'ASC',
					);
					$custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() ) : ?>
					<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
							<div class="position-relative">
								<?php echo get_the_post_thumbnail(get_the_ID(),attr:array("class"=>"post-banner")); ?>
								<div class="banner position-absolute">
									<?php the_content(); ?> 
								</div>
							</div>						
					<?php	endwhile; 
					wp_reset_postdata();
					endif;
				?>
			</div>
    	</section>  
		<div class="row g-0">
			<?php
				$args = array(
					'post_type' => 'vnh_location',
				);
				$custom_query = new WP_Query($args);
				if ( $custom_query->have_posts() ) : ?>
				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
						<div class="col-6 col-md-3">
							<div class="grid-item location-item">
								<a href="<?php echo get_the_permalink(get_the_ID()); ?>">
									<?php 
										echo get_the_post_thumbnail(get_the_ID(),'full',array("class"=>'location-custom-thumbnail')); 
									?>
								</a>
							</div>
						</div>					
				<?php	endwhile; 
				wp_reset_postdata();
				endif;
			?>
		</div>
		<div class="animated fadeInUp" style="animation-duration: 1s">
			<div class="content__news">
				<div class="container">
					<div class="row align-item-center justify-content-center">
						<div class="col-md-12 col-lg-10">
							<h2 class="content__news-title">
								Thông Tin
							</h2>
							<div class="content__news-list">
								<?php
									$args = array(
										'post_type' => 'post',
									);
									$custom_query = new WP_Query($args);
									if ( $custom_query->have_posts() ) : ?>
									<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
												<div class="row align-items-center py-4">
													<div class="col-md-2 news_branch-container">
														<?php
															$tags = get_the_tags();
															if($tags):
															$name = $tags[0]->name;
															$location_mark = get_location_mark($name);
														?>
															<div class="<?php echo $location_mark['class']; ?>"><?php echo $location_mark['name']; ?></div>
														<?php endif; ?>
													</div>
													<div class="col-md-2 news_date-container">
														<div class="news_box1">
															<div class="news_time-home">
																<?php echo get_the_date();?>
															</div>
														</div>
													</div>
													<div class="col-md-7 news_title-container">
														<div>
															<a class="news_title news_homeTitle" href="<?php echo get_the_permalink(get_the_ID()); ?>">
																<div class="article_title">
																	<?php the_title(); ?>
																</div>
															</a>
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
				</div>
			</div>
		</div>
		<?php
			get_template_part( 'template-parts/looking-booking', 'form',array("locations"=>get_query_var("locations")));
		?>
		<div class="animated fadeInUp" style="animation-duration: 1s">
			<div class="content__welcome" style="background:url('<?php echo wp_get_attachment_url(416) ?>') center center / cover no-repeat">
				<div class="container">
					<div class="row align-item-center">
						<div class="col-md-12 p-3">
						<h1 class="content__welcome-text">
							Chào mừng quý khách đến với Khách sạn VNH<small
							class="welcome_text-small"
							>Mang tới không gian an toàn và yên tâm cho doanh nhân đi công tác
							nước Ngoài</small
							>
						</h1>
						<p class="welcome-content">
							Ngày nay, số lượng doanh nhân từ các nước phát triển đến Việt Nam
							công tác ngày càng tăng theo từng năm.Trong lúc đó, lần đầu tiên đến
							Việt Nam chắc chẵn sẽ có rất nhiều lo lắng như là ẩm thực, ngôn ngữ.
							Ở khách sạn VNH chúng tôi nỗ lực hàng ngày để trở thành nơi dừng
							chân an toàn và yên tâm cho các doanh nhân Nhật Bản dựa trên khái
							niệm "Wa" trong Văn hóa Nhật Bản. Đối với những doanh nhân đi công
							tác nước ngoài, chúng tôi muốn cung cấp một không gian an toàn và
							yên tâm mà không có cảm giác như ở một đất nước xa lạ. Với phương
							châm này, Chúng tôi phục vụ "Tắm lộ thiên" và "Mát xa chân" để giảm
							bớt những mệt mỏi của công việc cũng như tiếp thêm năng lượng cho
							một ngày làm việc bằng bữa ăn sáng kiểu Nhật.Để khách có thể yên tâm
							tận hưởng cuộc sống ở nước ngoài, Chúng tôi cung cấp dịch vụ hiếu
							khách nhất có thể: Nhân viên lễ tân có thể đối ứng tiếng Nhật. Tất
							cả các phòng đều có thể xem các chương trình truyền hình Nhật Bản
							như NHK, WOWOW và các chương trình thương mại khác, dịch vụ đưa tiễn
							sân bay, dịch vụ giặt là, Internet miễn phí tốc độ cao, cho thuê xe,
							sắp xếp tham quan.
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="animated fadeInUp" style="animation-duration: 1s">
			<div class="content__feature">
			<div class="content__feature-title">Đặc trưng</div>
			<div class="container-fluid">
				<div class="row" style="justify-content: center">
					<?php
						$args = array(
							'post_type' => 'vnh_hotel_feature',
						);
						$custom_query = new WP_Query($args);
						if ( $custom_query->have_posts() ) : ?>
						<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
								<div class="col-md-6 col-lg-6 col-xl-3 col-xxl-3">
									<div class="content__feature-item">
										<div class="content__feature-container">
										<div
											class="content__feature-img"
											style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>')"
										>
											<a
											class="d-block"
											href="<?php echo home_url("feature"); ?>"
											style="height: 100%"
											></a>
										</div>
										</div>
										<div class="content__feature-name">
											<a href="<?php echo home_url("feature"); ?>"><?php the_title(); ?></a>
										</div>
										<div class="content__feature-text">
											<p style="text-align: justify">
												<?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
											<a
												class="continue_link"
												href="<?php echo home_url("feature"); ?>"
												>Xem tiếp</a
												>
											</p>
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
		</div>
	</main>
<?php
get_footer();
