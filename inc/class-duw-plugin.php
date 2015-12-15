<?php

/**
 * Class DUW_Plugin
 *
 * Contains global plugin metadata and plugin management functions
 */
class DUW_Plugin {
	/**
	 * The name of the plugin with proper formatting
	 * @var string
	 */
	const NAME = '{{PLUGIN_NAME}}';

	/**
	 * Helper function to check if we are running in a specific plugin hook
	 *
	 * @param $name string the hook to check for
	 *
	 * @return bool whether or not we are in the proper hook
	 */
	public static function inHook( $name ) {
		$hook   = $name . '_' . DUW_PLUGIN;
		$inHook = current_action() === $hook;

		return $inHook;
	}

	/**
	 * Plugin activation hook for {{PLUGIN_NAME}}
	 *
	 * @static
	 */
	public static function activate() {
		if ( ! static::inHook( 'activate' ) ) {
			return;
		}

		DUW_Permissions::init();

		// FIXME incomplete
	}

	/**
	 * Plugin deactivation hook for {{PLUGIN_NAME}}
	 *
	 * @static
	 */
	public static function deactivate() {
		if ( ! static::inHook( 'deactivate' ) ) {
			return;
		}

		// FIXME incomplete
	}

	/**
	 * Plugin deactivation hook for {{PLUGIN_NAME}}
	 *
	 * @static
	 */
	public static function uninstall() {
		if ( ! static::inHook( 'uninstall' ) ) {
			return;
		}

		DUW_Permissions::remove();

		// FIXME incomplete
	}
}
