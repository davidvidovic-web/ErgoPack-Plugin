<?php
namespace Ergopack\Component\Woocommerce;

/**
 * Class Checkout
 *
 * @author Effecticore
 * @since 0.1
 */

class Checkout
{
    /**
     * Run
     */
    public function run()
    {
        // Actions
        add_action('woocommerce_checkout_before_customer_details', [&$this, 'add_customer_select']);
        add_action('woocommerce_before_checkout_billing_form', [&$this, 'add_customer_salutation']);
        add_action('woocommerce_before_checkout_billing_form', [&$this, 'add_customer_title']);
        add_action('woocommerce_checkout_process', [&$this, 'validation']);
        add_action('woocommerce_checkout_before_customer_details', [&$this, 'add_quotation_hidden']);
        add_action('woocommerce_checkout_before_order_review_heading', [&$this, 'add_second_contact_fields']);
        add_action('woocommerce_checkout_update_order_meta', [&$this, 'checkout_update_order_meta']);
        add_action('woocommerce_checkout_order_processed', [&$this, 'order_processed'], 10, 3);
        add_action('woocommerce_review_order_before_submit', [&$this, 'add_quotation_button']);
        add_action('woocommerce_thankyou', [&$this, 'change_order_status'], 10, 1 );
        add_action('woocommerce_new_order', [&$this, 'save_seller_id'] );

        add_action('show_user_profile', [&$this, 'extra_user_profile_fields'], 1 );
        add_action('edit_user_profile', [&$this, 'extra_user_profile_fields'], 1 );
        add_action('personal_options_update', [&$this, 'save_extra_user_profile_fields'] );
        add_action('edit_user_profile_update', [&$this, 'save_extra_user_profile_fields'] );

        // Actions:Admin
        add_action('woocommerce_admin_order_data_after_billing_address', [&$this, 'display_admin_vorgangsnummer']);
        add_action('woocommerce_admin_order_data_after_billing_address', [&$this, 'display_admin_contact_person']);

        // Filters
        add_filter('woocommerce_ship_to_different_address_checked', '__return_true');
        add_filter('woocommerce_checkout_get_value','__return_empty_string',10);
        add_filter('woocommerce_checkout_customer_id', [&$this, 'get_order_customer_id']);

        // AJAX
        add_action('wp_ajax_epp_load_customer_data', [&$this, 'load_customer_data']);
    }

    /**
     * Change customer ID
     *
     * @param $cid
     * @return int
     */
    public function get_order_customer_id( $cid )
    {
        if( isset( $_POST['epp_customer_id'] ) ) {
            $cid = absint($_POST['epp_customer_id']);
        }

        return $cid;
    }

    /**
     * Render customer select template
     */
    public function add_customer_select()
    {
        $customers = $this->get_customers();
        require_once ERGO_TEMPLATE_DIR . '/woocommerce/checkout/customer-select.php';
    }

    /**
     * Render second contact person fields
     */
    public function add_second_contact_fields()
    {
        $salutations = Customer::get_salutation_options();
        $titles      = Customer::get_title_options();
        require_once ERGO_TEMPLATE_DIR . '/woocommerce/checkout/second-contact-person-fields.php';
    }



    /**
     * Render customer salutation template
     */
    public function add_customer_salutation()
    {
        woocommerce_form_field( 'epp_customer_salutation', array(
            'type'	=> 'select',
            'required' => true,
            'class'	=> array('form-row-first form-row-wide'),
            'label'	=> __('Anrede','ergo'),
            'options' => Customer::get_salutation_options()
        ) );
    }

    /**
     * Render customer title template
     */
    public function add_customer_title()
    {
        woocommerce_form_field( 'epp_customer_title', array(
            'type'	=> 'select',
            'required' => true,
            'class'	=> array('form-row-last form-row-wide'),
            'label'	=> __('Titel','ergo'),
            'options' => Customer::get_title_options()
        ) );
    }

    /**
     * Render customer select template
     */
    public function add_quotation_hidden()
    {
        woocommerce_form_field('is_order_quotation', [
            'type' => 'hidden',
            'value' => ''
        ]);
    }

