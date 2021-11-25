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

use Anekdotes\File\File;

class SendGridEmailAdapter
{
    /*
     * Contains the mail instance to be sent. This is what gets adapted
     * @var \SendGrid\Mail
     */
    private $mail;

    /*
     * Constructor. Instanciates the mail
     *
     * @param \SendGrid\Mail\Mail $mail Mail object that will be sent
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Builds the email and return it as a SendGrid Mail Instance!
     */
    public function getSendGridEmail()
    {
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
        $this->mail->addTo($email, $name);

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
        $this->mail->setFrom($email, $name);

        return $this;
    }

    /**
     * Change the sender's name+email in the "ReplyTo" email field.
     *
     * @param string $name  Name of the sender
     * @param string $email Email of the sender
     */
    public function setReplyTo($email, $name)
    {
        $this->mail->setReplyTo($email, $name);

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
        $this->mail->addCc($email, $name);

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
        $this->mail->addBcc($email, $name);

        return $this;
    }

    /**
     * Set a Subject.
     *
     * @param string $subject Subject
     */
    public function subject($subject)
    {
        $this->mail->setSubject($subject);

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
        $this->mail->addContent($type, $content);

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
            $filename = explode('/', $file)[count(explode('/', $file)) - 1];
            $mime = $this->mime_content_type($file);
            $fileEncoded = base64_encode(File::get($file));

            $this->mail->addAttachment($fileEncoded, $mime, $filename, 'attachment');
        }

        return $this;
    }

    private function mime_content_type($filename)
    {
        $mime_types = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        $explodedfile = explode('.', $filename);
        $ext = strtolower(array_pop($explodedfile));

        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        else {
            return 'application/octet-stream';
        }
    }
}
