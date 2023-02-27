# Docker-laravel

## Get started

1. Create .env file
```
cp .env.example .env
```
2. Set variable PROJECT_PATH
3. Build and run project
```
docker-compose build
docker-compose up -d
```
4. Generate application key
```
php artisan key:generate
```
5. Install dependencies
```
composer install
```
