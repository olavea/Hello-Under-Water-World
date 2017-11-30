<form method="get" id="search-form" action="<?php echo home_url( '/' ); ?>/">
	<div>
		<label for="s"><?php _e( 'Search', 'react' ); ?></label>
		<input type="text" value="" name="s" id="s"/>
		<input type="submit" value="<?php esc_attr_e( 'Search', 'react' ); ?>" />
	</div>
</form>
