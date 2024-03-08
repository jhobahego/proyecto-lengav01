# Semillero SUIS

## Descripción

Semillero SUIS es un proyecto de investigación en Ingeniería en Sistemas que tiene como objetivo mejorar los procesos académicos en la región sucreña. Este proyecto está desarrollado en Laravel con Inertia.js utilizando Jetstream y se conecta a una base de datos MySQL.

## Requisitos

- PHP >= 7.4
- Composer
- Node.js
- NPM
- MySQL

## Instalación

1. Clonar el repositorio:

   ```sh
   git clone https://github.com/jhobahego/proyecto-lengav01.git
   ```

2. Instalar dependencias:

```sh
cd suis-lengav01
composer install
npm install
```

## Configuración e inicio de aplicación

- Configurar archivo `.env` con los datos de la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bd-suis
DB_USERNAME=root
DB_PASSWORD=
```

- Generar la clave de la aplicación y ejecutar las migraciones y los seeders:

```sh
php artisan key:generate
php artisan migrate --seed
```

- Compilar los assets e iniciar el servidor:

```sh
npm run dev
php artisan serve
```
