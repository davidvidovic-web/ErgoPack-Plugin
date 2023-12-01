<?php
namespace Ergopack\Component;

/**
 * Class Woocommerce
 *
 * @author Effecticore
 * @since 0.1
 */

class Woocommerce
{
    /**
     * Run
     */
    public function run()
    {
        add_action('init', [&$this, 'add_roles']);

        add_filter('woocommerce_taxonomy_args_pa_accessories', [&$this, 'enable_hierarchy']);
        add_filter('woocommerce_taxonomy_args_pa_special-equipment', [&$this, 'enable_hierarchy']);
    }

    public function add_roles()
    {
        add_role( 'sale_person', __( 'Verkäufer','ergo' ), ['read' => true, 'edit_posts'   => true]);
    }

    public function enable_hierarchy( $data )
    {
        $data['hierarchical'] = true;
        return $data;
    }
}