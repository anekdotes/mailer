<?php

/*
 * This file is part of the Mailer package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer\Adapters\MailTrap;

use Illuminate\Mail\Message;
use Swift_Message;

class MailTrapEmailAdapter
{
    /*
     * Contains the emails to send this message to
     * @var array
     */
    private $tos;
    /*
     * Contains the shared email data
     * @var array
     */
    private $from;
    private $subject;
    private $body;

    /*
     * Constructor. Instanciates the mail
     *
     */
    public function __construct()
    {
        $this->tos = [];
        $this->from = '';
        $this->subject = '';
        $this->body = [];
    }

    /**
     * Builds the email array and return it as an array of all emails to be sent!!
     */
    public function getIlluminateEmails()
    {
        $emails = [];
        foreach ($this->tos as $destination) {
            $mail = new Message(new Swift_Message());
            $mail->to($destination[0], $destination[1]);
            $mail->from($this->from['email'], $this->from['name']);
            $mail->subject($this->subject);
            $mail->setBody($this->body['content'], $this->body['type']);
            $emails[] = $mail;
        }

        return $emails;
    }

    /**
     * Add a new recipient in the "Tos" array .
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function to($email, $name)
    {
        $this->tos[] = [$email, $name];

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
        $this->from = ['email' => $email, 'name' => $name];

        return $this;
    }

    /**
     * Add a CC recipient.
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function addCc($email, $name)
    {
        $this->tos[] = [$email, $name];

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
        $this->tos[] = [$email, $name];

        return $this;
    }

    /**
     * Set a Subject.
     *
     * @param string $subject Subject
     */
    public function subject($subject)
    {
        $this->subject = $subject;

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
        $this->body = ['content' => $content, 'type' => $type];

        return $this;
    }
}
