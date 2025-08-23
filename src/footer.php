<footer class="footer" aria-label="Footer">
		<span>Rich On Rails</span>
	</footer>

	<footer class="tabbar" role="navigation" aria-label="Mobile navigation">
		<nav>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Home"
			><svg><use href="#icon-home"></use></svg
		></a>		
		<a href="<?php echo esc_url( home_url( 'profile' ) ); ?>" aria-label="Profile"
			><svg><use href="#icon-user"></use></svg
		></a>
		</nav>
	</footer>
		<?php wp_footer(); ?>
	</body>
</html>
