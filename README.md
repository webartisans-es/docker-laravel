# Docker Laravel 

This is a simple package that creates some commands to run easily a docker container in order to serve you laravel app from docker.

This is meant only for development purposes.

### Installation

```bash
composer require wartisans/docker-laravel --save-dev
```

if you want to change any of the configurations you can publish the `docker-laravel.php` configuration, if not, it will just take the defaults.

```bash
 php artisan vendor:publish --provider="WebArtisans\\DockerLaravel\\Providers\\DockerLaravelServiceProvider"
```


### Usage

To serve your current project you can just run

```bash
php artisan docker:serve
```


To stop the current container

```bash
php artisan docker:stop
```


To remove the container

```bash
php artisan docker:remove
```
