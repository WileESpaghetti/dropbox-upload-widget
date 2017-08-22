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
		$saveThis = array();

		$saveThis['app_key']      = ( ! empty($settings['app_key']) )      ? sanitize_text_field($settings['app_key'])      : '';
		$saveThis['app_secret']   = ( ! empty($settings['app_secret']) )   ? sanitize_text_field($settings['app_secret'])   : '';
		$saveThis['access_token'] = ( ! empty($settings['access_token']) ) ? sanitize_text_field($settings['access_token']) : '';

		if (empty($saveThis['app_key']) || empty($saveThis['app_secret']) || empty($saveThis['access_token'])) {
			add_settings_error('duw_dropbox_upload', 'api-settings', __('The Dropbox API settings not configured correctly', DUW_PLUGIN::I18N), 'notice-warning'); // FIXME hard-coded setting name
		}

		if (current_user_can('edit_users')) {
			$roles = DUW_Permissions::get_roles_with_guest();
			foreach($roles as $slug => $role) {
				$role       = get_role($slug);
				$roleName   = esc_attr($role->name);
				$cantUpload = empty($settings[$roleName]) || $settings[$roleName] !== 'on';

				if ($cantUpload) {
					$role->remove_cap( DUW_Permissions::UPLOAD_CAP );
				} else {
					$role->add_cap(    DUW_Permissions::UPLOAD_CAP );
				}
			}
		}

		return $saveThis;
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
	 * Callback to render the settings page section for {{PLUGIN_NAME}}
	 */
	public static function the_options_sections() {
		static::the_dropbox_api_settings_section();
		static::the_account_info_section();
		static::the_upload_permissions_settings_section();
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
			__('<p>You will need to create an <a href="https://www.dropbox.com/developers/apps" target="_blank">application</a> on the <a href="https://www.dropbox.com/developers" target="_blank">Dropbox developer page</a> if you haven\'t already.</p>', DUW_Plugin::I18N),
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

		add_settings_field(
			'access_token',
			__( 'Access token', DUW_PLUGIN::I18N ),
			array(get_called_class(), 'the_setting_text_field'),
			static::OPTION_NAME,
			'dropbox_api',
			array('access_token')
		);
	}
	
	/**
	 * Callback to render profile information for the configured Dropbox account
	 *
	 * This section mainly exists to test that the Dropbox API is properly configured.
	 */
	public static function the_account_info_section() {
		add_settings_section(
			'account_info',
			__('Dropbox profile', DUW_PLUGIN::I18N),
			'__return_null',
			static::OPTION_NAME
		);
		
		if ( ! DUW_Dropbox::is_configured() ) {
			// FIXME show user warning if API not configured or error if API called failed
			return;
		}

		add_settings_field(
			'display_name',
			__( 'Display name', DUW_PLUGIN::I18N ),
			'duw_the_display_name',
			static::OPTION_NAME,
			'account_info',
			array()
		);

		add_settings_field(
			'email',
			__( 'Email', DUW_PLUGIN::I18N ),
			'duw_the_email',
			static::OPTION_NAME,
			'account_info',
			array()
		);

		add_settings_field(
			'uid',
			__( 'User ID', DUW_PLUGIN::I18N ),
			'duw_the_uid',
			static::OPTION_NAME,
			'account_info',
			array()
		);

		add_settings_field(
			'referral_link',
			__( 'Referral link', DUW_PLUGIN::I18N ),
			'duw_the_referral_link',
			static::OPTION_NAME,
			'account_info',
			array()
		);
	}

	/**
	 * Callback to render the upload permissions settings
	 */
	public static function the_upload_permissions_settings_section() {
		add_settings_section(
			'upload_permissions',
			__('Upload Permissions', DUW_PLUGIN::I18N),
			'__return_null',
			static::OPTION_NAME
		);

		if (current_user_can('edit_users')) {
			$roles = DUW_Permissions::get_roles_with_guest();

			foreach($roles as $slug => $role) {
				$role = get_role($slug);

				$displayName = DUW_Permissions::get_role_display_name($role);
				$hasPerms    = $role->has_cap(DUW_Permissions::UPLOAD_CAP);
				$checked     = checked($hasPerms, true, false);

				add_settings_field(
					'user_role_' . $slug,
					__( $displayName, DUW_PLUGIN::I18N ),
					array(get_called_class(), 'the_upload_permission_field'),
					static::OPTION_NAME,
					'upload_permissions',
					array($role->name, $checked, $displayName)
				);
			}
		}
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

	/**
	 * Callback to render a checkbox for user role permission settings
	 *
	 * @param $args
	 */
	public static function the_upload_permission_field($args) {
		printf('<label><input type="checkbox" name="%s[%s]" %s> %s</label>',
			esc_attr(static::OPTION_NAME),
			esc_attr($args[0]),
			$args[1],
			__('Allowed', DUW_PLUGIN::I18N)
		);
	}
}