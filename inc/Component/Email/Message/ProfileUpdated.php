<?php
namespace TLESearch\Email\Message;

use TLESearch\Email\Email;

/**
 * Class ProfileUpdated
 *
 * @author 11bytes
 * @since 1.2.7
 */

class ProfileUpdated extends AbstractMessage implements MessageInterface
{
    /**
     * Send emails
     */
    public function send()
    {
        $title = 'Profile updated';
        $to    = $this->recipient;
        $body  = $this->message;

        // Send email
        $email = new Email($this->separator);
        $email->send($to, $title, $body);
    }
}