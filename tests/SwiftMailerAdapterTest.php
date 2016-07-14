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

use Anekdotes\Mailer\Adapters\SwiftMailer\SwiftMailerAdapter;
use PHPUnit_Framework_TestCase;

class SwiftMailerAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the SwiftMailer Adapter
    public function testInstantiateSwiftMailerAdapter()
    {
        $stub = $this->createMock(SwiftMailer::class);
        $swiftMailerAdapter = new SwiftMailerAdapter($stub);
        $this->assertInstanceOf(SwiftMailerAdapter::class, $swiftMailerAdapter);
    }
}
