
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
│   └── css/
│       └── style.css    
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

### Sección 1: Prueba de Soportes Individuales (inicio.php)

**Captura 1:** Página principal de pruebas
![Captura 1](assets/screenshots/cap1.png)
*Interfaz inicial del sistema de gestión de videoclub con navegación entre secciones.*

**Captura 2:** Prueba de CintaVideo
![Captura 2](assets/screenshots/cap2.png)
*Demostración de la clase CintaVideo mostrando título, precio y duración en minutos.*

**Captura 3:** Información del DVD
![Captura 3](assets/screenshots/cap3.png)
*Visualización de propiedades del DVD incluyendo idiomas soportados y formato de pantalla.*

**Captura 4:** Detalles del Juego
![Captura 4](assets/screenshots/cap4.png)
*Presentación de la clase Juego con consola, número de jugadores y precio.*

### Sección 2: Gestión de Clientes y Encadenamiento (inicio2.php)

**Captura 5:** Información de clientes
![Captura 5](assets/screenshots/cap5.png)
*Registro de dos clientes con sus identificadores únicos.*

**Captura 6:** Catálogo de soportes disponibles
![Captura 6](assets/screenshots/cap6.png)
*Lista de productos disponibles para alquilar con detalles y precios.*

**Captura 7:** Alquileres exitosos
![Captura 7](assets/screenshots/cap7.png)
*Resultado de alquileres múltiples usando encadenamiento de métodos (method chaining).*

**Captura 8:** Validación de alquiler duplicado
![Captura 8](assets/screenshots/cap8.png)
*Manejo de excepción cuando se intenta alquilar un soporte ya alquilado.*

**Captura 9:** Control de cupo máximo
![Captura 9](assets/screenshots/cap9.png)
*Validación que impide superar el máximo de alquileres concurrentes permitidos.*

**Captura 10:** Devolución y nuevo alquiler
![Captura 10](assets/screenshots/cap10.png)
*Proceso de devolución de soporte y alquiler de uno nuevo mediante encadenamiento.*

**Captura 11:** Listado de alquileres actuales
![Captura 11](assets/screenshots/cap11.png)
*Consulta de todos los soportes alquilados actualmente por un cliente.*

**Captura 12:** Validaciones de devolución
![Captura 12](assets/screenshots/cap12.png)
*Manejo de intentos de devolver soportes que no existen en los alquileres.*

### Sección 3: Gestión Completa del Videoclub (inicio3.php)

**Captura 13:** Inicialización del videoclub
![Captura 13](assets/screenshots/cap13.png)
*Creación del videoclub con nombre y estado inicial.*

**Captura 14:** Inclusión de productos en catálogo
![Captura 14](assets/screenshots/cap14.png)
*Adición de 7 productos variados (DVDs, juegos y cintas de vídeo) al catálogo.*

**Captura 15:** Gestión de socios
![Captura 15](assets/screenshots/cap15.png)
*Registro de socios con diferentes cupos máximos de alquiler concurrente.*

**Captura 16:** Alquileres y validaciones finales
![Captura 16](assets/screenshots/cap16.png)
*Demostración completa de operaciones: alquiler exitoso, validación de duplicados y control de cupo.*

---

<div align="center">

**Desarrollado para aprender PHP y POO**

</div>

