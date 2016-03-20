<?php

class DUW_Permissions {
	const UPLOAD_CAP = 'duw_upload_files';

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
		if ( ! DUW_Plugin::inHook( 'activate' ) ) {
			return;
		}

		// Add custom guest role if needed
		$guestAdded = add_role( static::$GUEST_ROLE['slug'], static::$GUEST_ROLE['name'], array() );

		$permsSetup = ( $guestAdded === null );
		if ( $permsSetup ) {
			return;
		}

		static::reset();
	}

	/**
	 * Reset custom upload permissions to their default setting for all roles
	 */
	public static function reset() {
		$resetAllowed = ( DUW_Plugin::inHook( 'activate' ) || current_user_can( 'edit_users' ) );
		if ( ! $resetAllowed ) {
			return;
		}

		$roles = static::get_roles_with_guest();
		foreach ( $roles as $slug => $role ) {
			$role      = get_role( $slug );
			$hasUpload = $role->has_cap( 'upload_files' );
			if ( $hasUpload ) {
				$role->add_cap( static::UPLOAD_CAP );
			} else {
				$role->remove_cap( static::UPLOAD_CAP );
			}
		}
	}

	/**
	 * Remove any custom roles and capabilities
	 */
	public static function remove() {
		$removeAllowed = ( DUW_Plugin::inHook( 'uninstall' ) || current_user_can( 'edit_users' ) );
		if ( ! $removeAllowed ) {
			return;
		}

		remove_role( static::$GUEST_ROLE['slug'] );

		$roles = get_editable_roles();
		foreach ( $roles as $slug => $role ) {
			$role = get_role( $slug );
			$role->remove_cap( static::UPLOAD_CAP );
		}
	}

	/**
	 * Filter the list of editable roles to exclude our guest role by default.
	 * This is meant to be called inside of the editable_roles filter
	 *
	 * @param $roles array roles passed in from the editable_roles filter
	 *
	 * @return array $roles List of roles.
	 */
	public static function hide_guest_role( $roles ) {
		if ( isset( $roles[ self::$GUEST_ROLE['slug'] ] ) ) {
			unset( $roles[ self::$GUEST_ROLE['slug'] ] );
		}

		return $roles;
	}

	/**
	 * Bypass the hide_guest_role() filter
	 *
	 * @return array $roles List of roles.
	 */
	public static function get_roles_with_guest() {
		remove_filter( 'editable_roles', array( self::class, 'hide_guest_role' ), 11 );
		$roles = get_editable_roles();
		add_filter( 'editable_roles', array( self::class, 'hide_guest_role' ), 11, 1 );

		return $roles;
	}

	/**
	 * Gets the friendly display name of a user role
	 *
	 * @param WP_Role $role
	 *
	 * @return array|WP_Roles
	 */
	public static function get_role_display_name(WP_Role $role) {
		$displayName = wp_roles();
		$displayName = $displayName->get_names();
		$displayName = $displayName[$role->name];

		return $displayName;
	}
}
