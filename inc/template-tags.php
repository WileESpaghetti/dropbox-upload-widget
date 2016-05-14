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

/**
 * Retrieve the user ID associated with the configured Dropbox account.
 *
 * @since 0.0.0
 *
 * @return string|false The user ID or false if there was an error getting the Dropbox account information
 */
function duw_get_the_uid() {
    $accountInfo = DUW_Dropbox::account_info();

    if (empty($accountInfo) || empty($accountInfo['uid'])) {
        return false;
    }

    return $accountInfo['uid'];
}

/**
 * Display the user ID associated with the configured Dropbox account.
 *
 * @since 0.0.0
 */
function duw_the_uid() {
    $uid = duw_get_the_uid();

    /**
     * Filter the Dropbox user ID.
     *
     * @since 0.0.0
     *
     * @param string $uid            The Dropbox user ID.
     * @param array  $accountInfo    The raw Dropbox account information pulled from the API.
     */
    echo apply_filters('duw_the_uid', $uid, DUW_Dropbox::account_info());
}

/**
 * Retrieve the referral link associated with the configured Dropbox account.
 *
 * @since 0.0.0
 *
 * @return string|false The referral link or false if there was an error getting the Dropbox account information
 */
function duw_get_the_referral_link() {
    $accountInfo = DUW_Dropbox::account_info();

    if (empty($accountInfo) || empty($accountInfo['referral_link'])) {
        return false;
    }

    return $accountInfo['referral_link'];
}

/**
 * Display the referral link associated with the configured Dropbox account.
 *
 * @since 0.0.0
 */
function duw_the_referral_link() {
    $referralLink = duw_get_the_referral_link();

    /**
     * Filter the Dropbox referral link.
     *
     * @since 0.0.0
     *
     * @param string $referralLink    The Dropbox referral URL you can use to get credit for user registrations.
     * @param array  $accountInfo     The raw Dropbox account information pulled from the API.
     */
    echo apply_filters('duw_the_referral_link', $referralLink, DUW_Dropbox::account_info());
}

/**
 * Retrieve the number of bytes used by files on the configured Dropbox account.
 *
 * @since 0.0.0
 *
 * @return string|false The number of bytes or false if there was an error getting the Dropbox account information
 */
function duw_get_the_usage() {
    $accountInfo = DUW_Dropbox::account_info();

    if (empty($accountInfo) || empty($accountInfo['quota_info']) || empty($accountInfo['quota_info']['normal'])) {
        return false;
    }

    return $accountInfo['quota_info']['normal'];
}

/**
 * Display the number of bytes used by files on the configured Dropbox account.
 *
 * @since 0.0.0
 */
function duw_the_usage() {
    $usage = duw_get_the_usage();

    /**
     * Filter the Dropbox usage.
     *
     * @since 0.0.0
     *
     * @param string $usage             The number of bytes you are allowed to use to store files on Dropbox.
     * @param array  $accountInfo     The raw Dropbox account information pulled from the API.
     */
    echo apply_filters('duw_the_usage', $usage, DUW_Dropbox::account_info());
}

/**
 * Retrieve the maximum number of bytes that can be used to store files on the configured Dropbox account.
 *
 * @since 0.0.0
 *
 * @return string|false The max usage or false if there was an error getting the Dropbox account information
 */
function duw_get_the_quota() {
    $accountInfo = DUW_Dropbox::account_info();

    if (empty($accountInfo) || empty($accountInfo['quota_info']) || empty($accountInfo['quota_info']['quota'])) {
        return false;
    }

    return $accountInfo['quota_info']['quota'];
}

/**
 * Display the maximum number of bytes that can be stored on the configured Dropbox account.
 *
 * @since 0.0.0
 */
function duw_the_quota() {
    $max = duw_get_the_quota();

    /**
     * Filter the maximum number of bytes that can be stored on the configured Dropbox account.
     *
     * @since 0.0.0
     *
     * @param string $max             The number of bytes you are allowed to use to store files on Dropbox.
     * @param array  $accountInfo     The raw Dropbox account information pulled from the API.
     */
    echo apply_filters('duw_the_quota', $max, DUW_Dropbox::account_info());
}
