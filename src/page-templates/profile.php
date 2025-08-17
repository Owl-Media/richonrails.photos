<?php

/**
 * Template Name: Profile Page
 *
 * @since 1.0.0
 */

?>

<?php get_header(); ?>
<body>
<?php
$user = get_user_by( 'login', 'rich' );
if ( $user ) {
	$user_id = $user->ID;
}
?>

<?php require_once get_template_directory() . '/components/head.php'; ?> 

<main class="container" role="main">
	<!-- Profile header -->
	<section class="profile" aria-label="User profile">
	<div class="profile-grid">
		<div class="avatar">
		<?php
		echo get_avatar(
			$user_id,
			160,
			'',
			get_the_author(),
			array(
				'class'      => 'avatar avatar-36',
				'height'     => 160,
				'width'      => 160,
				'extra_attr' => 'decoding="async" loading="lazy"',
			)
		);
		?>
		</div>

		<div class="headline">
		<div class="row-top">
			<div class="username"><?php echo get_the_author_meta( 'nickname', $user_id ); ?></div>				
		</div>

		<?php
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'photo',
			'posts_per_page' => -1,
		);

		$the_posts   = new WP_Query( $args );
		$total_posts = $the_posts->found_posts;
		?>

		<div class="stats" aria-label="Profile stats">
			<div class="stat">
			<span class="num"><?php echo $total_posts; ?></span><span>posts</span>
			</div>				
		</div>

		<div class="bio">
			<div class="about">
			<?php echo get_the_author_meta( 'description', $user_id ); ?>
			</div>
		</div>
		</div>
	</div>
	</section>

	<!-- Tabs -->
	<nav class="tabs" aria-label="Profile sections">
	</nav>

	<!-- Grid -->
	<section
	id="posts"
	class="grid"
	aria-label="Posts grid"
	style="margin-top: 60px"
	>
	<?php
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'photo',
			'posts_per_page' => 9,
		);

		$the_posts   = new WP_Query( $args );
		$total_posts = $the_posts->found_posts;

		if ( $total_posts > 0 ) {
			?>

				<?php
				if ( $the_posts->have_posts() ) :
					while ( $the_posts->have_posts() ) :
								$the_posts->the_post();
						get_template_part( 'components/profile/grid-image', get_post_format() );
						endwhile;
					?>
										<?php
					endif;
				wp_reset_postdata();
		}
		?>
	</section>
</main>
<?php get_footer(); ?>
