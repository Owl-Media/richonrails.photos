<?php get_header(); ?>
<body>   

<?php require_once get_template_directory() . '/components/head.php'; ?> 

<main class="container" role="main">
	<section class="card" aria-label="Page not found">
	<h3>Page not found</h3>
	<div class="suggestions">
		<p>
		We looked high, low, and under the buffers, but this page has left
		the station.
		</p>
		<!-- Inline search to help users recover -->
		<label class="search" aria-label="Search the site">
		<svg aria-hidden="true"><use href="#icon-search"></use></svg>
		<input
			type="search"
			name="q"
			placeholder="Try searching for people, tags, or places"
		/>
		</label>
		<div style="display: flex; gap: 10px; flex-wrap: wrap">
		<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Go to Home</a>
		<a class="btn" href="search.html">Open Search</a>
		<a class="btn" href="profile.html">View Profile</a>
		</div>
	</div>
	</section>
</main>

	<?php get_footer(); ?>