    /**
     * Validate custom fields
     */
    public function validation()
    {
        // Check Vorgangsnummer value
        if ( isset($_POST['epp_vorgangsnummer']) && empty($_POST['epp_vorgangsnummer']) )
            wc_add_notice( __( 'Bitte Vorgangsnummer eingeben.','ergo' ), 'error' );

        // Check contact person's email
        if( isset( $_POST['epp_second_contact_email'] ) && !empty($_POST['epp_second_contact_email']) && strpos($_POST['epp_second_contact_email'],'@') === false )
            wc_add_notice( __( 'E-Mail-Adresse ist nicht korrekt.', 'ergo' ), 'error' );
    }

    /**
     * @param $order_id
     */
    public function checkout_update_order_meta( $order_id ){
        if( isset( $_POST['epp_customer_id'] ) && intval($_POST['epp_customer_id']) > 0 ) {
            if (!empty($_POST['epp_customer_title'])) {
                update_user_meta($_POST['epp_customer_id'], 'epp_customer_title', sanitize_text_field($_POST['epp_customer_title']));
            }
            if (!empty($_POST['epp_customer_salutation'])) {
                update_user_meta($_POST['epp_customer_id'], 'epp_customer_salutation', sanitize_text_field($_POST['epp_customer_salutation']));
            }
            if( isset( $_POST['epp_second_contact_salutation'] ) && !empty($_POST['epp_second_contact_salutation']) && isset( $_POST['epp_second_contact_lastname'] ) && !empty($_POST['epp_second_contact_lastname']) ) {
                update_user_meta($_POST['epp_customer_id'], '_epp_second_contact_salutation', sanitize_text_field($_POST['epp_second_contact_salutation']));
            }
            if( isset( $_POST['epp_second_contact_title'] ) && !empty($_POST['epp_second_contact_title']) ) {
                update_user_meta($_POST['epp_customer_id'], '_epp_second_contact_title', sanitize_text_field($_POST['epp_second_contact_title']));
            }
            if( isset( $_POST['epp_second_contact_firstname'] ) && !empty($_POST['epp_second_contact_firstname']) ) {
                update_user_meta($_POST['epp_customer_id'], '_epp_second_contact_firstname', sanitize_text_field($_POST['epp_second_contact_firstname']));
            }
            if( isset( $_POST['epp_second_contact_lastname'] ) && !empty($_POST['epp_second_contact_lastname']) ) {
                update_user_meta($_POST['epp_customer_id'], '_epp_second_contact_lastname', sanitize_text_field($_POST['epp_second_contact_lastname']));
            }
            if( isset( $_POST['epp_second_contact_email'] ) && !empty($_POST['epp_second_contact_email']) ) {
                update_user_meta($_POST['epp_customer_id'], '_epp_second_contact_email', sanitize_email($_POST['epp_second_contact_email']));
            }
        }
        if( isset( $_POST['epp_vorgangsnummer'] ) && absint($_POST['epp_vorgangsnummer']) > 0 ) {
            update_post_meta($order_id, '_epp_vorgangsnummer', absint($_POST['epp_vorgangsnummer']));
        }
    }

