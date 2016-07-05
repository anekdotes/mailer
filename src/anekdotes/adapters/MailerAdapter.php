<?php
/*
 * This file is part of the Logger package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Mailer\Adapters;

/**
 * Interface used by the Mailer to handle Emails.
 */
interface MailerAdapter
{
  /*
   * Configure default from fields
   *
   * @param string $email Email for the from field
   * @param string $name  Name for the from field
   */
  public function alwaysFrom($email, $name);
}
