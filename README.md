# Artisan Market Back-End with Laravel

![logo](assets/logo.png)

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
