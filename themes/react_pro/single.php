<?php get_header(); ?>
<?php if ( has_post_format( 'gallery' ) ) : ?>
	<?php get_template_part( 'tmpart-loop-page' ); ?>
<?php else : ?>
	<div id="content" class="clear <?php if ( $react->sidebarDisable() != 'true' ) echo ( 'blog' ); ?>">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>
					<div class="post-header clear">
						<h2 class="post-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( sprintf( __( 'Permanent Link to %s', 'react' ), the_title_attribute( 'echo=false' ) ) ); ?>"><?php the_title(); ?></a>
						</h2>
						<p><?php the_time( __( 'F jS, Y', 'react' ) ); ?></p>
						<p><?php the_author(); ?></p>
						<div class="entry-post-image">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'react-thumb' );
							} ?>
						</div>
					</div><!--end post-header-->
					<div class="entry entry-post clear">
						<?php the_content( __( 'Read more', 'react' ) ); ?>
						<?php edit_post_link( __( 'Edit this', 'react' ), '<p>', '</p>' ); ?>
					</div><!--end entry-->
					<div class="post-footer clear">
						<p>
							<?php printf( __( 'Filed under %s.', 'react' ), get_the_category_list( ', ' ) ); ?>
						</p>
					</div><!--end post-footer-->
				</div><!--end post-->
			<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
			<?php comments_template( '', true ); ?>
		<?php endif; ?>
	</div><!--end content-->
	<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>