<?php
/*
 * This file is part of the Mailer package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer\Adapters\Symfony;

use Anekdotes\Mailer\Adapters\MailerAdapter;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class SymfonyAdapter implements MailerAdapter
{
    /**
     * The default address and name messages will be sent from.
     *
     * @var array
     */
    protected $from;

    /**
     * The Symfony Mailer instance.
     *
     * @var \SymfonyMailer
     */
    protected $symfonyMailer;

    /**
     * Create a new Mailer instance.
     *
     * @param Mailer $symfonyMailer The SymfonyMailer instance to be used with the Mailer
     */
    public function __construct(Mailer $symfonyMailer)
    {
        $this->symfonyMailer = $symfonyMailer;
    }

    /**
     * Configure default from fields.
     *
     * @param string $email Email for the from field
     * @param string $name  Name for the from field
     */
    public function alwaysFrom($address, $name)
    {
        $this->from = compact('address', 'name');
    }

    /**
     * Send an email!
     *
     * @param string $message  HTML Content with the message(body)
     * @param string $callback Callback function to act on the message
     */
    public function send($htmlMessage, $callback)
    {
        $message = $this->createMessage();

        $this->callMessageBuilder($callback, $message);

        $message->setBody($htmlMessage, 'text/html');

        try {
            $this->symfonyMailer->send($message->getMessage());
        } 
        catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /*
     * Create a new message instance.
     *
     * @return SendGridEmailAdapter  Generated message instance
     */
    protected function createMessage()
    {
        $message = new SymfonyEmailAdapter(new \Symfony\Component\Mime\Email());

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
     * @param  \Closure   $callback  The function used (and called) to build the message
     * @param  Message    $message   The message to use and add the fields to
     */
    protected function callMessageBuilder($callback, $message)
    {
        if ($callback instanceof \Closure) {
            return call_user_func($callback, $message);
        }
        throw new \Exception('the Message Builder Callback is not valid.');
    }
}
