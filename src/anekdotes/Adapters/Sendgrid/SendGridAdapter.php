<?php
/*
 * This file is part of the Mailer package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer\Adapters\Sendgrid;

use Anekdotes\Mailer\Adapters\MailerAdapter;
use SendGrid\Mail\Mail;

/**
 * Adapts the Sendgrid API to send.
 */
class SendGridAdapter implements MailerAdapter
{
    /**
     * The default address and name messages will be sent from.
     *
     * @var array
     */
    protected $from;

    /**
     * Sendgrid instance we're adapting.
     *
     * @var Sengrid
     */
    protected $sendgrid;

    /**
     * Instanciates the adapter with its Sendgrid control.
     *
     * @param \Sendgrid $sendgrid Instance of sendgrid mail api
     */
    public function __construct($sengrid)
    {
        $this->sendgrid = $sengrid;
    }

    /*
     * Configure default from fields.
     *
     * @param string $address Email for the from field
     * @param string $name  Name for the from field
     */
    public function alwaysFrom($address, $name)
    {
        $this->from = compact('address', 'name');
    }

    /*
     * Send an email!
     *
     * @param string $htmlMessage   HTML Content with the message(body)
     * @param string $callback  Callback function to act on the message
     */
    public function send($htmlMessage, $callback)
    {
        $message = $this->createMessage();
        $this->callMessageBuilder($callback, $message);
        $message->setBody($htmlMessage, 'text/html');

        return $this->sendgrid->client->mail()->send()->post($message->getSendGridEmail());
    }

    /*
     * Create a new message instance.
     *
     * @return SendGridEmailAdapter  Generated message instance
     */
    protected function createMessage()
    {
        $message = new SendGridEmailAdapter(new Mail());

        // If a global from address has been specified we will set it on every message
        // instances so the developer does not have to repeat themselves every time
        // they create a new message. We will just go ahead and push the address.
        if (isset($this->from['address'])) {
            $message->from($this->from['address'], $this->from['name']);
        }

        return $message;
    }

    /*
     * Build the message with its fields using a callback
     *
     * @param  \Closure                   $callback  The function used (and called) to build the message
     * @param  SendGridEmailAdapter  $message   The message to use and add the fields to
     */
    protected function callMessageBuilder($callback, $message)
    {
        if ($callback instanceof \Closure) {
            return call_user_func($callback, $message);
        }
        throw new \Exception('the Message Builder Callback is not valid.');
    }
}
