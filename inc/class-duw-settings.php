<?php

/**
 * Class DUW_Settings
 *
 * {{PLUGIN_NAME}} settings management functions
 */
class DUW_Settings {
	const OPTION_NAME = 'duw_dropbox_upload';
	const OPTIONS_PAGE_TITLE = DUW_Plugin::NAME . ' Settings';
	const OPTIONS_PAGE_PERMS = 'manage_options';
	const OPTIONS_MENU_TITLE = DUW_PLUGIN::NAME;
	const OPTIONS_MENU_SLUG = DUW_PLUGIN;

	/**
	 * Action to register {{PLUGIN_NAME}} settings
	 *
	 * This needs to be be run from the `admin_init` hook
	 */
	public static function register() {
		if ( current_filter() !== 'admin_init' ) {
			return;
		}

		register_setting(static::OPTION_NAME, static::OPTION_NAME, array(static::class, 'update'));
	}

	/**
	 * Action to sanitize {{PLUGIN_NAME}} settings
	 *
	 * This is run as the sanitize_callback for register_setting
	 * which is run during the sanitize_option_{$option_name} hook
	 *
	 * @param $settings array of settings to sanitize
	 *
	 * @return array the sanitized settings
	 */
	public static function update( $settings ) {
		// FIXME stub
		return $settings;
	}

	/**
	 * Action to add link to the plugin settings page to the Settings menu.
	 *
	 * This needs to be be run from the `admin_menu` hook
	 */
	public static function the_menu_item() {
		if ( current_filter() !== 'admin_menu' ) {
			return;
		}

		add_options_page(
			static::OPTIONS_PAGE_TITLE,
			static::OPTIONS_MENU_TITLE,
			static::OPTIONS_PAGE_PERMS,
			static::OPTIONS_MENU_SLUG,
			array( get_called_class(), 'the_options_page' )
		);
	}

	/**
	 * Callback to render the settings page for {{PLUGIN_NAME}}
	 */
	public static function the_options_page() {
		?><div class="wrap">
            <h1><?php echo static::OPTIONS_PAGE_TITLE; ?></h1>

            <form method="post" action="options.php"><?php
                settings_fields( static::OPTION_NAME );
                do_settings_sections( static::OPTION_NAME );
                submit_button();
            ?></form>
        </div><?php
	}

	/**
	 * Callback to render the Dropbox API settings
	 */
	public static function the_dropbox_api_settings_section() {
		add_settings_section(
			'dropbox_api',
			__('You will need to create an <a href="https://www.dropbox.com/developers/apps" target="_blank">application</a> on the <a href="https://www.dropbox.com/developers" target="_blank">Dropbox developer page</a> if you haven\'t already.', DUW_Plugin::I18N),
			'__return_null',
			static::OPTION_NAME
		);

		add_settings_field(
			'app_key',
			__( 'App key', DUW_PLUGIN::I18N ),
			array(get_called_class(), 'the_setting_text_field'),
			static::OPTION_NAME,
			'dropbox_api',
			array('app_key')
		);

		add_settings_field(
			'app_secret',
			__( 'App secret', DUW_PLUGIN::I18N ),
			array(get_called_class(), 'the_setting_text_field'),
			static::OPTION_NAME,
			'dropbox_api',
			array('app_secret')
		);
	}

	/**
	 * Callback to render a text field for simple settings
	 */
	public static function the_setting_text_field($args) {
		$options  = get_option( static::OPTION_NAME );
		$optName  = $args[0];
		$optValue = empty($options[$optName]) ? '' : $options[$optName];

		printf('<input type="text" name="%s[%s]" value="%s" class="regular-text">', esc_attr(static::OPTION_NAME), esc_attr($optName), esc_attr($optValue));
	}
}