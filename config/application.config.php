<?php
$appenv = strtolower(getenv('APP_ENV'));

$config = [
    'modules'                 => [
        'Application',
        'DoctrineModule',
        'DoctrineORMModule',
    ],
    'module_listener_options' => [
        'module_paths'             => [
            './module',
            './vendor',
        ],
        'config_glob_paths'        => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'config_cache_key'         => 'application.config.cache',
        'config_cache_enabled'     => false,
        'cache_dir'                => 'data/cache/',
        'module_map_cache_key'     => 'application.module.cache',
        'module_map_cache_enabled' => false,
    ],
];

return $config;
