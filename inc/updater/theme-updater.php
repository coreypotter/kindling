<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://www.fuelyourphotos.com', // Site where EDD is hosted
		'item_name'      => 'Kindling', // Name of theme
		'theme_slug'     => 'kindling', // Theme slug
		'version'        => '0.3.0', // The current version of this theme
		'author'         => 'Corey Potter', // The author of this theme
		'download_id'    => '', // Optional, used for generating a license renewal link
		'renew_url'      => '', // Optional, allows for a custom license renewal link
		'beta'           => false, // Optional, set to true to opt into beta versions
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'kindling' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'kindling' ),
		'license-key'               => __( 'License Key', 'kindling' ),
		'license-action'            => __( 'License Action', 'kindling' ),
		'deactivate-license'        => __( 'Deactivate License', 'kindling' ),
		'activate-license'          => __( 'Activate License', 'kindling' ),
		'status-unknown'            => __( 'License status is unknown.', 'kindling' ),
		'renew'                     => __( 'Renew?', 'kindling' ),
		'unlimited'                 => __( 'unlimited', 'kindling' ),
		'license-key-is-active'     => __( 'License key is active.', 'kindling' ),
		'expires%s'                 => __( 'Expires %s.', 'kindling' ),
		'expires-never'             => __( 'Lifetime License.', 'kindling' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'kindling' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'kindling' ),
		'license-key-expired'       => __( 'License key has expired.', 'kindling' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'kindling' ),
		'license-is-inactive'       => __( 'License is inactive.', 'kindling' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'kindling' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'kindling' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'kindling' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'kindling' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'kindling' ),
	)

);
