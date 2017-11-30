<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header(); ?>
<div id="content" class="clear">
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="entry-page-image">
			<?php the_post_thumbnail( 'react-thumb' ); ?>
		</div>
	<?php } ?>
	<h1 class="page-title"><?php bloginfo( 'title' ); ?> <?php _e( 'Sitemap', 'react' ); ?></h1>
	<div class="entry entry-page clear <?php echo has_post_thumbnail() ? 'thumbnail' : ''; ?>">
		<h2><?php _e( 'Pages', 'react' ); ?></h2>
		<ul>
			<?php wp_list_pages( 'sort_column=menu_order&depth=0&title_li=' ); ?>
		</ul>
		<h2><?php _e( 'Categories', 'react' ); ?></h2>
		<ul>
			<?php wp_list_categories( 'depth=0&title_li=&show_count=1' ); ?>
		</ul>
		<h2><?php _e( 'Monthly Archives', 'react' ); ?></h2>
		<ul>
			<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>
	</div>
</div>
<?php get_footer(); ?>