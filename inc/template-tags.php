<?php
/**
 * {{PLUGIN_NAME}} Template Functions.
 *
 * Various info from the Dropbox API.
 *
 * @package {{TEXT_DOMAIN}}
 * @subpackage Template
 */

/**
 * Retrieve the display name of the configured Dropbox account.
 *
 * @since 0.0.0
 *
 * @return string|false The display name or false if there was an error getting the Dropbox account information
 */
function duw_get_the_display_name() {
    $accountInfo = DUW_Dropbox::account_info();

    if (empty($accountInfo) || empty($accountInfo['display_name'])) {
        return false;
    }

    return $accountInfo['display_name'];
}

/**
 * Display the display name of the configured Dropbox account.
 *
 * @since 0.0.0
 */
function duw_the_display_name() {
    $displayName = duw_get_the_display_name();

    /**
     * Filter the display name of the configured Dropbox account.
     *
     * @since 0.0.0
     *
     * @param string $usage        The Dropbox usage.
     * @param array  $quotaInfo    The raw quota information from the Dropbox account information.
     */
    echo apply_filters('duw_the_display_name', $displayName, DUW_Dropbox::account_info());
}
