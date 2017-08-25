# Information

This is a solution for the API task.

# Tested Environment

*   PHP 7.1.8

# Composer Dependencies

*   [laravel/framework] (v5.4.35) - Standard
*   [guzzlehttp/guzzle] (v6.3.0)

# Installation

1.  Clone this repository
1.  Execute Composer install:

    ```console
    $ composer install
    ```

1.  Launch built-in web server:

    ```console
    $ php artisan serve --port=8080
    ```

# Tests

**Test coverage of my own code is 100%.**

You can run the tests by using the provided phpunit.xml file.

*   Run all tests:

    ```console
    $ vendor/bin/phpunit
    ```

*   Run only feature tests:

    (Feature tests are functional tests)

    ```console
    $ vendor/bin/phpunit --testsuite "Feature"
    ```

*   Run only unit tests:

    ```console
    $ vendor/bin/phpunit --testsuite "Unit"
    ```

[laravel/framework]: https://packagist.org/packages/laravel/framework
[guzzlehttp/guzzle]: https://packagist.org/packages/guzzlehttp/guzzle
