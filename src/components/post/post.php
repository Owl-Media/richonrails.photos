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
	<div class="post-actions">
		<div class="left-actions">
			<?php
			if ( function_exists( 'hl_the_like_button' ) ) {
				echo hl_render_like_button( get_the_ID(), array( 'show_count' => false ) );
			}
			?>
					</div>
	</div>
	<div class="post-body">
		<div class="likes">
		<?php
		if ( function_exists( 'hl_the_like_count' ) ) {
			hl_the_like_count( get_the_ID() );
		}
		?>
		</div>
		<div class="caption">
			<?php the_content(); ?>
		</div>
	</div>
</article>