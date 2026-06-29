# GestorPro

Plataforma de gestion integral construida con Laravel 13.

## Requisitos

- PHP >= 8.3
- Composer
- Node.js y npm
- SQLite (por defecto) o MySQL

## Instalacion

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

## Desarrollo

```bash
composer run dev
```

Este comando levanta en paralelo: servidor, cola, logs (pail) y Vite.

## Tests

```bash
composer test
```

## Licencia

MIT
