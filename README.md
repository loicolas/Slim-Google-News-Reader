# Slim News Reader

A simple News reader made with the php framework Slim


## Installation

1. Clone repository
2. Create local database
3. Copy file src/local_settings.php.dist to src/local_settings.php
4. Run CLI command **composer install**
5. Set database parameters in src/local_settings.php
6. Create database's table using the doctrine command in CLI: **php vendor/bin/doctrine.php orm:schema-tool:update --force**
7. Run the sql script data/fixtures.sql to populate database with fixtures data.
8. You're done.


## Log in with predefineded user

The fixtures set a demo user with some preferences exemples.
You can login with there parameters:

* email: test@test.fr
* password: test
