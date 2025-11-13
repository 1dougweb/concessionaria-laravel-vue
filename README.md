<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Concessionária Laravel + Vue 3

Sistema completo de concessionária desenvolvido com **Laravel 11** (backend) e **Vue 3 + Vite** (frontend).  
O projeto é uma **SPA** integrada via API REST e **WebSocket**, com **autenticação JWT**, **login social (Google)**, **PWA**, **Skeleton Loading**, **SEO técnico (Schema.org + sitemap automático)** e **notificações em tempo real**.

---

## Stack Tecnológica

### **Backend — Laravel 12**
- PHP 8.3+
- Laravel 11
- MySQL
- JWT Auth (`tymon/jwt-auth`)
- Laravel Socialite (Google Auth)
- Laravel WebSockets (ou Pusher / Ably)
- Laravel Echo Server
- Spatie Packages:
  - `laravel-permission` → controle de papéis e permissões  
  - `laravel-medialibrary` → upload e galeria de imagens  
  - `laravel-responsecache` → cache de respostas HTTP  
  - `laravel-sitemap` → geração automática de sitemap.xml  
  - `schema-org` → estruturação de dados SEO  
  - `laravel-backup` → backup automático  
- `fruitcake/laravel-cors` → configuração de CORS  
- `laravel/telescope` → debug e análise de requisições  
- `pestphp/pest` → testes automatizados  

### **Frontend — Vue 3 + Vite**
- Vue 3 (Composition API)
- Vue Router 4
- Pinia (state management)
- TailwindCSS
- Axios
- HeadlessUI + Heroicons
- vue-loading-skeleton (sistema de esqueleto)
- vite-plugin-pwa (PWA + manifest)
- @vueuse/core (composables reativos)
- Laravel Echo + Socket.io-client (WebSocket)
- vue3-toastify (notificações em tempo real)

---

## Funcionalidades Principais

- Cadastro e gerenciamento de **carros** e **motos**
- Sistema de **categorias e marcas**
- **Metaboxes personalizados** (ano, quilometragem, combustível, etc.)
- Upload múltiplo com galeria (Spatie Medialibrary)
- SEO nativo (meta title, description, slug automático)
- Sitemap.xml + dados Schema.org automáticos
- Autenticação JWT + Login com Google
- **Atualização em tempo real via WebSocket**
- Sistema de notificações instantâneas (novos anúncios, vendas, mensagens)
- PWA: cache offline e manifest configurado
- Skeleton Loading em componentes e listagens
- Painel administrativo SPA responsivo
- Rate Limiting e Middleware personalizados
- Backup automático diário
- Testes unitários e E2E (Pest + Cypress)

---

## Instalação e Configuração
# Clonar o projeto
```bash
git clone https://github.com/1dougweb/concessionaria-laravel-vue.git
cd concessionaria-laravel-vue
```
# Backend
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```
# Instalar WebSocket
```bash
composer require beyondcode/laravel-websockets
php artisan websockets:serve
```
## Frontend
```bash
npm install
npm run dev
```
# Iniciar servidor Laravel
```bash
php artisan serve
```
## Dependências — Composer
```bash
composer require tymon/jwt-auth
```
```bash
composer require laravel/socialite
```
```bash
composer require spatie/laravel-permission
```
```bash
composer require spatie/laravel-medialibrary
```
```bash
composer require spatie/laravel-responsecache
```
```bash
composer require spatie/laravel-sitemap
```
```bash
composer require spatie/schema-org
```
```bash
composer require fruitcake/laravel-cors
```
```bash
composer require spatie/laravel-backup
```
```bash
composer require beyondcode/laravel-websockets
```
```bash
composer require pestphp/pest --dev
```
```bash
composer require laravel/telescope --dev
```

## Dependências — NPM
```bash
npm install vue@3 vue-router@4 pinia axios tailwindcss @headlessui/vue @heroicons/vue
```
```bash
npm install vite-plugin-pwa vue-loading-skeleton @vueuse/core @vueuse/integrations
```
```bash
npm install laravel-echo socket.io-client vue3-toastify
```
```bash
npm install --save-dev autoprefixer postcss cypress
```

## Estrutura Completa do Projeto
pgsql
```bash
concessionaria/
├── app/
│   ├── Events/
│   │   ├── NovoVeiculoCadastrado.php
│   │   ├── MensagemEnviada.php
│   │   └── VendaAtualizada.php
│   ├── Broadcasting/
│   │   └── NotificacaoChannel.php
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── CarroController.php
│   │   │   │   ├── MotoController.php
│   │   │   │   ├── CategoriaController.php
│   │   │   │   ├── AuthController.php
│   │   │   │   └── NotificacaoController.php
│   │   │   └── DashboardController.php
│   │   ├── Middleware/
│   │   │   ├── JwtMiddleware.php
│   │   │   ├── AdminMiddleware.php
│   │   │   └── CorsMiddleware.php
│   │   ├── Requests/
│   │   │   ├── StoreCarroRequest.php
│   │   │   ├── StoreMotoRequest.php
│   │   │   └── AuthRequest.php
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── Carro.php
│   │   ├── Moto.php
│   │   ├── Categoria.php
│   │   ├── User.php
│   │   └── Marca.php
│   ├── Providers/
│   └── Services/
│       ├── SeoService.php
│       ├── SitemapService.php
│       ├── BackupService.php
│       └── WebSocketService.php
│
├── config/
│   ├── app.php
│   ├── jwt.php
│   ├── websockets.php
│   ├── medialibrary.php
│   ├── permission.php
│   ├── responsecache.php
│   ├── sitemap.php
│   └── cors.php
│
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── CarCard.vue
│   │   │   ├── MotoCard.vue
│   │   │   ├── SkeletonCard.vue
│   │   │   ├── Notification.vue
│   │   │   └── ChatBox.vue
│   │   ├── layouts/
│   │   │   ├── DefaultLayout.vue
│   │   │   └── AdminLayout.vue
│   │   ├── router/
│   │   │   ├── index.js
│   │   │   └── guards.js
│   │   ├── stores/
│   │   │   ├── useAuthStore.js
│   │   │   ├── useCarStore.js
│   │   │   ├── useMotoStore.js
│   │   │   └── useNotificationStore.js
│   │   ├── views/
│   │   │   ├── Home.vue
│   │   │   ├── Carros.vue
│   │   │   ├── Motos.vue
│   │   │   ├── Detalhes.vue
│   │   │   ├── Login.vue
│   │   │   ├── Dashboard.vue
│   │   │   └── NotFound.vue
│   │   ├── App.vue
│   │   └── main.js
│   └── css/
│       ├── app.css
│       └── tailwind.css
```

## WebSocket — Estrutura
- Canal público: exibe novos veículos cadastrados em tempo real
- Canal privado: usado para notificações de usuários autenticados
- Broadcasting: controlado via NovoVeiculoCadastrado e VendaAtualizada
- Frontend: laravel-echo conectado com socket.io-client

## Testes e Observabilidade
- PestPHP para testes unitários e de integração
- Cypress para E2E
- Telescope para requisições, eventos e monitoramento WebSocket