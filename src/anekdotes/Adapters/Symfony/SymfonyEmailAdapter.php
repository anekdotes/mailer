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

use Anekdotes\File\File;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SymfonyEmailAdapter
{
    /*
     * Contains the custom details of the email
     * @var \Symfony\Component\Mime\Email
     */
    private $message;

    public function __construct(Email $message)
    {
        $this->message = $message;
    }

    /**
     * Builds the email and return it as a SendGrid Mail Instance!
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Add a new recipient in the "To" email field.
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function to($email, $name)
    {
        $this->message->addTo(new Address($email, $name));

        return $this;
    }

    /**
     * Change the sender's name+email in the "From" email field.
     *
     * @param string $name  Name of the sender
     * @param string $email Email of the sender
     */
    public function from($email, $name)
    {
        $this->message->from(new Address($email, $name));

        return $this;
    }

    /**
     * Change the sender's name+email in the "ReplyTo" email field.
     *
     * @param string $name  Name of the sender
     * @param string $email Email of the sender
     */
    public function replyTo($email, $name)
    {
        $this->message->addReplyTo(new Address($email, $name));

        return $this;
    }

    public function setReplyTo($email, $name)
    {
        return $this->replyTo($email, $name);
    }

    /**
     * Add a CC recipient.
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function addCc($email, $name)
    {
        $this->message->addCc(new Address($email, $name));

        return $this;
    }

    /**
     * Add a BCC recipient.
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function addBcc($email, $name)
    {
        $this->message->addBcc(new Address($email, $name));

        return $this;
    }

    /**
     * Add a returnPath recipient.
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function returnPath($email, $name)
    {
        $this->message->returnPath(new Address($email, $name));

        return $this;
    }

    /**
     * Set a Subject.
     *
     * @param string $subject Subject
     */
    public function subject($subject)
    {
        $this->message->subject($subject);

        return $this;
    }

    /**
     * Set the content.
     *
     * @param string $content Content
     * @param string $type    Content type (i.e. text/html)
     */
    public function setBody($content, $type)
    {
        if ($type == 'text/html') {
            $this->message->html($content);
        }
        else {
            $this->message->text($content);
        }

        return $this;
    }

    /**
     * Set the attachement.
     *
     * @param string $path
     */
    public function attach($file)
    {
        if (File::exists($file)) {
            $this->message->attachFromPath($file);
        }

        return $this;
    }
}
