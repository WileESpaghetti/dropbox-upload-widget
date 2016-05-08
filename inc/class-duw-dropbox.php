<?php

/**
 * Class DUW_Plugin
 *
 * Contains global plugin metadata and plugin management functions
 */
class DUW_Dropbox {
    public static function is_configured() {
        $options  = get_option( DUW_Settings::OPTION_NAME );
        return (! (empty($options['app_key']) || empty($options['app_secret']) || empty($options['access_token'])));
    }
}
