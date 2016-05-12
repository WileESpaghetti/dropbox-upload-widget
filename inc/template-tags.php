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

/**
 * Retrieve the email address associated with the configured Dropbox account.
 *
 * @since 0.0.0
 *
 * @return string|false The email address or false if there was an error getting the Dropbox account information
 */
function duw_get_the_email() {
    $accountInfo = DUW_Dropbox::account_info();

    if (empty($accountInfo) || empty($accountInfo['email'])) {
        return false;
    }

    return $accountInfo['email'];
}

/**
 * Display the email address associated with the configured Dropbox account.
 *
 * @since 0.0.0
 */
function duw_the_email() {
    $email = duw_get_the_email();

    /**
     * Filter the Dropbox email address.
     *
     * @since 0.0.0
     *
     * @param string $email          The Dropbox user's email address.
     * @param array  $accountInfo    The raw Dropbox account information pulled from the API.
     */
    echo apply_filters('duw_the_email', $email, Duw_Dropbox::account_info());
}
