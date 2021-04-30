## Initial Setup
1. Clone Repository
2. `npm install`
3. Install MySQL

    In order to run it with the database you will need to download MySQL
    You can download it from this URL: https://dev.mysql.com/doc/mysql-osx-excerpt/5.7/en/osx-installation-pkg.html

4. You then need to copy the .env.example:

    `cp .env.example .env`

    And then change any values in the .env to allow you to login with the details you have set up for your database.

5. Generate php artisan key
   `php artisan key:generate`

## Artisan commands
`php artisan migrate:fresh`

To perform a complete migration of the database

`php artisna migrate:fresh --seed`
To perform a complete migration of the database with added seed data

`php artisan serve`

To serve the application on `127.0.0.1`

## Heroku
Access files on live by running

`heroku run bash`

Now you can run anything you need like normal

Currently available on:

`https://salty-gorge-09035.herokuapp.com`
