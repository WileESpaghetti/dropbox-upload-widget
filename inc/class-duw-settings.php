<?php

/**
 * Class DUW_Settings
 *
 * {{PLUGIN_NAME}} settings management functions
 */
class DUW_Settings {
	const OPTION_NAME = '';
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
}