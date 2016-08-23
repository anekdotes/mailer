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

use Anekdotes\Mailer\Adapters\Mailtrap\MailTrapEmailAdapter;
use PHPUnit_Framework_TestCase;

class MailTrapEmailAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the MailTrap Email Adapter
    public function testInstantiateMTEmailAdapter()
    {
        $email = new MailTrapEmailAdapter();
        $this->assertInstanceOf(MailTrapEmailAdapter::class, $email);
    }

    public function testMTEmailSend()
    {
        $email = new MailTrapEmailAdapter();
        $this->assertEquals([], $email->getIlluminateEmails());
    }

    public function testMTEmailTo()
    {
        $email = new MailTrapEmailAdapter();
        $email->to('a@b.c', 'abc');
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('tos');
        $mailProp->setAccessible(true);
        $this->assertEquals([['a@b.c', 'abc']], $mailProp->getValue($email));
    }

    public function testMTEmailFrom()
    {
        $email = new MailTrapEmailAdapter();
        $email->from('a@b.c', 'abc');
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('from');
        $mailProp->setAccessible(true);
        $this->assertEquals(['email' => 'a@b.c', 'name' => 'abc'], $mailProp->getValue($email));
    }

    public function testMTEmailAddCC()
    {
        $email = new MailTrapEmailAdapter();
        $email->addCc('a@b.c', 'abc');
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('tos');
        $mailProp->setAccessible(true);
        $this->assertEquals([['a@b.c', 'abc']], $mailProp->getValue($email));
    }

    public function testMTEmailAddBCC()
    {
        $email = new MailTrapEmailAdapter();
        $email->addBcc('a@b.c', 'abc');
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('tos');
        $mailProp->setAccessible(true);
        $this->assertEquals([['a@b.c', 'abc']], $mailProp->getValue($email));
    }

    public function testMTEmailSubject()
    {
        $email = new MailTrapEmailAdapter();
        $this->assertEquals($email, $email->subject('Subjectt'));
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('subject');
        $mailProp->setAccessible(true);
        $this->assertEquals('Subjectt', $mailProp->getValue($email));
    }

    public function testMTEmailsetBody()
    {
        $email = new MailTrapEmailAdapter();
        $this->assertEquals($email, $email->setBody('<div>kk</div>', 'text/html'));
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('body');
        $mailProp->setAccessible(true);
        $this->assertEquals(['content' => '<div>kk</div>', 'type' => 'text/html'], $mailProp->getValue($email));
    }

    public function testMTEmailsetFiles()
    {
        $email = new MailTrapEmailAdapter();
        $this->assertEquals($email, $email->attach('/upload/dummy.pdf'));
        $reflection = new \ReflectionClass($email);
        $mailProp = $reflection->getProperty('files');
        $mailProp->setAccessible(true);
        $this->assertEquals(['/upload/dummy.pdf'], $mailProp->getValue($email));
    }
}
