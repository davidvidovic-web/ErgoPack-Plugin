<?php
namespace Ergopack\Component;

/**
 * Class Metabox
 *
 * @author Effecticore
 * @since 0.1
 */

class Metabox
{
    /**
     * Run
     */
    public function run()
    {
        add_filter('rwmb_meta_boxes', [&$this, 'register_tax_line_metaboxes']);
    }

    /**
     * Register metaboxes for "line" taxonomy
     * @param $meta_boxes
     * @return array
     */
    public function register_tax_line_metaboxes( $meta_boxes )
    {
        $meta_boxes[] = array(
            'title'      => __( 'Allgemeines', 'ergo'),
            'taxonomies' => 'epp_line',
            'fields' => array(
                array(
                    'name' => 'Featured Image',
                    'id'   => 'epp_line_image',
                    'type' => 'image_advanced',
                ),
            ),
        );
        return $meta_boxes;
    }
}