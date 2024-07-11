<?php
/**
 * Plugin Name: Debug Hooks
 * Plugin URI:  https://wp-tip.com/
 * Description: Show All WordPress Hooks
 * Author:      Ahmed Saeed
 * Author URI:  https://github.com/engahmeds3ed
 * Version:     0.1.1
 * License:     GPLv2 or later (license.txt)
 */

use function DebugHooks\Dependencies\LaunchpadCore\boot;

defined( 'ABSPATH' ) || exit;


require __DIR__ . '/vendor-prefixed/wp-launchpad/core/inc/boot.php';

boot( __FILE__ );
