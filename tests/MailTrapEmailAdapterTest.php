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

use Anekdotes\Mailer\Adapters\MailTrap\MailTrapEmailAdapter;
use PHPUnit_Framework_TestCase;
use Illuminate\Mail\Message;

class MailTrapEmailAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the MailTrap Email Adapter
    public function testInstantiateMTEmailAdapter()
    {
        $mailStub = $this->createMock(Message::class);
        $email = new MailTrapEmailAdapter($mailStub);
        $this->assertInstanceOf(MailTrapEmailAdapter::class, $email);
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('mail');
        $mailProp->setAccessible(true);
        $this->assertEquals($mailStub, $mailProp->getValue($email));
    }

    public function testMTEmailSend()
    {
        $mailStub = $this->createMock(Message::class);
        $email = new MailTrapEmailAdapter($mailStub);
        $this->assertEquals([], $email->getIlluminateEmails());
    }

    public function testMTEmailTo()
    {
        $mailStub = $this->createMock(Message::class);
        $email = new MailTrapEmailAdapter($mailStub);
        $email->to('a@b.c','abc');
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('tos');
        $mailProp->setAccessible(true);
        $this->assertEquals([['a@b.c','abc']], $mailProp->getValue($email));
    }

    public function testMTEmailFrom()
    {
        $mailStub = $this->createMock(Message::class);
        $mailStub->expects($this->once())->method('from')->with('a@b.c','abc');
        $email = new MailTrapEmailAdapter($mailStub);
        $email->from('a@b.c', 'abc');
    }

    public function testMTEmailAddCC()
    {
        $mailStub = $this->createMock(Message::class);
        $email = new MailTrapEmailAdapter($mailStub);
        $email->addCc('a@b.c','abc');
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('tos');
        $mailProp->setAccessible(true);
        $this->assertEquals([['a@b.c','abc']], $mailProp->getValue($email));
    }

    public function testMTEmailAddBCC()
    {
        $mailStub = $this->createMock(Message::class);
        $email = new MailTrapEmailAdapter($mailStub);
        $email->addBcc('a@b.c','abc');
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('tos');
        $mailProp->setAccessible(true);
        $this->assertEquals([['a@b.c','abc']], $mailProp->getValue($email));
    }

    public function testMTEmailSubject()
    {
        $mailStub = $this->createMock(Message::class);
        $mailStub->expects($this->once())->method('subject')->with(
          $this->equalTo('Subjectt')
        );
        $email = new MailTrapEmailAdapter($mailStub);
        $this->assertEquals($email, $email->subject('Subjectt'));
    }

    public function testMTEmailsetBody()
    {
        $mailStub = $this->createMock(Message::class);
        $mailStub->expects($this->once())->method('__call')->with('setBody',['<div>kk</div>','text/html']);
        $email = new MailTrapEmailAdapter($mailStub);
        $this->assertEquals($email, $email->setBody('<div>kk</div>', 'text/html'));
    }
}
