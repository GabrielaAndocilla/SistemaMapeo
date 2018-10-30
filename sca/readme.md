## SCA - Sistema de Control Académico

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/downloads.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

SCA es una herramienta para la Universidad de las Américas, cuyo objetivo es el manejo de los sílabos de las materias de cada carrera. Este sistema esta desarrollado con un framework de PHP llamado Laravel 5. El motivo por el cual se decidio el desarrollo en este framework fue su simplicidad y además tomando en cuenta la organización del proyecto que posee, manteniendo una estructura y un modelo de desarrollo de software.

## Documentación Oficial

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).


### Getting started

Clone this repo on your computer or git clone in your graphic client.

```shell
> git clone https://github.com/RobertoArmas/SCA.git
```
Then, you need to download laravel dependences with the following commands.

```bash
cd SCA
composer install
```

After that, you need to setup the environment so create your .env file and you need to create the key's app, this can be done executing these commands on your shell:

```bash
> copy .env.example .env
> php artisan key:generate
```

Finally, you need to startup the web server with this:

```bash
> php artisan serve
```

Open this URL `http://localhost:8000` on your browser.

## Contributing

### License


