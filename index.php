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

/**
 * FUNCIÓN PARA INICIALIZAR CLIENTES Y SOPORTES
 * Si no existen en sesión, los creamos automáticamente
 */
function inicializarClientesYSoportes() {
    if (!isset($_SESSION['clientes']) || !isset($_SESSION['soportes'])) {
        // Crear soportes
        $soporte1 = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
        $soporte2 = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
        $soporte3 = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);
        $soporte4 = new Dvd("El Imperio Contraataca", 4, 3, "es,en", "16:9");
        $soporte5 = new CintaVideo("Blade Runner", 5, 4.5, 117);
        $soporte6 = new Juego("Elden Ring", 27, 59.99, "PS5", 1, 1);
        
        $soportes_array = array(
            23 => $soporte1, 24 => $soporte2, 26 => $soporte3,
            4 => $soporte4, 5 => $soporte5, 27 => $soporte6
        );
        
        // Crear clientes
        $cliente1 = new Cliente("Bruce Wayne", 23, "bruce.wayne", "prueba1234");
        $cliente2 = new Cliente("Pepe Fernandez", 33, "pepe.fdez", "prueba1234");
        $cliente3 = new Cliente("Ramon Dino", 45, "ramon.dino", "prueba1234");
        $cliente4 = new Cliente("Barry Allen", 12, "barry.allen", "prueba1234");
        $cliente5 = new Cliente("Leo Messi", 56, "leo.messi", "prueba1234");
        
        // Agregar algunos alquileres a Leo Messi para demostración
        $cliente5->alquilar($soporte1)->alquilar($soporte2);
        
        $clientes_array = array(
            23 => $cliente1, 33 => $cliente2, 45 => $cliente3,
            12 => $cliente4, 56 => $cliente5
        );
        
        // Guardar en sesión
        $_SESSION['soportes'] = $soportes_array;
        $_SESSION['clientes'] = $clientes_array;
    }
}

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

// Inicializamos clientes y soportes si no existen
inicializarClientesYSoportes();

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
        
        // Si verificarLogin() devuelve true, es el administrador
        if ($resultado === true) {
            // Guardamos el usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            
            // Es admin, lo redirigimos a mainAdmin.php
            header('Location: mainAdmin.php');
            exit();
        } 
        // Si devuelve 'cliente', intentamos validar como cliente
        else if ($resultado === 'cliente') {
            // Buscamos si el usuario coincide con algún cliente
            // Los clientes ya fueron inicializados al cargar esta página
            $clientes = $_SESSION['clientes'];
            $clienteEncontrado = null;
            
            foreach ($clientes as $cliente) {
                if ($cliente->getUsuario() === $usuario) {
                    $clienteEncontrado = $cliente;
                    break;
                }
            }
            
            // Si es un cliente registrado, lo redirigimos a mainCliente.php
            if ($clienteEncontrado !== null) {
                // Verificamos la contraseña usando password_verify para las contraseñas hasheadas
                if (password_verify($password, $clienteEncontrado->getPassword())) {
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['cliente'] = $clienteEncontrado;
                    header('Location: mainCliente.php');
                    exit();
                } else {
                    // Contraseña incorrecta
                    $mostrar_error = true;
                    $mensaje_error = 'Usuario o contraseña incorrectos. Intenta de nuevo.';
                }
            } else {
                // Usuario no encontrado en clientes, mostrar error
                $mostrar_error = true;
                $mensaje_error = 'Usuario o contraseña incorrectos. Intenta de nuevo.';
            }
        } 
        else {
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
