## Prerequisites

- PHP >= 7.3
- MySql

## Steps to up running the projects Laravel

- git clone `https://github.com/rsvijay2009/weather_api.git`

- Change `DB_DATABASE` variable in the `.env` to point your local database

- Add `OPEN_WEATHER_API_KEY` variable in the `.env`

- cd weather_api `composer install`

- `php artisan migrate:fresh`

- `php artisan serve`
