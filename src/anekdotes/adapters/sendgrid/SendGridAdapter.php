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
use Sengrid;

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
     * Return the default from field.
     *
     * @returns array the adress+name of the always from field
     */
    public function getAlwaysFrom()
    {
        return $this->from;
    }

    /*
     * Send an email!
     *
     * @param string $message   HTML Content with the message(body)
     * @param string $callback  Callback function to act on the message
     */
    public function send($message, $callback)
    {
    }
}
