<?php global $react; ?>
<div class="subscribe clear">
	<?php if ( $react->followDisable() != 'true' ) { ?>
		<ul>
			<?php if ( $react->flickrToggle() == 'true' ) { ?>
				<li>
					<a href="<?php echo esc_url( $react->flickr() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-flickr.png' ); ?>" alt="<?php esc_attr_e( 'Flickr', 'react' ); ?>" title="<?php esc_attr_e( 'Flickr', 'react' ); ?>"/></a>
				</li>
			<?php } ?>
			<?php if ( $react->googlePlusToggle() == 'true' ) { ?>
				<li>
					<a href="<?php echo esc_url( $react->googlePlus() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-google-plus.png' ); ?>" alt="<?php esc_attr_e( 'Google+', 'react' ); ?>" title="<?php esc_attr_e( 'Google+', 'react' ); ?>"/></a>
				</li>
			<?php } ?>
			<?php if ( $react->facebookToggle() == 'true' ) { ?>
				<li>
					<a href="<?php echo esc_url( $react->facebook() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-facebook.png' ); ?>" alt="<?php esc_attr_e( 'Facebook', 'react' ); ?>" title="<?php esc_attr_e( 'Facebook', 'react' ); ?>"/></a>
				</li>
			<?php } ?>
			<?php if ( $react->twitterToggle() == 'true' ) { ?>
				<li>
				 <a href="http://twitter.com/<?php esc_attr_e( $react->twitter() ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-twitter.png' ); ?>" alt="<?php esc_attr_e( 'Twitter', 'react' ); ?>" title="<?php esc_attr_e( 'Twitter', 'react' ); ?>"/></a>
				</li>
			<?php } ?>
			<li>
				<a href="<?php bloginfo( 'rss2_url' ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/images/flw-rss.png' ); ?>" alt="<?php esc_attr_e( 'RSS Feed', 'react' ); ?>" title="<?php esc_attr_e( 'RSS', 'react' ); ?>"/></a>
			</li>
		</ul>
	<?php } ?>
</div>