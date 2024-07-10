<?php
/**
 * Plugin Name: Debug Hooks
 * Plugin URI:  https://wp-tip.com/
 * Description: Show All WordPress Hooks
 * Author:      Ahmed Saeed
 * Author URI:  https://github.com/engahmeds3ed
 * Version:     0.1
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class WPDH_Main {

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function add_hooks() {
		add_action( 'admin_menu', function () {
			add_management_page( 'WP Hooks', 'WP Hooks', 'manage_options', 'wordpress-hooks', [ $this, 'show_tools_page' ] );
		} );
	}

	public function show_tools_page() {
		global $wp_filter;

		echo '<table border="1" width="100%" cellpadding="5">';
		echo '<tr><th>Hook</th><th width="100">Type</th><th>Name</th><th>Location</th><th>Parameters</th></tr>';

		foreach ( $wp_filter as $filter_name => $item ) {

			foreach ( $item->callbacks as $callback_item ) {
				foreach ( $callback_item as $callback ) {
					if ( is_array( $callback['function'] ) ) {
						//class
						$this->handle_class_type( $filter_name, $callback['function'] );
					} else if ( is_string( $callback['function'] ) ) {
						//function
						$this->handle_function_type( $filter_name, $callback['function'] );
					} else {
						echo "<tr><th colspan='5'>Type is: " . gettype( $callback['function'] ) . '</th></tr>';
					}

				}
				echo '<tr><th colspan="5">&nbsp;</th></tr>';
			}

		}

		echo "</table>";
	}

	private function handle_class_type( $filter_name, $callback_function ) {
		echo '<tr><td>' . $filter_name . '</td><td>Class</td>';
		$class_name = is_string( $callback_function[0] ) ? $callback_function[0] : get_class( $callback_function[0] );
		echo '<td>' . $class_name . '::' . $callback_function[1] . '</td>';

		try {
			$class = new \ReflectionClass( $class_name );
			$class_file = $class->getFileName();

			echo '<td>Class: ' . $class_file . '</td>';

			$method_parameters = $class->getMethod( $callback_function[1] )->getParameters();
			if ( is_array( $method_parameters ) && $method_parameters ) {
				echo '<td>';
				foreach ( $method_parameters as $method_parameter ) {
					echo $method_parameter->getName() . '<br>';
				}
				echo '</td>';
			}else{
				echo '<td></td>';
			}
		} catch ( \Exception $e ) {
			echo "<td colspan='2'>Error: " . $e->getMessage() . "</td>";
		}

		echo '</tr>';
	}

	private function handle_function_type( $filter_name, $callback_function ) {
		echo '<tr><td>' . $filter_name . '</td><td>Function</td>';
		echo '<td>' . $callback_function . '</td>';

		try {
			$func = new \ReflectionFunction( $callback_function );
			echo '<td>' . $func->getFileName()  . '</td>';

			$func_parameters = $func->getParameters();
			if ( is_array( $func_parameters ) && $func_parameters ) {
				echo '<td>';
				foreach ( $func_parameters as $parameter ) {
					echo $parameter->getName() . '<br>';
				}
				echo '</td>';
			}else{
				echo '<td></td>';
			}
		} catch (\Exception $e) {
			echo "<td colspan='2'>Error: " . $e->getMessage() . "</td>";
		}
		echo '</tr>';
	}

}

add_action( 'plugins_loaded', [ WPDH_Main::get_instance(), 'add_hooks' ] );
