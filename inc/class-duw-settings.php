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
            <h1><?php echo DUW_Settings::OPTIONS_PAGE_TITLE; ?></h1>

            <form method="post" action="options.php"><?php
                settings_fields( DUW_Settings::OPTION_NAME );
                do_settings_sections( DUW_Settings::OPTION_NAME );
                submit_button();
            ?></form>
        </div><?php
	}
}