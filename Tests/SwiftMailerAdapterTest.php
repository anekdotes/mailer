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

use Anekdotes\Mailer\Adapters\Swiftmailer\SwiftMailerAdapter;
use PHPUnit_Framework_TestCase;
use Swift_Mailer;
use Swift_SmtpTransport;

class SwiftMailerAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the SwiftMailer Adapter
    public function testInstantiateSwiftMailerAdapter()
    {
        $stub = $this->createMock(Swift_Mailer::class);
        $swiftMailerAdapter = new SwiftMailerAdapter($stub);
        $this->assertInstanceOf(SwiftMailerAdapter::class, $swiftMailerAdapter);
    }

    //Sets the Adapter with AlwaysFrom
    public function testAlwaysFromSwiftMailerAdapter()
    {
        $stub = $this->createMock(Swift_Mailer::class);
        $swiftMailerAdapter = new SwiftMailerAdapter($stub);
        $swiftMailerAdapter->alwaysFrom('a@b.c', 'abc');
        $reflection = new \ReflectionClass($swiftMailerAdapter);
        $reflectionProperty = $reflection->getProperty('from');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals(
          ['address' => 'a@b.c', 'name' => 'abc'],
          $reflectionProperty->getValue($swiftMailerAdapter)
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
        $swiftMailerAdapter = new SwiftMailerAdapter($swiftMailerStub);
        $this->assertTrue(
            $swiftMailerAdapter->send('<div>blabla</div>', function ($message) {
                $message->to('a@b.c', 'abc');
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
        $swiftMailerAdapter = new SwiftMailerAdapter($swiftMailerStub);
        $swiftMailerAdapter->alwaysFrom('b@a.c', 'bac');
        $this->assertTrue(
            $swiftMailerAdapter->send('<div>blabla</div>', function ($message) {
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
        $swiftMailerAdapter = new SwiftMailerAdapter($swiftMailerStub);
        $swiftMailerAdapter->send('<div>blabla</div>', 'blabla');
    }
}