    /**
     * Get customers
     *
     * @return array
     */
    public function get_customers()
    {
        global $wpdb;

        $results = $wpdb->get_results("
            SELECT u.ID, um2.meta_value nickname, um3.meta_value first_name, um4.meta_value last_name, um5.meta_value company
            FROM {$wpdb->prefix}users u
            JOIN {$wpdb->prefix}usermeta um1 ON um1.user_id = u.ID AND um1.meta_key = '{$wpdb->prefix}capabilities'
            JOIN {$wpdb->prefix}usermeta um2 ON um2.user_id = u.ID AND um2.meta_key = 'nickname'
            LEFT JOIN {$wpdb->prefix}usermeta um3 ON um3.user_id = u.ID AND um3.meta_key = 'first_name'
            LEFT JOIN {$wpdb->prefix}usermeta um4 ON um4.user_id = u.ID AND um4.meta_key = 'last_name'
            LEFT JOIN {$wpdb->prefix}usermeta um5 ON um5.user_id = u.ID AND um5.meta_key = 'billing_company'
            WHERE um1.meta_value LIKE '%s:8:\"customer\"%' 
        ");

        $arr = [];
        foreach( $results as $customer ) {
            $company = !empty($customer->company) ? ($customer->company . ' - ') : '';
            $name = empty($customer->first_name) ? $customer->nickname : ( $customer->first_name . ' ' . $customer->last_name . ' ('.$customer->nickname.')' );
            $arr[$customer->ID] = $company . $name;
        }

        return $arr;
    }


    /**
     * Load customer data
     */
    public function load_customer_data()
    {
        global $wpdb;

        $json = [];

        if( wp_verify_nonce( $_POST['nonce'], 'ajax-nonce') ) {

            $customer = $wpdb->get_row($wpdb->prepare("
                SELECT 
                    u.ID, 
                    um10.meta_value billing_first_name, 
                    um11.meta_value billing_last_name, 
                    um1.meta_value billing_company, 
                    um2.meta_value billing_address_1, 
                    um3.meta_value billing_address_2, 
                    um4.meta_value billing_city, 
                    um5.meta_value billing_postcode, 
                    um6.meta_value billing_country, 
                    um7.meta_value billing_state, 
                    um8.meta_value billing_phone, 
                    um9.meta_value billing_email,
                    um28.meta_value shipping_first_name, 
                    um29.meta_value shipping_last_name, 
                    um21.meta_value shipping_company, 
                    um22.meta_value shipping_address_1, 
                    um23.meta_value shipping_address_2, 
                    um24.meta_value shipping_city, 
                    um25.meta_value shipping_postcode, 
                    um26.meta_value shipping_country, 
                    um27.meta_value shipping_state, 
                    um30.meta_value epp_customer_title,
                    um31.meta_value epp_customer_salutation
                FROM {$wpdb->prefix}users u
                LEFT JOIN {$wpdb->prefix}usermeta um1 ON um1.user_id = u.ID AND um1.meta_key = 'billing_company'
                LEFT JOIN {$wpdb->prefix}usermeta um2 ON um2.user_id = u.ID AND um2.meta_key = 'billing_address_1'
                LEFT JOIN {$wpdb->prefix}usermeta um3 ON um3.user_id = u.ID AND um3.meta_key = 'billing_address_2'
                LEFT JOIN {$wpdb->prefix}usermeta um4 ON um4.user_id = u.ID AND um4.meta_key = 'billing_city'
                LEFT JOIN {$wpdb->prefix}usermeta um5 ON um5.user_id = u.ID AND um5.meta_key = 'billing_postcode'
                LEFT JOIN {$wpdb->prefix}usermeta um6 ON um6.user_id = u.ID AND um6.meta_key = 'billing_country'
                LEFT JOIN {$wpdb->prefix}usermeta um7 ON um7.user_id = u.ID AND um7.meta_key = 'billing_state'
                LEFT JOIN {$wpdb->prefix}usermeta um8 ON um8.user_id = u.ID AND um8.meta_key = 'billing_phone'
                LEFT JOIN {$wpdb->prefix}usermeta um9 ON um9.user_id = u.ID AND um9.meta_key = 'billing_email'
                LEFT JOIN {$wpdb->prefix}usermeta um10 ON um10.user_id = u.ID AND um10.meta_key = 'billing_first_name'
                LEFT JOIN {$wpdb->prefix}usermeta um11 ON um11.user_id = u.ID AND um11.meta_key = 'billing_last_name'
                LEFT JOIN {$wpdb->prefix}usermeta um21 ON um21.user_id = u.ID AND um21.meta_key = 'shipping_company'
                LEFT JOIN {$wpdb->prefix}usermeta um22 ON um22.user_id = u.ID AND um22.meta_key = 'shipping_address_1'
                LEFT JOIN {$wpdb->prefix}usermeta um23 ON um23.user_id = u.ID AND um23.meta_key = 'shipping_address_2'
                LEFT JOIN {$wpdb->prefix}usermeta um24 ON um24.user_id = u.ID AND um24.meta_key = 'shipping_city'
                LEFT JOIN {$wpdb->prefix}usermeta um25 ON um25.user_id = u.ID AND um25.meta_key = 'shipping_postcode'
                LEFT JOIN {$wpdb->prefix}usermeta um26 ON um26.user_id = u.ID AND um26.meta_key = 'shipping_country'
                LEFT JOIN {$wpdb->prefix}usermeta um27 ON um27.user_id = u.ID AND um27.meta_key = 'shipping_state'
                LEFT JOIN {$wpdb->prefix}usermeta um28 ON um28.user_id = u.ID AND um28.meta_key = 'shipping_first_name'
                LEFT JOIN {$wpdb->prefix}usermeta um29 ON um29.user_id = u.ID AND um29.meta_key = 'shipping_last_name'
                LEFT JOIN {$wpdb->prefix}usermeta um30 ON um30.user_id = u.ID AND um30.meta_key = 'epp_customer_title'
                LEFT JOIN {$wpdb->prefix}usermeta um31 ON um31.user_id = u.ID AND um31.meta_key = 'epp_customer_salutation'
                WHERE u.ID = %d
            ", intval($_POST['cid'])), 'ARRAY_A');

            $json['success'] = 'no';

            if( $customer ) {
                $json['success'] = 'ok';
                $json['data'] = $customer;
            }
        }

        wp_send_json($json);
    }

    /**
     * Add Quotation button
     */
    public function add_quotation_button()
    {
        $order_button_text = __('Angebot erstellen','ergo');
        echo '<button type="button" class="button alt" name="woocommerce_checkout_place_order_quotation" id="place_order_quotation" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button> ';

        $order_button_text = __('Bestellung aufgeben','ergo');
        echo '<button type="button" class="button alt" name="woocommerce_checkout_place_order_trig" id="place_order_trig" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>';
    }

    /**
     * Set meta if quotation
     *
     * @param $order_id
     * @param $posted_data
     * @param $order
     */
    public function order_processed( $order_id, $posted_data, $order )
    {
        if( isset($_POST['is_order_quotation']) && 1 == $_POST['is_order_quotation'] ) {
            update_post_meta($order_id, '_ep_is_quotation', '1');
        }
    }

    /**
     * Change Quotation status
     *
     * @param $order_id
     */
    public function change_order_status( $order_id )
    {
        if( ! $order_id ) return;

        $is_quotation = get_post_meta($order_id, '_ep_is_quotation', true);

        if( '1' === $is_quotation ) {
            $order = wc_get_order($order_id);

            $time_order = strtotime($order->get_date_created());
            $time_current = time();
            $time_interval = $time_current - $time_order;

            //Case refresh page after 3 minutes at order, no changed status
            if ($time_interval < 180) {
                $order->update_status('quotation-offer');
            }
        }
    }

    /**
     * Save seller's ID
     *
     * @param $order_id
     */
    public function save_seller_id( $order_id )
    {
        if( ! $order_id ) return;

        if( get_current_user_id() > 0 ) {
            update_post_meta($order_id, '_ep_seller_id', get_current_user_id());
        }
    }

    /**
     * ============
     *    ADMIN
     * ============
     */
    /**
     * Display admin contact person
     *
     * @param $order
     */
    public function display_admin_vorgangsnummer( $order )
    {
        $dealid = (int)get_post_meta( $order->get_id(), '_epp_vorgangsnummer', true );

        if( $dealid > 0 ) {
            ?>
            <hr>
            <p><strong><?php echo esc_html__('Vorgangsnummer:','ergo'); ?></strong> <?php echo $dealid ?></p>
            <?php
        }
    }

    /**
     * Display admin contact person
     *
     * @param $order
     */
    public function display_admin_contact_person( $order )
    {
        $salutation = get_user_meta( $order->get_customer_id(), '_epp_second_contact_salutation', true );
        if( $salutation == 'Sehr geehrter Herr' ) {
            $new_salutation = __('Sehr geehrter Herr','ergo');
        } else if ( $salutation == 'Sehr geehrte Frau' ) {
            $new_salutation = __('Sehr geehrte Frau','ergo');
        }
        $new_salutation;
        $title      = get_user_meta( $order->get_customer_id(), '_epp_second_contact_title', true );
        $firstname  = get_user_meta( $order->get_customer_id(), '_epp_second_contact_firstname', true );
        $lastname   = get_user_meta( $order->get_customer_id(), '_epp_second_contact_lastname', true );
        $email      = get_user_meta( $order->get_customer_id(), '_epp_second_contact_email', true );

        if(empty($lastname)) {
            return;
        }
        ?>
        <hr>
        <h3><?php esc_html__('Zusätzlicher Ansprechpartner','ergo'); ?></h3>
        <p><?php echo $new_salutation; ?> <?php echo $title ?> <?php echo $firstname ?> <?php echo $lastname ?></p>
        <p><strong>E-Mail-Address:</strong> <a href="mailto:<?php echo esc_attr($email)?>"><?php echo $email ?></a></p>
        <?php
    }
}