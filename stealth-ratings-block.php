<?php
/**
 * Plugin Name:       Stealth Ratings Block
 * Description:       Gather ratings from your site visitors, quietly.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Think Ahead Tech
 * Author URI:        https://www.thinkaheadtech.net
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       stealth-ratings-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/includes/Api.php';
require_once __DIR__ . '/includes/Block.php';
require_once __DIR__ . '/includes/Settings.php';
require_once __DIR__ . '/includes/Scripts.php';

add_action( 'plugins_loaded', [ 'StealthRatings\Block', 'init' ] );
add_action( 'plugins_loaded', [ 'StealthRatings\Settings', 'init' ] );
add_action( 'plugins_loaded', [ 'StealthRatings\Scripts', 'init' ] );
add_action( 'plugins_loaded', [ 'StealthRatings\Api', 'init' ] );
