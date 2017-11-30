<?php get_header(); ?>
<div id="content" class="clear">
	<h1 class="page-title"><?php _e( '404: Page Not Found', 'react' ); ?></h1>
	<div class="entry entry-page clear">
		<p><?php _e( 'We are terribly sorry, but the URL you typed no longer exists. It might have been moved or deleted. Try searching the site:', 'react' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</div>
<?php get_footer(); ?>