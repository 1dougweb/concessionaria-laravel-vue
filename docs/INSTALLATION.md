# Guia de Instalação – Concessionária Laravel + Vue

## Requisitos
- PHP 8.3+
- Composer 2.x
- Node.js 20+ (ou pnpm 9+)
- MySQL 8 (ou MariaDB compatível)
- Redis (opcional para cache/queues)

## 1. Clonar o repositório
```bash
git clone https://github.com/1dougweb/concessionaria-laravel-vue.git
cd concessionaria-laravel-vue
```

## 2. Backend Laravel
1. **Instalar dependências**
   ```bash
   composer install
   ```
2. **Configurar `.env`**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. **Configurar banco**
   - Ajuste `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
4. **Configurar JWT**
   ```bash
   php artisan jwt:secret
   ```
5. **Migrations + Seeds**
   ```bash
   php artisan migrate --seed
   ```
6. **(Opcional) Telescope**
   ```bash
   php artisan telescope:install
   php artisan migrate
   ```
7. **Serviços em tempo real**
   - Ajuste `BROADCAST_DRIVER=pusher`.
   - Configure `PUSHER_*` (ou use Laravel WebSockets e rode `php artisan websockets:serve`).
8. **Iniciar servidor**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```
9. **Queues/WebSockets**
   - `php artisan queue:work`
   - `php artisan websockets:serve` (se aplicável)

## 3. Frontend Vue 3 (Vite)
1. ```bash
   cd frontend
   npm install
   cp .env.example .env    # crie com variáveis VITE_* (ver abaixo)
   ```
2. **Variáveis**
   ```
   VITE_API_BASE_URL=http://localhost:8000/api/v1
   VITE_ECHO_KEY=local-key
   VITE_ECHO_HOST=localhost
   VITE_ECHO_PORT=6001
   VITE_ECHO_TLS=false
   ```
3. **Rodar dev server**
   ```bash
   npm run dev -- --host
   ```
   Acesse `http://localhost:5173`.

## 4. Usuário padrão
O seed cria/atualiza:
```
email: admin@concessionaria.local
senha: Admin#123
```

## 5. Testes e Qualidade
- **Backend**
  ```bash
  php artisan test
  ```
- **Frontend (Vitest)**
  ```bash
  cd frontend
  npm run test:unit
  npm run lint
  npm run build
  ```

## 6. Produção
- Use `.env.production` com credenciais seguras.
- Configure HTTPS para WebSockets (NGINX/Traefik) e defina `VITE_ECHO_TLS=true`.
- Utilize supervisores para `queue:work` e `websockets:serve`.
- Habilite cache/config otimizado:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

## 7. Troubleshooting
- **401 no login**: verifique `JWT_SECRET`, usuário seed e credenciais.
  ```php
  php artisan tinker
  >>> User::updateOrCreate(['email'=>'admin@concessionaria.local'], ['password'=>Hash::make('Admin#123')]);
  ```
- **WebSocket `ws://undefined`**: defina `VITE_ECHO_HOST` ou deixe `window.location.hostname`.
- **Telescope erros**: rode `telescope:install` ou remova o provider.

## 8. Próximos passos
- Configurar CI/CD (GitHub Actions).
- Criar containers (Docker Compose) com serviços (app, queue, websockets, mysql, redis).
- Monitoramento: habilitar logs no Telescope/Stackdriver.

