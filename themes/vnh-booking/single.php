<?php
get_header();
?>
<main id="primary" class="site-main">
	<section>
		<div>
			<div class="policies__header" style="background:url('<?php echo wp_get_attachment_url(444,'full'); ?>') 50% / cover no-repeat">
			<div classnamename="container">
				<div class="row">
				<div class="col-md-12"><h1>Thông Báo</h1></div>
				</div>
			</div>
			</div>
			<div class="container">
			<div class="row">
				<div class="col-md-12">
				<div class="re__breadcrumb">
					<ul class="breadcrumb__list">
					<li class="breadcrumb__item">
						<a href="/"><i class="fa-solid fa-house"></i></a>
					</li>
					<li class="breadcrumb__item">/</li>
					<li class="breadcrumb__item">
						<a class="breadcrumb__title" href="/news">Thông báo</a>
					</li>
					<li class="breadcrumb__item">/</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__title"
						>Open cold bath at Azumaya Hotel DaNang</span
						>
					</li>
					</ul>
				</div>
				</div>
			</div>
			</div>
			<div class="container">
			<div class="row">
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
				<div class="col-md-8">
				<div>
					<div class="news_title mb-5">
						<?php the_title(); ?>
					</div>
					<div class="news_content">
						<?php the_content(); ?>
					</div>
				</div>
				</div>
				<div class="col-md-2">
					<div class="recent_post-container">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
