# Checkpoint

<!--
[![Build Status](https://travis-ci.com/csun-metalab/CSU-Metro-LA.svg?token=e9qZAYzzq9K9MQ8bgdpF&branch=dev)](https://travis-ci.com/csun-metalab/CSU-Metro-LA) [![Build Status](https://travis-ci.com/csun-metalab/CSU-Metro-LA.svg?token=e9qZAYzzq9K9MQ8bgdpF&branch=demo)](https://travis-ci.com/csun-metalab/CSU-Metro-LA) -->

> A clock-in application

## Table of Contents

## Getting Started

Make sure you meet the necessary [Prerequisites](#prerequisites) in order to start developing on your machine.

## Prerequisites

-   [Git](https://git-scm.com/downloads)
-   [Docker](https://docs.docker.com/install/)
-   [Docker-Compose](https://docs.docker.com/compose/install/)
-   Favorite Text Editor or IDE

## Serving the application

To begin, navigate to the project root on your favorite terminal and run the following:

```
$ ./start.sh
```

Answer the following prompt honestly, after run.

```
docker-compose up -d
```

This will build and run the following containers:

-   The Laravel web service, named **checkpoint-server**
-   Composer service, which installs composer and runs `$ composer install`
-   A database administration GUI - Adminer, named **checkpoint-adminer**
-   MySQL service, named **checkpoint-mysql**

⚠️ **Important** Inside the `docker-compose.yml` file, you will find the database configuration that needs to be included in the project's `.env` file. After you have done this you should be able to type `localhost:8080` on your favorite browser and see the application's landing page.

To end the serve

```
docker-compose down
```

## Additional project set-up

### Seeding the application

Once you have successfully served the application, you will need to seed the database. In order to do that you need to navigate to the project root on your favorite terminal and run the following:

```
$ docker exec -it checkpoint-server bash
```

This will drop you into the `checkpoint-server` container which allows you to run any commands inside the web server. Since we are seeding the database for the very first time, we want to run the following command:

```
$ php artisan migrate:refresh --seed
$ php artisan passport:install
```

Add the corressponding Laravel Password Grant Client column secret and id to the corressponding .env values

```
PASSPORT_LOGIN_ENDPOINT=<IP>:8080/oauth/token
PASSPORT_CLIENT_ID=
PASSPORT_CLIENT_SECRET=
```

## Development cycle commands

### Back end

When in doubt.

```
composer dump
```

## Bugs and issues:

If you discover a bug and or issue within the application, please create a JIRA ticket with the BUG prefix. In addition, please list the necessary steps to reproduce the bug in the description.

## License

The [Laravel](https://laravel.com/) framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
