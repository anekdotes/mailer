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

use Anekdotes\Mailer\Adapters\Symfony\SymfonyAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport as SymfonyTransport;

final class SymfonyAdapterTest extends TestCase
{
    /**
     * @before
     */
    public function setupSomeFixtures(): void
    {
        \DG\BypassFinals::enable();
    }

    //Tests the instantion of the SwiftMailer Adapter
    public function testInstantiateSymfonyAdapter()
    {
        $stub = $this->createMock(SymfonyMailer::class);
        $symfonyMailerAdapter = new SymfonyAdapter($stub);
        $this->assertInstanceOf(SymfonyAdapter::class, $symfonyMailerAdapter);
    }

    //Sets the Adapter with AlwaysFrom
    public function testAlwaysFromSymfonyAdapter()
    {
        $stub = $this->createMock(SymfonyMailer::class);
        $symfonyMailerAdapter = new SymfonyAdapter($stub);
        $symfonyMailerAdapter->alwaysFrom('a@b.c', 'abc');
        $reflection = new \ReflectionClass($symfonyMailerAdapter);
        $reflectionProperty = $reflection->getProperty('from');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals(
          ['address' => 'a@b.c', 'name' => 'abc'],
          $reflectionProperty->getValue($symfonyMailerAdapter)
        );
    }
}
