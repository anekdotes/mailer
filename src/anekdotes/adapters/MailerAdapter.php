<?php
/*
 * This file is part of the Mailer package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer\Adapters;

/**
 * Interface used by the Mailer to handle Emails.
 */
interface MailerAdapter
{
    /*
     * Configure default from fields
     *
     * @param string $email Email for the from field
     * @param string $name  Name for the from field
     */
    public function alwaysFrom($email, $name);

    /*
     * Send an email!
     *
     * @param string $message   HTML Content with the message(body)
     * @param string $callback  Callback function to act on the message
     */
    public function send($message, $callback);
}
