<?php
/**
	Plugin Name: WP Desk Omnibus
	Plugin URI: https://www.wpdesk.pl/sklep/omnibus-woocommerce/
	Description: WP Desk Omnibus
	Product: WP Desk Omnibus
	Version: 0.0.1
	Author: WP Desk
	Author URI: https://www.wpdesk.pl/
	Text Domain: wpdesk-omnibus
	Domain Path: /lang/
	Requires at least: 5.0
	Tested up to: 5.9.3
	WC requires at least: 6.0
	WC tested up to: 6.4
	Requires PHP: 7.2

	@package \WPDesk\Omnibus

	Copyright 2022 WP Desk Ltd.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$plugin_version = '0.0.1';
$plugin_name        = 'WP Desk Omnibus';
$plugin_class_name  = '\WPDesk\Omnibus\Plugin';
$plugin_text_domain = 'wpdesk-omnibus';
$product_id         = 'WP Desk Omnibus';
$plugin_file        = __FILE__;
$plugin_dir         = __DIR__;

$requirements = [
	'php'     => '7.2',
	'wp'      => '5.5',
	'plugins' => [
		[
			'name'      => 'woocommerce/woocommerce.php',
			'nice_name' => 'WooCommerce',
			'version'   => '6.0',
		],
	],
];

require __DIR__ . '/vendor_prefixed/wpdesk/wp-plugin-flow-common/src/plugin-init-php52.php';
