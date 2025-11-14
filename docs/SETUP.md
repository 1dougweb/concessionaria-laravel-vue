# Setup Guide

## Backend

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
php artisan storage:link
```

### Local WebSockets

```bash
php artisan websockets:serve
```

## Frontend

```bash
cd frontend
pnpm install
pnpm run dev
```

## Quality Gates

```bash
php artisan test
./vendor/bin/pest
pnpm run lint
pnpm run test:unit
```

