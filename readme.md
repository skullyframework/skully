# Skully PHP Framework

Skully Framework is an MVC framework focusing mainly on a better separation of directories for
collaborative work between web programmer and web designer.

It is also a simple php framework you could use as a skeleton for any php project, hence the name Skully.

With Skully Framework you may give access to just the public directory to web designers, and complete access
to the project's main programmers. Ideally This system would allow you to work remotely with multiple
team members.

Features:

1. RedBeanPHP as its ORM.
2. Javascript compressing tool.
3. Sass / Scss
4. Templating system supported by Smarty. Templates are also completely separated from rest of the project's code. This allows for work division between client and server developers.
5. Ruckusing for database schema.

Skully project aims to teach its adapters best practices in PHP programming, and programming in general as adapters use it in their projects. We are a big fan of project [PHP The Right Way](http://phptherightway.com) so we built a framework around the concepts written there.

This framework uses [RedbeanPHP](http://redbeanphp.com) as its ORM and [Smarty](http://smarty.net) as its templating engine.

## What's So Good About Skully?

- We at Trio Digital Agency use Skully framework on all of our client projects, so you can expect a continuous development.
- One thing we particularly enjoy in using Skully is its separation of responsibilities: We can share a project's /public directory to our remote web developers and they can start doing their magic, while our in-house developers build its structure and back-end system.
- It is a compilation of best practices in software development. The structure of this framework fully supports Test Driven Development! There is no global variables or functions (except convenience methods that are insignificant), and it has been used again and again in TDD projects.
- Easy to use command line tools (we use the symfony Command plugin for this), and additional tools you can add as you go. Examples below.
- Database migration, a great feature from Rails, is integrated with the help of Ruckusing module (which we tinkered with a bit).
- We think this is the best feature Skully offers: Clean integration with our favourite IDE: [PHP Storm](http://www.jetbrains.com/phpstorm/). Do you remember the days when you have to do find-from-all to find out where a class / method is inherited from? That days are long gone with Skully on PHP Storm.

## Setting Up

The fastest way to start a skully project is by cloning our skeleton project here: http://github.com/triodigital/skully-project

## Project Structure and File Naming Conventions

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
Skully uses Smarty as its templating tool. It supports multiple themes and template caching. Skully itself does not force you to use a certain CSS / Javascript framework, but our skeleton uses Zurb's Foundation CSS framework for a starting point.

### Smarty's nocache blocks Rules

1. nocache blocks MUST be put inside blocks.
2. nocache blocks MUST be used in both fetched and parent templates.
3. Do not put nocache inside wrappers (templates used in extends block).

See Skully/Tests/TemplateTest.tpl for usage information.

## Command Line (Console) Applications

Skully contains various tools that are available via Command line to help you with your app development. They are available in directory Skully/Commands/ Look into each file to find out how to use each of them.

The core contains following console apps:

### Schema Migration Tool

Schema migration tool is similar to Rails' database migration, if you ever use one. Basically it is a way to create tables and initial data to be used on the site, in a way that when you recreate this project elsewhere, you do not need to copy and re-run your database for this project; You just need to re-run this migration tool.

`./console skully:schema db:generate createTableSomething` - Create a migration file "createTableSomething"
`./console skully:schema db:migrate` - Run the migration

You can have a different set of migration files for other environments of your app. for example To run your migrations to test version, run the following:
`./console skully:schema db:migrate ENV=test`
or
`./console skully:schema db:migrate -t`

And likewise to create a migration file on test stage, you can also add `-t` or `ENV=test` to your `db:generate` command.

To revert all migrations, do:
`./console skully:schema db:migrate VERSION=0`

Or to revert to older migrations:
`./console skully:schema db:migrate VERSION=[number]`
Where number is the numbers shown before each migration file name.

More information can be read at [Ruckusing Migration page](https://github.com/ruckus/ruckusing-migrations).

### Javascript Packer Tool

It is certainly not nice to have all your javascript files plainly visible on your site, uncompressed and uncombined. So we integrated a javascript packer tool into our framework.

To use this packer, all you need to do is:

Create a packer configuration file. It should look like this, for example:

```
@compress all.min.js
    jquery.min.js
    my_plugin1.js
    my_plugin2.js
```

Then run the following:

`./console skully:pack address/to/config/file`

Or, on windows:
`php console skully:pack address\\to\\config\\file`

You can technically use this to pack your css files, but in our workflow we prefer to use SCSS and Compass for packing CSS.

### Password Encryption Tool

Revertable encryption is sometimes useful to store password data in database or text file. Whereas you can use our library PassEncryptor for database-storing, you can also access via console by running
`./console skully:encrypt password`
and
`./console skully:decrypt encrypted_pass`

# What now?

Go to http://github.com/skullyframework/skully-project to grab a copy and start playing with it!
