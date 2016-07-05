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

use Anekdotes\Mailer\Mailer;
use Anekdotes\Mailer\Adapters\MailerAdapter;
use PHPUnit_Framework_TestCase;

class MailerTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the Mailer
    public function testInstantiateMailer()
    {
        $stub = $this->createMock(MailerAdapter::class);
        $mailer = new Mailer($stub);
        $this->assertInstanceOf(Mailer::class,$mailer);
    }
}
