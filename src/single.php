<?php get_header(); ?>
<body>
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();

			require_once get_template_directory() . '/components/head.php';

			?>

	<main class="container" role="main">
	<article class="card media-view" aria-label="Post by luna.design">
		<div class="media-left">
			<?php
			$rows   = get_field( 'image_repeater' ) ?: array();
			$images = array();

			// Normalise to a flat array of URLs
			foreach ( $rows as $row ) {
				if ( ! empty( $row['image'] ) ) {
					$images[] = esc_url( $row['image'] );
				}
			}

			$count = count( $images );
			$perm  = get_permalink();
			$pid   = get_the_ID(); // unique per post to avoid ID collisions

			if ( $count === 1 ) :
				?>
	<a href="<?php echo esc_url( $perm ); ?>">
		<img src="<?php echo $images[0]; ?>" alt="" loading="lazy" decoding="async">
	</a>
			<?php elseif ( $count > 1 ) : ?>
	<div class="rr-slider" id="rr-slider-<?php echo (int) $pid; ?>" data-slider>
		<div class="rr-slider__track" role="group" aria-roledescription="carousel" aria-label="Post images">
			<ul class="rr-slider__list" data-slider-list>
					<?php foreach ( $images as $i => $url ) : ?>
					<li class="rr-slider__slide" data-slide aria-roledescription="slide" aria-label="<?php echo ( $i + 1 ) . ' of ' . $count; ?>">
						<a href="<?php echo esc_url( $perm ); ?>">
							<img src="<?php echo $url; ?>" alt="" loading="lazy" decoding="async">
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<button class="rr-slider__btn rr-slider__btn--prev" type="button" data-prev aria-label="Previous image">❮</button>
		<button class="rr-slider__btn rr-slider__btn--next" type="button" data-next aria-label="Next image">❯</button>

		<div class="rr-slider__dots" data-dots aria-hidden="true">
				<?php for ( $i = 0; $i < $count; $i++ ) : ?>
				<button type="button" class="rr-slider__dot" data-dot="<?php echo $i; ?>"></button>
			<?php endfor; ?>
		</div>
	</div>
	<?php endif; ?>
		</div>

		<aside class="media-right">
		<header class="post-header">
			<div class="ph-avatar">
			<?php
			$author_id = get_the_author_meta( 'ID' );

			echo get_avatar(
				$author_id,
				72,
				'',
				get_the_author(),
				array(
					'class'      => 'avatar avatar-36',
					'height'     => 36,
					'width'      => 36,
					'extra_attr' => 'decoding="async" loading="lazy"',
				)
			);
			?>
			</div>
			<div class="meta">
			<div class="user"><a href="<?php echo esc_url( home_url( 'profile' ) ); ?>"><?php the_author(); ?></a></div>
			<span class="time"><?php echo post_time_ago(); ?></span>
			</div>
		</header>

		<section class="media-body" aria-label="Caption and comments">
			<div class="caption"><span class="user"><?php the_author(); ?></span><?php the_content(); ?></div>			
		</section>

		<footer class="media-actions">
			<div class="left-actions">
			<?php
			if ( function_exists( 'hl_the_like_button' ) ) {
				echo hl_render_like_button( get_the_ID(), array( 'show_count' => false ) );
			}
			?>
			</div>
			<div class="right-actions" style="display:flex;gap:8px;">
			<?php previous_post_link( '<span class="btn">%link</span>', 'Prev' ); ?>
			<?php next_post_link( '<span class="btn primary">%link</span>', 'Next' ); ?>
			</div>
		</footer>
		</aside>
	</article>
	</main>
			<?php get_footer(); ?>
</body>
</html>
		<?php endwhile;
endif; ?>