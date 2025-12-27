# Instalación del Proyecto Videoclub con Composer

## Requisitos

- PHP >= 8.0
- Composer instalado en tu ordenador

## Pasos de Instalación

### 1. Instalar dependencias con Composer

Abre **CMD (Símbolo del Sistema)** o **PowerShell** en Windows y navega al directorio del proyecto:

```cmd
cd C:\xampp\htdocs\videoclub-management
```

Luego ejecuta:

```cmd
composer install
```

Esto descargará:

- **Monolog 3.0+**: Librería de logging para registrar eventos
- **PHPUnit 10.0+**: Framework de testing para pruebas unitarias

### 2. Verificar la instalación

Una vez completado, verás que se creó una carpeta `vendor/` con todas las dependencias. El archivo `composer.lock` registra las versiones exactas instaladas.

### 3. Autoload automático

El proyecto usa **PSR-4 Autoloading** de Composer. Todas las clases bajo el namespace `Dwes\ProyectoVideoclub\` se cargan automáticamente desde la carpeta `app/`.

En tus archivos PHP, solo necesitas:

```php
require_once 'vendor/autoload.php';
```

Ya no necesitas `require_once 'autoload.php'`.

## Estructura de Dependencias

```text
composer.json
├── require:
│   ├── php: >=8.0
│   └── monolog/monolog: ^3.0
└── require-dev:
    └── phpunit/phpunit: ^10.0
```

- **monolog**: Instalada en `vendor/monolog/` para logging en producción
- **phpunit**: Instalada en `vendor/phpunit/` solo para desarrollo/testing

## Ejecutar Tests con PHPUnit

Una vez instalado, puedes ejecutar pruebas unitarias:

```cmd
vendor\bin\phpunit
```

## Actualizar dependencias

Para actualizar a las últimas versiones permitidas por `composer.json`:

```cmd
composer update
```

## Notas importantes

- **No subir `vendor/` a GitHub**: Ya está en `.gitignore`
- **`composer.lock` sí va a GitHub**: Asegura que todos usen las mismas versiones
- **Para clonar el repo**: Solo necesitas hacer `composer install` después de clonar
