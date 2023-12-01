<?php
namespace Ergopack\Component\Email\Message;

/**
 * Class AbstractMessage
 *
 * @author Effecticore
 * @since 0.1
 */
class AbstractMessage
{
    /** @var string $eol */
    protected $eol = "\r\n";

    /** @var string $separator */
    protected $separator;

    /** @var string $recipient */
    protected $recipient = '';

    /** @var string $message */
    protected $message = '';

    /** @var \WC_Order $order */
    protected $order;

    /** @var $current_user */
    protected $current_user;

    /** @var array $current_user_data */
    protected $current_user_data = [];

    /** @var array $customer_data */
    protected $customer_data = [];

    /**
     * Email constructor.
     *
     * @param null $separator
     */
    public function __construct( $separator = null )
    {
        $this->separator    = md5(uniqid(time()));
        $this->current_user = wp_get_current_user();
    }

    /**
     * Set message
     *
     * @param string
     */
    public function set_message( $message )
    {
        $this->message = $message;
    }

    /**
     * Set recipient
     *
     * @param string
     */
    public function set_recipient( $recipient )
    {
        $this->recipient = $recipient;
    }

    public function get_current_user_data()
    {
        $first_name = $this->current_user->first_name;
        $last_name  = $this->current_user->last_name;
        $fullname   = !empty($first_name) ? sprintf('%s %s', $first_name, $last_name) : $this->current_user->nickname;
        $email      = $this->current_user->user_email;
        $title      = get_user_meta($this->current_user->ID, 'description', true);
        $phone      = get_user_meta($this->current_user->ID, 'billing_phone', true);

        return [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'fullname'   => $fullname,
            'email'      => $email,
            'title'      => $title,
            'phone'      => $phone
        ];
    }

    /**
     * @return array
     */
    public function get_customer_data()
    {
        $args = [
            'customer_firstname' => '',
            'customer_lastname' => '',
            'customer_fullname' => '',
            'customer_company' => '',
            'customer_address1' => '',
            'customer_address2' => '',
            'customer_fulladdress' => '',
            'customer_zip' => '',
            'customer_city' => '',
            'customer_email' => '',
            'customer_phone' => '',
            'customer_title' => '',
            'customer_salutation' => __('Sehr geehrter','ergo'),
            'customer_second_contact_title' => '',
            'customer_second_contact_salutation' => '',
            'customer_second_contact_firstname' => '',
            'customer_second_contact_lastname' => '',
            'customer_second_contact_email' => ''
        ];

        if( !$this->order ) return $args;

        $customer_id = $this->order->get_user_id();

        $billing_firstname = $this->order->get_billing_first_name();
        $billing_lastname  = $this->order->get_billing_last_name();
        $fullname          = !empty($billing_firstname) && !empty($billing_lastname) ? sprintf('%s %s<br>', $billing_firstname, $billing_lastname) : '';
        $company           = $this->order->get_billing_company();
        $email             = $this->order->get_billing_email();
        $phone             = $this->order->get_billing_phone();
        $title             = get_the_author_meta('epp_customer_title', $customer_id);

        $salutation        = get_the_author_meta('epp_customer_salutation', $customer_id);
        if( $salutation == 'Sehr geehrter Herr' ) {
            $new_salutation = __('Sehr geehrter Herr','ergo');
        } else if ( $salutation == 'Sehr geehrte Frau' ) {
            $new_salutation = __('Sehr geehrte Frau','ergo');
        }

        $new_salutation;

        $billing_address1  = $this->order->get_billing_address_1();
        $billing_address2  = $this->order->get_billing_address_2();
        $address           = $billing_address1 . (!empty($billing_address2) ? sprintf(' %s', $billing_address2) : '') . '<br>';
        $billing_zip       = $this->order->get_billing_postcode();
        $billing_city      = $this->order->get_billing_city();

        $args['customer_firstname']  = $billing_firstname;
        $args['customer_lastname']   = $billing_lastname;
        $args['customer_fullname']   = $fullname;
        $args['customer_company']    = $company;
        $args['customer_address1']   = $billing_address1;
        $args['customer_address2']   = $billing_address2;
        $args['customer_fulladdress'] = $address;
        $args['customer_zip']        = $billing_zip;
        $args['customer_city']       = $billing_city;
        $args['customer_email']      = $email;
        $args['customer_phone']      = $phone;
        $args['customer_title']      = $title;
        $args['customer_salutation'] = $new_salutation;

        /** SECOND CONTACT PERSON */
        $title      = get_the_author_meta('_epp_second_contact_title', $customer_id);
        $salutation = get_the_author_meta('_epp_second_contact_salutation', $customer_id);
        $firstname  = get_the_author_meta('_epp_second_contact_firstname', $customer_id);
        $lastname   = get_the_author_meta('_epp_second_contact_lastname', $customer_id);
        $email      = get_the_author_meta('_epp_second_contact_email', $customer_id);

        $args['customer_second_contact_email']      = $email;
        $args['customer_second_contact_firstname']  = $firstname;
        $args['customer_second_contact_lastname']   = $lastname;
        $args['customer_second_contact_title']      = $title;
        $args['customer_second_contact_salutation'] = $new_salutation;

        return $args;
    }

    /**
     * Render email's HTML head
     *
     * @return string
     */
    public function render_html_head()
    {
        $fonts_uri = ERGO_FONTS_URI;

        if( !$this->current_user_data ) {
            $this->current_user_data = $this->get_current_user_data();
        }
        extract($this->current_user_data);

        if( !$this->customer_data ) {
            $this->customer_data = $this->get_customer_data();
        }
        extract($this->customer_data);

        ob_start();
        include ERGO_TEMPLATE_DIR . '/email/header.html.php';
        return ob_get_clean();
    }

    /**
     * Render email's HTML footer
     *
     * @return string
     */
    public function render_html_footer()
    {
        if( !$this->current_user_data ) {
            $this->current_user_data = $this->get_current_user_data();
        }
        extract($this->current_user_data);

        if( !$this->customer_data ) {
            $this->customer_data = $this->get_customer_data();
        }
        extract($this->customer_data);

        ob_start();
        include ERGO_TEMPLATE_DIR . '/email/footer.html.php';
        return ob_get_clean();
    }

    /**
     * Render email's styles
     *
     * @return string
     */
    public function render_html_style()
    {
        return file_get_contents(ERGO_TEMPLATE_DIR . '/email/style.css');
    }
}

