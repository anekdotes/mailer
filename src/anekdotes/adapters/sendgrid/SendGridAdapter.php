<?php
/*
 * This file is part of the Logger package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer\Adapters\SendGrid;

use Anekdotes\Mailer\Adapters\MailerAdapter;
/**
 * Adapts the Sendgrid API to send
 */
class SendGridAdapter implements MailerAdapter
{
    /**
     * The default address and name messages will be sent from
     *
     * @var array
     */
    protected $from;

    /*
     * Configure default from fields
     *
     * @param string $email Email for the from field
     * @param string $name  Name for the from field
     */
    public function alwaysFrom($email, $name){
      $this->from = compact('address', 'name');
    }

    /*
     * Send an email!
     *
     * @param string $message   HTML Content with the message(body)
     * @param string $callback  Callback function to act on the message
     */
    public function send($message, $callback){
      
    }
}
