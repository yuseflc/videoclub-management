
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

Este proyecto cuenta con el apoyo de **GitHub Copilot**, concretamente **Claude Sonnet 4.5**, para facilitar la escritura de código, comentarios y documentación, ayudando a mantener la coherencia y calidad en el desarrollo.

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

*Esta sección se completará más adelante, cuando el proyecto tenga una interfaz visual o ejemplos de ejecución.*

---

<div align="center">

**Desarrollado para aprender PHP y POO**

</div>

