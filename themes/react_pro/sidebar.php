<?php global $react; ?>
<?php if ( $react->sidebarDisable() != 'true' ) { ?>
	<div id="sidebar">
		<?php if ( $react->followDisable() != 'true' ) { ?>
			<?php get_template_part( 'tmpart-subscribe' ); ?>
		<?php } ?>
		<ul>
			<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'sidebar_1' ) ) : ?>
				<li class="widget widget_recent_entries">
					<h3 class="widgettitle"><?php _e( 'Recent Articles', 'react' ); ?></h3>
					<?php $side_posts = new WP_Query( 'numberposts=10' ); ?>
					<?php if ( $side_posts->have_posts() ) : ?>
						<ul>
							<?php while( $side_posts->have_posts() ) : $side_posts->the_post(); ?>
								<li><a href= "<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php endwhile; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endif; ?>
		</ul>
	</div><!--end sidebar-->
<?php } ?>