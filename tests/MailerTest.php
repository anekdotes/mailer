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

use Anekdotes\Mailer\Adapters\MailerAdapter;
use Anekdotes\Mailer\Mailer;
use PHPUnit_Framework_TestCase;

class MailerTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the Mailer
    public function testInstantiateMailer()
    {
        $stub = $this->createMock(MailerAdapter::class);
        $mailer = new Mailer($stub);
        $this->assertInstanceOf(Mailer::class, $mailer);
    }

    //Sets the Adapter with AlwaysFrom
    public function testAlwaysFrom()
    {
        $stub = $this->createMock(MailerAdapter::class);
        $stub->expects($this->once())->method('alwaysFrom');

        $mailer = new Mailer($stub);
        $mailer->alwaysFrom('a@b.c', 'abc');
    }

    //Tests that send calls the Adapter's send method
    public function testSend()
    {
        $stub = $this->createMock(MailerAdapter::class);
        $stub->expects($this->once())->method('send');

        $mailer = new Mailer($stub);
        $mailer->send('<div>blabla</div>', function ($message) {
            $message->blabla();
        });
    }
}
