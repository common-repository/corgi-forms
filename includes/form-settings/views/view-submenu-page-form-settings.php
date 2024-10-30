<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Set active tab
$active_tab = ( ! empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general' );

?>

<div class="wrap crfo-wrap">

	<!-- Page Heading -->
	<h1>
		<?php echo __( 'Form Settings', 'corgi-forms' ); ?>
	</h1>

	<div id="crfo-form-settings-wrapper">

		<form id="crfo-form-settings" method="POST" action="">

			<!-- Navigation Tabs -->
			<div class="crfo-settings-nav-tab-wrapper">

				<div class="crfo-settings-nav-tab-logo">
					<img src="<?php echo CRFO_PLUGIN_DIR_URL . 'assets/img/corgi.png'; ?>" />

					<div id="crfo-woof-woof">* woof woof *</div>
				</div>

				<?php

					$tabs = $this->tabs;

					// Echo the nav tabs
					foreach( $tabs as $tab_slug => $tab_name ) {

						// Echo the nav tab
						echo '<a href="#" data-tab="' . esc_attr( $tab_slug ) . '" class="crfo-nav-tab crfo-settings-nav-tab ' . ( $active_tab == $tab_slug ? 'crfo-active' : '' ) . '">';
							echo $tab_name;
						echo '</a>';

					}
				?>
			</div>

			<!-- Tabs -->
			<div class="crfo-settings-tabs-wrapper">

				<?php 

					// Echo the tabs with the fields
					foreach( $tabs as $tab_slug => $tab_name ) {

						echo '<div id="crfo-settings-tab-' . esc_attr( $tab_slug ) . '" data-tab="' . esc_attr( $tab_slug ) . '" class="crfo-tab crfo-settings-tab ' . ( $active_tab == $tab_slug ? 'crfo-active' : '' ) . '">';

						/**
						 * Action to add custom content to each tab
						 *
						 */
						do_action( 'crfo_form_settings_tab_' . $tab_slug );

						echo '</div>';

					}

				?>

				<!-- Footer -->
				<div class="crfo-settings-footer">

					<?php wp_nonce_field( 'crfo_edit_form', 'crfo_token' ); ?>

					<input type="hidden" value="<?php echo $active_tab; ?>" name="active_tab" />
					<input type="submit" value="<?php echo __( 'Save Changes', 'corgi-forms' ); ?>" class="button-primary" />

				</div>

			</div>

		</form>


		<div id="crfo-form-settings-sidebar">

			<!-- Begin MailChimp Signup Form -->
			<div id="crfo-mailchimp-subscribe-wrapper">
				<form action="//devpups.us10.list-manage.com/subscribe/post?u=391911b7881ba9ca27be83107&amp;id=e8045e44a7" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				    
				    <h3><?php echo __( 'Subscribe to get early access', 'corgi-forms' ); ?></h3>
				    <p><?php echo __( "to new plugins, discounts and brief updates about what's new with DevPups!", 'corgi-forms' ); ?></p>

					<div class="mc-field-group">
						<label for="mce-EMAIL"><?php echo __( 'Email Address', 'corgi-forms' ); ?></label>
						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
					</div>
					<div class="mc-field-group">
						<label for="mce-FNAME"><?php echo __( 'First Name', 'corgi-forms' ); ?></label>
						<input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
					</div>

					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

				    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_391911b7881ba9ca27be83107_e8045e44a7" tabindex="-1" value=""></div>
				    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
				    
				</form>
			</div>
			<!--End mc_embed_signup-->

		</div>

	</div>

</div>