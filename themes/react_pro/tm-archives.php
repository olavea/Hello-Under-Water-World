<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
<div id="content" class="clear">
	<?php query_posts( 'showposts=25' ); ?>
	<?php if ( have_posts() ) : ?>
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="entry-page-image">
				<?php the_post_thumbnail( 'react-thumb' ); ?>
			</div>
		<?php } ?>
		<h1 class="page-title"><?php bloginfo( 'title' ); ?> <?php _e( 'Archives', 'react' ); ?></h1>
		<div class="entry entry-page clear <?php echo has_post_thumbnail() ? 'thumbnail' : ''; ?>">
			<h2><?php _e( 'Recent posts', 'react' ); ?></h2>
			<ul>
				<?php while ( have_posts() ) : the_post(); ?>
					<li class="clear">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						<span class="archives-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
					</li>
				<?php endwhile; endif; ?>
			</ul>
			<h2><?php _e( 'Monthly archives', 'react' ); ?></h2>
			<ul>
				<?php wp_get_archives( 'type=monthly&show_post_count=1' ); ?>
			</ul>
		</div><!--end entry-->
</div>
<?php get_footer(); ?>