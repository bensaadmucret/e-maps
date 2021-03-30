<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://fr.linkedin.com/in/mohammed-bensaad-developpeur
 * @since      1.0.0
 *
 * @package    Emaps
 * @subpackage Emaps/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Emaps
 * @subpackage Emaps/includes
 * @author     Mohammed Bensaad <mohammed.bensaad@itga.fr>
 */
class Emaps_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'emaps',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
