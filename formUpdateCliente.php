<?php

/**
 * formUpdateCliente.php
 * 
 * Formulario para editar los datos de un cliente existente.
 * He creado este formulario tanto para que el cliente edite sus propios datos,
 * como para que el administrador pueda editar los datos de cualquier cliente.
 * 
 * Funcionalidades:
 * - Mostrar un formulario con los datos actuales del cliente
 * - Permitir cambiar nombre, usuario y contraseña
 * - Redirigir a updateCliente.php para procesar los cambios
 */

// Incluyo el autoload ANTES de session_start para que las clases estén disponibles
require_once 'autoload.php';

// Inicio la sesión
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Aquí verifico que:
 * 1. El usuario esté logueado
 * 2. Si es cliente, que solo edite sus propios datos
 * 3. Si es admin, que pueda editar cualquier cliente
 */
if (!isset($_SESSION['usuario'])) {
    // El usuario no está logueado
    header('Location: index.php');
    exit();
}

// Obtengo el ID del cliente que quiero editar (viene en la URL o en la sesión)
$id_cliente_editar = isset($_GET['id']) ? intval($_GET['id']) : null;
$nombre_usuario = $_SESSION['usuario'];

/**
 * DETERMINAMOS QUÉ CLIENTE EDITAR
 * 
 * Si es admin, puede editar cualquier cliente (el ID viene en la URL)
 * Si es cliente normal, solo puede editar el suyo propio
 */
$cliente_a_editar = null;

if ($nombre_usuario === 'admin') {
    // Es administrador, puede editar cualquier cliente
    if ($id_cliente_editar === null) {
        // No hay ID en la URL, redirigimos al listado
        header('Location: mainAdmin.php');
        exit();
    }

    // Buscamos el cliente por ID en la sesión
    if (isset($_SESSION['clientes'][$id_cliente_editar])) {
        $cliente_a_editar = $_SESSION['clientes'][$id_cliente_editar];
    } else {
        // Cliente no encontrado
        header('Location: mainAdmin.php');
        exit();
    }
} else {
    // Es un cliente normal, solo puede editar el suyo
    if (isset($_SESSION['cliente'])) {
        $cliente_a_editar = $_SESSION['cliente'];
    } else {
        // No es un cliente válido
        header('Location: index.php');
        exit();
    }
}

// Ahora tengo el cliente que voy a editar
$id_cliente = $cliente_a_editar->getNumero();
$nombre_actual = $cliente_a_editar->nombre;
$usuario_actual = $cliente_a_editar->getUsuario();

// Variables para mostrar errores si viene del POST con errores
$mostrar_error = false;
$mensaje_error = '';

if (isset($_GET['error'])) {
    $mostrar_error = true;
    $mensaje_error = htmlspecialchars($_GET['error']);
}

// Recupero los datos antiguos en caso de error
$nombre_antiguo = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : $nombre_actual;
$usuario_antiguo = isset($_GET['usuario']) ? htmlspecialchars($_GET['usuario']) : $usuario_actual;

// Determino a dónde volver después de guardar
// Si es admin, vuelvo a mainAdmin.php
// Si es cliente, vuelvo a mainCliente.php
$pagina_retorno = ($nombre_usuario === 'admin') ? 'mainAdmin.php' : 'mainCliente.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - Videoclub</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/formUpdate.css">
</head>

<body>
    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Encabezado con información del usuario logueado -->
        <header class="main-header">
            <div class="header-content">
                <!-- Título del videoclub -->
                <h1>Videoclub - Editar Cliente</h1>

                <!-- Información del usuario logueado y enlace para salir -->
                <div class="user-info">
                    <p>Bienvenido, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                    <?php if ($nombre_usuario === 'admin'): ?>
                        <a href="mainAdmin.php?logout=1" class="btn-logout">Cerrar Sesión</a>
                    <?php else: ?>
                        <a href="mainCliente.php?logout=1" class="btn-logout">Cerrar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <main>
            <!-- SECCIÓN DE BIENVENIDA -->
            <section class="welcome-section">
                <h2>Editar Datos del Cliente</h2>
                <p>Aquí puedes modificar la información del cliente. Completa los campos que desees cambiar.</p>
            </section>

            <!-- MOSTRAR ERROR SI LO HAY -->
            <?php if ($mostrar_error): ?>
                <div class="mensaje-error" style="margin: 20px auto; max-width: 600px;">
                    <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>

            <!-- FORMULARIO DE EDICIÓN DE CLIENTE -->
            <section class="admin-section" style="max-width: 600px; margin: 30px auto;">
                <form method="POST" action="updateCliente.php" class="form-update-cliente">

                    <!-- Campo ID (oculto) para identificar qué cliente editar -->
                    <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($id_cliente); ?>">

                    <!-- Campo Nombre -->
                    <div class="form-group">
                        <label for="nombre">Nombre Completo:</label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            placeholder="Ej: Yusef Laroussi de la Calle";
                            value=<?php echo $nombre_antiguo; ?>
                            required>
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
                            required>
                        <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                            Debe ser único y sin espacios
                        </small>
                    </div>

                    <!-- Campo Contraseña (Opcional) -->
                    <div class="form-group">
                        <label for="password">Contraseña (dejar en blanco si no deseas cambiarla):</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Deja en blanco para no cambiar la contraseña">
                        <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                            Si quieres cambiarla, mínimo 6 caracteres
                        </small>
                    </div>

                    <!-- Campo Confirmar Contraseña (Opcional) -->
                    <div class="form-group">
                        <label for="password_confirm">Confirmar Contraseña:</label>
                        <input
                            type="password"
                            id="password_confirm"
                            name="password_confirm"
                            placeholder="Repite la contraseña si la cambias">
                    </div>

                    <!-- Botones de Acción -->
                    <div class="form-actions" style="display: flex; gap: 10px; margin-top: 30px;">
                        <button type="submit" class="btn-update">Guardar Cambios</button>
                        <a href="<?php echo htmlspecialchars($pagina_retorno); ?>" class="btn-cancel">Cancelar</a>
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