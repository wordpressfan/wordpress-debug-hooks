<?php
namespace DebugHooks\Tests\Integration;

define( 'DEBUG_HOOKS_PLUGIN_ROOT', dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR );
define( 'DEBUG_HOOKS_TESTS_FIXTURES_DIR', dirname( __DIR__ ) . '/Fixtures' );
define( 'DEBUG_HOOKS_TESTS_DIR', __DIR__ );
define( 'DEBUG_HOOKS_IS_TESTING', true );

// Manually load the plugin being tested.
tests_add_filter(
    'muplugins_loaded',
    function() {
        // Load the plugin.
        require DEBUG_HOOKS_PLUGIN_ROOT . '/debug-hooks.php';
    }
);
