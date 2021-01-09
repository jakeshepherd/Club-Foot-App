## Initial Setup
This project runs with MySQL
In order to run it with the database you will need to download MySQL
You can download it from this URL: https://dev.mysql.com/doc/mysql-osx-excerpt/5.7/en/osx-installation-pkg.html

You then need to copy the .env.example:

`cp .env.example .env`

And then change any values in the .env to allow you to login with the details you have set up for your database.

## Artisan commands
`php artisan migrate:fresh`

To perform a complete migration of the database

`php artisan serve`

To serve the application on `127.0.0.1`