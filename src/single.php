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
				$rows = get_field( 'image_repeater' );
			if ( ! empty( $rows ) && is_array( $rows ) ) {
				foreach ( $rows as $row ) {
					$perm = get_permalink();
					$url  = isset( $row['image'] ) ? $row['image'] : '';
					if ( $url ) {
						printf(
							'<a href="%s"><img src="%s" alt="" loading="lazy" decoding="async"></a>',
							esc_url( $perm ),
							esc_url( $url )
						);
					}
				}
			}
			?>
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