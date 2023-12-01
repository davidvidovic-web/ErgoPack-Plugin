<?php

namespace Ergopack\Component\Pdf;

/**
 * Class ErgoPDF
 *
 * @package Ergopack\Component\Pdf
 * @author Effecticore
 */
class ErgoPDF extends \TCPDF
{
    public function Header()
    {
        if (ICL_LANGUAGE_CODE == 'us') {
            $image_file = ERGO_IMG_DIR . '/ep_pdf_headerstripe-us.jpg';
        } else {
            $image_file = ERGO_IMG_DIR . '/ep_pdf_headerstripe.jpg';
        }

        $this->Image($image_file, 0, 0, 210, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Cell(0, 40, '');
    }

    public function Footer()
    {
        $this->SetY(-35);

        $nb = $this->getAliasNumPage();
        $pages = $this->getAliasNbPages();

        ob_start();
        require ERGO_TEMPLATE_DIR . '/pdf/footer.php';
        $html = ob_get_clean();

        $this->writeHTML($html, true, false, true, false, '');

        $image_file = ERGO_IMG_DIR . '/ep_pdf_top100.png';
        $this->Image($image_file, 180, 265, 15, '', 'PNG', '', 'R', false, 300, '', false, false, 0, false, false, false);

    }
}