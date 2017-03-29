<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Kindling Theme
 */

function fyp_register_required_plugins() {
	# Plugins to Nag for Install
	$plugins = array(
		# Elementor
		array(
			'name'              => 'Elementor Page Builder',
			'slug'              => 'elementor',
			'required'          => false,
			'force_activation'  => false,
		),
		# The SEO Framework
		array(
			'name'              => 'The SEO Framework',
			'slug'              => 'autodescription',
			'required'          => false,
			'force_activation'  => false,
		),
		# GitHub Updater
		array(
			'name'              => 'Kindling Updater',
			'slug'              => 'github-updater',
			'source'			=> str_replace('/', DIRECTORY_SEPARATOR, KINDLING_INC_DIR . 'updater/github-updater.zip'),
			'required'          => true,
			'force_activation'  => true,
			'force_deactivation'  => true,
		),
	);
	$config = array(
		'id'           => 'kindling',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'fyp_register_required_plugins' );