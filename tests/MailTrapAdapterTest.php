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

use Anekdotes\Mailer\Adapters\MailTrap\MailTrapAdapter;
use PHPUnit_Framework_TestCase;
use Swift_Mailer;
use Swift_SmtpTransport;

class MailTrapAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the SwiftMailer Adapter
    public function testInstantiateMailTrapAdapter()
    {
        $stub = $this->createMock(Swift_Mailer::class);
        $mailTrapAdapter = new MailTrapAdapter($stub);
        $this->assertInstanceOf(MailTrapAdapter::class, $mailTrapAdapter);
    }

    //Sets the Adapter with AlwaysFrom
    public function testAlwaysFromMailTrapAdapter()
    {
        $stub = $this->createMock(Swift_Mailer::class);
        $mailTrapAdapter = new MailTrapAdapter($stub);
        $mailTrapAdapter->alwaysFrom('a@b.c', 'abc');
        $reflection = new \ReflectionClass($mailTrapAdapter);
        $reflectionProperty = $reflection->getProperty('from');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals(
          ['address' => 'a@b.c', 'name' => 'abc'],
          $reflectionProperty->getValue($mailTrapAdapter)
        );
    }

    //Tests that send Sends a message
    public function testSend()
    {
        $swiftMailer = new \ReflectionClass('Swift_Mailer');
        $transportReflection = $swiftMailer->getProperty('_transport');
        $swiftMailerStub = $this->createMock(Swift_Mailer::class);
        $swiftMailerStub->expects($this->once())
                   ->method('send')
                   ->willReturn(true);
        $transportStub = $this->getMockBuilder(Swift_SmtpTransport::class)
                           ->setMethods(['send', '__construct'])
                           ->disableOriginalConstructor()
                           ->getMock();
        $transportReflection->setAccessible(true);
        $transportReflection->setValue($swiftMailerStub, $transportStub);
        $mailTrapAdapter = new MailTrapAdapter($swiftMailerStub);
        $this->assertTrue(
            $mailTrapAdapter->send('<div>blabla</div>', function ($message) {
                $message->to('a@b.c', 'abc');
                $message->from('a@b.d', 'abd');
            }));
    }

    public function testSendWithAlwaysFromSwiftMailer()
    {
        $swiftMailer = new \ReflectionClass('Swift_Mailer');
        $transportReflection = $swiftMailer->getProperty('_transport');
        $swiftMailerStub = $this->createMock(Swift_Mailer::class);
        $swiftMailerStub->expects($this->once())
                   ->method('send')
                   ->willReturn(true);
        $transportStub = $this->getMockBuilder(Swift_SmtpTransport::class)
                           ->setMethods(['send', '__construct'])
                           ->disableOriginalConstructor()
                           ->getMock();
        $transportReflection->setAccessible(true);
        $transportReflection->setValue($swiftMailerStub, $transportStub);
        $mailTrapAdapter = new MailTrapAdapter($swiftMailerStub);
        $mailTrapAdapter->alwaysFrom('b@a.c', 'bac');
        $this->assertTrue(
            $mailTrapAdapter->send('<div>blabla</div>', function ($message) {
                $message->to('a@b.c', 'abc');
            }));
    }

    public function testInvalidClosureMessageBuilder()
    {
        $swiftMailer = new \ReflectionClass('Swift_Mailer');
        $transportReflection = $swiftMailer->getProperty('_transport');
        $swiftMailerStub = $this->createMock(Swift_Mailer::class);
        $transportStub = $this->getMockBuilder(Swift_SmtpTransport::class)
                           ->setMethods(['send', '__construct'])
                           ->disableOriginalConstructor()
                           ->getMock();
        $transportReflection->setAccessible(true);
        $transportReflection->setValue($swiftMailerStub, $transportStub);
        $this->setExpectedException('\Exception');
        $mailTrapAdapter = new MailTrapAdapter($swiftMailerStub);
        $mailTrapAdapter->send('<div>blabla</div>', 'blabla');
    }
}
