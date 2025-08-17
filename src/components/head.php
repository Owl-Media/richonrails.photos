<header class="topbar" role="banner">
	<div class="topbar-inner">
		<div class="brand" aria-label="Rich On Rails Photos home">
			<input
			id="nav-toggle"
			class="nav-toggle"
			type="checkbox"
			aria-label="Toggle menu"
			/>
			<label for="nav-toggle" class="hamburger" aria-label="Open menu">
			<svg aria-hidden="true"><use href="#icon-menu"></use></svg>
			</label>
			<div class="mobile-menu" role="dialog" aria-label="Mobile menu">
				<?php get_search_form(); ?>
				<?php require_once get_template_directory() . '/components/mobile-menu.php'; ?>
			</div>
			<img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo.png' ); ?>" alt="Logo">
		</div>

		<?php get_search_form(); ?>
		<?php require_once get_template_directory() . '/components/top-menu.php'; ?> 
	</div>
</header>
