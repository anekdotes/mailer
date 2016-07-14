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

class MailTrapEmailAdapter
{
    /*
     * Contains the mail instance to be sent. This is what gets adapted
     * @var \Illuminate\Mail
     */
    private $mail;
    /*
     * Contains the emails to send this message to 
     * @var array
     */
    private $tos;

    /*
     * Constructor. Instanciates the mail
     *
     * @param \Illuminate\Mail $mail Mail object that will be sent(multiple times hehe)
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Builds the email array and return it as an array of all emails to be sent!!
     */
    public function getIlluminateEmails()
    {
        $emails = [];
        foreach($tos as $destination){
          $mailCopy = $mail;
          $mailCopy->to($destination);
          $emails[] = $mailCopy;
        }
        return $emails;
    }

    /**
     * Add a new recipient in the "Tos" array .
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function to($name, $email)
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
    public function from($name, $email)
    {
        $this->mail->from($email, $name);

        return $this;
    }

    /**
     * Add a CC recipient.
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function addCc($name, $email)
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
    public function addBcc($name, $email)
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
        $this->mail->subject($subject);

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
        $this->mail->setBody($type, $content);

        return $this;
    }
}
