<?php
namespace Ergopack\Component\Pdf\Document;

use Ergopack\Component\Pdf\ErgoPDF;

/**
 * Class AbstractDocument
 *
 * @package Ergopack\Component\Pdf\Document
 * @author Effecticore
 */
abstract class AbstractDocument implements DocumentInterface
{
    /** @var string AUTHOR */
    const AUTHOR = 'Ergopack';

    /** @var string CREATOR */
    const CREATOR = 'TCPDF';

    /** @var string ENCODING */
    const ENCODING = 'utf-8';

    /** @var string FONT_NAME_MAIN */
    const FONT_NAME_MAIN = 'dejavusans';

    /** @var int FONT_SIZE_MAIN */
    const FONT_SIZE_MAIN = 10;

    /** @var string FONT_MONOSPACED */
    const FONT_MONOSPACED = 'courier';

    /** @var string HEADER_TITLE */
    const HEADER_TITLE = 'ErgoPack';

    /** @var float IMAGE_SCALE_RATIO */
    const IMAGE_SCALE_RATIO = 1.25;

    /** @var int MARGIN_HEADER */
    const MARGIN_HEADER = 5;

    /** @var int MARGIN_FOOTER */
    const MARGIN_FOOTER = 5;

    /** @var int MARGIN_TOP */
    const MARGIN_TOP = 38;

    /** @var int MARGIN_BOTTOM */
    const MARGIN_BOTTOM = 40;

    /** @var int MARGIN_LEFT */
    const MARGIN_LEFT = 15;

    /** @var int MARGIN_RIGHT */
    const MARGIN_RIGHT = 15;

    /** @var string PAGE_ORIENTATION */
    const PAGE_ORIENTATION = 'P';

    /** @var string PAGE_FORMAT */
    const PAGE_FORMAT = 'A4';

    /** @var string UNIT */
    const UNIT = 'mm';

    /** @var \TCPDF $pdf */
    protected $pdf;

    /** @var mixed $data */
    protected $data;

    /** @var string $filename */
    protected $filename;

    /** @var $fontname */
    protected $fontname;

    /**
     * Pdf constructor.
     *
     * @param string $title
     * @param string $subject
     * @param string $keywords
     * @param string $header_title
     */
    public function __construct($title = 'TLE Search', $subject = '', $keywords = '', $header_title = '')
    {
        if( empty($header_title) ) {
            $header_title = self::HEADER_TITLE;
        }

        $this->pdf = new ErgoPDF(self::PAGE_ORIENTATION, self::UNIT, self::PAGE_FORMAT, true, self::ENCODING, false, true );

        // set document information
        $this->pdf->SetCreator(self::CREATOR);
        $this->pdf->SetAuthor(self::AUTHOR);
        $this->pdf->SetTitle($title);
        $this->pdf->SetSubject($subject);
        $this->pdf->SetKeywords($keywords);

        // set default header data
        //$this->pdf->SetHeaderData('', 0, $header_title, $subject);

        // set header and footer fonts
        $this->pdf->setHeaderFont([self::FONT_NAME_MAIN, '', self::FONT_SIZE_MAIN]);
        $this->pdf->setFooterFont([self::FONT_NAME_MAIN, '', self::FONT_SIZE_MAIN]);

        // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(self::FONT_MONOSPACED);

        // set margins
        $this->pdf->SetMargins(self::MARGIN_LEFT, self::MARGIN_TOP, self::MARGIN_RIGHT);
        $this->pdf->SetHeaderMargin(self::MARGIN_HEADER);
        $this->pdf->SetFooterMargin(self::MARGIN_FOOTER);

        // set auto page breaks
        $this->pdf->SetAutoPageBreak(true, self::MARGIN_BOTTOM);

        // set image scale factor
        $this->pdf->setImageScale(self::IMAGE_SCALE_RATIO);

        $this->pdf->SetFont(self::FONT_NAME_MAIN);

        $this->data = null;
    }

    /**
     * Set data
     *
     * @param $data
     * @return mixed|void
     */
    public function set_data( $data )
    {
        $this->data = $data;
    }

    /**
     * Set filename
     *
     * @since 1.0.1
     *
     * @param $filename
     * @return mixed|void
     */
    public function set_filename( $filename )
    {
        $this->filename = $filename;
    }

    /**
     * Set data
     *
     * @since 1.0.1
     *
     * @return string
     */
    public function get_filename()
    {
        if( empty($this->filename) ) {
            $this->filename = 'attachement';
        }
        return $this->filename . '.pdf';
    }

    /**
     * Get document path
     *
     * @return string
     */
    public function get_document_path()
    {
        return '';
    }
}