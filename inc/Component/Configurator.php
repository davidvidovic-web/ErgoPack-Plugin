<?php
namespace Ergopack\Component;

/**
 * Class Configurator
 *
 * @deprecated
 *
 * @author Effecticore
 * @since 0.1
 */

class Configurator
{
    /**
     * Run
     */
    public function run()
    {
        // Actions
        add_action('init', [&$this, 'rewrite_endpoints']);
        add_action('init', [&$this, 'create_line_tax']);
        add_action('epp_display_configurator', [&$this, 'display']);

        // AJAX
        add_action('wp_ajax_epp_load_attributes', [&$this, 'load_attributes']);
        add_action('wp_ajax_epp_save_configuration', [&$this, 'save_configuration']);
    }

    public function rewrite_endpoints()
    {
        add_rewrite_endpoint('line', EP_PAGES);
    }

    public function create_line_tax()
    {
        $labels = [
            'name'              => _x( 'Line', 'taxonomy general name', 'epp' ),
            'singular_name'     => _x( 'Lines', 'taxonomy singular name', 'epp' ),
            'search_items'      => __( 'Search Line', 'epp' ),
            'all_items'         => __( 'All Lines', 'epp' ),
            'parent_item'       => __( 'Parent Line', 'epp' ),
            'parent_item_colon' => __( 'Parent Line:', 'epp' ),
            'edit_item'         => __( 'Edit Line', 'epp' ),
            'update_item'       => __( 'Update Line', 'epp' ),
            'add_new_item'      => __( 'Add New Line', 'epp' ),
            'new_item_name'     => __( 'New Line Name', 'epp' ),
            'menu_name'         => __( 'Lines', 'epp' ),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'line' ),
        ];

        register_taxonomy( 'epp_line', [ 'product' ], $args );
    }

    /**
     *
     */
    public function display()
    {
        $line = get_query_var('line');

        if( empty($line) ) {
            $this->display_main();
        } else {
            $this->display_line($line);
        }
    }

    /**
     *
     */
    public function display_main()
    {
        $args = [
            'taxonomy' => 'epp_line',
            'hide_empty' => false
        ];

        $lines = get_terms( $args );

        $url = home_url('/configurator/line/');

        require_once ERGO_TEMPLATE_DIR . '/configurator/main.php';
    }

    public function display_line( $line_slug )
    {
        $args = [
            'post_type' => 'product',
            'tax_query' => [
                [
                    'taxonomy' => 'epp_line',
                    'field' => 'slug',
                    'terms' => [ $line_slug ]
                ]
            ]
        ];

        $products = get_posts( $args );

        $line = get_term_by('slug', $line_slug, 'epp_line');

        require_once ERGO_TEMPLATE_DIR . '/configurator/line.php';
    }

    /**
     *
     */
    public function load_attributes()
    {
        if( isset($_POST['pid']) ) {

            $pid = intval($_POST['pid']);
            $product = wc_get_product($pid);
            $attributes = $product->get_attributes();

            require_once ERGO_TEMPLATE_DIR . '/configurator/attributes.php';

        }
        wp_die();
    }

    /**
     * @param $options
     * @param $name
     * @return array
     */
    public function get_attribute_options($options, $name)
    {
        $args = [
            'taxonomy' => $name,
            'include' => $options,
            'orderby' => 'term_order',
            'parent' => 0,
            'hierarchical' => true,
            'hide_empty' => false
        ];

        $terms = get_terms( $args );

        $options = [];
        foreach( $terms as $term ) {
            $options[$term->term_id] = $term;

            // get children
            $args['parent'] = $term->term_id;
            $children = get_terms( $args );

            if( $children ) {
                $options[$term->term_id]->children = $children;
            }

            // get opts from description
            preg_match('/opts=(.*)/', $term->description, $matches);
            if( isset( $matches[1]) ) {
                $options[$term->term_id]->opts = explode(',',$matches[1]);
            }
        }

//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';

        return $options;
    }

    public function save_configuration()
    {
        // Defaults
        $error_msg  = '';
        $product_id = 0;

        // Sanitize
        if( isset($_POST['epp_conf_model']) ) {
            $product_id = intval($_POST['epp_conf_model']);
        }

        // Validation
        if( !$product_id ) {
            $error_msg = 'Choose model';
        }

        if( empty($error_msg) ) {
            $order = wc_create_order();
            $product_item_id = $order->add_product(wc_get_product($product_id), 1);
            $order->calculate_totals();

            wc_add_order_item_meta($product_item_id, 'epp_configurator', serialize($_POST['epp_conf_options']));

            $json = [
                'status' => 'success',
                'message' => sprintf('<p>%s #%s</p>', __('Produkt erfolgreich bestellt! Auftragsnummer:','ergo'), $order->get_id()),
                'order_preview_link' => sprintf('<a href="%s" class="btn btn--primary">'.__('Bestellung anzeigen','ergo').'</a>', $order->get_edit_order_url())
            ];
        } else {
            $json = [
                'status' => 'error',
                'message' => 'There is an error. ' . $error_msg
            ];
        }

        echo json_encode($json);

        wp_die();
    }
}