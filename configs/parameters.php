<?php

defined( 'ABSPATH' ) || exit;

$plugin_name = 'Debug Hooks';

$plugin_launcher_path = dirname(__DIR__) . '/';

return [
    'plugin_name' => $plugin_name,
    'plugin_slug' => sanitize_key( $plugin_name ),
    'plugin_version' => '0.1.1',
    'plugin_launcher_file' => $plugin_launcher_path . '/' . 'debug-hooks' . '.php',
    'plugin_launcher_path' => $plugin_launcher_path,
    'plugin_inc_path' => realpath( $plugin_launcher_path . 'inc/' ) . '/',
    'prefix' => 'debug_hooks_',
    'translation_key' => 'debughooks',
    'is_mu_plugin' => false,
];
