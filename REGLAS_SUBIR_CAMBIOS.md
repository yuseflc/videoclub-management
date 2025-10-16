# Guía paso a paso para subir cambios desde una rama `feature` a `develop` y luego a `main` usando GitHub Desktop

Este documento explica cómo integrar cambios al proyecto desde una rama de desarrollo (`feature/yusef`, `feature/david`, etc.) hacia `develop`, y posteriormente a `main`, utilizando GitHub Desktop. Se siguen las reglas de protección establecidas para mantener el orden y evitar conflictos.

## Estructura de ramas

- `main`: Rama estable. Solo recibe cambios desde `develop`.
- `develop`: Rama de integración. Aquí se fusionan las ramas `feature`.
- `feature/<nombre>`: Ramas individuales para cada funcionalidad o tarea.

## Subir cambios desde `feature` a `develop`

1. Confirmar los cambios en tu rama `feature`
   - Abre GitHub Desktop.
   - Asegúrate de estar en tu rama, por ejemplo `feature/yusef`.
   - Revisa los archivos modificados en la pestaña Changes.
   - Escribe un mensaje de commit claro y descriptivo. Ejemplo: "Añadida validación de campos en el formulario de registro".
   - Haz clic en Commit to feature/yusef.

2. Sincronizar tu rama con `develop`
   - Cambia a la rama `develop` desde el menú de ramas.
   - Haz clic en Fetch origin y luego en Pull origin para obtener la última versión.
   - Vuelve a tu rama `feature/yusef`.
   - Haz clic en Branch → Merge into current branch... y selecciona `develop`.
   - Si hay conflictos, resuélvelos y haz commit de la resolución.

3. Crear un Pull Request hacia `develop`
   - En GitHub Desktop, haz clic en Branch → Create Pull Request.
   - Verifica que la base sea `develop` y la comparación sea tu rama `feature`.
   - Escribe un título claro y una descripción útil. Ejemplo:
     Título: Validación de formularios
     Descripción:
     - Se añadió validación de campos obligatorios
     - Se muestran mensajes de error personalizados
     - Listo para integración con backend
   - Haz clic en Create Pull Request (esto abrirá GitHub en el navegador).
   - Espera la revisión y aprobación (si aplica).
   - Una vez aprobado, haz clic en Merge pull request y luego en Confirm merge.

## Subir cambios desde `develop` a `main`

Solo haz esto cuando `develop` esté listo para entrega o publicación.

1. Verificar que `main` esté actualizado
   - Cambia a la rama `main` en GitHub Desktop.
   - Haz clic en Fetch origin y luego en Pull origin.

2. Fusionar `develop` en `main`
   - Cambia a la rama `develop`.
   - Haz clic en Branch → Merge into current branch... y selecciona `main`.
   - Revisa los cambios y resuelve conflictos si aparecen.
   - Haz commit si es necesario.
   - Haz clic en Push origin para subir los cambios.

## Recomendaciones generales

- Siempre trabajar en ramas `feature/<nombre>` creadas desde `develop`.
- Actualizar tu rama con los últimos cambios de `develop` antes de hacer el pull request.
- Resolver conflictos en tu rama `feature`, no en `develop` ni `main`.
- Usar mensajes de commit y descripciones claras.
- Comunicarse con el compañero antes de hacer el merge para evitar solapamientos.

Este flujo asegura que el proyecto se mantenga limpio, organizado y libre de conflictos innecesarios.
