<?php /**
	 * Search template
	 *
	 *
	 * @since 1.0.0
*/
?>

<?php get_header(); ?>

<body>

<?php require_once get_template_directory() . '/components/head.php'; ?> 

<?php
if ( ! function_exists( 'rr_get_repeater_image_urls' ) ) {
	function rr_get_repeater_image_urls( $post_id ) {
		$rows = array();

		// Try ACF first.
		if ( function_exists( 'get_field' ) ) {
			$rows = get_field( 'image_repeater', $post_id );
			// Fallback for Smart/Secure Custom Fields (SCF).
		} elseif ( class_exists( 'SCF' ) ) {
			$rows = SCF::get( 'image_repeater', $post_id );
		} else {
			// Last-ditch attempt if stored as meta.
			$rows = get_post_meta( $post_id, 'image_repeater', true );
		}

		if ( empty( $rows ) || ! is_array( $rows ) ) {
			return array();
		}

		$urls = array();

		foreach ( $rows as $row ) {
			// Common structures:
			// $row['image'] can be a URL string, an ID, or an ACF image array with ['url'].
			if ( is_array( $row ) && isset( $row['image'] ) ) {
				$img = $row['image'];

				// ACF image array
				if ( is_array( $img ) && isset( $img['url'] ) ) {
					$urls[] = $img['url'];
					// Attachment ID
				} elseif ( is_numeric( $img ) ) {
					$maybe_url = wp_get_attachment_image_url( (int) $img, 'large' );
					if ( $maybe_url ) {
						$urls[] = $maybe_url;
					}
					// Plain URL
				} elseif ( is_string( $img ) ) {
					$urls[] = $img;
				}
				// If the row itself is a URL string
			} elseif ( is_string( $row ) && filter_var( $row, FILTER_VALIDATE_URL ) ) {
				$urls[] = $row;
			}
		}

		// De-dupe and tidy
		$urls = array_values( array_unique( array_filter( $urls ) ) );

		return $urls;
	}
}
?>

<div class="layout" role="main">
	<aside class="sidebar" aria-label="Search filters">
		<section class="card">
			<h3>Top Tags</h3>
			<div class="suggestions">
				<?php
				$tags = get_tags(
					array(
						'orderby' => 'count',
						'order'   => 'DESC',
						'number'  => 5,
					)
				);

				if ( $tags ) :
					foreach ( $tags as $tag ) :
						$tag_link = get_tag_link( $tag->term_id );
						?>
						<div class="suggestion">
							<div class="trend">
								<a href="<?php echo esc_url( $tag_link ); ?>">
									<span>#<?php echo esc_html( $tag->name ); ?></span>
								</a>
							</div>
						</div>
						<?php
					endforeach;
				else :
					echo '<div class="trend"><p>No tags found.</p></div>';
				endif;
				?>
			</div>
		</section>
	</aside>

	<section class="feed" aria-label="Search results">	
		<section id="top" aria-label="Top results">
			<h2 class="visually-hidden">Top results</h2>
			<div class="card" style="padding: 10px 10px 4px">
			<h3>Results</h3>
			<div class="grid">
				<?php
				$paged  = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
				$search = get_search_query();

				// Query matching 'photo' posts for this search
				$q = new WP_Query(
					array(
						'post_type'      => 'photo',
						'post_status'    => 'publish',
						's'              => $search,
						'posts_per_page' => 24,        // tune to taste
						'paged'          => $paged,
						'no_found_rows'  => false,     // keep true if you want paginate_links
					)
				);

				$image_count = 0;

				if ( $q->have_posts() ) :
					while ( $q->have_posts() ) :
						$q->the_post();
						$post_id    = get_the_ID();
						$post_link  = get_permalink( $post_id );
						$post_title = get_the_title( $post_id );

						$urls = rr_get_repeater_image_urls( $post_id );
						if ( empty( $urls ) ) {
							continue;
						}

						// Output every image from the repeater as a tile
						foreach ( $urls as $url ) :
							++$image_count;
							?>
			<a class="tile" href="<?php echo esc_url( $post_link ); ?>">
				<img
					src="<?php echo esc_url( $url ); ?>"
					alt="<?php echo esc_attr( $post_title ); ?>"
					loading="lazy"
					decoding="async"
				/>
			</a>
							<?php
						endforeach;
					endwhile;
					wp_reset_postdata();
else :
	?>
	<p>No results for “<?php echo esc_html( $search ); ?>”.</p>
	<?php
endif;

// Optional feedback and pagination for the post query
?>
</div><!-- end .grid -->

<div class="card" style="padding: 8px 12px; margin-top: 8px;">
	<p style="margin: 0;">
		<?php if ( $image_count > 0 ) : ?>
			Found <strong><?php echo (int) $image_count; ?></strong> image<?php echo $image_count === 1 ? '' : 's'; ?> for “<?php echo esc_html( $search ); ?>”.
		<?php endif; ?>
	</p>
	<?php
		$pagination = paginate_links(
			array(
				'total'     => max( 1, (int) $q->max_num_pages ),
				'current'   => $paged,
				'type'      => 'list',
				'prev_text' => '&laquo; Previous',
				'next_text' => 'Next &raquo;',
			)
		);
		if ( $pagination ) {
			echo '<nav class="pagination" aria-label="Results navigation">' . $pagination . '</nav>';
		}
		?>
			</div>
			</div>
		</section>
	</section> 

	<?php
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'photo',
			'posts_per_page' => -1,
		);

		$the_posts   = new WP_Query( $args );
		$total_posts = $the_posts->found_posts;
		?>

	<?php
	$first_post_date = '';
	$first_post_ids  = get_posts(
		array(
			'post_type'              => 'photo',
			'post_status'            => 'publish',
			'orderby'                => 'date',
			'order'                  => 'ASC',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	if ( ! empty( $first_post_ids ) ) {
		$first_post_date = get_the_date( get_option( 'date_format' ), $first_post_ids[0] );
	}

	$include_empty_terms = false;
	$total_locations     = wp_count_terms(
		'location',
		array(
			'hide_empty' => ! $include_empty_terms,
		)
	);
	if ( is_wp_error( $total_locations ) ) {
		$total_locations = 0;
	}

	$total_locomotives = wp_count_terms(
		'locomotive',
		array(
			'hide_empty' => ! $include_empty_terms,
		)
	);
	if ( is_wp_error( $total_locomotives ) ) {
		$total_locomotives = 0;
	}
	?>
	<aside class="rightbar" aria-label="Trending">
	<section class="card">
		<h3>Statistics</h3>
		<div class="trends">
		<div class="trend"><span>Total Posts</span> <span><?php echo (int) $total_posts; ?></span></div>
		<div class="trend"><span>First Post</span> <span><?php echo $first_post_date ? esc_html( $first_post_date ) : '—'; ?></span></div>
		<div class="trend"><span>Total Locations</span> <span><?php echo (int) $total_locations; ?></span></div>
		<div class="trend"><span>Total Locomotives</span> <span><?php echo (int) $total_locomotives; ?></span></div>
		</div>
	</section>
	</aside>
</div>

<?php get_footer(); ?>
