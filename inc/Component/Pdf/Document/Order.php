<?php

namespace Ergopack\Component\Pdf\Document;

/**
 * Class Order
 *
 * @package Ergopack\Component\Pdf\Document
 * @author Effecticore
 */
class Order extends AbstractDocument
{
    /** @var \WC_Order $order */
    protected $order;

    public function __construct($title = 'Unser Angebot', $subject = '', $keywords = '', $header_title = '')
    {
        parent::__construct($title, $subject, $keywords, $header_title);
    }

    /**
     * Check if data object is available
     *
     * @return bool
     */
    public function is_empty()
    {
        return !($this->order instanceof \WC_Order);
    }

    /**
     * Set data
     *
     * @param \WC_Order $order
     */
    public function set_order(\WC_Order $order)
    {
        $this->order = $order;
    }

    /**
     * Table header titles
     *
     * @return array
     */
    public function get_doc_header_titles()
    {
        return ['', 'Autor', 'Titel', 'Seite(n)'];
    }

    /**
     * Table header width
     *
     * @return array
     */
    public function get_doc_header_widths()
    {
        return ['4%', '96%'];
    }

    /**
     * Table header classes
     *
     * @return array
     */
    public function get_doc_header_classes()
    {
        return ['', 'th-autor', 'th-titel', 'th-seiten'];
    }

    /**
     * Count cell items
     *
     * @return int
     */
    public function get_doc_header_num()
    {
        return count($this->get_doc_header_titles());
    }

