<?php
/**
 * Theme search form
 * Save as: wp-content/themes/your-theme/searchform.php
 */
$search_id = uniqid( 'search-' ); // unique ID so multiple forms don't clash
?>
<form role="search"
		method="get"
		class="searchform"
		action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<label class="search" for="<?php echo esc_attr( $search_id ); ?>" aria-label="<?php esc_attr_e( 'Search the site', 'your-textdomain' ); ?>">
	<svg aria-hidden="true"><use href="#icon-search"></use></svg>

	<input id="<?php echo esc_attr( $search_id ); ?>"
			type="search"
			class="search-field"
			name="s"
			placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'your-textdomain' ); ?>"
			value="<?php echo get_search_query(); ?>"
			autocomplete="off" />
	</label>

	<!-- Keep a submit button for accessibility, hide visually if you like -->
	<button type="submit" class="visually-hidden">
	<?php echo esc_html_x( 'Search', 'submit button', 'your-textdomain' ); ?>
	</button>

	<?php
	// Optional: limit to a post type
	// echo '<input type="hidden" name="post_type" value="post" />';
	?>
</form>
