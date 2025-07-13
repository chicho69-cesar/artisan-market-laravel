# Artisan Market Back-End with Laravel

<div style="width: 100%; display: flex; justify-content: center; margin-block: 1rem;">
  <img src="./assets/logo.png" width="100" height="100" />
</div>

**Artisan Market Back-End** es un proyecto desarrollado con Laravel, diseñado para impulsar una tienda en línea especializada en la venta de productos artesanales. Este repositorio alberga el código fuente del backend de la aplicación, proporcionando las capacidades esenciales para gestionar productos, usuarios, órdenes y más en la plataforma.

## Funcionalidades Clave

- **Gestión de Productos**: Administra una amplia variedad de productos artesanales, incluyendo detalles como nombre, descripción, precio y cantidad en stock.

- **Control de Usuarios**: Permite a los vendedores y administradores registrarse, autenticarse y gestionar sus cuentas.

- **Órdenes y Compras**: Facilita la creación, seguimiento y finalización de órdenes de compra, incluyendo estados como "pagado", "pendiente" y "cancelado".

- **Revisiones y Calificaciones**: Los clientes pueden dejar revisiones y calificaciones para los productos, proporcionando retroalimentación valiosa.

- **Estadísticas de Venta**: Ofrece estadísticas detalladas sobre las ventas, incluyendo el número de órdenes pagadas, pendientes, canceladas y más.

## Requisitos

Asegúrate de tener instaladas las siguientes herramientas y dependencias antes de empezar:

- [Laravel](https://laravel.com/docs/10.x/installation) - Framework de PHP utilizado para desarrollar la aplicación.

- [Composer](https://getcomposer.org/) - Manejador de dependencias de PHP para instalar las bibliotecas requeridas.

- [Base de Datos](https://laravel.com/docs/10.x/database) - Configura una base de datos compatible con Laravel, como MySQL o PostgreSQL.

## Instalación

Sigue estos pasos para configurar y ejecutar el proyecto en tu entorno local:

**Clona este repositorio:**

```bash
  git clone https://github.com/chicho69-cesar/artisan-market-laravel.git
  cd artisan-market-laravel
```

**Instala las dependencias de Laravel usando Composer:**

```bash
composer install
```

**Crea un archivo de configuración .env y configura la conexión a la base de datos. Puedes usar el archivo .env.example como plantilla:**

```bash
cp .env.example .env
```

**Genera una clave de aplicación:**

```bash
php artisan key:generate
```

**Ejecuta las migraciones para crear las tablas de la base de datos:**

```bash
php artisan migrate
```

**Ejecuta el seed de los datos para rellenar la base de datos:**

```bash
php artisan db:seed
```

**Instalar Passport para el proyecto:**

```bash
php artisan passport:install
```

**Crear tu Personal Access Client key para Passport:**

```bash
php artisan passport:client --personal
```

**Inicia el servidor de desarrollo:**

```bash
php artisan serve
```

Accede a la aplicación en tu navegador visitando <http://localhost:8000>

**Inicia el servidor para acceder dentro de una LAN:**

```bash
php artisan serve --host 192.168.100.14 --port="8000"
```

Accede a la aplicación desde otro dispositivo conectado a la misma red visitando <http://192.168.100.14:8000>

**Crea un enlace simbólico al almacenamiento de las imágenes:**

```bash
php artisan storage:link
```

Ahora se puede acceder a las imágenes usando la ruta de la imagen concatenada al enlace: <<http://localhost:8000/storage/{path> de la imagen}>

## Ejecutar proyecto con Docker

Para ejecutar el proyecto utilizando Docker, asegúrate de tener Docker y Docker Compose instalados en tu máquina. Luego, sigue estos pasos:

**Levantar el docker compose haciendo build:**

```bash
docker-compose -f docker-compose.dev.yml up -d --build
```

Esto iniciará los contenedores necesarios para la aplicación, incluyendo el servidor web y la base de datos.

**Ejecutar comandos en la consola interactiva:**

Para ejecutar comandos de Artisan o Composer dentro del contenedor de la aplicación, puedes usar el siguiente comando:

```bash
docker exec -it artisan_market_app bash

php artisan migrate --seed
php artisan passport:install
php artisan passport:client --personal
php artisan storage:link
```

**Acceder a la aplicación:**

Abre tu navegador y visita <http://localhost:8000> para acceder a la aplicación.

## Docker creando la imagen

Para crear la imagen del proyecto y ejecutarla sin la necesidad de usar Docker Compose, puedes seguir estos pasos:

**Levantar base de datos:**

```bash
docker compose up -d
```

**Construir la imagen:**

```bash
docker build -t artisan_market_app:1.0.0 .
```

**Ejecutar la imagen:**

```bash
docker container run -dp 8000:80 `
> --name artisan_market_app `
> --network artisan-market-laravel_artisan_market_network `
> --env-file .env.template `
> artisan_market_app:1.0.0
```

**Ejecutar comandos en la consola interactiva:**

Para ejecutar comandos de Artisan o Composer dentro del contenedor de la aplicación, puedes usar el siguiente comando:

```bash
docker exec -it artisan_market_app bash

php artisan migrate --seed
php artisan passport:install
php artisan passport:client --personal
php artisan storage:link
```

Si el comando `php artisan storage:link` falla, porque el link ya existe, puedes eliminarlo con:

```bash
rm -rf public/storage # En MacOS o Linux
Remove-Item public\storage -Recurse -Force # En Windows PowerShell
```
