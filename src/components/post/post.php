<article class="post" aria-label="Post by rich">
	<header class="post-header">
	<div class="ph-avatar">
		<a href="<?php echo esc_url( home_url( 'profile' ) ); ?>">
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
		</a>
	</div>
	<div class="meta">
		<div class="user"><a href="<?php echo esc_url( home_url( 'profile' ) ); ?>"><?php echo get_the_author(); ?></a></div>
		<span class="time"><?php echo post_time_ago(); ?></span>
	</div>
	</header>
	<div class="post-media">

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
					<li class="rr-slider__slide" data-slide aria-roledescription="slide" aria-label="<?php echo (int) ( $i + 1 ) . ' of ' . (int) $count; ?>">
						<a href="<?php echo esc_url( $perm ); ?>">
							<img src="<?php echo esc_url( $url ); ?>" alt="" loading="lazy" decoding="async">
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<button class="rr-slider__btn rr-slider__btn--prev" type="button" data-prev aria-label="Previous image">❮</button>
		<button class="rr-slider__btn rr-slider__btn--next" type="button" data-next aria-label="Next image">❯</button>

		<div class="rr-slider__dots" data-dots aria-hidden="true">
				<?php for ( $i = 0; $i < $count; $i++ ) : ?>
				<button type="button" class="rr-slider__dot" data-dot="<?php echo (int) $i; ?>"></button>
			<?php endfor; ?>
		</div>
	</div>
	<?php endif; ?>

	</div>
	<div class="post-actions">
		<div class="left-actions">
			<?php
			if ( function_exists( 'hl_the_like_button' ) ) {
				echo hl_render_like_button( get_the_ID(), array( 'show_count' => false ) );
			}
			?>
			<div class="likes">
		<?php
		if ( function_exists( 'hl_the_like_count' ) ) {
			hl_the_like_count( get_the_ID() );
		}
		?>
		</div>
		</div>
	</div>
	<div class="post-body">		
		<div class="caption">
			<?php the_content(); ?>
		</div>
	</div>
</article>