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

	/**
	 * Filter the list of editable roles to exclude our guest role by default.
	 * This is meant to be called inside of the editable_roles filter
	 *
	 * @param $roles array roles passed in from the editable_roles filter
	 *
	 * @return array $roles List of roles.
	 */
	public static function hide_guest_role($roles) {
		if (isset($roles[self::$GUEST_ROLE['slug']])) {
			unset($roles[self::$GUEST_ROLE['slug']]);
		}

		return $roles;
	}

	/**
	 * Bypass the hide_guest_role() filter
	 *
	 * @return array $roles List of roles.
	 */
	public static function get_roles_with_guest() {
		remove_filter('editable_roles', array(self::class, 'hide_guest_role'), 11);
		$roles = get_editable_roles();
		add_filter('editable_roles', array(self::class, 'hide_guest_role'), 11, 1);

		return $roles;
	}
}
