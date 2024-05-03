# Pharmacy System

Api for manage user permission levels and create customers and medications.

## Installation

To get started, make sure you have [Docker installed](https://docs.docker.com/docker-for-mac/install/) on your system, and then clone this repository.

checkout master branch `git checkout master`

change `.env.example` file to `.env`

**Note**: Your MySQL database host name should be `db`, **not** `localhost`. The username and database should both be `db_user` with a password of `secret`.

Next, navigate in your terminal to the directory you cloned this, and spin up the containers for the web server by running `docker-compose build app`.

The following are built for our web server, with their exposed ports detailed:

- **nginx** - `:8000`
- **mysql** - `:3308`

Next run `docker-compose up -d`

go to the `app` container inside by running
```bash
docker-compose exec app bash
``` 

install the dependencies.

```bash
composer install
```

key generate.
```bash
php artisan key:generate 
```

run migrations
```bash
php artisan migrate
```

run seeders
```bash
php artisan db:seed
```
Installation done you can access the api through `http://localhost:8000/api`

## Testing
first need to go to `app` container inside
```bash
docker-compose exec app bash
```
then run
```bash
./vendor/bin/phpunit
```
