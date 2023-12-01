<?php
namespace Ergopack\Component\Email;

/**
 * Class Email
 *
 * @author Effecticore
 * @since 0.1
 */

class Email
{
    /** @var string $body */
    protected $body;

    /** @var string|null $attachement */
    protected $attachement = null;

    /** @var string|null $attachement_filename */
    protected $attachement_filename = null;

    /** @var string|null $styles */
    protected $styles = null;

    /** @var string $separator */
    protected $separator;

    /**
     * Email constructor.
     *
     * @param null $separator
     */
    public function __construct( $separator = null )
    {
        add_action( 'wp_mail_failed', [$this, 'on_mail_error']);

        if( !$separator ) {
            $separator = md5(uniqid(time()));
        }

        $this->separator = $separator;
    }

    /**
     * Display error on email failure
     *
     * @param $wp_error
     */
    public function on_mail_error( $wp_error )
    {
        echo "<pre>";
        print_r($wp_error);
        echo "</pre>";
        wp_die();
    }

    /**
     * Set attachement
     *
     * @param $attachement
     */
    public function set_attachement( $attachement, $filename = 'attachement.pdf' )
    {
        $this->attachement = $attachement;
        $this->attachement_filename = $filename;
    }

    /**
     * Set multipart content type
     *
     * @return string
     */
    public function set_multipart_content_type()
    {
        return 'multipart/mixed; boundary="PHP-mix-'.$this->separator.'"';
    }

    /**
     * Set charset
     *
     * @return string
     */
    public function set_charset()
    {
        return 'utf-8';
    }

    /**
     * Set styles
     *
     * @return string
     */
    public function set_styles( $styles )
    {
        $this->styles = $styles;
    }

    /**
     * Process attachment and set headers
     *
     * @param array $email
     * @return array
     */
    public function process_attachement( $email = [] )
    {
        add_filter('wp_mail_content_type', [$this, 'set_multipart_content_type'], 22);
        add_filter('wp_mail_charset', [$this, 'set_charset'], 22);

        // carriage return type (RFC)
        $eol = "\r\n";

        $headers = $email['headers'];

        // add styles
        $message = $email['message'];
        $message = str_replace('{{ERGO:STYLES}}', $this->styles, $message);

        if (!$headers) {
            $headers = [];
        }

        $body = "--PHP-mix-" . $this->separator . $eol;

        $body .= "Content-Transfer-Encoding: 7bit" . $eol;
        $body .= "Content-Type: text/html; charset=asci" . $eol;
        $body .= "Mime-Version: 1.0" . $eol . $eol;

        $body .= $message . $eol . $eol;

        if(!empty($this->attachement)) {
            // attachement
            $body .= "--PHP-mix-" . $this->separator . $eol;
            $body .= "Content-Transfer-Encoding: base64" . $eol;
            $body .= "Content-Type: application/octet-stream; name=\"".$this->attachement_filename."\"" . $eol;
            $body .= "Content-Disposition: attachement" . $eol;
            $body .= $this->attachement . $eol . $eol;

        } else {
            if (!$headers) {
                $headers[] = 'Content-Type: text/html; charset=UTF-8';
            }
        }

        $body .= "--PHP-mix-" . $this->separator . "--";

        $email['message'] = $body;
        $email['headers'] = $headers;

        return $email;
    }

    /**
     * Process email
     *
     * @param $email
     * @return array
     */
    public function process_email( $email )
    {
        $email = $this->process_attachement( $email );

        return $email;
    }

    /**
     * Send email
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array $headers
     */
    public function send($to, $subject = 'ErgoPack', $body = '',  $headers = [])
    {
        if( empty($to) || empty($body) ) {
            return;
        }

        //error_log('[Email] pre-send ' . $to );

        // TODO: only for testing!
        //$to = 'lutz.eckardt@effecticore.de';
        //$to = 'ro.alabrudzinski@gmail.com';

        if( defined('ERGO_ORDER_EMAIL_FROM') && defined('ERGO_ORDER_EMAIL_FROMNAME') ) {
            $headers[] = 'Content-type: text/html; charset=utf-8' . "\r\n";
            //$headers[] = sprintf('From: %s <%s>', ERGO_ORDER_EMAIL_FROMNAME, ERGO_ORDER_EMAIL_FROM) . "\r\n";
        }

        add_filter('wp_mail', [$this, 'process_email'], 20, 1);

        $sent = wp_mail($to, $subject, $body, $headers);
        if (!$sent) {
            error_log('[Email] ups ' . $to );
            die('Ups...');
        }

        //error_log('[Email] sent ' . $to );

        remove_filter('wp_mail', [$this, 'process_email'], 20, 1);
    }
}