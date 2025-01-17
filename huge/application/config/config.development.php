<?php

/**
 * Configuration for DEVELOPMENT environment
 * To create another configuration set just copy this file to config.production.php etc. You get the idea :)
 */

/**
 * Configuration for: Error reporting
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configuration for cookie security
 */
ini_set('session.cookie_httponly', 1);

/**
 * Returns the full configuration.
 */
return array(
    /**
     * Configuration for: Base URL
     */
    'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),

    /**
     * Configuration for: Folders
     */
    'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/application/controller/',
    'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/application/view/',

    /**
     * Configuration for: Avatar paths
     */
    'PATH_AVATARS' => realpath(dirname(__FILE__).'/../../') . '/public/avatars/',
    'PATH_AVATARS_PUBLIC' => 'avatars/',

    /**
     * Configuration for: Default controller and action
     */
    'DEFAULT_CONTROLLER' => 'index',
    'DEFAULT_ACTION' => 'index',

    /**
     * Configuration for: Database
     */
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'huge_db',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    'DB_PORT' => '3306',
    'DB_CHARSET' => 'utf8',

    /**
     * Configuration for: Captcha size
     */
    'CAPTCHA_WIDTH' => 359,
    'CAPTCHA_HEIGHT' => 100,

    /**
     * Configuration for: Cookies
     */
    'COOKIE_RUNTIME' => 1209600,
    'COOKIE_PATH' => '/',
    'COOKIE_DOMAIN' => "",
    'COOKIE_SECURE' => false,
    'COOKIE_HTTP' => true,
    'SESSION_RUNTIME' => 604800,

    /**
     * Configuration for: Avatars/Gravatar support
     */
    'USE_GRAVATAR' => false,
    'GRAVATAR_DEFAULT_IMAGESET' => 'mm',
    'GRAVATAR_RATING' => 'pg',
    'AVATAR_SIZE' => 44,
    'AVATAR_JPEG_QUALITY' => 85,
    'AVATAR_DEFAULT_IMAGE' => 'default.jpg',

    /**
     * Configuration for: Encryption Keys
     */
    'ENCRYPTION_KEY' => '6#x0gÊìf^25cL1f$08&',
    'HMAC_SALT' => '8qk9c^4L6d#15tM8z7n0%',

    /**
     * Configuration for: Email server credentials
     */
    'EMAIL_USED_MAILER' => 'phpmailer',
    'EMAIL_USE_SMTP' => false,
    'EMAIL_SMTP_HOST' => 'yourhost',
    'EMAIL_SMTP_AUTH' => true,
    'EMAIL_SMTP_USERNAME' => 'yourusername',
    'EMAIL_SMTP_PASSWORD' => 'yourpassword',
    'EMAIL_SMTP_PORT' => 465,
    'EMAIL_SMTP_ENCRYPTION' => 'ssl',

    /**
     * Configuration for: Email content data
     */
    'EMAIL_PASSWORD_RESET_URL' => 'login/verifypasswordreset',
    'EMAIL_PASSWORD_RESET_FROM_EMAIL' => 'no-reply@example.com',
    'EMAIL_PASSWORD_RESET_FROM_NAME' => 'My Project',
    'EMAIL_PASSWORD_RESET_SUBJECT' => 'Password reset for PROJECT XY',
    'EMAIL_PASSWORD_RESET_CONTENT' => 'Please click on this link to reset your password: ',
    'EMAIL_VERIFICATION_URL' => 'register/verify',
    'EMAIL_VERIFICATION_FROM_EMAIL' => 'no-reply@example.com',
    'EMAIL_VERIFICATION_FROM_NAME' => 'My Project',
    'EMAIL_VERIFICATION_SUBJECT' => 'Account activation for PROJECT XY',
    'EMAIL_VERIFICATION_CONTENT' => 'Please click on this link to activate your account: ',
);

?>
