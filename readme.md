# Anekdotes Mailer 

[![Latest Stable Version](https://poser.pugx.org/anekdotes/mailer/v/stable)](https://packagist.org/packages/anekdotes/mailer)
[![Build Status](https://travis-ci.org/anekdotes/mailer.svg?branch=master)](https://travis-ci.org/anekdotes/mailer)
[![codecov.io](https://codecov.io/github/anekdotes/mailer/coverage.svg)](https://codecov.io/github/anekdotes/mailer?branch=master)
[![StyleCI](https://styleci.io/repos/62647499/shield?style=flat)](https://styleci.io/repos/62647499)
[![License](https://poser.pugx.org/anekdotes/mailer/license)](https://packagist.org/packages/anekdotes/mailer)
[![Total Downloads](https://poser.pugx.org/anekdotes/mailer/downloads)](https://packagist.org/packages/anekdotes/mailer)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/50134febcefe4cc78daf07ca45969728)](https://www.codacy.com/app/Grasseh/mailer?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=anekdotes/mailer&amp;utm_campaign=Badge_Grade)

Allows adaptation and abstraction of mailing APIs. The goal of this project is to unify different Mailer APIs into a unified Send function. 
In otherwords, this Mailer allows to only have to change the Mailer instantion if a different API needs to be used, without needing to changed the Send Messages calls.

## Installation

Install via composer into your project:

    composer require anekdotes/mailer

## Basic Usage

You can either use the Mailer abstraction class to simplify adapter handling

```
    use Anekdotes\Mailer\Mailer;
    use Anekdotes\Mailer\Adapters\SendgridAdapter;
    use Sendgrid\Sendgrid;

    $mailer = new Mailer(new SendgridAdapter(new SendGrid('sendgridapikey')));
    $mailer->send('<p>My HTML message</p>',function($message){
        $message->from('me@you.com','Me');
            ->to('you@me.com','You');
            ->subject('This is a message'); 
    });

```

Or directly use an adapter
```
    use Anekdotes\Mailer\Adapters\SendgridAdapter;

    $sendgrid = new SendgridAdapter(new SendGrid('sendgridapikey'));

    $sendgrid->send('<p>My HTML message</p>',function($message){
        $message->from('me@you.com','Me');
            ->to('you@me.com','You');
            ->subject('This is a message'); 
    });

```

## Adapters

The following adapters are currently available for use :

### SendgridAdapter

```
    use Anekdotes\Mailer\Mailer;
    use Anekdotes\Mailer\Adapters\SendgridAdapter;
    use Sendgrid\Sendgrid;

    $mailer = new Mailer(new SendgridAdapter(new SendGrid('sendgridapikey')));
    $mailer->send('<p>My HTML message</p>',function($message){
        $message->from('me@you.com','Me');
            ->to('you@me.com','You');
            ->subject('This is a message'); 
    });

```

###SwiftMailerAdapter

```
    use Anekdotes\Mailer\Mailer;
    use Anekdotes\Mailer\Adapters\SwiftMailerAdapter;
    use \Swift_Mailer;
    use \Swift_SmtpTransport;

    $mailer = new Mailer(new SendgridAdapter(new Swift_Mailer(Swift_SmtpTransport::newInstance('smtp.example.org', 25)
        ->setUsername('your username')
        ->setPassword('your password'))));
    $mailer->send('<p>My HTML message</p>',function($message){
        $message->from('me@you.com','Me');
            ->to('you@me.com','You');
            ->subject('This is a message'); 
    });

```
