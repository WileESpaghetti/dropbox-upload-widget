<?php
/* {{PluginHeader}} */

defined( 'ABSPATH' ) or exit( 'WordPress must be running to use plugin' );

define( 'DUW_PLUGIN', true );

require_once( 'inc/class-duw-plugin.php' );

register_activation_hook( __FILE__, array( 'DUW_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DUW_Plugin', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'DUW_Plugin', 'uninstall' ) );

