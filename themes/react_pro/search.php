<?php get_header(); ?>
<h1 class="small-header"><?php printf( __( "Search results for '%s'", "react" ), get_search_query() ); ?></h1>
<div id="content" class="clear <?php if ( $react->sidebarDisable() != 'true' ) echo ( 'blog' ); ?>">
	<?php if ( have_posts() ) : ?>
		<?php get_template_part( 'tmpart-loop' ); ?>
	<?php else : ?>
		<div>
			<p><?php printf( __( 'Sorry, your search for "%s" did not turn up any results. Please try again.', 'react' ), get_search_query());?></p>
			<?php get_search_form(); ?>
		</div><!--end entry-->
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>