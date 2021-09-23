<h1>Technical Challenge - xModal</h1>

## How to setup the application:
In CLI: 
<br/>
```git clone https://github.com/brunomoreno7538/desafio-x-modal.git```
<br/>

```cd desafio-x-modal```
<br/>

```copy .env.example .env```

In .env file: 
```DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=aaa123
```

```docker-compose exec app php artisan key:generate```
<br/>

```docker-compose exec app php artisan config:cache```

## How to run the application:
```1- docker-compose up -d```
<br/>

```2- docker-compose exec app composer install```
<br/>

```3- docker-compose exec app php artisan migrate```
<br/>

```4- docker-compose exec app php artisan db:seed --class=StatesSeeder```
<br/>

```5- docker-compose exec app php artisan passport:install --force```
<br/>

```6- docker-compose exec app php ./vendor/bin/phpunit```
<br/>
