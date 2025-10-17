# Guía para escribir mensajes de commit y pull request

Este documento sirve como referencia para mantener mensajes claros, consistentes y útiles en los commits y pull requests del proyecto.

## Mensajes de commit

Los commits deben ser breves pero descriptivos. Usa verbos en infinitivo y explica qué se hizo.

**Formato recomendado:**

<tipo>: <descripción breve del cambio>

**Tipos comunes:**

- feat: nueva funcionalidad
- fix: corrección de errores
- refactor: mejora de código sin cambiar funcionalidad
- docs: cambios en documentación
- style: cambios de formato (espacios, indentación, etc.)
- test: añadir o modificar pruebas
- chore: tareas menores (configuración, limpieza, etc.)

## Mensajes de pull request

Los pull requests deben tener un título claro y una descripción que explique los cambios realizados.

**Título:**

Añadir validación de formularios en el registro

**Descripción:**

Este pull request incluye:

- Validación de campos obligatorios
- Mensajes de error personalizados
- Preparación para integración con backend

Notas:

- Se probó en Chrome y Firefox
- No se detectaron errores en consola

**Si el pull request cierra un issue:**

Closes #12

## Recomendaciones

- Escribe en español claro y directo.
- Usa viñetas para listar cambios.
- Si hay algo pendiente o por revisar, indícalo en la descripción.
- Evita mensajes genéricos como “cambios” o “actualización”.
