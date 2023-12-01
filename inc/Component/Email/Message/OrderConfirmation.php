<?php
namespace Ergopack\Component\Email\Message;

use Ergopack\Component\Email\Email;
use Ergopack\Component\Pdf;

/**
 * Class OrderConfirmation
 *
 * @author Effecticore
 * @since 0.1
 */

class OrderConfirmation extends AbstractMessage implements MessageInterface
{
    /** @var $order_id */
    protected $order_id;

    /** @var $order */
    protected $order;

    /**
     * Set order ID
     *
     * @param $order_id
     */
    public function set_order_id( $order_id )
    {
        $this->order_id = $order_id;
    }

    public function is_quotation()
    {
        return $this->order instanceof \WC_Order && $this->order->get_status() === 'quotation-offer';
    }

    /**
     * Build message body
     *
     * @param \WC_Order $order
     * @return string
     */
    public function build_message_body()
    {
        if( !$this->current_user_data ) {
            $this->current_user_data = $this->get_current_user_data();
        }

        extract($this->current_user_data);

        if( !$this->customer_data ) {
            $this->customer_data = $this->get_customer_data();
        }
        extract($this->customer_data);

        $body = $this->render_html_head();

        ob_start();
        if( $this->is_quotation() ) {
            include ERGO_TEMPLATE_DIR . '/email/quotation-confirmation-pdf.html.php';
        } else {
            include ERGO_TEMPLATE_DIR . '/email/order-confirmation-pdf.html.php';
        }
        $body .= ob_get_contents();
        ob_end_clean();

        $body .= $this->render_html_footer();

        return $body;
    }

    /**
     * Send emails
     */
    public function send()
    {
        $this->order = wc_get_order($this->order_id);

        //error_log('Presending #' .$this->order_id );

        if( $this->order ) {
            $sales_person_email = $this->current_user->user_email;

            $confirmation_quotation_title = __('Ihr persönliches Angebot für Ihr ErgoPack Umreifungssystem - %s','ergo');
            $confirmation_order_title = __('Ihr persönliches Angebot für Ihr ErgoPack Umreifungssystem - %s','ergo');

            $title = sprintf($this->is_quotation() ? $confirmation_quotation_title : $confirmation_order_title, $this->order->get_id());

            // Create email body
            $body = $this->build_message_body();

            // Get PDF filename
            $filename = ergo_pdf_filename($this->order_id);

            // Generate PDF for email
            $pdf = new Pdf\Document\Order();
            $pdf->set_filename($filename);
            $pdf->set_order($this->order);

            // Generate same PDF for saving
            $pdf_save = new Pdf\Document\Order();
            $pdf_save->set_filename($filename);
            $pdf_save->set_order($this->order);

            //error_log('Generating PDF #' .$this->order_id );

            // Send emails
            if (!$pdf->is_empty()) {
                //error_log('Sending #' .$this->order_id );

                // 1. Send to Sale Person
                $email = new Email($this->separator);
                $email->set_attachement($pdf->output('E'), $pdf->get_filename());
                $email->send($sales_person_email, $title, $body);

                // 2. Send to Second Contact Person
                $customer_id = $this->order->get_customer_id();
                $second_person_email = get_the_author_meta('_epp_second_contact_email', $customer_id);
                if( !empty($second_person_email) ) {
                    $email->send($second_person_email, $title, $body);
                }

                // 3. Send offer to Customer
                if( $this->is_quotation() ) {
                    $email->send($this->order->get_billing_email(), $title, $body);
                // 4. Send also to support
                } elseif (defined('ERGO_SALES_SUPPORT_EMAIL') && !empty(ERGO_SALES_SUPPORT_EMAIL)) {
                    $email->send(ERGO_SALES_SUPPORT_EMAIL, $title, $body);
                }

                // Save file
                $pdf_save->output('F');
            }
        }
    }
}