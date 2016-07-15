<?php

/*
 * This file is part of the Mailer package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer\Adapters\SendGrid;

class SendGridEmailAdapter
{
    /*
     * Contains the mail instance to be sent. This is what gets adapted
     * @var \SendGrid\Mail
     */
    private $mail;
    /*
     * Contains the custom details of the email
     * @var \SendGrid\Personalization
     */
    private $personalization;

    /*
     * Constructor. Instanciates the mail
     *
     * @param \SendGrid\Mail $mail Mail object that will be sent
     * @param \SendGrid\Personalization $personalization Additionnal contents to be added to the mail
     */
    public function __construct($mail, $personalization)
    {
        $this->mail = $mail;
        $this->personalization = $personalization;
    }

    /**
     * Builds the email and return it as a SendGrid Mail Instance!
     */
    public function getSendGridEmail()
    {
        $this->mail->addPersonalization($this->personalization);

        return $this->mail;
    }

    /**
     * Add a new recipient in the "To" email field.
     *
     * @param string $name  Name of the recipient
     * @param string $email Email of the recipient
     */
    public function to($email, $name)
    {
        $this->personalization->addTo(new \Sendgrid\Email($email, $name));

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
        $this->mail->setFrom(new \Sendgrid\Email($email, $name));

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
        $this->personalization->addCc(new \Sendgrid\Email($email, $name));

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
        $this->personalization->addBcc(new \Sendgrid\Email($email, $name));

        return $this;
    }

    /**
     * Set a Subject.
     *
     * @param string $subject Subject
     */
    public function subject($subject)
    {
        $this->personalization->setSubject($subject);

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
        $this->mail->addContent(new \Sendgrid\Content($type, $content));

        return $this;
    }
}
