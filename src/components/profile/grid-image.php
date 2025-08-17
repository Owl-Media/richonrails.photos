<a class="tile" href="<?php echo esc_url( get_permalink() ); ?>">
<span class="badge">
<?php
if ( function_exists( 'hl_the_like_count' ) ) {
	hl_the_like_count( get_the_ID() );
}
?>
</span>
<?php
	$rows = get_field( 'image_repeater' );

if ( ! empty( $rows ) && is_array( $rows ) ) {

	foreach ( $rows as $row ) {
		$perm = get_permalink();
		$url  = isset( $row['image'] ) ? $row['image'] : '';
		if ( $url ) {
			printf(
				'<img src="%s" alt="" loading="lazy" decoding="async">',
				esc_url( $url )
			);
		}
	}
}
?>
</a>
