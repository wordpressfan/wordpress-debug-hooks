<?php

namespace DebugHooks\Admin\HookBrowser;

class Subscriber {

	/**
	 * Registers the WP Hooks admin page under Tools menu.
	 *
	 * @hook admin_menu
	 */
	public function register_admin_page() {
		add_management_page( 'WP Hooks', 'WP Hooks', 'manage_options', 'wordpress-hooks', [ $this, 'show_tools_page' ] );
	}


	/**
	 * Displays the WP Hooks admin page.
	 */
	public function show_tools_page() {
		global $wp_filter;

		echo '<table border="1" width="100%" cellpadding="5">';
		echo '<tr><th>Hook</th><th width="100">Type</th><th>Name</th><th>Location</th><th>Parameters</th></tr>';

		foreach ( $wp_filter as $filter_name => $item ) {

			foreach ( $item->callbacks as $callback_item ) {
				foreach ( $callback_item as $callback ) {
					if ( is_array( $callback['function'] ) ) {
						// class.
						$this->handle_class_type( $filter_name, $callback['function'] );
					} elseif ( is_string( $callback['function'] ) ) {
						// function.
						$this->handle_function_type( $filter_name, $callback['function'] );
					} else {
						echo "<tr><th colspan='5'>Type is: " . esc_html( gettype( $callback['function'] ) ) . '</th></tr>';
					}
				}
				echo '<tr><th colspan="5">&nbsp;</th></tr>';
			}
		}

		echo '</table>';
	}

	/**
	 * Displays class object in the callbacks in WP Hooks page.
	 *
	 * @param string $filter_name Name of filter being processed.
	 * @param array  $callback_function Function callback entry from the callback array of the filter being processed.
	 */
	private function handle_class_type( $filter_name, $callback_function ) {
		echo '<tr><td>' . esc_html( $filter_name ) . '</td><td>Class</td>';
		$class_name = is_string( $callback_function[0] ) ? $callback_function[0] : get_class( $callback_function[0] );
		echo '<td>' . esc_html( $class_name ) . '::' . esc_html( $callback_function[1] ) . '</td>';

		try {
			$class      = new \ReflectionClass( $class_name );
			$class_file = $class->getFileName();

			echo '<td>Class: ' . esc_html( $class_file ) . '</td>';

			$method_parameters = $class->getMethod( $callback_function[1] )->getParameters();
			if ( is_array( $method_parameters ) && $method_parameters ) {
				echo '<td>';
				foreach ( $method_parameters as $method_parameter ) {
					echo esc_html( $method_parameter->getName() ) . '<br>';
				}
				echo '</td>';
			}else {
				echo '<td></td>';
			}
		} catch ( \Exception $e ) {
			echo "<td colspan='2'>Error: " . esc_html( $e->getMessage() ) . '</td>';
		}

		echo '</tr>';
	}

	/**
	 * Displays functions in the callbacks in WP Hooks page.
	 *
	 * @param string $filter_name Name of filter being processed.
	 * @param array  $callback_function Function callback entry from the callback array of the filter being processed.
	 */
	private function handle_function_type( $filter_name, $callback_function ) {
		echo '<tr><td>' . esc_html( $filter_name ) . '</td><td>Function</td>';
		echo '<td>' . esc_html( $callback_function ) . '</td>';

		try {
			$func = new \ReflectionFunction( $callback_function );
			echo '<td>' . esc_html( $func->getFileName() ) . '</td>';

			$func_parameters = $func->getParameters();
			if ( is_array( $func_parameters ) && $func_parameters ) {
				echo '<td>';
				foreach ( $func_parameters as $parameter ) {
					echo esc_html( $parameter->getName() ) . '<br>';
				}
				echo '</td>';
			}else {
				echo '<td></td>';
			}
		} catch ( \Exception $e ) {
			echo "<td colspan='2'>Error: " . esc_html( $e->getMessage() ) . '</td>';
		}
		echo '</tr>';
	}
}
