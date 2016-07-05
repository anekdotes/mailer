# Anekdotes Mailer 

[![Latest Stable Version](https://poser.pugx.org/anekdotes/mailer/v/stable)](https://packagist.org/packages/anekdotes/mailer)
[![Build Status](https://travis-ci.org/anekdotes/mailer.svg?branch=master)](https://travis-ci.org/anekdotes/mailer)
[![codecov.io](https://codecov.io/github/anekdotes/mailer/coverage.svg)](https://codecov.io/github/anekdotes/mailer?branch=master)
[![StyleCI](https://styleci.io/repos/62647499/shield?style=flat)](https://styleci.io/repos/62647499)
[![License](https://poser.pugx.org/anekdotes/mailer/license)](https://packagist.org/packages/anekdotes/mailer)
[![Total Downloads](https://poser.pugx.org/anekdotes/mailer/downloads)](https://packagist.org/packages/anekdotes/mailer)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/50134febcefe4cc78daf07ca45969728)](https://www.codacy.com/app/Grasseh/mailer?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=anekdotes/mailer&amp;utm_campaign=Badge_Grade)

Allows adaptation and abstraction of mailing APIs.

## Installation

Install via composer into your project:

    composer require anekdotes/sendgrid

## Basic Usage

You can either use the Mailer abstraction class to simplify adapter handling

```
    use Anekdotes\Mailer\Mailer;
    use Anekdotes\Mailer\Adapters\SendgridAdapter;

    $mailer = new Mailer(new SendgridAdapter('sendgridapikey'));
    $mailer->send('<p>My HTML message</p>',function($message){
        $message->from('me@you.com','Me');
            ->to('you@me.com','You');
            ->subject('This is a message'); 
    });

```

Or directly use an adapter
```
    use Anekdotes\Mailer\Adapters\SendgridAdapter;

    $sendgrid = new SendgridAdapter('sendgridapikey');
    $sendgrid->send('<p>My HTML message</p>',function($message){
        $message->from('me@you.com','Me');
            ->to('you@me.com','You');
            ->subject('This is a message'); 
    });

```
