<?php
namespace Ergopack\Component\Pdf;

use Ergopack\Component\Pdf\Document\Order;

/**
 * Class Viewer
 *
 * @package Ergopack\Component\Pdf
 * @author Effecticore
 * @since 0.1
 */

class Viewer
{
    /**
     * Run
     */
    public function run()
    {
        // Actions
        add_action( 'template_redirect', [&$this, 'get_file']);
    }

    /**
     * Display
     * @return string
     */
    public function get_file( )
    {
        if( isset($_GET['getpdf']) && isset($_GET['order_id']) && get_current_user_id() ) {
            $order_id  = filter_input(INPUT_GET, 'order_id');

            $order = wc_get_order( $order_id );

            if( $order ) {
                $filename = ergo_pdf_filename($order_id);
                $pdf_base = ergo_pdf_folder($filename);

                $pdf = new Order();
                $pdf->set_filename($filename);
                $pdf->set_order($order);
                $pdf->output(true === $pdf_base['file_exists'] ? 'I' : 'FI');
            }

            wp_die();
        }
    }
}
