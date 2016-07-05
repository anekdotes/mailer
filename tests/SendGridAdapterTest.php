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
use SendGrid;
use PHPUnit_Framework_TestCase;

class SendGridAdapterTest extends PHPUnit_Framework_TestCase
{
    //Tests the instantion of the Sendgrid Adapter
    public function testInstantiateSendgridAdapter()
    {
        $stub = $this->createMock(SendGrid::class);
        $sendgridAdapter = new SendGridAdapter($stub);
        $this->assertInstanceOf(SendGridAdapter::class, $sendgridAdapter);
    }
}
