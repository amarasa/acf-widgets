<?php

/**
 * Plugin Name: ACF Widgets by Kaleidico (originally by: Darren Spence)
 * Plugin URI: https://kaleidico.com
 * Description: A plugin to easily create widgets for use with ACF and add custom fields to any widget on your site.
 * Version: 1.12.2
 * Tested up to: 5.0.3
 * Author: Kaleidico
 * Author URI: http://kaleidico.com
 * Text Domain: acfw
 * License: GPL2+
 */

// Block direct requests
if (!defined('ABSPATH')) {
	die();
}

define('ACFW_VERSION', '1.12.2');
define('ACFW_STORE_URL', 'https://acfwidgets.com');
define('ACFW_ITEM_NAME', 'ACF Widgets');
define('ACFW_FILE', __FILE__);

add_action('after_setup_theme', 'acfw_globals');
function acfw_globals()
{
	if (apply_filters('acfw_lite', false))
		define('ACFW_LITE', true);
	if (apply_filters('acfw_include', false))
		define('ACFW_INCLUDE', true);
}

// Check to see if ACF is active
include_once('includes/acf-404.php');

$GLOBALS['acfw_default_widgets'] = array(
	'pages', 'calendar', 'archives', 'meta', 'search', 'text',
	'categories', 'recent-posts', 'recent-comments', 'rss', 'tag_cloud', 'nav_menu'
);

include_once('includes/helper-functions.php');

include_once('includes/admin-setup.php');

require_once('includes/ACFW_Widget.php');

require_once('includes/ACFW_Widget_Factory.php');

include_once('includes/widgets-setup.php');

include_once('includes/default-widgets.php');

// Removed code related to auto updater

register_activation_hook(__FILE__, 'acfw_activate');
function acfw_activate()
{
	$users = get_users('meta_key=acfw_dismiss_expired');
	foreach ($users as $user) {
		delete_user_meta($user->id, 'acfw_dismiss_expired');
	}
}

function acfw_add_widgets_menu()
{
	add_menu_page(
		'Widgets',           // Page title
		'Widgets',           // Menu title
		'edit_theme_options', // Capability: User needs this capability to view the link
		'widgets.php',       // Menu slug: Link to widgets.php
		'',                  // Function to output the content for this page
		'dashicons-screenoptions', // Icon URL: Use a dashicon for the menu
		60                   // Position in the menu order
	);
}

add_action('admin_menu', 'acfw_add_widgets_menu');

// End of File
