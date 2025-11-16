<?php

/**
 * formCreateCliente.php
 * 
 * Formulario para dar de alta a un nuevo cliente en el videoclub.
 * Solo los administradores pueden acceder aquí.
 * 
 * Funcionalidades:
 * - Formulario HTML para recopilar datos del nuevo cliente
 * - Validación en el lado del servidor en createCliente.php
 * - Redirección a mainAdmin.php tras crear el cliente
 */

// Incluimos el autoload ANTES de session_start
require_once 'autoload.php';

// Iniciamos la sesión
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Aquí comprobamos si el usuario está realmente logueado Y si es administrador.
 * Si no está logueado, lo redirigimos de vuelta al login.
 */
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    // El usuario no es administrador, lo sacamos de aquí
    header('Location: index.php');
    exit();
}

// Guardamos el nombre del usuario para usarlo en el HTML
$nombre_usuario = $_SESSION['usuario'];

// Variable para mostrar errores de validación
$mostrar_error = false;
$mensaje_error = '';

// Si viene del POST con errores, mostramos el mensaje
if (isset($_GET['error'])) {
    $mostrar_error = true;
    $mensaje_error = htmlspecialchars($_GET['error']);
}

// Recuperamos los datos que el usuario escribió en caso de error
$nombre_antiguo = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '';
$usuario_antiguo = isset($_GET['usuario']) ? htmlspecialchars($_GET['usuario']) : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente - Videoclub</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/formCreate.css">
</head>

<body>
    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Encabezado con información del usuario logueado -->
        <header class="main-header">
            <div class="header-content">
                <!-- Título del videoclub -->
                <h1>Videoclub - Crear Cliente</h1>

                <!-- Información del usuario logueado y enlace para salir -->
                <div class="user-info">
                    <p>Bienvenido, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                    <a href="mainAdmin.php?logout=1" class="btn-logout">Cerrar Sesión</a>
                </div>
            </div>
        </header>

        <main>
            <!-- SECCIÓN DE BIENVENIDA -->
            <section class="welcome-section">
                <h2>Crear Nuevo Cliente</h2>
                <p>Completa el formulario para registrar un nuevo cliente en el videoclub.</p>
            </section>

            <!-- MOSTRAR ERROR SI LO HAY -->
            <?php if ($mostrar_error): ?>
                <div class="mensaje-error" style="margin: 20px auto; max-width: 600px;">
                    <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>

            <!-- FORMULARIO DE CREACIÓN DE CLIENTE -->
            <section class="admin-section" style="max-width: 600px; margin: 30px auto;">
                <form method="POST" action="createCliente.php" class="form-create-cliente">
                    
                    <!-- Campo Nombre -->
                    <div class="form-group">
                        <label for="nombre">Nombre Completo:</label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            placeholder="Ej: Yusef Laroussi de la Calle"
                            value="<?php echo $nombre_antiguo; ?>"
                            required
                        >
                    </div>

                    <!-- Campo Usuario -->
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input 
                            type="text" 
                            id="usuario" 
                            name="usuario" 
                            placeholder="Ej: yuseflc"
                            value="<?php echo $usuario_antiguo; ?>"
                            required
                        >
                        <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                            Debe ser único y sin espacios
                        </small>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Ingresa una contraseña segura"
                            required
                        >
                        <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                            Mínimo 6 caracteres
                        </small>
                    </div>

                    <!-- Campo Confirmar Contraseña -->
                    <div class="form-group">
                        <label for="password_confirm">Confirmar Contraseña:</label>
                        <input 
                            type="password" 
                            id="password_confirm" 
                            name="password_confirm" 
                            placeholder="Repite la contraseña"
                            required
                        >
                    </div>

                    <!-- Botones de Acción -->
                    <div class="form-actions" style="display: flex; gap: 10px; margin-top: 30px;">
                        <button type="submit" class="btn-create">Crear Cliente</button>
                        <a href="mainAdmin.php" class="btn-cancel">Cancelar</a>
                    </div>
                </form>
            </section>

        </main>

        <!-- Pie de página -->
        <footer class="main-footer">
            <p>Videoclub - Sistema de Gestión</p>
        </footer>
    </div>
</body>

</html>
