<?php

/**
 * Wrapper for MetaBox getter
 */
if( !function_exists('epp_meta') ) {
    function epp_meta($field_id, $args = [], $post_id = null)
    {
        return rwmb_meta($field_id, $args, $post_id);
    }
}

/**
 * Get PDF directory
 *
 * @param string $filename
 * @return array
 */
function ergo_pdf_folder( $filename = '' )
{
    // Folder name inside uploads dir where PDF are stored
    $save_dir = 'pdfs';
    $file_exists = -1;

    $upload_dir = wp_upload_dir();
    $basedir    = $upload_dir['basedir'];
    $basedir   .= '/' . $save_dir;

    $baseurl    = $upload_dir['baseurl'];
    $baseurl   .= '/' . $save_dir;

    if( !is_dir($basedir) ) {
        mkdir( $basedir, 0700 );
    }

    if( !empty($filename) ) {
        $filename   .= '.pdf';
        $file_exists = file_exists($basedir.'/'.$filename) ? true : false;
    }

    return [
        'dir' => $basedir,
        'url' => $baseurl,
        'file_dir' => $basedir.'/'.$filename,
        'file_url' => $baseurl.'/'.$filename,
        'file_exists' => $file_exists
    ];
}

/**
 * Get PDF filename
 *
 * @param int $order_id
 * @return string
 */
function ergo_pdf_filename($order_id)
{
    return __('ErgoPack-Ihre-persoenliche-Systemkonfiguration_','ergo') . $order_id;
}