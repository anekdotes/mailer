<?php
/*
 * This file is part of the Logger package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer;

/**
 * Main API Of the package. Controls the adapter through a simple API.
 */
class Mailer
{
    /**
     * The Mailing Adapter used by the mailer.
     *
     * @var Anekdotes\Mailer\Adapters\MailerAdapter
     */
    private $adapter;

    /**
     * Instantiate The Mailer and its adapter.
     *
     * @param Anekdotes\Mailer\Adapters\MailerAdapter The adapter to provide to the Mailer
     */
    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Calls the AlwaysFrom method of the adapter.
     *
     * @param string $email Email to pass to the adapter
     * @param string $name  Name to pass to the adapter 
     */
    public function alwaysFrom($email, $name){
        $this->adapter->alwaysFrom($email, $name);
    }

    /**
     * Calls the adapter's send method
     */
    public function send($message, $callback){
        $this->adapter->send($message, $callback);
    }
}
