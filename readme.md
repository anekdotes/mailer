# Anekdotes Mailer 

[![Latest Stable Version](http://poser.pugx.org/anekdotes/mailer/v)](https://packagist.org/packages/anekdotes/mailer)
[![Total Downloads](http://poser.pugx.org/anekdotes/mailer/downloads)](https://packagist.org/packages/anekdotes/mailer)
[![License](http://poser.pugx.org/anekdotes/mailer/license)](https://packagist.org/packages/anekdotes/mailer)
[![PHP Version Require](http://poser.pugx.org/anekdotes/mailer/require/php)](https://packagist.org/packages/anekdotes/mailer)

Allows adaptation and abstraction of mailing APIs. The goal of this project is to unify different Mailer APIs into a unified Send function. 
In otherwords, this Mailer allows to only have to change the Mailer instantion if a different API needs to be used, without needing to change the Send Messages calls.

## Installation

Install via composer into your project:

    composer require anekdotes/mailer

## Basic Usage

You can either use the Mailer abstraction class to simplify adapter handling

```php
use Anekdotes\Mailer\Mailer;
use Anekdotes\Mailer\Adapters\SendgridAdapter;
use Sendgrid\Sendgrid;

$mailer = new Mailer(new SendgridAdapter(new SendGrid('sendgridapikey')));
$mailer->send('<p>My HTML message</p>',function($message){
    $message->from('me@you.com','Me')
        ->to('you@me.com','You')
        ->subject('This is a message'); 
});
```

Or directly use an adapter
```php
use Anekdotes\Mailer\Adapters\SendgridAdapter;

$sendgrid = new SendgridAdapter(new SendGrid('sendgridapikey'));

$sendgrid->send('<p>My HTML message</p>',function($message){
    $message->from('me@you.com','Me')
        ->to('you@me.com','You')
        ->subject('This is a message'); 
});

```

## Adapters

The following adapters are currently available for use :

### SendgridAdapter

```php
use Anekdotes\Mailer\Mailer;
use Anekdotes\Mailer\Adapters\SendgridAdapter;
use Sendgrid\Sendgrid;

$mailer = new Mailer(new SendgridAdapter(new SendGrid('sendgridapikey')));
$mailer->send('<p>My HTML message</p>',function($message){
    $message->from('me@you.com','Me')
        ->to('you@me.com','You')
        ->subject('This is a message'); 
});
```

###SymfonyAdapter

```php
use Anekdotes\Mailer\Mailer;
use Anekdotes\Mailer\Adapters\Symfony\SymfonyAdapter;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport as SymfonyTransport;

$dsn = 'smtp://user:pass@smtp.example.com:25';
$symfonyTransport = SymfonyTransport::fromDsn($dsn);
$symfonyMailer = new SymfonyMailer($symfonyTransport);
$mailer = new Mailer(new SymfonyAdapter($symfonyMailer));
$mailer->send('<p>My HTML message</p>',function($message){
    $message->from('me@you.com','Me')
        ->to('you@me.com','You')
        ->subject('This is a message'); 
});
```

```php
use Anekdotes\Mailer\Mailer;
use Anekdotes\Mailer\Adapters\SwiftMailerAdapter;
use \Swift_Mailer;
use \Swift_SmtpTransport;

$mailer = new Mailer(new SwiftMailerAdapter(new Swift_Mailer(Swift_SmtpTransport::newInstance('smtp.example.org', 25)
    ->setUsername('your username')
    ->setPassword('your password'))));
$mailer->send('<p>My HTML message</p>',function($message){
    $message->from('me@you.com','Me')
        ->to('you@me.com','You')
        ->subject('This is a message'); 
});
```

###MailTrapAdapter

Removed as of `2.0.0`