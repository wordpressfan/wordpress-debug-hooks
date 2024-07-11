<?php

defined( 'ABSPATH' ) || exit;

$debug_hooks_plugin_name = 'Debug Hooks';

$debug_hooks_plugin_launcher_path = dirname( __DIR__ ) . '/';

return [
	'plugin_name'          => $debug_hooks_plugin_name,
	'plugin_slug'          => sanitize_key( $debug_hooks_plugin_name ),
	'plugin_version'       => '0.1.1',
	'plugin_launcher_file' => $debug_hooks_plugin_launcher_path . '/debug-hooks.php',
	'plugin_launcher_path' => $debug_hooks_plugin_launcher_path,
	'plugin_inc_path'      => realpath( $debug_hooks_plugin_launcher_path . 'inc/' ) . '/',
	'prefix'               => 'debug_hooks_',
	'translation_key'      => 'debughooks',
	'is_mu_plugin'         => false,
];
