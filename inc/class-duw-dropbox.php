<?php

/**
 * Class DUW_Dropbox
 *
 * Class for helping interact with the Dropbox API
 */
class DUW_Dropbox {
    const TRANSIENT = DUW_Settings::OPTION_NAME . '_account_info';
    
    public static function is_configured() {
        $options  = get_option( DUW_Settings::OPTION_NAME );
        return (! (empty($options['app_key']) || empty($options['app_secret']) || empty($options['access_token'])));
    }

    /**
     * Fetch user's account info from the Dropbox API
     * This should be preferred over using the transient directly.
     * 
     * @return array filled with values from the Dropbox API or an empty array if API call fails
     * 
     * @see https://www.dropbox.com/developers/core/docs#account-info
     */
    public static function get_account_info() {
        $accountInfo = array();
        
        if ( ! static::is_configured() ) {
            return $accountInfo;
        }

        $options = get_option( DUW_Settings::OPTION_NAME );
        
        try {
            $dbxClient = new \Dropbox\Client($options['access_token'], DUW_Plugin::NAME);
            $accountInfo = $dbxClient->getAccountInfo(); // FIXME sanitize output
            
            set_transient(DUW_Dropbox::TRANSIENT, $accountInfo);
        } catch(Exception $apiFailure) {
            // TODO maybe we do something useful here... maybe not...
        }
        
        return $accountInfo;
    }
    
    public static function account_info() {
        $accountInfo = get_transient( static::TRANSIENT );
        
        if ( $accountInfo === false || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
            $accountInfo = static::get_account_info();
        }

        return $accountInfo;
    }
}
