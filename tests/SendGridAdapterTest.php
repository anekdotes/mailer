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

use Anekdotes\Mailer\Adapters\SendGrid\SendGridAdapter;
use PHPUnit_Framework_TestCase;
use SendGrid;
use SendGrid\Client;

class SendGridAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the Sendgrid Adapter
    public function testInstantiateSendgridAdapter()
    {
        $stub = $this->createMock(SendGrid::class);
        $sendgridAdapter = new SendGridAdapter($stub);
        $this->assertInstanceOf(SendGridAdapter::class, $sendgridAdapter);
    }

    //Sets the Adapter with AlwaysFrom
    public function testAlwaysFromSendgridAdapter()
    {
        $stub = $this->createMock(SendGrid::class);
        $sendgridAdapter = new SendGridAdapter($stub);
        $sendgridAdapter->alwaysFrom('a@b.c', 'abc');
        $reflection = new \ReflectionClass($sendgridAdapter);
        $reflection_property = $reflection->getProperty('from');
        $reflection_property->setAccessible(true);
        $this->assertEquals(
          ['address' => 'a@b.c', 'name' => 'abc'],
          $reflection_property->getValue($sendgridAdapter)
        );
    }

    //Tests that send Sends a message
    public function testSend()
    {
        $sendgrid = new \ReflectionClass('Sendgrid');
        $clientReflection = $sendgrid->getProperty('client');
        $sendgridStub = $this->createMock(SendGrid::class);
        $clientStub = $this->getMockBuilder(Client::class)
                           ->setMethods(['mail', '__construct'])
                           ->disableOriginalConstructor()
                           ->getMock();
        $clientStub->expects($this->once())
                   ->method('mail')
                   ->willReturn(new SendMock());
        $clientReflection->setAccessible(true);
        $clientReflection->setValue($sendgridStub, $clientStub);
        $sendgridAdapter = new SendGridAdapter($sendgridStub);
        $this->assertTrue(
            $sendgridAdapter->send('<div>blabla</div>', function ($message) {
                $message->to('a@b.c', 'abc');
            }));
    }
}

class SendMock
{
    public function send()
    {
        return new self();
    }

    public function post($whatevs)
    {
        return true;
    }
}
