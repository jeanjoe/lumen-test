## Lumen TEST

### Requirements
- PHP 7.2+
- Mysql 5.7 +

### How to set up.

- Clone the repo
- cd to the `lumen-test` directory
- Install Dependencies with `composer install`
- Create Database and update the `.env` environment variables
- Run migration with `php artisan serve`
- Serve your application with `php -S localhost:8000 -t public`

### Endpoints

- Create User `/users` **POST**
- Get All Users `/users` **GET**
- Get single User `/users/{id}` **GET**

- Rate a User `/ratings` **POST**
- Get Ratings   `/ratings` **GET**
