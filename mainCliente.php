<?php

/**
 * mainCliente.php
 * 
 * Esta es la página principal del cliente del Videoclub.
 * Solo los clientes registrados (usuarios que no sean admin) pueden acceder aquí.
 * 
 * Funcionalidades:
 * - Mostrar información del cliente
 * - Listado de alquileres del cliente
 * - Información detallada de cada soporte alquilado
 * - Opción de cerrar sesión
 */

// Incluimos el autoload de Composer ANTES de session_start para que las clases estén disponibles
require_once 'vendor/autoload.php';

// Iniciamos la sesión
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Aquí comprobamos si el usuario está realmente logueado Y si es un cliente.
 * Si no está logueado (no existe $_SESSION['usuario']),
 * lo redirigimos de vuelta al login.
 */
if (!isset($_SESSION['usuario']) || !isset($_SESSION['cliente'])) {
    // El usuario no está logueado como cliente, lo sacamos de aquí
    header('Location: index.php');
    exit();
}

// Guardamos el cliente actual en una variable
$cliente = $_SESSION['cliente'];
$nombre_usuario = $_SESSION['usuario'];

// Comprobamos si el usuario clickeó en "Cerrar sesión"
if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    // Eliminamos todos los datos de la sesión
    session_destroy();
    
    // Lo redirigimos al login
    header('Location: index.php');
    exit();
}

// Obtenemos el array de alquileres del cliente
$alquileres = $cliente->getAlquileres();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - Videoclub</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Encabezado con información del usuario logueado -->
        <header class="main-header">
            <div class="header-content">
                <!-- Título del videoclub -->
                <h1>Videoclub - Mi Cuenta</h1>

                <!-- Información del usuario logueado y enlace para salir -->
                <div class="user-info">
                    <!-- 
                        htmlspecialchars() es una función de seguridad que convierte
                        caracteres especiales para evitar ataques de XSS.
                    -->
                    <p>Bienvenido, <strong><?php echo htmlspecialchars($cliente->nombre); ?></strong></p>

                    <!-- 
                        El parámetro logout=1 en la URL es para que PHP sepa que
                        el usuario quiere cerrar sesión.
                    -->
                    <a href="mainCliente.php?logout=1" class="btn-logout">Cerrar Sesión</a>
                </div>
            </div>
        </header>

        <main>
            <!-- SECCIÓN DE INFORMACIÓN DEL CLIENTE -->
            <section class="welcome-section">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2>Información de tu Cuenta</h2>
                        <div class="info-cliente">
                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($cliente->nombre); ?></p>
                            <p><strong>Usuario:</strong> <span class="badge badge-usuario"><?php echo htmlspecialchars($cliente->getUsuario()); ?></span></p>
                            <p><strong>ID Cliente:</strong> <?php echo htmlspecialchars($cliente->getNumero()); ?></p>
                        </div>
                    </div>
                    <!-- He agregado un botón para editar los datos del cliente -->
                    <a href="formUpdateCliente.php" class="btn-action" style="background-color: #3498db; text-decoration: none; padding: 10px 20px; display: inline-block; margin-top: 20px; height: fit-content;">Editar mis datos</a>
                </div>
            </section>

            <!-- SECCIÓN DE LISTADO DE ALQUILERES -->
            <section class="admin-section">
                <h2>Mis Alquileres</h2>
                
                <?php if (count($alquileres) > 0): ?>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Precio (€)</th>
                                    <th>Precio con IVA (€)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alquileres as $soporte): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($soporte->getNumero()); ?></td>
                                        <td><?php echo htmlspecialchars($soporte->titulo); ?></td>
                                        <td>
                                            <?php 
                                            // Determinamos el tipo de soporte usando get_class
                                            $clase = get_class($soporte);
                                            if (strpos($clase, 'CintaVideo') !== false) {
                                                echo 'Cinta de Video';
                                            } elseif (strpos($clase, 'Dvd') !== false) {
                                                echo 'DVD';
                                            } elseif (strpos($clase, 'Juego') !== false) {
                                                echo 'Videojuego';
                                            } else {
                                                echo 'Desconocido';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo number_format($soporte->getPrecio(), 2, ',', '.'); ?></td>
                                        <td><?php echo number_format($soporte->getPrecioConIVA(), 2, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- RESUMEN DE ALQUILERES -->
                    <section class="admin-section" style="margin-top: 30px;">
                        <h3>Resumen de Alquileres</h3>
                        <div class="stats-container">
                            <div class="stat-card">
                                <div class="stat-number"><?php echo count($alquileres); ?></div>
                                <div class="stat-label">Soportes Alquilados</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">
                                    <?php
                                    // Calculamos el costo total de los alquileres
                                    $costo_total = 0;
                                    foreach ($alquileres as $soporte) {
                                        $costo_total += $soporte->getPrecio();
                                    }
                                    echo number_format($costo_total, 2, ',', '.');
                                    ?>
                                </div>
                                <div class="stat-label">Costo Total (€)</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">
                                    <?php
                                    // Calculamos el costo total con IVA
                                    $costo_total_iva = 0;
                                    foreach ($alquileres as $soporte) {
                                        $costo_total_iva += $soporte->getPrecioConIVA();
                                    }
                                    echo number_format($costo_total_iva, 2, ',', '.');
                                    ?>
                                </div>
                                <div class="stat-label">Costo Total con IVA (€)</div>
                            </div>
                        </div>
                    </section>
                <?php else: ?>
                    <div class="mensaje-info">
                        <p>No tienes ningún soporte alquilado en este momento.</p>
                    </div>
                <?php endif; ?>
            </section>

        </main>

        <!-- Pie de página -->
        <footer class="main-footer">
            <p>Videoclub - Sistema de Gestión</p>
        </footer>
    </div>
</body>

</html>
