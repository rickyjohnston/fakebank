# FakeBank

## Introduction
Code challenge: create an API for a made up BANK. For full requirements, see requirements.md.

## Installation
1. Clone repo

2. Run `composer install`

3. Create a new database for the project

4. Copy `.env.example` to `.env` and edit, saving environment variables according to local settings (notably, linking `DB_DATABASE` to the database created in Step 3, `DB_USERNAME` and `DB_PASSWORD` to those matching local MySql settings, and `APP_URL` to the addresss of your local server for the project)

5. Run `php artisan migrate` to migrate your database for the project

6. If no `APP_KEY` is present in `.env`, (as per Laravel installation instructions) run `php artisan key:generate`

7. Run `php artisan db:seed` to seed your test database with 50 transaction records.

8. Serve the project via local server

## Tests
There are a number of automated tests included. To run them, from the project directory,
run `vendor/bin/phpunit`

## API Routes
A full list of routes can be seen by running `php artisan route:list` from the project root.
