# 🛡️ Reglas de protección de ramas

Este documento describe las configuraciones de protección aplicadas a las ramas `main` y `develop` en este proyecto colaborativo. El objetivo es mantener un flujo de trabajo ordenado, evitar errores accidentales y facilitar la colaboración entre los miembros del equipo, en este caso entre David Lopez Ferreras y Yusef Laroussi de la Calle.

---

## 🔹 Rama `main`

La rama `main` representa la versión estable del proyecto. No se realizan cambios directos en ella. Todos los cambios deben llegar desde `develop` mediante _pull requests_.

### ✅ Configuraciones activadas:

- **Require a pull request before merging**  
  Se requiere un _pull request_ para integrar cambios. Esto evita que se hagan modificaciones directas a la rama `main`.

- **Dismiss stale pull request approvals when new commits are pushed**  
  Si se agregan nuevos commits a un _pull request_, las aprobaciones anteriores se invalidan. Esto obliga a revisar siempre la versión más reciente antes de hacer _merge_.

- **Require conversation resolution before merging**  
  Todos los comentarios y conversaciones en el _pull request_ deben estar resueltos antes de permitir el _merge_. Esto asegura que no queden dudas ni observaciones pendientes.

- **Do not allow bypassing the above settings**  
  Nadie puede saltarse estas reglas, ni siquiera los administradores o usuarios con permisos especiales (en este caso el administrador del repositorio, Yusef Laroussi de la Calle). Se garantiza que todos sigan el mismo proceso de revisión.

---

## 🔸 Rama `develop`

La rama `develop` es el punto de integración de las ramas `feature`. Aquí se revisan y prueban los cambios antes de pasar a `main`.

### ✅ Configuraciones activadas:

- **Require status checks to pass before merging**  
  Si existen pruebas automáticas (como tests o validaciones), deben completarse correctamente antes de permitir el _merge_. Esto asegura que el código no rompa funcionalidades existentes.

  - **Require branches to be up to date before merging**  
    La rama del _pull request_ debe estar sincronizada con la última versión de `develop` antes de hacer _merge_. Esto ayuda a evitar conflictos y garantiza que las pruebas se ejecuten sobre el código más reciente.

---

## 📌 Recomendaciones generales

- Antes de hacer _merge_, actualizar la rama con los últimos cambios de `develop`.
- Resolver conflictos en la rama `feature`, no en `develop` ni `main`.
- Usar mensajes de commit claros y descriptivos.
- Comunicarse antes de hacer _merge_ para evitar solapamientos. Muy importante para no pisarnos entre nosotros.

---

Estas reglas están diseñadas para facilitar el trabajo colaborativo y mantener la calidad del código sin complicar el flujo de desarrollo del proyecto.
