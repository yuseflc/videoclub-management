
<div align="center">

# 🎬 VIDEOCLUB

### Sistema de Gestión de Alquileres

Proyecto de programación orientada a objetos desarrollado en PHP para la gestión completa de un videoclub clásico.

---

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php&logoColor=white)
![POO](https://img.shields.io/badge/Paradigma-POO-success?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)

</div>

---

## Propósito

Este proyecto simula la gestión de un videoclub clásico, permitiendo almacenar y consultar información sobre soportes como películas y videojuegos. El objetivo es aprender y practicar programación orientada a objetos en PHP, así como el trabajo colaborativo y el uso de buenas prácticas de desarrollo.

## Instalación

1. Clona el repositorio:

    ```bash
    git clone https://github.com/yuseflc/Proyecto-Videoclub.git
    ```

2. Accede a la carpeta del proyecto:

    ```bash
    cd Proyecto-Videoclub
    ```

3. Configura tu servidor local (XAMPP, WAMP, etc.) para que apunte a la carpeta del proyecto.
4. Ejecuta los archivos de prueba en `/test/` desde tu navegador.

## Autores

- **David López Ferreras**
- **Yusef Laroussi de la Calle**

## IA utilizada

Este proyecto cuenta con el apoyo de **GitHub Copilot** (Claude Sonnet 4.5) como herramienta de asistencia, enfocada en:

- Facilitar la escritura de código base y estructuras de clases
- Generar comentarios explicativos detallados
- Mantener coherencia y calidad en la documentación
- Ayuda a la realización de parte de los estilos css del proyecto

**Importante**: La IA se utilizó como **apoyo, no como sustitución**. Todo el código ha sido:

- ✓ Revisado y comprendido completamente por los desarrolladores
- ✓ Adaptado al contexto específico del proyecto Videoclub
- ✓ Mejorado con lógica personalizada (validaciones, encadenamiento de métodos)
- ✓ Comentado de forma manual para explicar decisiones de diseño

**Ejemplos de adaptaciones realizadas**:

- **Fluent Interface**: Modificación manual del código sugerido para permitir encadenamiento de métodos (`$cliente->alquilar($s)->devolver($s2)`)
- **Sistema de Excepciones**: Personalización completa del manejo de errores específicos del videoclub
- **Control de Estado**: Lógica propia para gestionar alquileres activos y totales
- **Validaciones**: Implementación de reglas de negocio (máximo de alquileres, duplicados, etc.)

**Transparencia**: Los commits con mayor contenido de IA se indican en el historial, y cualquier limitación encontrada se documentó en cada iteración.

## Explicación técnica

El proyecto está estructurado en clases PHP separadas, siguiendo el modelo UML. Cada clase representa un tipo de soporte y contiene métodos para consultar sus propiedades. El código está comentado para facilitar su comprensión, especialmente para principiantes.

### Estructura del proyecto

```
Proyecto-Videoclub/
├── .git/    # Control de versiones Git
├── .gitignore     # Archivos ignorados
├── app/                       # Clases principales del proyecto
│   ├── CintaVideo.php
│   ├── Cliente.php
│   ├── Dvd.php
│   ├── Juego.php
│   ├── Resumible.php
│   ├── Soporte.php
│   ├── Videoclub.php
│   └── Util/              # Excepciones
│       ├── ClienteNoEncontradoException.php
│       ├── CupoSuperadoException.php
│       ├── SoporteNoEncontradoException.php
│       ├── SoporteYaAlquiladoException.php
│       └── VideoclubException.php
├── assets/          # Recursos estáticos
│   ├── css/
│   │   └── style.css
│   └── screenshots/     # Capturas de pantalla del proyecto
│       ├── cap1.png hasta cap16.png
├── test/            # Archivos de prueba
│   ├── inicio.php
│   ├── inicio2.php
│   └── inicio3.php
├── vendor/             # Dependencias
├── autoload.php  
├── LICENSE             
├── README.md           
├── REGLAS_COMMITS.md   
├── REGLAS_RAMAS.md     
└── REGLAS_SUBIR_CAMBIOS.md 
```

## Capturas de pantalla

### Sección 1: Prueba de Soportes Individuales (`inicio.php`)

Este archivo demuestra cómo instanciar diferentes tipos de soportes (CintaVideo, DVD, Juego) y acceder a sus propiedades.

| Captura | Descripción | Código |
|---------|-------------|--------|
| ![1](Screenshots/1cap.png) | Página principal con opciones de prueba | Muestra opciones para navegar entre las 3 secciones de prueba |
| ![2](Screenshots/2cap.png) | Instancia de CintaVideo | `new CintaVideo("Los cazafantasmas", 23, 3.5, 107);` - Título, ID, precio, duración |
| ![3](Screenshots/3cap.png) | Instancia de DVD | `new Dvd("Origen", 24, 15, "es,en,fr", "16:9");` - Incluye idiomas y formato |
| ![4](Screenshots/4cap.png) | Instancia de Juego | `new Juego("The Last of Us", 26, 49.99, "PS4", 1, 1);` - Consola, jugadores |

**Concepto clave:** Polimorfismo. Todas las clases extienden `Soporte` implementando métodos como `getPrecio()`, `getPrecioConIVA()`, `muestraResumen()`.

---

### Sección 2: Gestión de Clientes y Encadenamiento (`inicio2.php`)

Demuestra cómo los clientes alquilan y devuelven soportes, con validaciones de negocio.

| Captura | Descripción | Código |
|---------|-------------|--------|
| ![5](Screenshots/5cap.png) | Creación de clientes | `new Cliente("Bruce Wayne", 23, "bruce.wayne", "batman2024");` - Incluye usuario/contraseña |
| ![6](Screenshots/6cap.png) | Catálogo de soportes | Array asociativo de 6 soportes disponibles para alquilar |
| ![7](Screenshots/7cap.png) | Alquileres con encadenamiento | `$cliente->alquilar($s1)->alquilar($s2);` - Method chaining |
| ![8](Screenshots/8cap.png) | Excepción: Alquiler duplicado | Lanza `SoporteYaAlquiladoException` si intenta alquilar lo mismo dos veces |
| ![9](Screenshots/9cap.png) | Control de cupo máximo | Lanza `CupoSuperadoException` al alcanzar límite de 3 alquileres |
| ![10](Screenshots/10cap.png) | Devolución y re-alquiler | `$cliente->devolver(26)->alquilar($s3);` - Libera espacio e inmediatamente alquila otro |
| ![11](Screenshots/11cap.png) | Listado de alquileres | `$cliente->getAlquileres();` - Array con todos los soportes actuales del cliente |
| ![12](Screenshots/12cap.png) | Error en devolución | Lanza `SoporteNoEncontradoException` si intenta devolver soporte no alquilado |

**Conceptos clave:** 
- **Fluent Interface**: Métodos devuelven `$this` para encadenamiento
- **Excepciones personalizadas**: Control de errores de negocio
- **Validaciones**: Previene estados inválidos (duplicados, cupo, devoluciones incorrectas)

---

### Sección 3: Gestión Completa del Videoclub (`inicio3.php`)

Demuestra la clase `Videoclub` integrando múltiples clientes y soportes.

| Captura | Descripción | Código |
|---------|-------------|--------|
| ![13](Screenshots/13cap.png) | Videoclub inicializado | `new Videoclub("VideoClub Express");` - Instancia con nombre |
| ![14](Screenshots/14cap.png) | Catálogo con 7 soportes | Agregación de CintaVideo, DVD, Juego usando `agregarSoporte($soporte)` |
| ![15](Screenshots/15cap.png) | 3 clientes registrados | Clientes con diferentes cupos máximos (3, 4, 2) usando `agregarCliente($cliente, $cupo)` |
| ![16](Screenshots/16cap.png) | Operaciones finales | Alquileres, validaciones de excepciones, devoluciones en flujo completo |

**Concepto clave:** La clase `Videoclub` actúa como contenedor que gestiona todo el catálogo y la experiencia del usuario.

---

### Sección 4: Sistema Web - Login y Gestión de Clientes

Interfaz web completa con autenticación y panel de administración para gestionar clientes.

| Captura | Descripción |
|---------|-------------|
| ![17](Screenshots/17cap.png) | Página de login - Formulario de autenticación para admin y clientes |
| ![18](Screenshots/18cap.png) | Panel de administración - Lista de clientes con opciones editar/eliminar |
| ![19](Screenshots/19cap.png) | Panel de administración - Lista de clientes con opciones editar/eliminar |
| ![20](Screenshots/20cap.png) | Descripcion del panel de administración - Lista de clientes con opciones editar/eliminar |
| ![21](Screenshots/21cap.png) | Editar datos de cliente - Modificar nombre, usuario y contraseña (opcional) |
| ![22](Screenshots/22cap.png) | Tras pulsar 'Eliminar cliente' |
| ![23](Screenshots/23cap.png) | Tras pulsar '+ Crear cliente' Creacion de nuevo cliente |

**Conceptos clave:**

- **Autenticación**: Login diferencia entre admin (panel completo) y clientes (perfil personal)
- **CRUD de clientes**: Crear, leer, actualizar, eliminar con validaciones
- **Persistencia JSON**: Los datos se guardan en `data/clientes.json` entre sesiones
- **Confirmación JavaScript**: Previene eliminaciones accidentales con `confirm()`
- **Control de permisos**: Admin gestiona todos, clientes solo su perfil

---

**Cómo ejecutar la aplicación web:**

```bash
# En tu navegador, accede a:
http://localhost/Proyecto-Videoclub/index.php

# Credenciales de prueba:
# Admin: usuario=admin, contraseña=admin
# Clientes disponibles:
#   usuario=bruce.wayne, contraseña=prueba1234
#   usuario=pepe.fdez, contraseña=prueba1234
#   usuario=ramon.dino, contraseña=prueba1234
#   usuario=barry.allen, contraseña=prueba1234
#   usuario=leo.messi, contraseña=prueba1234
```

---

**Cómo ejecutar las pruebas de CLI:**

```bash
# En tu navegador, accede a:
http://localhost/Proyecto-Videoclub/test/inicio.php    # Sección 1
http://localhost/Proyecto-Videoclub/test/inicio2.php   # Sección 2
http://localhost/Proyecto-Videoclub/test/inicio3.php   # Sección 3
http://localhost/Proyecto-Videoclub/index.php          # Seccion 4
```

---

<div align="center">

**Desarrollado por David López Ferreras y Yusef Laroussi de la Calle**

</div>