    /**
     * Define document header
     */
    public function doc_header()
    {
        $this->pdf->setFormDefaultProp([
            'lineWidth'   => 1,
            'borderStyle' => 'solid',
            'fillColor'   => [255, 255, 255],
            'strokeColor' => [255, 128, 128]
        ]);

        // Colors, line width and bold font
        $this->pdf->SetFillColor(196, 162, 95);
        $this->pdf->SetTextColor(0);
        $this->pdf->SetDrawColor(240, 240, 240);
        $this->pdf->SetLineWidth(0.3);
        $this->pdf->SetFont('helvetica', '', 11);

        $fonts_uri = ERGO_FONTS_URI;

        $html = <<<EOD
<style>
    @font-face {
        font-family: SegoeUI;
        src:
            local("Segoe UI Semibold"),
            url(//c.s-microsoft.com/static/fonts/segoe-ui/west-european/semibold/latest.woff2) format("woff2"),
            url(//c.s-microsoft.com/static/fonts/segoe-ui/west-european/semibold/latest.woff) format("woff"),
            url(//c.s-microsoft.com/static/fonts/segoe-ui/west-european/semibold/latest.ttf) format("truetype");
        font-weight: normal;
    }
    @font-face {
        font-family: SegoeUIBold;
        src:
            local("Segoe UI Bold"),
            url(//c.s-microsoft.com/static/fonts/segoe-ui/west-european/bold/latest.woff2) format("woff2"),
            url(//c.s-microsoft.com/static/fonts/segoe-ui/west-european/bold/latest.woff) format("woff"),
            url(//c.s-microsoft.com/static/fonts/segoe-ui/west-european/bold/latest.ttf) format("truetype");
        font-weight: bold;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: SegoeUIBold;
    }
    h1 {
        font-size: 24px;
        display: none;
    }
    h2 {
        font-size: 22px;
    }
    h2 div {
        font-size: 12px;
		font-weight: normal;
    }
    h3 {
        font-size: 16px;
        padding: 0;
        margin: 0;
    }
    td, p {
        font-family: SegoeUI;
        font-size: 14px;
        color: #000000;
    }
    td p {
    }
    td h4 {
        font-family: Helvetica, sans-serif;
    }
    li {
        list-style-type: square;
    }
    strong {
        font-weight: bold;
    }
    td.td-item1 { }
    td.td-item2 { }
    td.td-item2-2 { text-align: left }
    td.td-item3 { text-align: right }
    td.td-summary { border-bottom: 1px solid #000000; }
</style>
EOD;
        return $html;
    }

    /**
     * ==============
     * HELPER GETTERS
     * ==============
     */
    public function get_order_date()
    {
        return $this->order->get_date_created()->date_i18n('d. F Y');
    }

    /**
     * ==============
     * CONTENT
     * ==============
     */
    public function display_welcome()
    {
        $order = $this->order;
        $order_id = $order->id;
        $html  = $this->doc_header();

        // Customer info
        $billing_company   = $order->get_billing_company();
        $billing_company   = !empty($billing_company) ? sprintf('%s<br>', $billing_company) : '';

        $billing_firstname = $order->get_billing_first_name();
        $billing_lastname  = $order->get_billing_last_name();
        $fullname          = !empty($billing_firstname) && !empty($billing_lastname) ? sprintf('%s %s<br>', $billing_firstname, $billing_lastname) : '';

        $billing_address1  = $order->get_billing_address_1();
        $billing_address2  = $order->get_billing_address_2();
        $address           = $billing_address1 . (!empty($billing_address2) ? sprintf(' %s', $billing_address2) : '') . '<br>';

        $billing_zip       = $order->get_billing_postcode();
        $billing_city      = $order->get_billing_city();

        $email             = $order->get_billing_email();

        $title             = get_the_author_meta('epp_customer_title', $order->get_user_id());
        $salutation        = get_post_meta($order_id, '_epp_customer_salutation', true);

        $new_salutation = '';
        if ($salutation == 'Sehr geehrter Herr') {
            $new_salutation = __('Sehr geehrter Herr', 'ergo');
        } else if ($salutation == 'Sehr geehrte Frau') {
            $new_salutation = __('Sehr geehrte Frau', 'ergo');
        }

        $new_salutation;


        // SECOND CONTACT PERSON
        $customer_id                        = $order->get_customer_id();
        $customer_second_contact_title      = get_the_author_meta('_epp_second_contact_title', $customer_id);
        $customer_second_contact_salutation = get_post_meta($order_id, '_epp_second_contact_salutation', true);
        $new_second_salutation = '';
        if ($customer_second_contact_salutation == 'Sehr geehrter Herr') {
            $new_second_salutation = __('Sehr geehrter Herr', 'ergo');
        } else if ($customer_second_contact_salutation == 'Sehr geehrte Frau') {
            $new_second_salutation = __('Sehr geehrte Frau', 'ergo');
        }
        $new_second_salutation;
        $customer_second_contact_firstname  = get_the_author_meta('_epp_second_contact_firstname', $customer_id);
        $customer_second_contact_lastname   = get_the_author_meta('_epp_second_contact_lastname', $customer_id);
        $customer_second_contact_email      = get_the_author_meta('_epp_second_contact_email', $customer_id);

        // aliases
        $customer_firstname  = $billing_firstname;
        $customer_lastname   = $billing_lastname;
        $customer_fullname   = $fullname;
        $customer_company    = $billing_company;
        $customer_address1   = $billing_address1;
        $customer_address2   = $billing_address2;
        $customer_fulladdress = $address;
        $customer_zip        = $billing_zip;
        $customer_city       = $billing_city;
        $customer_email      = $email;
        $customer_title      = $title;
        $customer_salutation = $new_salutation;

        // Order date
        $order_date = $this->get_order_date();

        // Seller info
        $current_user = wp_get_current_user();

        $seller_firstname = $seller_lastname = $seller_title = $seller_email = $seller_phone = '';

        if ($current_user) {
            $seller_firstname = $current_user->first_name;
            $seller_lastname = $current_user->last_name;
            $seller_fullname = !empty($seller_firstname) && !empty($seller_lastname) ? sprintf('%s %s<br>', $seller_firstname, $seller_lastname) : $current_user->nickname;
            $seller_title = get_user_meta($current_user->ID, 'description', true);
            $seller_email = $current_user->user_email;
            $seller_phone = get_user_meta($current_user->ID, 'billing_phone', true);
        }

        ob_start();

        require ERGO_TEMPLATE_DIR . '/pdf/order/signature.php';
        require ERGO_TEMPLATE_DIR . '/pdf/order/welcome.php';
        $html .= ob_get_clean();

        $this->pdf->writeHTML($html, true, false, true, false, '');
    }

    public function display_order_item(\WC_Order_Item $item)
    {
        $product = $item->get_product();

        $item_title = $item->get_name();
        $item_quantity = $item->get_quantity();
        $item_price = wc_price($this->order->get_item_subtotal($item, false, true), ['currency' => $this->order->get_currency()]);
        $item_total = wc_price($item->get_subtotal(), ['currency' => $this->order->get_currency()]);
        $item_description = $product->get_description();
        $item_description = str_replace('<ul>', '<ul style="list-style-type: square;">', $item_description);

        $image = '';
        $image_data = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'medium');

        if ($image_data) {
            $image_size = @getimagesize($image_data[0]);
            if (isset($image_size[0])) {
                $image_url = esc_url($image_data[0]);
                $image = sprintf('<img src="%s" border="0"/>', $image_url);
            }
        }
        $price_item = __('Preis pro Stück ab Werk', 'ergo');
        return <<<EOD
<tr>
    <td colspan="5" style="font-size: 0px; height: 5px"></td>
</tr>
<tr>
    <td class="td-item1" width="5%" align="center"></td>
    <td class="td-item2" width="80%" colspan="3"><h4 style="font-family: Helvetica">{$item_title}</h4></td>
</tr>
<tr>
    <td colspan="5" style="font-size: 0px; height: 20px"></td>
</tr>
<tr>
    <td class="td-item1" width="5%" align="center"></td>
    <td class="td-item2" width="95%" colspan="4"><table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td width="25%">{$image}</td>
            <td width="75%">{$item_description}</td>
        </tr>    
        </table>
    </td>
</tr>
<tr>
    <td colspan="5" style="font-size: 0px; height: 15px"></td>
</tr>
<tr>
    <td class="td-item1" width="5%"></td>
    <td class="td-item2" width="50%">{$price_item}</td>
    <td class="td-item2-1" width="20%">{$item_price}</td>
    <td class="td-item2-2" width="10%">x {$item_quantity}</td>
    <td class="td-item3" width="15%" align="right">{$item_total}</td>
</tr>
<tr>
    <td colspan="5" style="font-size: 0px; height: 50px"></td>
</tr>
EOD;
    }

    public function display_order_item_summary($total_price, $label = 'Zwischensumme')
    {

        $html = <<<EOD
<tr>
    <td class="" width="5%"></td>
    <td class="td-summary" width="80%" colspan="3">{$label}:</td>
    <td class="td-summary" width="15%" align="right">{$total_price}</td>
</tr>
<tr>
    <td colspan="5"><p></p><p></p></td>
</tr>
EOD;
        return $html;
    }

    public function display_section_total_price($total_price, $label = 'Zwischensumme', $topmargin = true, $withtable = true)
    {
        $html = $withtable ? '<table cellspacing="0" cellpadding="0" border="0">' : '';

        if ($topmargin) {
            $html = <<<EOD
<tr>
    <td colspan="5"><p></p><p></p></td>
</tr>
EOD;
        }

        $html .= $this->display_summary_price($total_price, $label);

        $html .=  <<<EOD
<tr>
    <td colspan="5"><p></p><p></p></td>
</tr>
EOD;
        $html .= $withtable ? '</table>' : '';

        return $html;
    }

    public function display_summary_price($price, $label)
    {
        return <<<EOD
<tr>
    <td class="td-summary" width="85%" colspan="4">{$label}</td>
    <td class="td-summary" width="15%" align="right">{$price}</td>
</tr>
EOD;
    }

    /**
     * Create table
     */
    public function display_order_items()
    {
        // Order date
        $order_date = $this->get_order_date();

        // Items
        $order_items = $this->order->get_items();

        // Group items via categories
        $grouped = [
            'system'   => [],
            'zubehoer' => [],
            'umreifungsbaender' => [],
            'montage'  => []
        ];

        if ($order_items) {
            foreach ($order_items as $item) {
                $product_id = $item->get_product_id();
                //$composited_item = wc_cp_is_composited_order_item( $item, $this->order );
                $composite_container = wc_cp_is_composite_container_order_item($item);
                $child_items  = wc_cp_get_composited_order_items($item, $this->order, false, true);

                if (
                    has_term('zubehoer', 'product_cat', $product_id)
                    || has_term('accessories-en', 'product_cat', $product_id)
                    || has_term('accessories-en-us', 'product_cat', $product_id)
                ) {
                    $grouped['zubehoer'][] = $item;
                } elseif (
                    has_term('umreifungsbaender', 'product_cat', $product_id)
                    || has_term('strapping-bands', 'product_cat', $product_id)
                ) {
                    $grouped['umreifungsbaender'][] = $item;
                } elseif (has_term('montage', 'product_cat', $product_id)) {
                    $grouped['montage'][] = $item;
                } else {
                    if ($composite_container) {
                        $grouped['system'][] = [
                            'parent' => $item,
                            'children' => $child_items
                        ];
                    }
                }
            }
        }

        $html = $this->doc_header();
        $html .= "<h4 style=\"text-decoration: underline\">" . __('Unser Angebot vom', 'ergo') . " {$order_date}</h4><p></p>";

        // Total system
        $total_system = $total_section = 0;

        // System
        if ($grouped['system']) {
            $html .= '<h3>' . __('ErgoPack System:', 'ergo') . '</h3>';
            $html .= '<table cellspacing="0" cellpadding="0" border="0">';

            foreach ($grouped['system'] as $system) {
                $total_per_system = 0;

                if (isset($system['parent'])) {
                    $total_system += $system['parent']->get_subtotal();
                    $total_per_system += $system['parent']->get_subtotal();
                    $html .= $this->display_order_item($system['parent']);
                }
                if (isset($system['children']) && is_array($system['children'])) {
                    foreach ($system['children'] as $child) {
                        $total_system += $child->get_subtotal();
                        $total_per_system += $child->get_subtotal();
                        $html .= $this->display_order_item($child);
                    }
                }

                $total_per_system_price = wc_price($total_per_system, ['currency' => $this->order->get_currency()]);
                $system_label = __('Systempreis', 'ergo');
                $html .= $this->display_order_item_summary($total_per_system_price, $system_label);
            }

            $html .= '</table>';
        }

        $total_system_price = wc_price($total_system, ['currency' => $this->order->get_currency()]);

        $system_preis = __('Zwischensumme', 'ergo');
        // Systempreis
        $html .= $this->display_section_total_price($total_system_price, $system_preis, false);

        // Zubehör
        if ($grouped['zubehoer']) {
            $html .= '<hr style="width: 100px">';
            $html .= '<h3>' . __('Zubehör:', 'ergo') . '</h3>';
            $html .= '<table cellspacing="0" cellpadding="0" border="0">';

            foreach ($grouped['zubehoer'] as $section) {
                $total_section += $section->get_subtotal();
                $html .= $this->display_order_item($section);
            }

            // Zubehörpreis
            $total_section_price = wc_price($total_section, ['currency' => $this->order->get_currency()]);
            $html .= $this->display_section_total_price($total_section_price, 'Zubehörpreis:', false, false);

            $html .= '</table>';
        }

        // Umreifungsbänder
        if ($grouped['umreifungsbaender']) {
            $html .= '<hr style="width: 100px">';
            $html .= '<h3>' . __('Umreifungsbänder:', 'ergo') . '</h3>';
            $html .= '<table cellspacing="0" cellpadding="0" border="0">';

            foreach ($grouped['umreifungsbaender'] as $section) {
                $total_section += $section->get_subtotal();
                $html .= $this->display_order_item($section);
            }

            // Umreifungsbänderpreis
            $total_section_price = wc_price($total_section, ['currency' => $this->order->get_currency()]);
            $html .= $this->display_section_total_price($total_section_price, 'Umreifungsbänderpreis:', false, false);

            $html .= '</table>';
        }

        $html .= '<table cellspacing="0" cellpadding="0" border="0">';

        if ($grouped['montage']) {
            foreach ($grouped['montage'] as $montage) {
                $html .= $this->display_order_item($montage);
            }
        }

        // Coupons
        $coupons = $this->order->get_coupons();
        if ($coupons) {
            foreach ($coupons as $coupon) {
                $coupon_code = $coupon->get_code();
                $coupon_amount = wc_price($coupon->get_discount(), ['currency' => $this->order->get_currency()]);
                $html .= $this->display_summary_price("-{$coupon_amount}", "Aktionscode / Staffelrabatt auf Systeme: {$coupon_code}");
            }

            $html .= <<<EOD
<tr>
    <td colspan="4"><p></p><p></p></td>
</tr>
EOD;
        }

        // Shipping
        $shipping_total = wc_price($this->order->get_shipping_total(), ['currency' => $this->order->get_currency()]);
        $versand_label = __('Versand:', 'ergo');
        $html .= $this->display_summary_price($shipping_total, $versand_label);

        $html .= <<<EOD
<tr>
    <td colspan="4"><p></p><p></p></td>
</tr>
EOD;

        // Total
        $total_price = wc_price($this->order->get_total(), ['currency' => $this->order->get_currency()]);
        $total_label = __('Gesamtpreis', 'ergo');
        $html .= $this->display_summary_price($total_price, $total_label);

        $html .= '</table><p></p>';

        ob_start();
        require ERGO_TEMPLATE_DIR . '/pdf/order/after_table.php';
        require ERGO_TEMPLATE_DIR . '/pdf/order/discount.php';
        require ERGO_TEMPLATE_DIR . '/pdf/order/satisfaction.php';
        $html .= ob_get_clean();

        $this->pdf->writeHTML($html, true, false, true, false, '');
    }

    /**
     * Generate output
     *
     * @param $dest
     * @return mixed|string
     */
    public function output($dest = 'F')
    {
        $this->pdf->setFontSubsetting(false);

        $this->pdf->AddPage();
        $this->display_welcome();

        $this->pdf->AddPage();
        $this->display_order_items();

        $this->pdf->lastPage();

        $base = ergo_pdf_folder($this->get_filename());

        if (strpos($dest, 'F') !== false) {
            $path = $base['dir'] . '/' . $this->get_filename();
        } else if ($dest === 'E') {
            return $this->pdf->Output($this->get_filename(), $dest);
        } else {
            $path = $this->get_filename();
        }

        $this->pdf->Output($path, $dest);

        return $base['file_url'];
    }
}
