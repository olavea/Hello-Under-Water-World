<?php get_header(); ?>
<div id="content" class="clear <?php if ( $react->sidebarDisable() != 'true' ) echo ( 'blog' ); ?>">
	<?php if ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php /* If this is a category archive */ if ( is_category() ) { ?>
			<h1 class="small-header"><?php printf( __( 'Posts from the  &#8216;%s&#8217; Category', 'react' ), single_cat_title( '', false ) ); ?></h1>
		<?php /* If this is a tag archive */ } elseif ( is_tag() ) { ?>
			<h1 class="small-header"><?php printf( __( 'Posts tagged &#8216;%s&#8217;', 'react' ), single_tag_title( '', false ) ); ?></h1>
		<?php /* If this is a daily archive */ } elseif ( is_day() ) { ?>
			<h1 class="small-header"><?php printf( __( 'Archive for %s', 'react' ), get_the_time(  'F jS, Y', 'react' ) ); ?></h1>
		<?php /* If this is a monthly archive */ } elseif ( is_month() ) { ?>
			<h1 class="small-header"><?php printf( __( 'Archive for %s', 'react' ), get_the_time(  'F, Y', 'react' ) ); ?></h1>
		<?php /* If this is a yearly archive */ } elseif ( is_year() ) { ?>
			<h1 class="small-header"><?php printf( __( 'Archive for %s', 'react' ), get_the_time(  'Y', 'react' ) ); ?></h1>
		<?php /* If this is an author archive */ } elseif ( is_author() ) { ?>
			<h1 class="small-header"><?php printf( __( 'Posts by %s', 'react' ), get_the_author() ); ?></h1>
		<?php /* If this is a paged archive */ } elseif ( is_paged() ) { ?>
			<h1 class="small-header"><?php _e( 'Blog Archives', 'react' ); ?></h1>
		<?php } ?>
		<?php rewind_posts(); ?>
		<?php get_template_part( 'tmpart-loop' ); ?>
	<?php else : ?>
		<p><?php _e( 'No posts found.', 'react' ); ?></p>
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>