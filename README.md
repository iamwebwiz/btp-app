## Subscribers Management System

A minimalistic subscribers management system

### Technologies

-   Laravel
-   Vue
-   Inertia
-   GitHub Actions
-   BootstrapCSS
-   Vite

### Requirements

-   PHP8.1+
-   Composer
-   npm/yarn/pnpm

### Installation

Clone the repository

```sh
git clone https://github.com/iamwebwiz/btp-app.git
```

Change current directory

```sh
cd btp-app
```

Install composer dependencies

```sh
composer install
```

Install JavaScript dependencies

```sh
npm install
# or
yarn
# or
pnpm install
```

Create environment variables file

```sh
cp .env.example .env
```

Generate app key

```sh
php artisan key:generate
```

Update database details

```text
DB_DATABASE=bythepixel_app
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations

```sh
php artisan migrate
```

Start Vite dev server

```sh
npm run dev
# or
yarn dev
# or
pnpm dev
```

Start Laravel dev server

```sh
php artisan serve
```

Launch your web browser and navigate to http://localhost:8000 to view the client built for the project

## Testing

The automated tests in this application can be run using

```sh
php artisan test
```
