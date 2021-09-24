<h1>Technical Challenge - xModal</h1>

# How to setup

```git clone https://github.com/brunomoreno7538/desafio-x-modal.git```
<br/>

```cd desafio-x-modal```
<br/>

On CLI
<br/>

```copy .env.example .env```
<br/>

Change .env
```
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=aaa123
```

# How to run

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
