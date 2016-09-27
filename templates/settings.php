<?php

	global $wp_bootstrap;

	if ( isset( $_POST['submit'] ) ) {
		$wp_bootstrap->save_settings();
	}

	$settings = $wp_bootstrap->__init_settings();

?>
<style>
	.wp-bootstrap-settings-page label {font-weight: bold;}
	.wp-bootstrap-settings-page section {border-bottom: #ccc 1px solid; padding-bottom: 25px;  margin-bottom: 25px;}
</style>
<div class="wrap wp-bootstrap-settings-page">
	<h1>WP Bootstrap Settings</h1>
	<form method="post" action="">
		<?php wp_nonce_field( 'wp_bootstrap_settings' ); ?>
		<section class="general">
			<h2><?php _e('General settings', 'wpboot'); ?></h2>
			<p class="form-field">
				<label><?php _e('Auto-update for new versions'); ?></label></br><span class="description"><?php _e('This will update Bootstrap to the last stable version', 'wpboot'); ?></span>
			</br><input type="checkbox" name="_enable_bootstrap_auto_updt" value="yes" <?php if ($settings['_enable_bootstrap_auto_updt'] == 'yes') echo 'checked="checked"' ?>>
			</p>
			<p class="form-field">
				<label><?php _e('Choose a loading location', 'wpboot'); ?></label></br>
				<select name="_bootstrap_load_location">
					<option value="head" <?php if ( $settings['_bootstrap_load_location'] == 'head' ) echo 'selected="selected"'; ?>>Head</option>
					<option value="footer" <?php if ( $settings['_bootstrap_load_location'] == 'footer' ) echo 'selected="selected"'; ?>>Footer</option>
				</select>
			</p>
		</section>
		<section class="frontend">
			<h2><?php _e('Frontend settings', 'wpboot'); ?></h2>
			<p class="form-field">
				<label><?php _e('Enable Bootstrap in frontend'); ?></label></br>
				<input type="checkbox" name="_enable_bootstrap_front" value="yes" <?php if ($settings['_enable_bootstrap_front'] == 'yes') echo 'checked="checked"' ?>>
			</p>
			<p class="form-field">
				<label><?php _e('Bootstrap resources to load'); ?></label></br>
				<?php $sel_resources = unserialize( $settings['_enabled_bootstrap_resources_front'] ); ?>
				<select name="_enabled_bootstrap_resources_front[]" multiple="multiple">
					<?php foreach ( $wp_bootstrap->resources as $value => $name ) : ?>
						<option value="<?php echo $value; ?>" <?php if ( in_array($value, $sel_resources) ) echo 'selected="selected"'; ?>><?php echo $name; ?></option>
					<?php endforeach; ?>
				</select>
			</p>
		</section>
		<section class="backend">
			<h2><?php _e('Backend settings', 'wpboot'); ?></h2>
			<p class="form-field">
				<label><?php _e('Enable Bootstrap in backend'); ?></label></br>
				<input type="checkbox" name="_enable_bootstrap_back" value="yes" <?php if ($settings['_enable_bootstrap_back'] == 'yes') echo 'checked="checked"' ?>>
			</p>
			<p class="form-field">
				<label><?php _e('Bootstrap resources to load'); ?></label></br>
				<select name="_enabled_bootstrap_resources_back[]" multiple="multiple">
					<?php $sel_resources = unserialize( $settings['_enabled_bootstrap_resources_back'] ); ?>
					<?php foreach ( $wp_bootstrap->resources as $value => $name ) : ?>
						<option value="<?php echo $value; ?>" <?php if ( in_array($value, $sel_resources) ) echo 'selected="selected"'; ?>><?php echo $name; ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<p class="form-field">
				<?php $post_types = get_post_types( array('_builtin' => false ) ); ?>
				<label><?php _e('Enabled Boostrap resources in post types', 'wpboot'); ?></label></br>
				<?php $sel_pt = unserialize( $settings['_enabled_bootstrap_post_types'] ); ?>
				<select name="_enabled_bootstrap_post_types[]" multiple="multiple">
					<option value="post" <?php if ( in_array('post', $sel_pt ) ) echo 'selected="selected"'; ?>>post</option>
					<option value="page" <?php if ( in_array('page', $sel_pt ) ) echo 'selected="selected"'; ?>>page</option>
					<?php foreach ( $post_types as $post_type_slug => $post_type ) : ?>
						<option value="<?php echo $post_type_slug; ?>" <?php if ( in_array( $post_type_slug, $sel_pt) ) echo 'selected="selected"'; ?>><?php echo $post_type; ?></option>
					<?php endforeach; ?>
				</select>
			</p>
		</section>
		<section class="others">
			<h2><?php _e('Other settings', 'wpboot'); ?></h2>
			<label><?php _e('Load Bootstrap Walker'); ?></label></br>
			<input type="checkbox" name="_enable_bootstrap_walker" value="yes" <?php if ($settings['_enable_bootstrap_walker'] == 'yes') echo 'checked="checked"' ?>>
		</section>
		<?php submit_button(); ?>
	</form>
</div>
