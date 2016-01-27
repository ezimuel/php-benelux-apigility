# php-benelux-apigility
Hands on part of the "Develop RESTful API in PHP using Apigility" tutorial at [PHP Benelux 2016](https://conference.phpbenelux.eu/2016/talk/develop-restful-api-in-php-using-apigility/).

Installation
------------

You can install the tutorial using composer:

```console
$ composer install
```

After that you can run the Apigility Admin UI with the following command:

```console
php -S 0:8888 -t public/ public/index.php
```

and open your browser to [http://localhost:8888](http://localhost:8888).

Exercises
---------

The tutorial is based on exercises, to see the solution of each one you need to
checkout the specific branch. For instance, for the exercise 1 execute the
following command:

 ```console
 git checkout exercise/1
 ```

 All the exercises are stored in the `exercise/*` branches.
