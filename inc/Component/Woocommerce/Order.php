<?php
namespace Ergopack\Component\Woocommerce;

use Ergopack\Component\Email\Message\OrderConfirmation;

/**
 * Class Order
 *
 * @author Effecticore
 * @since 0.1
 */

class Order
{
    /**
     * Run
     */
    public function run()
    {
        // Actions
        add_action( 'init', [&$this, 'register_quotation_order_status'] );
        add_action( 'woocommerce_order_status_changed', [&$this, 'order_status_changed_send_pdf'], 10, 3);
        add_action( 'woocommerce_order_item_add_action_buttons', [&$this, 'display_pdf_link'], 100, 1 );
        add_action( 'manage_shop_order_posts_custom_column' , [&$this, 'orders_list_column_content'], 20, 2 );
        add_action( 'restrict_manage_posts', [&$this, 'display_admin_seller_filter'] );

        // Actions:admin
        add_action('woocommerce_admin_order_data_after_billing_address', [&$this, 'display_admin_pdf_url']);

        // Filters
        add_filter( 'wc_order_statuses', [&$this, 'add_quotation_to_order_statuses'] );
        add_filter( 'manage_edit-shop_order_columns', [&$this, 'add_order_column'], 20 );
        add_filter( 'pre_get_posts', [&$this, 'process_admin_order_seller_filter'] );
    }

    /**
     * Register Quotation Offer status
     */
    public function register_quotation_order_status()
    {
        register_post_status( 'wc-quotation-offer', array(
            'label'                     => __('Angebot','ergo'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Angebot (%s)', 'Angebot (%s)','ergo' )
        ) );
    }

    /**
     * Add Quotation Offer to statuses
     *
     * @param $order_statuses
     * @return mixed
     */
    public function add_quotation_to_order_statuses( $order_statuses )
    {
        foreach ( $order_statuses as $key => $status ) {
            if ( 'wc-processing' === $key )
                $order_statuses['wc-quotation-offer'] = 'Angebot';
        }
        return $order_statuses;
    }

    /**
     * Display PDF button on admin order page
     *
     * @param $order
     */
    public function display_pdf_link( $order )
    {
        $filename = ergo_pdf_filename($order->get_id());
        $base     = ergo_pdf_folder($filename);

        if( true === $base['file_exists'] ) {
            printf('<a href="%s" class="button" target="_blank">PDF</a>', esc_url($base['file_url']));
        } else {
            printf('<a href="%s" class="button" target="_blank">PDF</a>', esc_url(home_url('/?getpdf=1&order_id=' . $order->get_id())));
        }
    }

    /**
     * Send PDF on status change
     *
     * @param $order_id
     * @param $old_status
     * @param $new_status
     */
    public function order_status_changed_send_pdf( $order_id, $old_status, $new_status )
    {
        $is_quotation = get_post_meta($order_id, '_ep_is_quotation', true);

        if( ERGO_SEND_PDF && ( (ERGO_ORDER_STATUS_SEND_PDF === $new_status && $is_quotation != '1' ) || (ERGO_QUOTATION_STATUS_SEND_PDF === $new_status && $is_quotation == '1' )) ) {
            error_log('--- Order Confirmation #' .$order_id . ' - ' . $old_status . ' => ' . $new_status );

            // send email with PDF
            $confirmation = new OrderConfirmation();
            $confirmation->set_order_id($order_id);
            $confirmation->send();

            // create custom hook for Hubspot API
	        do_action('ergo_hubspot', $order_id);
        }
    }

    /**
     * Add Sale User column
     *
     * @param $columns
     * @return array
     */
    function add_order_column($columns)
    {
        $reordered_columns = array();

        foreach( $columns as $key => $column){
            $reordered_columns[$key] = $column;
            if( $key ==  'order_status' ){
                $reordered_columns['seller'] = 'Sale Person';
            }
        }
        return $reordered_columns;
    }

    /**
     * Display Sale User value
     *
     * @param $column
     * @param $post_id
     */
    function orders_list_column_content( $column, $post_id )
    {
        switch ( $column )
        {
            case 'seller' :
                $seller_id = get_post_meta( $post_id, '_ep_seller_id', true );
                $user = get_user_by('id', $seller_id);

                if( $user ) {
                    $fullname = empty($user->first_name) ? $user->nickname : sprintf('%s %s', $user->first_name, $user->last_name);
                    printf('<a href="%s" target="_blank">%s</a>',esc_url(get_edit_user_link($seller_id)), esc_html($fullname));

                } else {
                    echo '--';
                }

                break;
        }
    }

    /**
     * Display select filter for Seller
     */
    public function display_admin_seller_filter()
    {
        global $pagenow, $post_type, $wpdb;

        if( 'shop_order' === $post_type && 'edit.php' === $pagenow ) {
            $filtered = isset($_GET['filter_shop_order_seller'])? $_GET['filter_shop_order_seller'] : '';

            $sellers = $wpdb->get_results("
                SELECT pm.meta_value ID, um1.meta_value first_name, um2.meta_value last_name, um3.meta_value nickname
                FROM {$wpdb->prefix}postmeta pm
                JOIN {$wpdb->prefix}users u ON pm.meta_value = u.ID
                LEFT JOIN {$wpdb->prefix}usermeta um1 ON um1.user_id = u.ID AND um1.meta_key = 'first_name'
                LEFT JOIN {$wpdb->prefix}usermeta um2 ON um2.user_id = u.ID AND um2.meta_key = 'last_name'
                LEFT JOIN {$wpdb->prefix}usermeta um3 ON um3.user_id = u.ID AND um3.meta_key = 'nickname'
                WHERE pm.meta_key = '_ep_seller_id'
                GROUP BY pm.meta_value
                ORDER BY um3.meta_key
            ");

            echo '<select name="filter_shop_order_seller"><option value="">'. __('Nach Verkaufsperson filtern','ergo').'</option>';
            foreach ( $sellers as $user ) {
                $fullname = empty($user->first_name) ? $user->nickname : sprintf('%s %s', $user->first_name, $user->last_name);
                printf( '<option value="%s"%s>%s</option>', $user->ID,$user->ID == $filtered ? '" selected="selected"' : '', $fullname );
            }
            echo '</select>';
        }
    }

    /**
     * Add Seller meta query
     *
     * @param $query
     */
    public function process_admin_order_seller_filter( $query )
    {
        global $pagenow;

        if ( $query->is_admin && $pagenow == 'edit.php' && isset( $_GET['filter_shop_order_seller'] ) && $_GET['filter_shop_order_seller'] != '' && $_GET['post_type'] == 'shop_order' ) {

            $meta_query = (array)$query->get( 'meta_query' );

            $meta_query[] = [
                'key' => '_ep_seller_id',
                'value'    => esc_attr( $_GET['filter_shop_order_seller'] ),
            ];

            $query->set( 'meta_query', $meta_query );
            $query->set( 'posts_per_page', 10 );
            $query->set( 'paged', ( get_query_var('paged') ? get_query_var('paged') : 1 ) );
        }
    }

    /**
     * Display PDF link in order (admin)
     *
     * @param $order
     */
    public function display_admin_pdf_url( $order )
    {
        $filename = ergo_pdf_filename($order->get_id());
        $pdf      = ergo_pdf_folder($filename);

        if( true === $pdf['file_exists'] ) {
            printf('<hr><p><strong>PDF:</strong><br> <a href="%1$s" target="_blank">%1$s</a></p>', esc_url($pdf['file_url']));
        }
    }
}
