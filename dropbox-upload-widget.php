<?php
/* {{PluginHeader}} */

defined( 'ABSPATH' ) or exit( 'WordPress must be running to use plugin' );

define( 'DUW_PLUGIN', plugin_basename( __FILE__ ) );

require_once( 'inc/class-duw-permissions.php' );
require_once( 'inc/class-duw-settings.php' );
require_once( 'inc/class-duw-plugin.php' );

register_activation_hook( __FILE__, array( 'DUW_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DUW_Plugin', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'DUW_Plugin', 'uninstall' ) );

add_filter( 'editable_roles', array( 'DUW_Permissions', 'hide_guest_role' ), 11, 1 );
