<?php
namespace Ergopack\Component\Woocommerce;

/**
 * Class Customer
 *
 * @author Effecticore
 * @since 0.1
 */

class Customer
{
    /**
     * Run
     */
    public function run()
    {
        // Actions
        add_action('show_user_profile', [&$this, 'extra_user_profile_fields'], 1 );
        add_action('edit_user_profile', [&$this, 'extra_user_profile_fields'], 1 );
        add_action('personal_options_update', [&$this, 'save_extra_user_profile_fields'] );
        add_action('edit_user_profile_update', [&$this, 'save_extra_user_profile_fields'] );

        // AJAX
        add_action('wp_ajax_epp_load_customer_data', [&$this, 'load_customer_data']);
    }

    /**
     * @return array
     */
    public static function get_salutation_options()
    {
        return [
            'Sehr geehrter Herr' => __('Sehr geehrter Herr','ergo'),
            'Sehr geehrte Frau' => __('Sehr geehrte Frau','ergo')
        ];
    }

    /**
     * @return array
     */
    public static function get_title_options()
    {
        return [
            '' => '',
            'Dr.' => 'Dr.',
            'Dipl. Ing.' => 'Dipl. Ing.',
            'Prof.' => 'Prof.',
            'Prof. Dr.' => 'Prof. Dr.'
        ];
    }

    /**
     * @param $user
     */
    public function extra_user_profile_fields( $user ) { ?>
        <h3><?php echo esc_html__('Personalisierungsdaten des Kunden','ergo'); ?></h3>

        <table class="form-table">
            <tr>
                <th><label for="epp_customer_title"><?php echo esc_html__('Titel','ergo'); ?></label></th>
                <td>
                    <select name="epp_customer_title" id="epp_customer_title" class="">
                        <?php foreach( self::get_title_options() as $title_key => $title_option ): ?>
                            <option value="<?php echo esc_attr($title_key)?>" <?php selected( $title_key, get_the_author_meta( 'epp_customer_title', $user->ID ) ); ?>><?php echo esc_html($title_option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="epp_customer_salutation"><?php echo esc_html__('Anrede','ergo'); ?></label></th>
                <td>
                    <select name="epp_customer_salutation" id="epp_customer_salutation" class="">
                        <?php foreach( self::get_salutation_options() as $salutation_key => $salutation_option ): ?>
                            <option value="<?php echo esc_attr($salutation_key)?>" <?php selected( $salutation_key, get_the_author_meta( 'epp_customer_salutation', $user->ID ) ); ?>><?php echo esc_html($salutation_option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>

        <h3><?php esc_html__('Zusätzlicher Ansprechpartner ','ergo'); ?> </h3>

        <table class="form-table">
            <tr>
                <th><label for="epp_second_contact_title"><?php echo esc_html__('Titel','ergo'); ?></label></th>
                <td>
                    <select name="epp_second_contact_title" id="epp_second_contact_title" class="">
                        <?php foreach( self::get_title_options() as $title_key => $title_option ): ?>
                            <option value="<?php echo esc_attr($title_key)?>" <?php selected( $title_key, get_the_author_meta( '_epp_second_contact_title', $user->ID ) ); ?>><?php echo esc_html($title_option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="epp_second_contact_salutation"><?php echo esc_html__('Anrede','ergo') ?></label></th>
                <td>
                    <select name="epp_second_contact_salutation" id="epp_second_contact_salutation" class="">
                        <?php foreach( self::get_salutation_options() as $salutation_key => $salutation_option ): ?>
                            <option value="<?php echo esc_attr($salutation_key)?>" <?php selected( $salutation_key, get_the_author_meta( '_epp_second_contact_salutation', $user->ID ) ); ?>><?php echo esc_html($salutation_option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="epp_second_contact_firstname"><?php echo esc_html__('Vorname','ergo'); ?></label></th>
                <td>
                    <input type="text" name="epp_second_contact_firstname" id="epp_second_contact_firstname" value="<?php echo get_the_author_meta( '_epp_second_contact_firstname', $user->ID ); ?>">
                </td>
            </tr>
            <tr>
                <th><label for="epp_second_contact_lastname"><?php echo esc_html__('Nachname','ergo'); ?></label></th>
                <td>
                    <input type="text" name="epp_second_contact_lastname" id="epp_second_contact_lastname" value="<?php echo get_the_author_meta( '_epp_second_contact_lastname', $user->ID ); ?>">
                </td>
            </tr>
            <tr>
                <th><label for="epp_second_contact_email"><?php echo esc_html__('E-Mail-Adresse','ergo'); ?></label></th>
                <td>
                    <input type="text" name="epp_second_contact_email" id="epp_second_contact_email" value="<?php echo get_the_author_meta( '_epp_second_contact_email', $user->ID ); ?>">
                </td>
            </tr>
        </table>
    <?php }

    /**
     * @param $user_id
     * @return bool|void
     */
    public function save_extra_user_profile_fields( $user_id ) {
        if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
            return;
        }

        if ( !current_user_can( 'edit_user', $user_id ) ) {
            return false;
        }

        update_user_meta( $user_id, 'epp_customer_title', $_POST['epp_customer_title'] );
        update_user_meta( $user_id, 'epp_customer_salutation', $_POST['epp_customer_salutation'] );

        if( isset( $_POST['epp_second_contact_salutation'] ) && !empty($_POST['epp_second_contact_salutation']) && isset( $_POST['epp_second_contact_lastname'] ) && !empty($_POST['epp_second_contact_lastname']) ) {
            update_user_meta($user_id, '_epp_second_contact_salutation', sanitize_text_field($_POST['epp_second_contact_salutation']));
        }
        if( isset( $_POST['epp_second_contact_title'] ) && !empty($_POST['epp_second_contact_title']) ) {
            update_user_meta($user_id, '_epp_second_contact_title', sanitize_text_field($_POST['epp_second_contact_title']));
        }
        if( isset( $_POST['epp_second_contact_firstname'] ) && !empty($_POST['epp_second_contact_firstname']) ) {
            update_user_meta($user_id, '_epp_second_contact_firstname', sanitize_text_field($_POST['epp_second_contact_firstname']));
        }
        if( isset( $_POST['epp_second_contact_lastname'] ) && !empty($_POST['epp_second_contact_lastname']) ) {
            update_user_meta($user_id, '_epp_second_contact_lastname', sanitize_text_field($_POST['epp_second_contact_lastname']));
        }
        if( isset( $_POST['epp_second_contact_email'] ) && !empty($_POST['epp_second_contact_email']) ) {
            update_user_meta($user_id, '_epp_second_contact_email', sanitize_email($_POST['epp_second_contact_email']));
        }
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
}