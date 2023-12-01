<?php
/**
 * Ergopack plugin.
 *
 * @license   GPL-2.0+
 *
 * Plugin Name: Ergopack Plugin
 * Description: Plugin for Ergopack
 * Version:     0.1.1
 * Author:      Effecticore
 * Author URI:  https://effecticore.de
 * License:     GPL v2 http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: ergo
 */

/** Defines */
define( 'ERGO_VERSION', '0.1' );
define( 'ERGO_FILE', __FILE__);
define( 'ERGO_DIR', rtrim(plugin_dir_path(ERGO_FILE), '/'));
define( 'ERGO_DATA_DIR', ERGO_DIR . '/data' );
define( 'ERGO_FONTS_DIR', ERGO_DIR . '/fonts' );
define( 'ERGO_IMG_DIR', ERGO_DIR . '/img' );
define( 'ERGO_INC_DIR', ERGO_DIR . '/inc' );
define( 'ERGO_VENDOR_DIR', ERGO_DIR . '/vendor' );
define( 'ERGO_TEMPLATE_DIR', ERGO_DIR . '/templates' );
define( 'ERGO_URI', rtrim(plugin_dir_url(__FILE__), '/'));
define( 'ERGO_BUILD_URI', ERGO_URI . '/build' );
define( 'ERGO_FONTS_URI', ERGO_URI . '/fonts' );

/** */
define( 'ERGO_SEND_PDF', true );


/**
 * "Trigger" status for sending PDF order
 *
 * Available statuses:
 * - pending    => Pending payment
 * - processing => Processing
 * - on-hold    => On hold
 * - completed  => Completed
 * - cancelled  => Cancelled
 * - refunded   => Refunded
 * - failed     => Failed
 */
define( 'ERGO_ORDER_STATUS_SEND_PDF', 'on-hold' );

/** "Trigger" status for sending PDF quotation */
define( 'ERGO_QUOTATION_STATUS_SEND_PDF', 'quotation-offer' );

/** Sales Support Email (leave empty or comment to deactivate) */
define( 'ERGO_SALES_SUPPORT_EMAIL', 'vertriebs-innendienst@ergopack.de' );

/** Email Order Confirmation Title */
define( 'ERGO_EMAIL_ORDER_CONFIRMATION_TITLE', 'myergopack - Bestellung %s' );

/** Email Quotation Confirmation Title */
define( 'ERGO_EMAIL_QUOTATION_CONFIRMATION_TITLE', __('Ihr persönliches Angebot für Ihr ErgoPack Umreifungssystem - %s','ergo') );

/** */
define( 'ERGO_ORDER_EMAIL_FROM', 'kontakt@myergopack.com' );

/** */
define( 'ERGO_ORDER_EMAIL_FROMNAME', 'ErgoPack' );

/**
 * Autoload libraries
 */
require_once ERGO_VENDOR_DIR . '/autoload.php';


/**
 * Run plugin
 */
$plugin = new \Ergopack\Plugin();
$plugin->run();
