<?php get_header(); ?>
<div id="content" class="clear <?php if ( $react->sidebarDisable() != 'true' ) echo ( 'blog' ); ?>">
	<?php if (have_posts()) : ?>
		<?php get_template_part( 'tmpart-loop' ); ?>
	<?php else : ?>
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>