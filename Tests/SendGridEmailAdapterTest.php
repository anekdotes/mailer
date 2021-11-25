<?php

/*
 * This file is part of the Mailer package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Anekdotes\Mailer\Adapters\Sendgrid\SendGridEmailAdapter;
use PHPUnit\Framework\TestCase;
use SendGrid\Mail\Mail;

final class SendGridEmailAdapterTest extends TestCase
{
    //Tests the instantion of the Sendgrid Email Adapter
    public function testInstantiateSGEmailAdapter()
    {
        $mailStub = $this->createMock(Mail::class);
        $email = new SendGridEmailAdapter($mailStub);

        $this->assertInstanceOf(SendGridEmailAdapter::class, $email);

        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('mail');
        $mailProp->setAccessible(true);

        $this->assertEquals($mailStub, $mailProp->getValue($email));
    }

    public function testSGEmailSend()
    {
        $mailStub = $this->createMock(Mail::class);
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($mailStub, $email->getSendGridEmail());
    }

    public function testSGEmailTo()
    {
        $mailStub = $this->createMock(Mail::class);
        $mailStub->expects($this->once())->method('addTo')->with(
          $this->callback(function ($subject) {
              return is_string($subject);
          }));
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($email, $email->to('a@b.c', 'abc'));
    }

    public function testSGEmailFrom()
    {
        $mailStub = $this->createMock(Mail::class);
        $mailStub->expects($this->once())->method('setFrom')->with(
          $this->callback(function ($subject) {
              return is_string($subject);
          }));
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($email, $email->from('a@b.c', 'abc'));
    }

    public function testSGEmailAddCC()
    {
        $mailStub = $this->createMock(Mail::class);
        $mailStub->expects($this->once())->method('addCc')->with(
          $this->callback(function ($subject) {
              return is_string($subject);
          }));
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($email, $email->addCc('a@b.c', 'abc'));
    }

    public function testSGEmailAddBCC()
    {
        $mailStub = $this->createMock(Mail::class);
        $mailStub->expects($this->once())->method('addBcc')->with(
          $this->callback(function ($subject) {
              return is_string($subject);
          }));
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($email, $email->addBcc('a@b.c', 'abc'));
    }

    public function testSGEmailSubject()
    {
        $mailStub = $this->createMock(Mail::class);
        $mailStub->expects($this->once())->method('setSubject')->with(
          $this->equalTo('Subjectt')
        );
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($email, $email->subject('Subjectt'));
    }

    public function testSGEmailsetBody()
    {
        $mailStub = $this->createMock(Mail::class);
        $mailStub->expects($this->once())->method('addContent')->with(
          $this->callback(function ($subject) {
              return is_string($subject);
          }));
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($email, $email->setBody('text/html', '<div>kk</div>'));
    }

    public function testSGEMailAttach()
    {
        $mailStub = $this->createMock(Mail::class);
        $mailStub->expects($this->once())->method('addAttachment')->with(
          $this->callback(function ($subject) {
              return is_string($subject);
          }));
        $email = new SendGridEmailAdapter($mailStub);
        $this->assertEquals($email, $email->attach('Tests/input/input.txt'));
    }
}
