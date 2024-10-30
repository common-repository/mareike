<?php
/**
 * Plugin Name:  mareike
 * Description: A tool to help associations to manage travel or material costs for events or ongoing jobs.
 * Version: 1.3.0
 * Tags: mareike, administration, fincance, travelmanagement, association tool
 * Requires at least: 5.5
 * Requires PHP: 8.2
 * Author: Thomas Günther
 * Author URI: https://www.contelli.de
 * Text Domain: mareike
 *  License: GPLv3
 *  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package mareike
 *
 *  Copyright 2023 - 2024 by Thomas Günther (tidschi)
 *
 *  Licenced under the GNU GPL:
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'core/init.php';

add_shortcode( 'mareike-new-invoice', array( 'Mareike\App\Controllers\Invoices\NewInvoice', 'execute_from_public' ) );
add_action( 'init', array( 'Mareike\App\Controllers\Invoices\CreateInvoice', 'execute' ) );
add_action( 'admin_enqueue_scripts', 'mareike_admin_setup' );
add_action( 'admin_menu', 'mareike_add_menu' );
add_action( 'network_admin_menu', 'mareike_network_add_menu' );
add_action( 'wp_ajax_mareike_show_ajax', 'mareike_load_ajax_content' );
add_action( 'plugins_loaded', 'mareike_localization_setup' );
add_action( 'after_setup_theme', 'mareike_setup_roles' );
add_action( 'wp_initialize_site', 'mareike_new_blog_setup', 10, 2 );

add_filter( 'admin_enqueue_scripts', 'mareike_enqueue_custom_scripts', 10 );
