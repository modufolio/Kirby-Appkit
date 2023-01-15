## The Appkit

Kirby's Appkit is a setup to extend Kirby's core functionality.

[Replacing Kirby's core classes](https://getkirby.com/docs/cookbook/extensions/replacing-core-classes)

There are already a lot of ways you can customize Kirby by adding custom methods, overwrite core components, extend the Page class with your own model, and a whole lot more.

But there are also situations where you might want to overwrite certain parts of the core classes for which there is no existing extension yet. For example, to create virtual pages as children of the Site object or virtual users, or to simply add new methods to those classes.



## Installation

This extended Kirby setup is using sqlite as database for the users.

After cloning the repository, you need to install the dependencies with composer:

`composer install`

It will automatically create the database file `data.db` in the `database` folder when you run the console command:

`php console make:table`

Choose 1 for the users table.
Choose 2 for the content users table.



## The Panel

You can find the login for Kirby's admin interface at
http://yourdomain.com/panel. You will be guided through the signup
process for your first user, when you visit the panel
for the first time.

### Requirements

Kirby runs on PHP 8.0+, Apache or Nginx.

