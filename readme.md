# Skully PHP Framework

Skully Framework is a simple php framework you could use as a skeleton for any php project.

Skully project aims to teach its adapters best practices in PHP programming, and programming in general as adapters use it in their projects. We are a big fan of project [PHP The Right Way](http://phptherightway.com) so we built a framework around the concepts written there.

This framework uses [RedbeanPHP](http://redbeanphp.com) as its ORM and [Smarty](http://smarty.net) as its templating engine.

## What's So Good About Skully?

- We at Trio Digital Agency use Skully framework on all of our client projects, so you can expect a continuous development.
- One thing we particularly enjoy in using Skully is its separation of responsibilities: We can share a project's /public directory to our remote web developers and they can start doing their magic, while our in-house developers build its structure and back-end system.
- It is a compilation of best practices in software development.
- Easy to use command line tools (we use the symfony Command plugin for this), and additional tools you can add as you go. Examples below.
- Database migration, a great feature from Rails, is integrated with the help of Ruckusing module (which we tinkered with a bit).
- We think this is the best feature Skully offers: Clean integration with our favourite IDE: [PHP Storm](http://www.jetbrains.com/phpstorm/). Do you remember the days when you have to do find-from-all to find out where a class / method is inherited from? That days are long gone with Skully on PHP Storm.

## Setting Up

Within composer.json, add the following:
require: {
    "triodigital/skully": "dev-master"
}

## Project Structure

A Skully powered projects are normally structured as follows:

- App
    * Commands
    * Controllers
    * Crons
    * Helpers
    * Models
    * smarty
        - plugins
    * Tests
    * Application.php
- library
- logs
- migrations
- public
    * default
    * [template_name]
- bootstrap.php
- composer.json
- console
- globals.php
- index.php

**Note: Uppercase and lowercase first letter of words (i.e. Titleize) are important here. Rules for font-casing as follows:**

- Titleized words are for autoload-able classes. Basically the structure here has to follow the namespace of classes inside of it.
  For example if you have a class in file App\Controllers\HomeController.php the class name should be HomeController and it should have a namespace of App\Controllers.
- un-Titleized words (example: "thisFile") are used on non-autoload-able files / folders.
  There is actually no standard for naming of these files/directories.


## Templating with Skully is Fun!

## Command Line Applications

Coming Soon

## Tools

### Schema Migration Tool

### Javascript Packer Tool

### Password Encryption Tool