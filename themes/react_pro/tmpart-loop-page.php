<div id="content" class="clear">
	<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="page-<?php the_ID(); ?>" class="page clear">
			<?php if ( has_post_thumbnail() ) { ?>
				<div class="entry-page-image">
					<?php the_post_thumbnail( 'react-thumb' ); ?>
				</div>
			<?php } ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<div class="entry entry-page clear<?php echo ( has_post_thumbnail() ) ? ' thumbnail' : ''; ?>">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
	<?php comments_template( '', true ); ?>
	<?php endif; ?>
</div>