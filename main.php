<?php

/**
 * 
 * Si llegaste aquí es porque tu login fue exitoso. Esta es la página
 * "privada" que solo pueden ver los usuarios autenticados.
 */

// Iniciamos la sesión (igual que en index.php)
// Necesitamos hacer esto en TODAS las páginas donde queremos usar $_SESSION
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Aquí comprobamos si el usuario está realmente logueado.
 * Si no está logueado (no existe $_SESSION['usuario']),
 * lo redirigimos de vuelta al login.
 * 
 * ¿Por qué? Porque si alguien intenta acceder a main.php directamente
 * sin pasar por login, no debería poder entrar.
 */
if (!isset($_SESSION['usuario'])) {
    // El usuario no está logueado, lo sacamos de aquí
    header('Location: index.php');
    exit();
}

// Si llegamos aquí, es porque el usuario SÍ está logueado
// Guardamos su nombre en una variable para usarlo en el HTML
$nombre_usuario = $_SESSION['usuario'];

// Comprobamos si el usuario clickeó en "Cerrar sesión"
if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    // Eliminamos todos los datos de la sesión
    // session_destroy() borra completamente la sesión del usuario
    session_destroy();

    // Lo redirigimos al login
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal - Videoclub</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Encabezado con información del usuario logueado -->
        <header class="main-header">
            <div class="header-content">
                <!-- Título del videoclub -->
                <h1>Videoclub</h1>

                <!-- Información del usuario logueado y enlace para salir -->
                <div class="user-info">
                    <!-- 
                        htmlspecialchars() es una función de seguridad que convierte
                        caracteres especiales para evitar ataques. Por ejemplo, si alguien
                        intentara poner código malicioso en el nombre de usuario.
                    -->
                    <p>Bienvenido, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>

                    <!-- 
                        El parámetro logout=1 en la URL es para que PHP sepa que
                        el usuario quiere cerrar sesión. Cuando abre este enlace,
                        se ejecutará el código de arriba que destruye la sesión.
                    -->
                    <a href="main.php?logout=1" class="btn-logout">Cerrar Sesión</a>
                </div>
            </div>
        </header>

        <main>
            <section>
                <p>Has accedido correctamente a traves del login.</p>
            </section>

            <section>
                <p>Si quieres iniciar sesion de nuevo pulsa en el boton de 'Cerrar sesion'.</p>
            </section>

            <section>
                <p>Puede encontrar fallos ya que es una version de prueba.</p>
            </section>

            <section>
                <p>Gracias por utilizar el sistema de gestión web del Videoclub.</p>
            </section>

            <section>
                <p>Si tiene alguna duda contacte con los administradores, Yusef y o David.</p>
            </section>
        </main>

        <!-- Pie de página -->
        <footer class="main-footer">
            <p>&copy; 2025 Videoclub Online - Sistema de Gestión</p>
            <p>Desarrollado por Yusef Laroussi y David López Ferreras</p>
        </footer>
    </div>
</body>

</html>