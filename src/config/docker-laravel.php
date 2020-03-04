<?php


return [

    "namespace" => env("DOCKER_LARAVEL_NAMESPACE", null),

    "app" => env("APP_NAME", "app"),

    "repository" => env("DOCKER_LARAVEL_REPOSITORY", "wartisans/docker-laravel-lemp"),

    "tag" => env("DOCKER_LARAVEL_TAG", "latest"),

    "fileName" => env("DOCKER_LARAVEL_FILENAME", ".dockerID"),
];
