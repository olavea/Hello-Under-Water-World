<?php global $react; ?>
	<?php if (
						$react->footerProjects() == 'all' ||
						$react->footerProjects() == 'notfront' && !is_front_page() ||
						$react->footerProjects() == 'frontpage' && is_front_page() ||
						$react->footerProjects() == 'pages' && is_page() ||
						$react->footerProjects() == 'pagesnotfront' && is_page() && !is_front_page()
						)
	{ ?>
	<div class="footer footer-with-header clear">
		<h2><?php echo $react->plural_project_name(); ?></h2>
		<?php
			$args=array(
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'terms' => array( 'post-format-gallery' ),
					'field' => 'slug',
					'operator' => 'IN',
				),
			),
			'showposts' => 3
			);
			$react_recent_projects = null;
			$react_recent_projects = new WP_Query( $args );
			if( $react_recent_projects->have_posts() ) { ?>
				<?php
					$count = 0;
					while ( $react_recent_projects->have_posts() ) : $react_recent_projects->the_post(); ?>
						<?php $count++; ?>
						<div class="footer-column footer-<?php echo $count; ?>">
								<h3 class="widgettitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="project-thumb">
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
	<?php } ?>
	<?php if (
						$react->footerNews() == 'all' ||
						$react->footerNews() == 'frontpage' && is_front_page() ||
						$react->footerNews() == 'notfront' && !is_front_page() ||
						$react->footerNews() == 'pages' && is_page() ||
						$react->footerNews() == 'pagesnotfront' && is_page() && !is_front_page()
						)
	{ ?>
		<div class="footer footer-with-header clear">
			<h2><?php _e( 'Latest news', 'react' ); ?></h2>
			<?php
				$args=array(
				'post_status' => 'publish',
				'showposts' => 3,
				'ignore_sticky_posts' => 1
				);
				$react_latest_news = null;
				$react_latest_news = new WP_Query( $args );
				if( $react_latest_news->have_posts() ) { ?>
					<?php
						$count = 0;
						while ( $react_latest_news->have_posts() ) : $react_latest_news->the_post(); ?>
							<?php $count++; ?>
							<div class="footer-column footer-<?php echo $count; ?>">
									<h3 class="posttitle">
										<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( sprintf( __( 'Permanent Link to %s', 'react' ), the_title_attribute( 'echo=false' ) ) ); ?>"><?php the_title(); ?></a>
									</h3>
									<p class="date"><?php the_time( __( 'F jS, Y', 'react' ) ); ?></p>
									<?php the_excerpt(); ?>
							</div>
							<?php
						endwhile;
				} ?>
				<?php wp_reset_query(); // Restore global post data stomped by the_post(). ?>
		</div>
	<?php } ?>
	<?php if (
						$react->footerWidgets() == 'all' ||
						$react->footerWidgets() == 'notfront' && !is_front_page() ||
						$react->footerWidgets() == 'frontpage' && is_front_page() ||
						$react->footerWidgets() == 'pages' && is_page() ||
						$react->footerWidgets() == 'pagesnotfront' && is_page() && !is_front_page()
						)
	{ ?>
		<div class="footer clear">
			<div class="footer-column footer-1">
				<?php if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar('footer_1') ) : ?>
					<h3 class="widgettitle"><?php _e( 'First footer' , 'react' ); ?></h3>
					<p><?php _e( "Head over to Appearance &rarr; Widgets and add a new widget to Footer 1 to replace this text." , "react" ); ?></p>
				<?php endif; ?>
			</div>
			<div class="footer-column footer-2">
				<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'footer_2' ) ) : ?>
					<h3 class="widgettitle"><?php _e( 'Second footer' , 'react' ); ?></h3>
					<p><?php _e( "Head over to Appearance &rarr; Widgets and add a new widget to Footer 2 to replace this text." , "react" ); ?></p>
				<?php endif; ?>
			</div>
			<div class="footer-column footer-3">
				<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'footer_3' ) ) : ?>
					<h3 class="widgettitle"><?php _e( 'Third footer' , 'react' ); ?></h3>
					<p><?php _e( "Head over to Appearance &rarr; Widgets and add a new widget to Footer 3 to replace this text." , "react" ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php } ?>
	<div id="copyright">
		<?php
			if ( $react->copyrightName() != '' ) echo '<p>' . $react->copyrightName() . '</p>';
		?>
		<p>
			<?php
				printf(
					__( '<a href="%1$s">React Theme</a> by <a href="%2$s">The Theme Foundry</a>', 'react' ),
					'http://thethemefoundry.com/react/',
					'http://thethemefoundry.com/'
				);
			?>
		</p>
	</div><!--end copyright-->
</div><!--end wrapper-->
<?php wp_footer(); ?>
</body>
</html>