<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Extender class for the Form Settings submenu page
 *
 */
Class CRFO_Submenu_Page_Form_Settings extends CRFO_Submenu_Page {

	/**
	 * The array of the form's settings
	 *
	 */
	protected $form_settings;

	/**
	 * The current $_POST
	 *
	 */
	protected $post_fields;

	/**
	 * Tabs for different settings sections
	 *
	 */
	protected $tabs;


	/**
	 * Constructor
	 *
	 */
	public function __construct( $parent_slug = '', $page_title = '', $menu_title = '', $capability = '', $menu_slug = '' ) {
		
		parent::__construct( $parent_slug, $page_title, $menu_title, $capability, $menu_slug );

		add_action( 'admin_init', array( $this, 'register_settings' ) );

		/**
		 * Filter to dynamically add custom tabs in the settings page
		 *
		 * @param array
		 *
		 */
		$this->tabs = apply_filters( 'crfo_submenu_page_settings_tabs', array(
			'general' 	   => __( 'General', 'corgi-forms' ),
			'fields'  	   => __( 'Fields', 'corgi-forms' ),
			'confirmation' => __( 'Confirmation', 'corgi-forms' ),
			'notification' => __( 'Notification', 'corgi-forms' )
		));

		// Register each tab views
		foreach( $this->tabs as $tab_slug => $tab_name ) {

			add_action( 'crfo_form_settings_tab_' .$tab_slug , array( $this, 'output_form_settings_tab_' . $tab_slug ) );

		}

		// Load post fields
		$this->post_fields = stripslashes_deep( $_POST );

		// Load form settings
		$this->form_settings = get_option( 'crfo_form_settings', array() );

	}


	/**
     * Returns a message by the provided code.
     *
     * @param int $code
     *
     * @return string
     *
     */
	protected function get_message_by_code( $code = 0 ) {

		$messages = array(
			1 => __( 'Form Settings saved successfully.', 'corgi-forms' )
		);

		return ( ! empty( $messages[$code] ) ? $messages[$code] : '' );

	}


	/**
	 * Registers the settings option
	 *
	 */
	public function register_settings() {

		register_setting( 'crfo_form_settings', 'crfo_form_settings', array( $this, 'settings_sanitize' ) );

	}


	/**
	 * Sanitizes the settings before saving them to the db
	 *
	 */
	public function settings_sanitize( $settings ) {

		return $settings;

	}


	/**
	 * Request listener
	 *
	 */
	public function request_listener() {

		if( empty( $_GET['page'] ) || $_GET['page'] != $this->menu_slug )
			return;

		if( empty( $_POST ) )
			return;

		// Set active tab
		$active_tab  = ( ! empty( $_POST['active_tab'] ) ? sanitize_text_field( $_POST['active_tab'] ) : '' );

		$post_fields = stripslashes_deep( $_POST );
		$post_fields = crfo_sanitize_array( $post_fields );

		update_option( 'crfo_form_settings', $post_fields['form_settings'] );

		wp_redirect( add_query_arg( array( 'tab' => $active_tab, 'message' => 1, 'updated' => 1 ), admin_url( $this->admin_url ) ) );
		exit();

	}


	/**
	 * Handles the output for different cases
	 *
	 */
	public function output() {

		include 'views/view-submenu-page-form-settings.php';

	}


	/**
	 * Output the General tab
	 *
	 */
	public function output_form_settings_tab_general() {

		echo '<div class="crfo-settings-heading"><h3>' . __( 'Welcome to Corgi Forms', 'corgi-forms' ) . '</h3></div>';

		echo '<p>' . __( 'We have already set up the basic settings for your contact form so you can be up and running in no time. If you like it differently, please modify the settings to suit your needs.', 'corgi-forms' ) . '</p>';

		echo '<p>' . __( 'To use the contact form, please add the following shortcode to your posts or pages:', 'corgi-forms' ) . '<input id="crfo" value="[corgi_form]" /></p>';

	}


	/**
	 * Output the Fields tab
	 *
	 */
	public function output_form_settings_tab_fields() {

		// Heading
		crfo_output_settings_field( array(
			'type'    => 'heading',
			'default' => '<h3>' . __( 'Form Fields', 'corgi-forms' ) . '</h3>'
		));


		$form_fields = array(
			array(
				'display_name' => __( 'First Name', 'corgi-forms' ),
				'name'         => 'first_name',
				'type'         => 'first_name',
				'label'        => __( 'First Name', 'corgi-forms' ),
				'description'  => '',
				'required' 	   => false,
				'display'      => true,
			),
			array(
				'display_name' => __( 'Last Name', 'corgi-forms' ),
				'name'         => 'last_name',
				'type'         => 'last_name',
				'label'        => __( 'Last Name', 'corgi-forms' ),
				'description'  => '',
				'required'     => false,
				'display'      => true,
			),
			array(
				'display_name' => __( 'Email Address', 'corgi-forms' ),
				'name'         => 'email_address',
				'type'         => 'email_address',
				'label'        => __( 'Email Address', 'corgi-forms' ),
				'description'  => '',
				'required'     => true,
				'display'      => true,
			),
			array(
				'display_name' => __( 'Subject', 'corgi-forms' ),
				'name'         => 'subject',
				'type'         => 'text',
				'label'        => __( 'Subject', 'corgi-forms' ),
				'description'  => '',
				'required'     => false,
				'display'      => true,
			),
			array(
				'display_name' => __( 'Message', 'corgi-forms' ),
				'name'         => 'message',
				'type'         => 'textarea',
				'label'        => __( 'Message', 'corgi-forms' ),
				'description'  => '',
				'required'     => true,
				'display'      => true,
			),
			array(
				'display_name' => __( 'Submit Button', 'corgi-forms' ),
				'name'         => 'submit',
				'type'         => 'button',
				'button_text'         => __( 'Send Message', 'corgi-forms' ),
				'button_loading_text' => __( 'Sending...' )
			)
		);

		$current_field = 1;

		echo '<div class="crfo-form-fields-settings-wrapper">';

		foreach( $form_fields as $form_field ) {

			echo '<div style="top: -' . $current_field . 'px;" class="crfo-form-field-settings-wrapper ' . ( $current_field == count( $form_fields ) ? 'crfo-last' : '' ) . ' ' . ( $current_field == 1 ? 'crfo-first' : '' ) . '">';

				echo '<div class="crfo-form-field-settings-name">';
				
					echo '<strong>' . $form_field['display_name'] . '</strong>';

					echo '<span class="dashicons dashicons-arrow-up-alt2"></span>';

				echo '</div>';

				echo '<div class="crfo-form-field-settings-inner">';

					$fields = array(
						array(
							'name' => 'form_settings[fields][' . $form_field['name'] . '][name]',
							'type'  => 'hidden',
							'value' => $form_field['name']
						),
						array(
							'name' => 'form_settings[fields][' . $form_field['name'] . '][type]',
							'type'  => 'hidden',
							'value' => $form_field['type']
						)
					);

					// Push display option
					if( isset( $form_field['display'] ) ) {

						$field_value = ( ! empty( $this->form_settings['fields'][$form_field['name']]['display'] ) ? $this->form_settings['fields'][$form_field['name']]['display'] : '' );
						$field_value = ( ! empty( $this->post_fields['fields'][$form_field['name']]['display'] )   ? $this->post_fields['fields'][$form_field['name']]['display'] : $field_value );

						$fields[] = array(
							'name'    => 'form_settings[fields][' . $form_field['name'] . '][display]',
							'type'    => 'switch',
							'label'   => __( 'Display in Form', 'corgi-forms' ),
							'default' => ( $form_field['display'] ? '1' : '' ),
							'value'   => $field_value
						);
					}

					// Push label option
					if( isset( $form_field['label'] ) ) {

						$field_value = ( ! empty( $this->form_settings['fields'][$form_field['name']]['label'] ) ? $this->form_settings['fields'][$form_field['name']]['label'] : '' );
						$field_value = ( ! empty( $this->post_fields['fields'][$form_field['name']]['label'] )   ? $this->post_fields['fields'][$form_field['name']]['label'] : $field_value );

						$fields[] = array(
							'name'    => 'form_settings[fields][' . $form_field['name'] . '][label]',
							'type'    => 'text',
							'label'   => __( 'Field Label', 'corgi-forms' ),
							'default' => $form_field['label'],
							'value'   => $field_value
						);
					}

					// Push description option
					if( isset( $form_field['description'] ) ) {

						$field_value = ( ! empty( $this->form_settings['fields'][$form_field['name']]['description'] ) ? $this->form_settings['fields'][$form_field['name']]['description'] : '' );
						$field_value = ( ! empty( $this->post_fields['fields'][$form_field['name']]['description'] )   ? $this->post_fields['fields'][$form_field['name']]['description'] : $field_value );

						$fields[] = array(
							'name'    => 'form_settings[fields][' . $form_field['name'] . '][description]',
							'type'    => 'textarea',
							'label'   => __( 'Field Description', 'corgi-forms' ),
							'default' => $form_field['description'],
							'value'   => $field_value
						);
					}

					// Push required option
					if( isset( $form_field['required'] ) ) {

						$field_value = ( ! empty( $this->form_settings['fields'][$form_field['name']]['required'] ) ? $this->form_settings['fields'][$form_field['name']]['required'] : '' );
						$field_value = ( ! empty( $this->post_fields['fields'][$form_field['name']]['required'] )   ? $this->post_fields['fields'][$form_field['name']]['required'] : $field_value );

						$fields[] = array(
							'name'    => 'form_settings[fields][' . $form_field['name'] . '][required]',
							'type'    => 'switch',
							'label'   => __( 'Required', 'corgi-forms' ),
							'default' => ( $form_field['required'] ? '1' : '' ),
							'value'   => $field_value
						);
					}

					// Push button text option
					if( isset( $form_field['button_text'] ) ) {

						$field_value = ( ! empty( $this->form_settings['fields'][$form_field['name']]['button_text'] ) ? $this->form_settings['fields'][$form_field['name']]['button_text'] : '' );
						$field_value = ( ! empty( $this->post_fields['fields'][$form_field['name']]['button_text'] )   ? $this->post_fields['fields'][$form_field['name']]['button_text'] : $field_value );

						$fields[] = array(
							'name'    => 'form_settings[fields][' . $form_field['name'] . '][button_text]',
							'type'    => 'text',
							'label'   => __( 'Button Text', 'corgi-forms' ),
							'default' => ( $form_field['button_text'] ? $form_field['button_text'] : '' ),
							'value'   => $field_value
						);
					}

					// Push button loading text option
					if( isset( $form_field['button_loading_text'] ) ) {

						$field_value = ( ! empty( $this->form_settings['fields'][$form_field['name']]['button_loading_text'] ) ? $this->form_settings['fields'][$form_field['name']]['button_loading_text'] : '' );
						$field_value = ( ! empty( $this->post_fields['fields'][$form_field['name']]['button_loading_text'] )   ? $this->post_fields['fields'][$form_field['name']]['button_loading_text'] : $field_value );

						$fields[] = array(
							'name'    => 'form_settings[fields][' . $form_field['name'] . '][button_loading_text]',
							'type'    => 'text',
							'label'   => __( 'Button Loading Text', 'corgi-forms' ),
							'default' => ( $form_field['button_loading_text'] ? $form_field['button_loading_text'] : '' ),
							'value'   => $field_value
						);
					}

					foreach( $fields as $field ) {

						crfo_output_settings_field( $field );

					}

				echo '</div>';

			echo '</div>';

			$current_field++;

		}

		echo '</div><br />';

	}


	/**
	 * Output the Confirmation tab
	 *
	 */
	public function output_form_settings_tab_confirmation() {
		
		// Get wp pages
		$pages    = array( 0 => __( 'Please select...', 'corgi-forms' ) );
		$wp_pages = get_posts( array( 'post_type' => 'page', 'numberposts' => -1 ) );

		foreach( $wp_pages as $wp_page ) {
			$pages[$wp_page->ID] = $wp_page->post_title;
		}

		// Fields
		$fields = array(
			'confirmation_heading' => array(
				'type'    => 'heading',
				'default' => '<h3>' . __( 'Form Submit Confirmation', 'corgi-forms' ) . '</h3>'
			),
			'confirmation_type' => array(
				'name'    => 'form_settings[confirmation][type]',
				'type'    => 'select',
				'label'   => __( 'Confirmation Type', 'corgi-forms' ),
				'desc'    => __( 'Select what will happen after the user successfully submits the form.', 'corgi-forms' ),
				'options' => array(
					'message' 		=> __( 'Display Custom Message', 'corgi-forms' ),
					'redirect_page' => __( 'Redirect to Page', 'corgi-forms' ),
					'redirect_url'  => __( 'Redirect to URL', 'corgi-forms' )
				),
				'input_class' => 'widefat',
				'value'   => ( ! empty( $this->post_fields['confirmation']['type'] ) ? $this->post_fields['confirmation']['type'] : ( ! empty( $this->form_settings['confirmation']['type'] ) ? $this->form_settings['confirmation']['type'] : '' ) )
			),
			'confirmation_message' => array(
				'name'    => 'form_settings[confirmation][message]',
				'type'    => 'editor',
				'label'   => __( 'Custom Message', 'corgi-forms' ),
				'default' => __( 'Thank you for contacting us. We will get back to you shortly', 'corgi-forms' ),
				'editor_settings' => array( 'media_buttons' => false, 'textarea_rows' => 7, 'editor_height' => 150, 'tinymce' => array( 'toolbar1' => 'formatselect,bold,italic,underline,bullist,numlist | alignleft,aligncenter,alignright | link,unlink' ) ),
				'conditional' 		=> 'form_settings[confirmation][type]',
				'conditional_value' => 'message',
				'value'   => ( ! empty( $this->post_fields['confirmation']['message'] ) ? $this->post_fields['confirmation']['message'] : ( ! empty( $this->form_settings['confirmation']['message'] ) ? $this->form_settings['confirmation']['message'] : '' ) )
			),
			'confirmation_redirect_page' => array(
				'name'    => 'form_settings[confirmation][redirect_page]',
				'type'    => 'select',
				'label'   => __( 'Redirect to Page', 'corgi-forms' ),
				'options' => $pages,
				'conditional' 		=> 'form_settings[confirmation][type]',
				'conditional_value' => 'redirect_page',
				'input_class' => 'widefat',
				'value'   => ( ! empty( $this->post_fields['confirmation']['redirect_page'] ) ? $this->post_fields['confirmation']['redirect_page'] : ( ! empty( $this->form_settings['confirmation']['redirect_page'] ) ? $this->form_settings['confirmation']['redirect_page'] : '' ) )
			),
			'confirmation_redirect_url' => array(
				'name'    => 'form_settings[confirmation][redirect_url]',
				'type'    => 'text',
				'label'   => __( 'Redirect to URL', 'corgi-forms' ),
				'options' => $pages,
				'conditional' 		=> 'form_settings[confirmation][type]',
				'conditional_value' => 'redirect_url',
				'input_class' => 'widefat',
				'value'   => ( ! empty( $this->post_fields['confirmation']['redirect_url'] ) ? $this->post_fields['confirmation']['redirect_url'] : ( ! empty( $this->form_settings['confirmation']['redirect_url'] ) ? $this->form_settings['confirmation']['redirect_url'] : '' ) )
			)
		);

		foreach( $fields as $field ) {

			crfo_output_settings_field( $field );

		}

	}


	/**
	 * Output the Notification tab
	 *
	 */
	public function output_form_settings_tab_notification() {
		
		// Fields
		$fields = array(
			'notification_admin_heading' => array(
				'type'    => 'heading',
				'default' => '<h3>' . __( 'Admin Email Notification', 'corgi-forms' ) . '</h3>'
			),
			'notification_admin_send_to' => array(
				'name'    => 'form_settings[notification_admin][send_to]',
				'type'    => 'text',
				'label'   => __( 'Send To Emails', 'corgi-forms' ),
				'input_class' => 'widefat',
				'value'   => ( ! empty( $this->post_fields['notification_admin']['send_to'] ) ? $this->post_fields['notification_admin']['send_to'] : ( ! empty( $this->form_settings['notification_admin']['send_to'] ) ? $this->form_settings['notification_admin']['send_to'] : '' ) )
			),
			'notification_admin_from_name' => array(
				'name'    => 'form_settings[notification_admin][from_name]',
				'type'    => 'text',
				'label'   => __( 'From Name', 'corgi-forms' ),
				'input_class' => 'crfo-medium',
				'value'   => ( ! empty( $this->post_fields['notification_admin']['from_name'] ) ? $this->post_fields['notification_admin']['from_name'] : ( ! empty( $this->form_settings['notification_admin']['from_name'] ) ? $this->form_settings['notification_admin']['from_name'] : '' ) )
			),
			'notification_admin_from_email' => array(
				'name'    => 'form_settings[notification_admin][from_email]',
				'type'    => 'text',
				'label'   => __( 'From Email', 'corgi-forms' ),
				'input_class' => 'crfo-medium',
				'value'   => ( ! empty( $this->post_fields['notification_admin']['from_email'] ) ? $this->post_fields['notification_admin']['from_email'] : ( ! empty( $this->form_settings['notification_admin']['from_email'] ) ? $this->form_settings['notification_admin']['from_email'] : '' ) )
			),
			'notification_admin_subject' => array(
				'name'    => 'form_settings[notification_admin][subject]',
				'type'    => 'text',
				'label'   => __( 'Email Subject', 'corgi-forms' ),
				'value'   => ( ! empty( $this->post_fields['notification_admin']['subject'] ) ? $this->post_fields['notification_admin']['subject'] : ( ! empty( $this->form_settings['notification_admin']['subject'] ) ? $this->form_settings['notification_admin']['subject'] : '' ) )
			),
			'notification_admin_content' => array(
				'name'    => 'form_settings[notification_admin][content]',
				'type'    => 'editor',
				'label'   => __( 'Email Content', 'corgi-forms' ),
				'editor_settings' => array( 'media_buttons' => false, 'textarea_rows' => 7, 'editor_height' => 150, 'tinymce' => array( 'toolbar1' => 'formatselect,bold,italic,underline,bullist,numlist | alignleft,aligncenter,alignright | link,unlink' ) ),
				'value'   => ( ! empty( $this->post_fields['notification_admin']['content'] ) ? $this->post_fields['notification_admin']['content'] : ( ! empty( $this->form_settings['notification_admin']['content'] ) ? $this->form_settings['notification_admin']['content'] : '' ) )
			)
		);

		foreach( $fields as $field ) {

			crfo_output_settings_field( $field );

		}

	}

}

/**
 * Settings submenu page initializer
 *
 */
function crfo_add_submenu_page_form_settings() {

	new CRFO_Submenu_Page_Form_Settings( 'corgi-forms', __( 'Form Settings', 'corgi-forms' ), __( 'Form Settings', 'corgi-forms' ), 'manage_options', 'crfo-form-settings' );

}
add_action( 'init', 'crfo_add_submenu_page_form_settings', 100 );