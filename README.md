# Sakila

Framework agnostic domain logic build based on the MySql "Sakila" database schema.

The [Sakila Sample Database](https://dev.mysql.com/doc/sakila/en/)
was initially developed by Mike Hillyer, a former member of the MySQL AB documentation team, and is intended to provide a standard schema that can be used for examples in books, tutorials, articles, samples, and so forth. The Sakila sample database also serves to highlight features of MySQL such as Views, Stored Procedures, and Triggers.


## Usage
In your `composer.json` file:
```json
    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/piobuddev/sakila.git"
            }
        ],
        "require": {
            "piobuddev/sakila": "^1.0.0"
        }
    }
```

## Development setup:
### Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
* PHP >= `7.1`
* [Composer](https://getcomposer.org/): tool for dependency management in PHP

### Installing

To get the development environment running clone the repository and run the composer

```sh
$ git clone git@github.com:piobuddev/sakila.git
$ cd sakila/
$ composer install
```

## Running the tests

### Coding style tests
##### PHPStan : PHP Static Analysis Tool

```sh
$ vendor/bin/phpstan analyse -l 7 src tests -c phpstan.neon
```
##### PHPCS : Detects violations of a defined set of coding standards

```sh
$ vendor/bin/phpcs --standard=PSR2 --extensions=php --colors --severity=1 src
```

or run all tests together with:
```sh
$ composer test
```

Additionaly you can fix code formatting with:
##### PHPCBF : PHP Code Beautifier and Fixer

```sh
$ vendor/bin/phpcbf --standard=PSR2 --extensions=php --colors --severity=1 src
```

## Code Style
* [PSR2](https://www.php-fig.org/psr/psr-2/)


## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/piobuddev/c04b7341f68da9718907cb593012d746) for details on my code of conduct, and the process for submitting pull requests to me.

## Versioning

I use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/piobuddev/behat-webapi-extension/tags). 

## Authors

* **Piotr Budny** - [piobuddev](https://github.com/piobuddev)

## License

This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/piobuddev/repository-tester/blob/master/LICENSE.md) file for details
