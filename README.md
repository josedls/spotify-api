# Spotify API

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Set the Client ID and Client Secret of your Spotify App in your .env file. [Spotify API Documentation](https://developer.spotify.com/documentation/)

Alternative installation is possible without local dependencies relying on [Docker](#docker) with Laravel Sail. https://laravel.com/docs/9.x/sail

Clone the repository

    git clone git@github.com:josedls/spotify-api.git

Switch to the repo folder

    cd spotify-api

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Start the local development server

    php artisan serve

You can now access the server at http://localhost

    
## Docker

To install with [Docker](https://www.docker.com), run following commands:

```
php artisan sail:install
./vendor/bin/sail up
```

The api can be accessed at [http://localhost/api/v1](http://localhost/api/v1).

## API Specification

# Testing API

Run the tests

    php artisan test

You can now manually test the API in browser or Postman

    http://localhost/api/v1/albums?q=nirvana


----------