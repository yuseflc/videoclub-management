<?php

/**
 * mainAdmin.php
 * 
 * Esta es la página de administración del Videoclub.
 * Solo los administradores (usuario: admin) pueden acceder aquí.
 * 
 * Funcionalidades:
 * - Carga de datos de soportes y clientes desde arrays asociativos
 * - Almacenamiento en sesión para futuros accesos desde base de datos
 * - Listado de clientes
 * - Listado de soportes
 * - Página de bienvenida para administrador
 */

// Iniciamos la sesión (igual que en index.php)
// Necesitamos hacer esto en TODAS las páginas donde queremos usar $_SESSION
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Aquí comprobamos si el usuario está realmente logueado Y si es administrador.
 * Si no está logueado (no existe $_SESSION['usuario']),
 * lo redirigimos de vuelta al login.
 */
if (!isset($_SESSION['usuario'])) {
    // El usuario no está logueado, lo sacamos de aquí
    header('Location: index.php');
    exit();
}

// Guardamos el nombre del usuario para usarlo en el HTML
$nombre_usuario = $_SESSION['usuario'];

// Incluimos el autoload para cargar las clases automáticamente
require_once 'autoload.php';

// Importamos las clases que vamos a usar
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;

/**
 * CARGA DE DATOS DE PRUEBA
 * 
 * En esta sección copiamos los datos de las pruebas del proyecto
 * en arrays asociativos y los guardamos en la sesión.
 * 
 * Nota: En futuras versiones, estos datos se cargarán desde la base de datos.
 * En esta versión solo se cargan si no existen ya en la sesión.
 */
if (!isset($_SESSION['clientes']) || !isset($_SESSION['soportes'])) {
    
    /**
     * CREACIÓN DE SOPORTES DE PRUEBA
     * 
     * Creamos varios soportes (Cintas, DVDs y Juegos) como si fuera el catálogo
     * del videoclub. Usamos tipos diferentes para demostrar la herencia.
     */
    $soporte1 = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
    $soporte2 = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
    $soporte3 = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);
    $soporte4 = new Dvd("El Imperio Contraataca", 4, 3, "es,en", "16:9");
    $soporte5 = new CintaVideo("Blade Runner", 5, 4.5, 117);
    $soporte6 = new Juego("Elden Ring", 27, 59.99, "PS5", 1, 1);
    
    /**
     * Array asociativo de soportes
     * 
     * Guardamos los soportes en un array donde la clave es el número del soporte
     * y el valor es el objeto Soporte. Esto permite acceder fácilmente a cada soporte.
     */
    $soportes_array = array(
        23 => $soporte1,  // Los cazafantasmas
        24 => $soporte2,  // Origen
        26 => $soporte3,  // The Last of Us Part II
        4 => $soporte4,   // El Imperio Contraataca
        5 => $soporte5,   // Blade Runner
        27 => $soporte6   // Elden Ring
    );
    
    /**
     * CREACIÓN DE CLIENTES DE PRUEBA
     * 
     * Creamos varios clientes del videoclub con sus números de identificación.
     * Los clientes tienen un límite de 3 alquileres concurrentes.
     */
    $cliente1 = new Cliente("Bruce Wayne", 23);
    $cliente2 = new Cliente("Clark Kent", 33);
    $cliente3 = new Cliente("Diana Prince", 45);
    $cliente4 = new Cliente("Barry Allen", 12);
    $cliente5 = new Cliente("Arthur Curry", 56);
    
    /**
     * Array asociativo de clientes
     * 
     * Guardamos los clientes en un array donde la clave es el número del cliente
     * y el valor es el objeto Cliente.
     */
    $clientes_array = array(
        23 => $cliente1,  // Bruce Wayne
        33 => $cliente2,  // Clark Kent
        45 => $cliente3,  // Diana Prince
        12 => $cliente4,  // Barry Allen
        56 => $cliente5   // Arthur Curry
    );
    
    /**
     * Almacenamos los arrays en la sesión
     * 
     * De esta forma, los datos estarán disponibles en toda la sesión del usuario
     * y en futuras peticiones al servidor.
     */
    $_SESSION['soportes'] = $soportes_array;
    $_SESSION['clientes'] = $clientes_array;
}

/**
 * RECUPERACIÓN DE DATOS DE LA SESIÓN
 * 
 * Obtenemos los arrays de clientes y soportes desde la sesión.
 */
$clientes = $_SESSION['clientes'];
$soportes = $_SESSION['soportes'];

