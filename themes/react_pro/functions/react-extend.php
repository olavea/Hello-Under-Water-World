<?php

/*
----- Table of Contents

	1.  Load other functions
	2.  Set up theme specific variables
	3.  Define image sizes
	4.  Add custom background
	5.  Modify the excerpt
	6.  Add gallery post format for projects
	7.  Filter out project posts if filter enabled
	8. Get Project IDs for Projects template
	9.  Enqueue Client Files
	10.  Print Header Items
	11. Register Sidebars
	12. Main Menu Fallback
	13. Navigation Function
	14. Define theme options
	15. Theme option return functions
				I.    Logo
				II.   Subscribe
				III.  Fonts
				IV.   Layout
				V.    Projects
				VII.  Footer

*/

/*---------------------------------------------------------
	1. Load other functions
------------------------------------------------------------ */
locate_template( array( 'functions' . DIRECTORY_SEPARATOR . 'comments.php' ), true );
locate_template( array( 'functions' . DIRECTORY_SEPARATOR . 'ttf-admin.php' ), true );


if (!class_exists( 'React' )) {
	class React extends TTFCore {

		public $project_ids;

		/*---------------------------------------------------------
			2. Set up theme specific variables
		------------------------------------------------------------ */
		function React () {

			$this->themename = "React";
			$this->themeurl = "http://thethemefoundry.com/react/";
			$this->shortname = "react";
			$this->domain = "react";

			$this->project_ids = array();

			add_action( 'init', array( &$this, 'registerMenus' ) );
			add_action( 'setup_theme_react', array( &$this, 'setOptions' ) );

			add_action( 'wp_head', array( &$this, 'printHeaderItems' ) );
			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueueClientFiles' ) );

			add_filter( 'excerpt_length', array( &$this, 'new_excerpt_length' ), 10 );
			add_filter( 'excerpt_more', array( &$this, 'new_excerpt_more' ), 10 );
			add_filter( 'pre_get_posts', array( &$this, 'filter_project_results' ), 10 );
			add_filter( 'post_gallery', array( &$this, 'get_page_projects' ), 10, 2 ); // Filter [gallery] display

			$this->add_custom_background();
			$this->add_post_format_support();

			parent::TTFCore();
		}

		/*---------------------------------------------------------
			3. Define image sizes
		------------------------------------------------------------ */
		function addImageSize() {
			add_image_size( 'react-thumb', 600, 450, true );
		}

		/*---------------------------------------------------------
			4. Add custom background
		------------------------------------------------------------ */
		function add_custom_background() {
			add_custom_background();
		}

		/*---------------------------------------------------------
			5. Modify the excerpt
		------------------------------------------------------------ */
		function new_excerpt_length( $length ) {
			return 20;
		}
		function new_excerpt_more($more) {
			return '...';
		}

		/*---------------------------------------------------------
			6. Add gallery post format for projects
		------------------------------------------------------------ */

		function add_post_format_support() {
			add_theme_support( 'post-formats', array( 'gallery' ) );
		}

		/*---------------------------------------------------------
			7. Filter out project posts if filter enabled
		------------------------------------------------------------ */

		function filter_project_results( $query ) {
			$apply_tax_query =
				! is_admin() &&
				! $query->is_tax( 'post_format', 'post-format-gallery' ) &&
				get_option( $this->shortname . "_hide_projects" );

			if ( $apply_tax_query ) {
				$args = array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => 'post-format-gallery',
					'operator' => 'NOT IN'
				);

				if ( isset( $query->query_vars['tax_query'] ) ) {
					$query->query_vars['tax_query'][] = $args;
				} else {
					$query->set( 'tax_query', array( $args ) );
				}
			}

			return $query;
		}

		/*---------------------------------------------------------
			8. Get Project IDs for Projects template
		------------------------------------------------------------ */

		function get_page_projects( $output, $attr ) {
			// only apply this filter if we're on the projects template page
			if ( is_page_template( 'tm-projects.php' ) && isset( $attr['project_id'] ) ) {
				// add project_id to 'projects' to be pulled
				array_push( $this->project_ids, $attr['project_id'] );

				// prevent gallery from outputting anything
				return " ";
			} else {
				return $output;
			}
		}

		/*---------------------------------------------------------
			9. Enqueue Client Files
		------------------------------------------------------------ */
		function enqueueClientFiles() {

			global $wp_styles;

			if ( ! is_admin() ) {
				wp_enqueue_style(
					'react-style',
					get_bloginfo( 'stylesheet_url' ),
					'',
					null
				);

				wp_enqueue_style(
					'react-ie7-style',
					get_template_directory_uri() . '/stylesheets/ie7.css',
					array( 'react-style' ),
					null
				);
				$wp_styles->add_data( 'react-ie7-style', 'conditional', 'IE 7' );

				wp_enqueue_style(
					'react-ie8-style',
					get_template_directory_uri() . '/stylesheets/ie8.css',
					array( 'react-style' ),
					null
				);
				$wp_styles->add_data( 'react-ie8-style', 'conditional', '(gt IE 6)&(lt IE 9)' );

				// Include Lato with all fonts for accents, but don't include it twice
				if ( $this->bodyFont() == 'Lato:400,900' )
					$fontstack = 'http://fonts.googleapis.com/css?family=Lato';
				else
					$fontstack = 'http://fonts.googleapis.com/css?family=Lato|' . $this->bodyFont();

				if ( 'disable' != $this->bodyFont() ) {
					wp_enqueue_style(
						'react-body-font-style',
						$fontstack,
						array( 'react-style' ),
						null
					);
				}

				wp_enqueue_script( 'jquery' );

				wp_enqueue_script(
					'jquery-fitvids',
					get_template_directory_uri() . '/javascripts/jquery.fitvids.js',
					array( 'jquery' ),
					null
				);

				wp_enqueue_script(
					'react-theme-js',
					get_template_directory_uri() . '/javascripts/theme.js',
					array( 'jquery', 'jquery-fitvids' ),
					null
				);

				if ( is_singular() ) {
					wp_enqueue_script( 'comment-reply' );
				}

			}
		}

		/*---------------------------------------------------------
			10. Print Header Items
		------------------------------------------------------------ */
		function printHeaderItems() {

			if ( $this->bodyFont() == 'Droid+Sans' )
				$body_font = 'Droid Sans';
			elseif ( $this->bodyFont() == 'Droid+Serif' )
				$body_font = 'Droid Serif';
			elseif ( $this->bodyFont() == 'Lato:400,900' )
				$body_font = 'Lato';
			else
				$body_font = $this->bodyFont();

			if ( 'disable' != $this->bodyFont() ) : ?>
				<style type="text/css">body { font-family: '<?php echo $body_font ?>', Helvetica, Arial, sans-serif; }</style>
				<?php
			endif; ?>

			<!--[if (gt IE 6)&(lt IE 9)]>
				<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/javascripts/respond.js"></script>
			<![endif]-->
		<?php
		}

		/*---------------------------------------------------------
			11. Register Sidebars
		------------------------------------------------------------ */
		function registerSidebars() {

			register_sidebar( array(
				'name'=> __( 'Sidebar', 'react' ),
				'id' => 'sidebar_1',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			) );
			register_sidebar( array(
				'name'=> __( 'Footer 1', 'react' ),
				'id' => 'footer_1',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			) );
			register_sidebar( array(
				'name'=> __( 'Footer 2', 'react' ),
				'id' => 'footer_2',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			) );
			register_sidebar( array(
				'name'=> __( 'Footer 3', 'react' ),
				'id' => 'footer_3',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			) );

		}

		/*---------------------------------------------------------
			12. Main Menu Fallback
		------------------------------------------------------------ */
		function main_menu_fallback() {
			?>
			<div id="navigation" class="clear">
				<ul class="nav">
					<?php
						wp_list_pages( 'title_li=&number=6' );
					?>
				</ul>
			</div>
			<?php
			}

		/*---------------------------------------------------------
			13. Navigation Functions
		------------------------------------------------------------ */
		function registerMenus() {
			register_nav_menu( 'nav-1', __( 'Top Navigation', 'react' ) );
		}

		/*---------------------------------------------------------
			14. Define theme options
		------------------------------------------------------------ */
		function setOptions() {

			/*
				OPTION TYPES:
				- checkbox: name, id, desc, std, type
				- radio: name, id, desc, std, type, options
				- text: name, id, desc, std, type
				- colorpicker: name, id, desc, std, type
				- select: name, id, desc, std, type, options
				- textarea: name, id, desc, std, type, options
			*/

			$this->options = array(

				array(
					"name" => __( 'Custom logo image', 'react' ),
					"type" => "subhead"),

				array(
					"name" => __( 'Enable custom logo image', 'react' ),
					"id" => $this->shortname."_logo",
					"desc" => __( 'Check to use a custom logo in the header.', 'react' ),
					"std" => "false",
					"type" => "checkbox"),

				array(
					"name" => __( 'Logo URL', 'react' ),
					"id" => $this->shortname."_logo_img",
					"desc" => __( 'Upload an image or enter an URL for your image.', 'react' ),
					"std" => '',
					"upload" => true,
					"class" => "logo-image-input",
					"type" => "upload"),

				array(
					"name" => __( 'Logo image <code>&lt;alt&gt;</code> tag', 'react' ),
					"id" => $this->shortname."_logo_img_alt",
					"desc" => __( 'Specify the <code>&lt;alt&gt;</code> tag for your logo image.', 'react' ),
					"std" => '',
					"type" => "text"),

				array(
					"name" => __( 'Hide tagline', 'react' ),
					"id" => $this->shortname."_tagline",
					"desc" => __( 'Check to hide your tagline on the front page.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Subscribe links', 'react' ),
					"type" => "subhead"),

				array(
					"name" => __( 'Enable Twitter', 'react' ),
					"id" => $this->shortname."_twitter_toggle",
					"desc" => __( 'Hip to Twitter? Check this box. Please set your Twitter username in the Twitter menu.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Enable Facebook', 'react' ),
					"id" => $this->shortname."_facebook_toggle",
					"desc" => __( 'Check this box to show a link to your Facebook page.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Enable Flickr', 'react' ),
					"id" => $this->shortname."_flickr_toggle",
					"desc" => __( 'Check this box to show a link to Flickr.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Enable Google+', 'react' ),
					"id" => $this->shortname."_google_plus_toggle",
					"desc" => __( 'Check this box to show a link to Google+.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Disable all', 'react' ),
					"id" => $this->shortname."_follow_disable",
					"desc" => __( 'Check this box to hide all follow icons (including RSS). This option overrides any other settings.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Twitter name', 'react' ),
					"id" => $this->shortname."_twitter",
					"desc" => __( 'Enter your Twitter name.', 'react' ),
					"std" => '',
					"type" => "text"),

				array(
					"name" => __( 'Facebook link', 'react' ),
					"id" => $this->shortname."_facebook",
					"desc" => __( 'Enter your Facebook link.', 'react' ),
					"std" => '',
					"type" => "text"),

				array(
					"name" => __( 'Flickr link', 'react' ),
					"id" => $this->shortname."_flickr",
					"desc" => __( 'Enter your Flickr link.', 'react' ),
					"std" => '',
					"type" => "text"),

				array(
					"name" => __( 'Google+ link', 'react' ),
					"id" => $this->shortname."_google_plus",
					"desc" => __( 'Enter your Google+ link.', 'react' ),
					"std" => '',
					"type" => "text"),

				array(
					"name" => __( 'Typography', 'react' ),
					"type" => "subhead"),

				array(
					"name" => __( 'Primary font', 'react' ),
					"desc" => __( 'Fallback font stack is "Helvetica, Arial, sans-serif". Added page weight is in parentheses.', 'react' ),
					"id" => $this->shortname."_body_font",
					"std" => 'Lato:400,900',
					"type" => "select",
					"options" => array(
						"Droid+Sans" => __( 'Droid Sans (75kb)', 'react' ),
						"Droid+Serif" => __( 'Droid Serif (77kb)', 'react' ),
						"disable" => __( 'Helvetica', 'react' ),
						"Kameron" => __( 'Kameron (90kb)', 'react' ),
						"Lato:400,900" => __( 'Lato (49kb)', 'react' ),
						"Metrophobic" => __( 'Metrophobic (87kb)', 'react' ),
						"Muli" => __( 'Muli (81kb)', 'react' ) ) ),

				array(
					"name" => __( 'Layout', 'react' ),
					"type" => "subhead"),

				array(
					"name" => __( 'Disable sidebar', 'react' ),
					"id" => $this->shortname."_sidebar_disable",
					"desc" => __( 'Completely remove the sidebar from your blog.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Show the widgets footer', 'react' ),
					"id" => $this->shortname."_footer_widgets",
					"desc" => __( 'Set the visibility of the widgets footer.', 'react' ),
					"std" => 'all',
					"type" => "select",
					"options" => array(
						"disable" => __( 'Nowhere', 'react' ),
						"all" => __( 'Everywhere', 'react' ),
						"notfront" => __( 'Everywhere but the front page', 'react' ),
						"pages" => __( 'On all pages', 'react' ),
						"pagesnotfront" => __( 'On all pages but the front page', 'react' ),
						"frontpage" => __( 'On the front page only', 'react' ) ) ),

				array(
					"name" => __( 'Show the latest news footer', 'react' ),
					"id" => $this->shortname."_footer_news",
					"desc" => __( 'Set the visibility of the latest news footer.', 'react' ),
					"std" => 'disable',
					"type" => "select",
					"options" => array(
						"disable" => __( 'Nowhere', 'react' ),
						"all" => __( 'Everywhere', 'react' ),
						"notfront" => __( 'Everywhere but the front page', 'react' ),
						"pages" => __( 'On all pages', 'react' ),
						"pagesnotfront" => __( 'On all pages but the front page', 'react' ),
						"frontpage" => __( 'On the front page only', 'react' ) ) ),

				array(
					"name" => __( 'Show the recent projects footer', 'react' ),
					"id" => $this->shortname."_footer_projects",
					"desc" => __( 'Set the visibility of the recent projects footer.', 'react' ),
					"std" => 'disable',
					"type" => "select",
					"options" => array(
						"disable" => __( 'Nowhere', 'react' ),
						"all" => __( 'Everywhere', 'react' ),
						"notfront" => __( 'Everywhere but the front page', 'react' ),
						"pages" => __( 'On all pages', 'react' ),
						"pagesnotfront" => __( 'On all pages but the front page', 'react' ),
						"frontpage" => __( 'On the front page only', 'react' ) ) ),

				array(
					"name" => __( 'Projects', 'react' ),
					"type" => "subhead"),

				array(
					"name" => __( 'Hide project items on the blog', 'react' ),
					"id" => $this->shortname."_hide_projects",
					"desc" => __( 'Posts with the Gallery post format are displayed on any pages using the "Projects" page template. They are also shown on the blog. Check this box to hide them from the blog.', 'react' ),
					"std" => '',
					"type" => "checkbox"),

				array(
					"name" => __( 'Singular project name', 'react' ),
					"id" => $this->shortname."_singular_project_name",
					"desc" => __( 'Used on the blog to label the project.', 'react' ),
					"std" => 'Project',
					"type" => "text"),

				array(
					"name" => __( 'Plural project name', 'react' ),
					"id" => $this->shortname."_plural_project_name",
					"desc" => __( 'Used for the recent projects footer title.', 'react' ),
					"std" => 'Recent projects',
					"type" => "text"),

				array(
					"name" => __( 'Sort projects by', 'react' ),
					"id" => $this->shortname."_sort_projects",
"desc" => __( 'By default your project items are sorted by date on pages using the Projects page template. Use this option to change the sort order. <br /><br /><strong>NOTE:</strong> This does not affect the Recent Projects footer (controlled in the Layout section).', 'react' ),
					"std" => '',
					"type" => "select",
					"options" => array(
						"date" => __( 'Date', 'react' ),
						"title" => __( 'Title', 'react' ),
						"modified" => __( 'Last modified', 'react' ),
						"ID" => __( 'Post ID', 'react' ),
						"rand" => __( 'Randomly', 'react' ) ) ),

				array(
					"name" => __( 'Sort order', 'react' ),
					"id" => $this->shortname."_project_sort_order",
"desc" => __( 'Choose a sort order for your Projects page. Descending (3, 2, 1) or Ascending (a, b, c).', 'react' ),
					"std" => 'DESC',
					"type" => "select",
					"options" => array(
						"DESC" => __( 'Descending', 'react' ),
						"ASC" => __( 'Ascending', 'react' ) ) ),

				array(
					"name" => __( 'Footer', 'react' ),
					"type" => "subhead"),

				array(
					"name" => __( 'Copyright notice', 'react' ),
					"id" => $this->shortname."_copyright_name",
					"desc" => __( 'Your name or the name of your business.', 'react' ),
					"std" => '',
					"type" => "text")
			);
		}

		/*---------------------------------------------------------
			15. Theme option return functions
		------------------------------------------------------------ */

			/*---------------------------------------------------------
				I. Logo Functions
			------------------------------------------------------------ */
			function logoState () {
				return get_option($this->shortname.'_logo' );
			}
			function logoName () {
				return get_option( $this->shortname.'_logo_img' );
			}
			function logoAlt () {
				return get_option($this->shortname.'_logo_img_alt' );
			}
			function logoTagline () {
				return get_option($this->shortname.'_tagline' );
				}

			/*---------------------------------------------------------
				II. Subscribe Functions
			------------------------------------------------------------ */
			function twitter() {
				return stripslashes( wp_filter_post_kses( get_option( $this->shortname.'_twitter' ) ) );
			}
			function twitterToggle() {
				return get_option( $this->shortname.'_twitter_toggle' );
			}
			function facebook() {
				return stripslashes( wp_filter_post_kses( get_option( $this->shortname.'_facebook' ) ) );
			}
			function facebookToggle() {
				return get_option( $this->shortname.'_facebook_toggle' );
			}
			function flickr() {
				return wp_filter_post_kses( get_option( $this->shortname.'_flickr' ) );
			}
			function flickrToggle() {
				return get_option( $this->shortname.'_flickr_toggle' );
			}
			function googlePlus() {
				return get_option( $this->shortname."_google_plus" );
			}
			function googlePlusToggle() {
				return get_option( $this->shortname."_google_plus_toggle" );
			}
			function followDisable() {
				return get_option( $this->shortname.'_follow_disable' );
			}

			/*---------------------------------------------------------
				III. Typography Functions
			------------------------------------------------------------ */
			function bodyFont () {
				return get_option( $this->shortname.'_body_font', 'Lato:400,900' );
			}

			/*---------------------------------------------------------
				IV. Layout
			------------------------------------------------------------ */
			function sidebarDisable() {
				return get_option( $this->shortname.'_sidebar_disable' );
			}
			function footerWidgets() {
				return get_option( $this->shortname.'_footer_widgets', 'all' );
			}
			function footerNews() {
				return get_option( $this->shortname.'_footer_news' );
			}
			function footerProjects() {
				return get_option( $this->shortname.'_footer_projects' );
			}

			/*---------------------------------------------------------
				V. Projects
			------------------------------------------------------------ */
			function singular_project_name() {
				return get_option( $this->shortname.'_singular_project_name', 'Project' );
			}
			function plural_project_name() {
				return get_option( $this->shortname.'_plural_project_name', 'Recent projects' );
			}
			function sort_projects() {
				return get_option( $this->shortname.'_sort_projects', 'date' );
			}
			function project_sort_order() {
				return get_option( $this->shortname.'_project_sort_order', 'DESC' );
			}

			/*---------------------------------------------------------
				VI. Footer Functions
			------------------------------------------------------------ */
			function copyrightName() {
				return stripslashes( wp_filter_post_kses( get_option( $this->shortname.'_copyright_name' ) ) );
			}

	}
}

/* SETTING EVERYTHING IN MOTION */
function load_react_pro_theme() {
	$GLOBALS['react'] = new React;
}

add_action( 'after_setup_theme', 'load_react_pro_theme' );