<?php

	/**
	 * Homepage template
	 *
	 *
	 * @since 1.0.0
	*/

?>
 
<?php get_header(); ?> 
 
<body>
	<a href="#main" class="skip-link">Skip to main content</a>

	<?php require_once get_template_directory() . '/components/head.php'; ?> 

	<!-- Main Layout -->
	<div class="layout" id="main" role="main">
		<!-- Sidebar -->
		<aside class="sidebar" aria-label="Primary navigation">
		<nav class="nav">
			<a class="active" href="<?php echo esc_url( home_url() ); ?>"
			><svg aria-hidden="true"><use href="#icon-home"></use></svg
			><span class="label">Home</span></a
			>			
			<a href="<?php echo esc_url( home_url( 'profile' ) ); ?>"
			><svg aria-hidden="true"><use href="#icon-user"></use></svg
			><span class="label">Profile</span></a
			>
		</nav>
		</aside>

		<!-- Feed -->
		<section class="feed" aria-label="Feed">
		<!-- Post 1 -->
		<?php
			$args = array(
				'post_status'    => 'publish',
				'post_type'      => 'photo',
				'posts_per_page' => -1,
			);

			$the_posts   = new WP_Query( $args );
			$total_posts = $the_posts->found_posts;

			if ( $total_posts > 0 ) {
				?>

					<?php
					if ( $the_posts->have_posts() ) :
						while ( $the_posts->have_posts() ) :
									$the_posts->the_post();
							get_template_part( 'components/post/post', get_post_format() );
							endwhile;
						?>
											<?php
						endif;
					wp_reset_postdata();
			}
			?>
		</section>
	</div>

	<?php get_footer(); ?>