// Comprobamos si el usuario clickeó en "Cerrar sesión"
if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    // Eliminamos todos los datos de la sesión
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
    <title>Administración - Videoclub</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Encabezado con información del usuario logueado -->
        <header class="main-header">
            <div class="header-content">
                <!-- Título del videoclub -->
                <h1>🎬 Videoclub - Panel de Administración</h1>

                <!-- Información del usuario logueado y enlace para salir -->
                <div class="user-info">
                    <!-- 
                        htmlspecialchars() es una función de seguridad que convierte
                        caracteres especiales para evitar ataques de XSS.
                    -->
                    <p>Bienvenido, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>

                    <!-- 
                        El parámetro logout=1 en la URL es para que PHP sepa que
                        el usuario quiere cerrar sesión.
                    -->
                    <a href="mainAdmin.php?logout=1" class="btn-logout">Cerrar Sesión</a>
                </div>
            </div>
        </header>

        <main>
            <!-- SECCIÓN DE BIENVENIDA -->
            <section class="welcome-section">
                <h2>Panel de Administración del Videoclub</h2>
                <p>Aquí puedes ver y gestionar todos los clientes y soportes del videoclub.</p>
                <p>Los datos mostrados a continuación se cargan desde arrays asociativos.</p>
                <p><em>En futuras versiones se cargarán desde una base de datos.</em></p>
            </section>

            <!-- SECCIÓN DE LISTADO DE CLIENTES -->
            <section class="admin-section">
                <h2>📋 Listado de Clientes</h2>
                
                <?php if (count($clientes) > 0): ?>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Soportes Alquilados</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $id => $cliente): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($id); ?></td>
                                        <td><?php echo htmlspecialchars($cliente->nombre); ?></td>
                                        <td>
                                            <span class="badge badge-info">
                                                <?php echo $cliente->getNumSoportesAlquilados(); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn-action">Ver detalles</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="mensaje-info">
                        <p>No hay clientes registrados en el sistema.</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- SECCIÓN DE LISTADO DE SOPORTES -->
            <section class="admin-section">
                <h2>💿 Listado de Soportes</h2>
                
                <?php if (count($soportes) > 0): ?>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Tipo</th>
                                    <th>Precio (€)</th>
                                    <th>Precio con IVA (€)</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($soportes as $id => $soporte): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($id); ?></td>
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
                                        <td>
                                            <?php if ($soporte->alquilado): ?>
                                                <span class="badge badge-danger">Alquilado</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">Disponible</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn-action">Ver detalles</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="mensaje-info">
                        <p>No hay soportes registrados en el catálogo.</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- SECCIÓN DE ESTADÍSTICAS -->
            <section class="admin-section">
                <h2>📊 Estadísticas del Videoclub</h2>
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo count($clientes); ?></div>
                        <div class="stat-label">Clientes Registrados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo count($soportes); ?></div>
                        <div class="stat-label">Soportes Disponibles</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">
                            <?php
                            // Contamos cuántos soportes están alquilados
                            $alquilados = 0;
                            foreach ($soportes as $soporte) {
                                if ($soporte->alquilado) {
                                    $alquilados++;
                                }
                            }
                            echo $alquilados;
                            ?>
                        </div>
                        <div class="stat-label">Soportes Alquilados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">
                            <?php
                            // Calculamos la inversión total en soportes
                            $inversion_total = 0;
                            foreach ($soportes as $soporte) {
                                $inversion_total += $soporte->getPrecio();
                            }
                            echo number_format($inversion_total, 2, ',', '.');
                            ?>
                        </div>
                        <div class="stat-label">Inversión Total (€)</div>
                    </div>
                </div>
            </section>

        </main>

        <!-- Pie de página -->
        <footer class="main-footer">
            <p>&copy; 2025 Videoclub Online - Sistema de Gestión</p>
            <p>Desarrollado por Yusef Laroussi y David López Ferreras</p>
        </footer>
    </div>

    <style>
        /* Estilos adicionales específicos del panel de administración */
        
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .admin-table thead {
            background-color: #2c3e50;
            color: white;
        }

        .admin-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #34495e;
        }

        .admin-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ecf0f1;
        }

        .admin-table tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-info {
            background-color: #3498db;
            color: white;
        }

        .badge-success {
            background-color: #27ae60;
            color: white;
        }

        .badge-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-action {
            padding: 6px 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .btn-action:hover {
            background-color: #2980b9;
        }

        .admin-section {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }

        .admin-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .welcome-section p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #3498db;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }

        .mensaje-info {
            background-color: #d5f4e6;
            border: 1px solid #27ae60;
            color: #27ae60;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</body>

</html>
