# Installation
This extended Kirby setup is using sqlite as database for the users.

After cloning the repository, you need to install the dependencies with composer:

```composer install```

It will automatically create the database file data.db in the database folder when you run the console command:

```php console make:table```

Choose 1 for the users table. Choose 2 for the content users table.

## The Panel

You can find the login for Kirby's admin interface at
http://yourdomain.com/panel. You will be guided through the signup
process for your first user, when you visit the panel
for the first time.

### Requirements

Kirby runs on PHP 8.0+, Apache or Nginx.
