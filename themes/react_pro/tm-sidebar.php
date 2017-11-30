<?php
/*
Template Name: With Sidebar
*/
?>
<?php get_header(); ?>
<div id="with-sidebar">
	<?php get_template_part( 'tmpart-loop-page' ); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>