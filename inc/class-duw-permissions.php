<?php

class DUW_Permissions {

	/**
	 * @var array meta information for the custom guest role
	 */
	public static $GUEST_ROLE = array(
			'slug' => 'duw_guest',
			'name' => 'Guest'
	);

	/**
	 * Initialize the plugin's permissions if needed
	 */
	public static function init() {
		if (! DUW_Plugin::inHook('activate')) {
			return;
		}

		// Add custom guest role if needed
		$guestAdded = add_role(static::$GUEST_ROLE['slug'], static::$GUEST_ROLE['name'], array());

		// FIXME stub
	}

	/**
	 * Reset custom upload permissions to their default setting for all roles
	 */
	public static function reset() {
		// FIXME stub
	}

	/**
	 * Remove any custom roles and capabilities
	 */
	public static function remove() {
		$allowRemove = ( DUW_Plugin::inHook('uninstall') || current_user_can('edit_users') );
		if (! $allowRemove ) {
			return;
		}

		remove_role( static::$GUEST_ROLE['slug'] );

		// FIXME stub
	}
}