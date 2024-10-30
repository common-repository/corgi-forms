<?php
/**
 * Plugin Name: Corgi Forms
 * Plugin URI: http://www.devpups.com/corgi-forms/
 * Description: Create a simple and beautiful contact form that you can place in your posts and pages.
 * Version: 1.0.0
 * Author: DevPups, Mihai Iova
 * Author URI: http://www.devpups.com/
 * License: GPL2
 *
 * == Copyright ==
 * Copyright 2017 DevPups (www.devpups.com)
 *	
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

Class Corgi_Forms {

	/**
	 * Constructor
	 *
	 */
	public function __construct() {

		// Defining constants
		define( 'CRFO_VERSION', 			   '1.0.0' );
		define( 'CRFO_BASENAME',  			   plugin_basename( __FILE__ ) );
		define( 'CRFO_PLUGIN_DIR', 			   plugin_dir_path( __FILE__ ) );
		define( 'CRFO_PLUGIN_DIR_URL', 		   plugin_dir_url( __FILE__ ) );

		$this->include_files();

		define( 'CRFO_VERSION_TYPE', 		   apply_filters( 'crfo_get_plugin_version_type', 'free' ) );
		define( 'CRFO_TRANSLATION_DIR', 	   CRFO_PLUGIN_DIR . '/translations' );
		define( 'CRFO_TRANSLATION_TEXTDOMAIN', 'corgi-forms' );

		// Check if just updated
		add_action( 'plugins_loaded', array( $this, 'update_check' ), 20 );

		// Update the database tables
		add_action( 'crfo_update_check', array( $this, 'update_database_tables' ) );

		// Add and remove main plugin page
		add_action( 'admin_menu', array( $this, 'add_main_menu_page' ), 10 );
        add_action( 'admin_menu', array( $this, 'remove_main_menu_page' ), 11 );

        // Admin scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

        // Front-end scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_end_scripts' ) );

        register_activation_hook( __FILE__, array( $this, 'set_cron_jobs' ) );
        register_deactivation_hook( __FILE__, array( $this, 'unset_cron_jobs' ) );

        /**
         * Plugin initialized
         *
         */
        do_action( 'crfo_initialized' );

	}


	/**
	 * Add the main menu page
	 *
	 */
	public function add_main_menu_page() {

		add_menu_page( 'Corgi Forms', 'Corgi Forms', 'manage_options', 'corgi-forms', '','dashicons-feedback' );

	}
    
    /**
	 * Remove the main menu page as we will rely only on submenu pages
	 *
	 */
	public function remove_main_menu_page() {

		remove_submenu_page( 'corgi-forms', 'corgi-forms' );

	}


	/**
	 * Checks to see if the current version of the plugin matches the version
	 * saved in the database
	 *
	 * @return void 
	 *
	 */
	public function update_check() {

		$db_version 	 = get_option( 'crfo_version', '' );
		$db_version_type = get_option( 'crfo_version_type', '' );

		$do_update 		 = false;

		// If current version number differs from saved version number
		if( $db_version != CRFO_VERSION ) {

			$do_update = true;

			// Update the version number in the db
			update_option( 'crfo_version', CRFO_VERSION );

			// Add first activation time
			if( get_option( 'crfo_first_activation', '' ) == '' )
				update_option( 'crfo_first_activation', time() );

		}

		// If current version type differs from saved version type
		if( $db_version_type != CRFO_VERSION_TYPE ) {

			$do_update = true;

			// Update the version number in the db
			update_option( 'crfo_version_type', CRFO_VERSION_TYPE );

		}

		if( $do_update ) {

			// Hook for fresh update
			do_action( 'crfo_update_check', $db_version, $db_version_type );

			// Trigger set cron jobs
			$this->set_cron_jobs();

		}

	}


	/**
	 * Creates and updates the database tables
	 *
	 * @return void
	 *
	 */
	public function update_database_tables() {}


	/**
	 * Sets an action hook for modules to add custom schedules
	 *
	 */
	public function set_cron_jobs() {

		do_action( 'crfo_set_cron_jobs' );

	}


	/**
	 * Sets an action hook for modules to remove custom schedules
	 *
	 */
	public function unset_cron_jobs() {

		do_action( 'crfo_unset_cron_jobs' );

	}


	/**
	 * Include files
	 *
	 * @return void
	 *
	 */
	public function include_files() {

		// Functions
		if( file_exists( CRFO_PLUGIN_DIR . 'includes/functions.php' ) )
			require CRFO_PLUGIN_DIR . 'includes/functions.php';

		// Utilities
		if( file_exists( CRFO_PLUGIN_DIR . 'includes/functions-utils.php' ) )
			require CRFO_PLUGIN_DIR . 'includes/functions-utils.php';

		// Form handler
		if( file_exists( CRFO_PLUGIN_DIR . 'includes/functions-form-handler.php' ) )
			require CRFO_PLUGIN_DIR . 'includes/functions-form-handler.php';

		// Form outputter
		if( file_exists( CRFO_PLUGIN_DIR . 'includes/functions-form-outputter.php' ) )
			require CRFO_PLUGIN_DIR . 'includes/functions-form-outputter.php';

		// Admin settings fields
		if( file_exists( CRFO_PLUGIN_DIR . 'includes/functions-admin-settings-fields.php' ) )
			require CRFO_PLUGIN_DIR . 'includes/functions-admin-settings-fields.php';

		if( file_exists( CRFO_PLUGIN_DIR . 'includes/abstracts/abstract-class-submenu-page.php' ) )
			require CRFO_PLUGIN_DIR . 'includes/abstracts/abstract-class-submenu-page.php';

		// Form settings
		if( file_exists( CRFO_PLUGIN_DIR . 'includes/form-settings/class-submenu-page-form-settings.php' ) )
			include CRFO_PLUGIN_DIR . 'includes/form-settings/class-submenu-page-form-settings.php';

		/**
		 * Helper hook to include files early
		 *
		 */
		do_action( 'crfo_include_files' );

	}


	/**
	 * Enqueue the scripts and style for the admin area
	 *
	 */
	public function enqueue_admin_scripts( $hook ) {

		// Plugin styles
		wp_register_style( 'crfo-style', CRFO_PLUGIN_DIR_URL . 'assets/css/style-admin-corgi-forms.css', array(), CRFO_VERSION );
		wp_enqueue_style( 'crfo-style' );

		// Plugin script
		wp_register_script( 'crfo-script', CRFO_PLUGIN_DIR_URL . 'assets/js/script-admin-corgi-forms.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-datepicker' ), CRFO_VERSION );
		wp_enqueue_script( 'crfo-script' );

		/**
		 * Hook to enqueue scripts immediately after the plugin's scripts
		 *
		 */
		do_action( 'crfo_enqueue_admin_scripts' );

	}


	/**
	 * Enqueue the scripts and style for the front-end part
	 *
	 */
	public function enqueue_front_end_scripts() {

		// Plugin styles
		wp_register_style( 'crfo-style', CRFO_PLUGIN_DIR_URL . 'assets/css/style-front-corgi-forms.css', array(), CRFO_VERSION );
		wp_enqueue_style( 'crfo-style' );

		// Plugin script
		wp_register_script( 'crfo-script', CRFO_PLUGIN_DIR_URL . 'assets/js/script-front-corgi-forms.js', array( 'jquery' ), CRFO_VERSION, true );
		wp_enqueue_script( 'crfo-script' );

		$ajax_url = "
			var crfo_ajax_url = '" . admin_url( 'admin-ajax.php' ) . "';
		";
		
		wp_add_inline_script( 'crfo-script', $ajax_url, 'before' );

		/**
		 * Hook to enqueue scripts immediately after the plugin's scripts
		 *
		 */
		do_action( 'crfo_enqueue_front_end_scripts' );

	}

}

// Let's get the party started
new Corgi_Forms();