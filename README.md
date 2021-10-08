# Resource Management

This project includes a minimal resource management system.

### Installation

```sh
$ git clone https://github.com/93Kamuran/resource-management.git
$ cd resource-management
$ composer install
$ npm install
```


####  Database
Copy .env.example to .env
```sh
$ cp .env.example .env
```
Edit .env
```sh
DB_CONNECTION=mysql
DB_HOST=XXXX
DB_PORT=3306
DB_DATABASE=XXXX
DB_USERNAME=XXXX
DB_PASSWORD=XXXX
```
Create the database before run artisan command.
```sh
$ php artisan migrate
```
Generate your application encryption key:
```sh
$ php artisan key:generate
```

 