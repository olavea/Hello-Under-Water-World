<?php global $react; ?>
<!DOCTYPE html>
<html <?php language_attributes( 'html' ) ?>>
<head>
	<?php if ( is_front_page() ) : ?>
		<title><?php bloginfo( 'name' ); ?></title>
	<?php elseif ( is_404() ) : ?>
		<title><?php _e( 'Page Not Found |', 'react' ); ?> | <?php bloginfo( 'name' ); ?></title>
	<?php elseif ( is_search() ) : ?>
		<title><?php printf( __( "Search results for '%s'", "react" ), get_search_query()); ?> | <?php bloginfo( 'name' ); ?></title>
	<?php else : ?>
		<title><?php wp_title( $sep = '' ); ?> | <?php bloginfo( 'name' );?></title>
	<?php endif; ?>

	<!-- Basic Meta Data -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="copyright" content="<?php
		echo esc_attr( sprintf(
			__( 'Design is copyright %1$s The Theme Foundry', 'react' ),
			date( 'Y' )
		) );
	?>" />

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />

	<!-- WordPress -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="skip-content"><a href="#content"><?php _e( 'Skip to content', 'react' ); ?></a></div>
	<div id="wrapper" class="clear">
		<!-- bGraphic: Added language list -->
		<?php oa_languages_list(); ?>
		<div id="header" class="clear <?php if ( $react->logoState() == 'true' ) echo 'logo' ?>">
			<div id="title">
				<?php if ( $react->logoState() == 'true' ) : ?>
					<?php $upload_dir = wp_upload_dir(); ?>
					<a href="<?php echo home_url( '/' ); ?>">
						<img src="<?php echo $react->logoName(); ?>" alt="<?php if ( $react->logoAlt() !== '' ) echo $react->logoAlt(); else echo bloginfo( 'name' ); ?>" />
					</a>
				<?php else : ?>
					<?php if ( is_front_page() ) echo( '<h1>' ); ?>
						<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php if ( is_front_page() ) echo( '</h1>' ); ?>
				<?php endif; ?>
			</div>
			<?php
				wp_nav_menu(
					array(
						'theme_location'	=> 'nav-1',
						'container_id'		=> 'navigation',
						'container_class' => 'clear',
						'menu_class'			=> 'nav',
						'depth'						=> '2',
						'fallback_cb'			=> array( &$react, 'main_menu_fallback')
						)
					);
			?>
		</div><!--end header-->
		<?php if ( ($react->logoTagline() != 'true' ) && ( is_front_page() ) ) : ?>
			<div id="tagline" class="clear">
				<h2><?php bloginfo( 'description' ); ?></h2>
			</div><!--end tagline-->
		<?php endif; ?>