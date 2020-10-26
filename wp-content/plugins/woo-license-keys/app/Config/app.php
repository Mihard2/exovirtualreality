<?php

/**
 * App configuration file.
 */
return [

    'namespace' => 'LicenseKeys',

    'type' => 'plugin',

    'paths' => [

        'base'          => __DIR__ . '/../',
        'controllers'   => __DIR__ . '/../Controllers/',
        'views'         => __DIR__ . '/../../assets/views/',
        'log'           => WP_CONTENT_DIR . '/wpmvc/log',

    ],

    'version' => '1.4.0',

    'author' => '10 Quality Studio <https://www.10quality.com/>',

    'localize' => [
        // Enables or disables localization
        'enabled'       => true,
        // Default path for language files
        'path'          => __DIR__ . '/../../assets/languages/',
        // Text domain
        'textdomain'    => 'woo-license-keys',
        // Unload loaded locale files before localization
        'unload'        => true,
        // Flag that inidcates if this is a Wordpress.org plugin/theme
        'is_public'     => true,
    ],

    'autoenqueue' => [

        // Enables or disables auto-enqueue of assets
        'enabled'       => false,
        // Assets to auto-enqueue
        'assets'        => [],

    ],

    'cache' => [

        // Enables or disables cache
        'enabled'       => true,
        // files, auto (files), apc, wincache, xcache, memcache, memcached
        'storage'       => 'auto',
        // Default path for files
        'path'          => WP_CONTENT_DIR . '/wpmvc/cache',
        // It will create a path by PATH/securityKey
        'securityKey'   => '',
        // FallBack Driver
        'fallback'      => [
                            'memcache'  =>  'files',
                            'apc'       =>  'sqlite',
                        ],
        // .htaccess protect
        'htaccess'      => true,
        // Default Memcache Server
        'server'        => [
                            [ '127.0.0.1', 11211, 1 ],
                        ],

    ],

    'reviewer' => [

        // Enables reviewer
        'enabled'       => true,
        // Name to display in notice
        'name'          => 'License Keys for WooCommerce',
        // Display interval in minutes
        'interval'      => 43200,

    ],

    'addons' => [
        'WPMVC\Addons\Reviewer\ReviewerAddon',
    ],

];