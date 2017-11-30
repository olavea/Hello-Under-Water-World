<?php
/*
Template Name: Projects
*/
?>
<?php get_header(); ?>
<div id="content" class="projects clear">
	<div class="projects-header clear">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
				<div class="entry entry-page clear<?php echo ( has_post_thumbnail() ) ? ' thumbnail' : ''; ?>">
  				<?php the_content(); ?>
  			</div>
			<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<?php endif; ?>
	</div>
	<?php
		$args = array(
			'orderby' => $react->sort_projects(),
			'order' => $react->project_sort_order(),
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'terms' => array( 'post-format-gallery' ),
					'field' => 'slug',
					'operator' => 'IN',
				),
			),
			'posts_per_page' => -1
		);

		// limit to user-requested posts, if they were set via [gallery] shortcode
		if ( ! empty( $react->project_ids ) ) {
			$args['post__in'] = $react->project_ids;
		}

		$react_projects_template = new WP_Query( $args );
		if( $react_projects_template->have_posts() ) { ?>
			<?php
				$count = 0;
				while ( $react_projects_template->have_posts() ) : $react_projects_template->the_post(); ?>
					<?php $count++; ?>
					<div class="footer-column projects-column <?php if ( $count %3 == 0 ) echo 'project-three'; if ( $count %3 == 1 ) echo 'project-one'; ?>">
							<h3 class="widgettitle"><?php the_title(); ?></h3>
							<div class="projects-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'react-thumb' );
									} ?>
								</a>
							</div>
					</div>
					<?php
				endwhile;
		} ?>
		<?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>
</div>
<?php get_footer(); ?>