<?php
namespace Ergopack;

use Ergopack\Component\Pdf\Viewer;
use Ergopack\Component\Woocommerce\Customer;
use Ergopack\Component\Woocommerce\Checkout;
use Ergopack\Component\Woocommerce\Order;
use Ergopack\Component\Importer;
use Ergopack\Component\Metabox;
use Ergopack\Component\Woocommerce;
use Ergopack\Component\Hubspot\Hubspot;

/**
 * Class Plugin
 *
 * @author Effecticore
 * @since 0.1
 */

class Plugin
{
    /**
     * Run
     */
    public function run()
    {
        // Actions
        add_action('wp_enqueue_scripts', [&$this, 'enqueue_styles']);
        add_action('admin_footer-user-new.php', [&$this, 'uncheck_send_user_notification']);
        add_action('phpmailer_init', [&$this, 'mailer_smtp']);

        // Components
        $this->run_components();
    }

    /**
     * Mailer 
     */
    public function mailer_smtp( $phpmailer )
    {
        if( defined('SMTP_HOST') ) {
            $phpmailer->isSMTP();
            $phpmailer->Host       = SMTP_HOST;
            $phpmailer->SMTPAuth   = SMTP_AUTH;
            $phpmailer->Port       = SMTP_PORT;
            if( defined('SMTP_SECURE') ) {
                $phpmailer->SMTPSecure = SMTP_SECURE;
                $phpmailer->Username   = SMTP_USER;
                $phpmailer->Password   = SMTP_PASS;
            }
            $phpmailer->From       = SMTP_FROM;
            $phpmailer->FromName   = SMTP_NAME;
        }
    }

    public function uncheck_send_user_notification() {
        echo '<script type="text/javascript">document.getElementById("send_user_notification").checked = false;</script>';
    }

    /**
     * Run components
     */
    public function run_components()
    {
        //Importer
        $importer = new Importer();
        $importer->run();

        // Metabox
        $metabox = new Metabox();
        $metabox->run();

        // Woocommerce
        $woocommerce = new Woocommerce();
        $woocommerce->run();

        // Woocommerce/Customer
        $customer = new Customer();
        $customer->run();

        // Woocommerce/Checkout
        $checkout = new Checkout();
        $checkout->run();

        // Woocommerce/Order
        $order = new Order();
        $order->run();

        // PDF Viewer
        $pdf_viewer = new Viewer();
        $pdf_viewer->run();

        // Hubspot
	    $hubspot = new Hubspot();
	    $hubspot->run();

    }

    /**
     * Enqueue styles and scripts for plugin
     */
    public function enqueue_styles()
    {
        wp_enqueue_style( 'ergo-plugin-css', ERGO_BUILD_URI . '/style.css', null, ERGO_VERSION, 'all' );
        wp_enqueue_script('ergo-plugin-js', ERGO_BUILD_URI . '/index.js', null, ERGO_VERSION, true);

        wp_localize_script( 'ergo-plugin-js', 'epp', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce('ajax-nonce')
        ]);
    }
}
