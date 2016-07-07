<?php

/*
 * This file is part of the Logger package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Anekdotes\Mailer\Adapters\SendGrid\SendGridEmailAdapter;
use PHPUnit_Framework_TestCase;
use SendGrid\Mail;
use SendGrid\Personalization;

class SendGridEmailAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the Sendgrid Email Adapter
    public function testInstantiateSGEmailAdapter()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertInstanceOf(SendGridEmailAdapter::class, $email);
        $reflection = new \ReflectionClass($email);
        $mail_prop = $reflection->getProperty('mail');
        $perso_prop = $reflection->getProperty('personalization');
        $mail_prop->setAccessible(true);
        $perso_prop->setAccessible(true);
        $this->assertEquals($mailStub, $mail_prop->getValue($email));
        $this->assertEquals($persoStub, $perso_prop->getValue($email));
    }

    public function testSGEmailSend()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $mailStub->expects($this->once())->method('addPersonalization');
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertEquals($mailStub, $email->getSendGridEmail());
    }

    public function testSGEmailTo()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $persoStub->expects($this->once())->method('addTo')->with(
          $this->callback(function ($subject) {
              return $subject instanceof \SendGrid\Email;
          }));
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertEquals($email, $email->to('a@b.c', 'abc'));
    }

    public function testSGEmailFrom()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $mailStub->expects($this->once())->method('setFrom')->with(
          $this->callback(function ($subject) {
              return $subject instanceof \SendGrid\Email;
          }));
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertEquals($email, $email->from('a@b.c', 'abc'));
    }

    public function testSGEmailAddCC()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $persoStub->expects($this->once())->method('addCc')->with(
          $this->callback(function ($subject) {
              return $subject instanceof \SendGrid\Email;
          }));
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertEquals($email, $email->addCc('a@b.c', 'abc'));
    }

    public function testSGEmailAddBCC()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $persoStub->expects($this->once())->method('addBcc')->with(
          $this->callback(function ($subject) {
              return $subject instanceof \SendGrid\Email;
          }));
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertEquals($email, $email->addBcc('a@b.c', 'abc'));
    }

    public function testSGEmailSubject()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $persoStub->expects($this->once())->method('setSubject')->with(
          $this->equalTo('Subjectt')
        );
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertEquals($email, $email->subject('Subjectt'));
    }

    public function testSGEmailsetBody()
    {
        $mailStub = $this->createMock(Mail::class);
        $persoStub = $this->createMock(Personalization::class);
        $mailStub->expects($this->once())->method('addContent')->with(
          $this->callback(function ($subject) {
              return $subject instanceof \SendGrid\Content;
          }));
        $email = new SendGridEmailAdapter($mailStub, $persoStub);
        $this->assertEquals($email, $email->setBody('text/html', '<div>kk</div>'));
    }
}
