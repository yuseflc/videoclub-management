<?php
/**
 *
 * Cuando alguien entra al Videoclub online,
 * primero aterriza en esta página. Les pedimos que se identifiquen con
 * un usuario y contraseña.
 */

// Incluimos el autoload de Composer ANTES de session_start para que las clases estén disponibles
require_once 'vendor/autoload.php';
require_once 'clientesData.php';

// Iniciamos la sesión. Las sesiones en PHP nos permiten mantener información
// del usuario mientras navega por el sitio. Es como si le diéramos un "carnet"
// que lo identifica durante su visita.
session_start();

// Si el usuario ya está logueado (tiene una sesión activa), lo redirigimos
// directamente a main.php para que no vuelva a ver el login.
// Explicación: isset() comprueba si la variable existe, $_SESSION['usuario']
// es donde guardamos el nombre del usuario cuando se loguea correctamente.
if (isset($_SESSION['usuario'])) {
    // header() nos permite redirigir a otra página
    // exit() detiene la ejecución del script actual
    header('Location: main.php');
    exit();
}

// Variables para mostrar mensajes de error
$mostrar_error = false;  // Bandera para saber si hay error
$mensaje_error = '';     // El texto del mensaje de error

// Comprobamos si el formulario ha sido enviado por el usuario (método POST)
// $_POST es un array especial que PHP nos da con los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos los valores que el usuario escribió en los campos del formulario
    // isset() comprueba que existan, trim() elimina espacios en blanco al inicio/final
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    // Verificamos que el usuario no dejó los campos vacíos
    if (empty($usuario) || empty($password)) {
        $mostrar_error = true;
        $mensaje_error = 'Por favor, completa todos los campos.';
    } else {
        // Si los campos no están vacíos, llamamos a login.php para verificar
        // los datos usando require_once (que ejecuta el archivo una sola vez)
        require_once 'login.php';
        
        // Después de require_once, la función verificarLogin() estará disponible
        // Le pasamos el usuario y contraseña para que los verifique
        $resultado = verificarLogin($usuario, $password);
        
        // Si verificarLogin() devuelve true, el usuario es correcto
        if ($resultado === true) {
            // Guardamos el usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            
            // Comprobamos si el usuario es administrador
            // Si es admin, lo redirigimos a mainAdmin.php
            if ($usuario === 'admin') {
                header('Location: mainAdmin.php');
                exit();
            }
            
            // Si no es admin, verificamos si es un cliente registrado
            // Cargamos los datos de clientes de la sesión
            if (!isset($_SESSION['clientes'])) {
                // Si no hay clientes en la sesión, los cargamos desde mainAdmin
                require_once 'mainAdmin.php';
            }
            
            // También cargamos los clientes persistidos
            $datosClientesPeristidos = cargar_clientes_persistidos();
            if (!empty($datosClientesPeristidos)) {
                foreach ($datosClientesPeristidos as $numero => $datosCliente) {
                    // Creamos un objeto Cliente con los datos persistidos
                    $clientePersistido = new \Dwes\ProyectoVideoclub\Cliente(
                        $datosCliente['nombre'],
                        $numero,
                        $datosCliente['usuario'],
                        $datosCliente['password']
                    );
                    // Establecemos la contraseña ya hasheada usando el setter
                    $clientePersistido->setPassword($datosCliente['password']);
                    
                    // Agregamos el cliente persistido a la sesión
                    $_SESSION['clientes'][$numero] = $clientePersistido;
                }
            }
            
            // Buscamos si el usuario coincide con algún cliente
            $clientes = $_SESSION['clientes'];
            $clienteEncontrado = null;
            $passwordEncontrada = null;
            
            foreach ($clientes as $cliente) {
                if ($cliente->getUsuario() === $usuario) {
                    $clienteEncontrado = $cliente;
                    $passwordEncontrada = $cliente->getPassword();
                    break;
                }
            }
            
            // Si es un cliente registrado, lo redirigimos a mainCliente.php
            if ($clienteEncontrado !== null) {
                // Verificamos la contraseña usando password_verify para las contraseñas hasheadas
                if (password_verify($password, $passwordEncontrada)) {
                    $_SESSION['cliente'] = $clienteEncontrado;
                    header('Location: mainCliente.php');
                    exit();
                } else {
                    // Contraseña incorrecta
                    $mostrar_error = true;
                    $mensaje_error = 'Usuario o contraseña incorrectos. Intenta de nuevo.';
                }
            } else {
                // Si no es admin ni cliente, lo redirigimos a main.php
                header('Location: main.php');
                exit();
            }
        } else {
            // Si no es correcto, mostramos error
            $mostrar_error = true;
            $mensaje_error = 'Usuario o contraseña incorrectos. Intenta de nuevo.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Videoclub</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <!-- Contenedor principal del login -->
    <div class="login-container">
        <!-- Encabezado con el título del videoclub -->
        <div class="login-header">
            <h1>Videoclub Online</h1>
            <p>Sistema de Gestión</p>
        </div>

        <!-- Si hay error, mostramos el mensaje -->
        <?php if ($mostrar_error): ?>
            <div class="mensaje-error">
                <!-- Mostramos el mensaje de error que preparamos arriba -->
                <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de login -->
        <!-- 
            action="index.php" significa que al enviar el formulario, vuelve a esta misma página
            method="POST" significa que los datos se envían de forma segura (no visible en la URL)
        -->
        <form method="POST" action="index.php" class="login-form">
            <!-- Campo de usuario -->
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <!-- 
                    El atributo 'name="usuario"' es importante porque PHP 
                    lo usa para reconocer el dato en $_POST['usuario']
                -->
                <input 
                    type="text" 
                    id="usuario" 
                    name="usuario" 
                    placeholder="Escribe tu usuario"
                    required
                >
            </div>

            <!-- Campo de contraseña -->
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <!-- 
                    type="password" oculta lo que escribes por seguridad
                -->
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Escribe tu contraseña"
                    required
                >
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
