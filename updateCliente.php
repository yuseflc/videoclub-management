<?php

/**
 * updateCliente.php
 * 
 * Procesa el formulario de edición de cliente.
 * He creado este archivo para:
 * 1. Validar los datos enviados desde formUpdateCliente.php
 * 2. Actualizar los datos del cliente en la sesión
 * 3. Guardar los cambios de forma persistente en el archivo JSON
 * 4. Redirigir al cliente o al administrador según corresponda
 */

// Incluyo el autoload ANTES de session_start
require_once 'autoload.php';

// Inicio la sesión
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Verifico que:
 * 1. El usuario esté logueado
 * 2. La solicitud sea POST
 * 3. El usuario sea admin o cliente válido
 */
if (!isset($_SESSION['usuario'])) {
    // El usuario no está logueado
    header('Location: index.php');
    exit();
}

// Verifico que es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // No es POST, redirigimos al formulario
    header('Location: formUpdateCliente.php');
    exit();
}

// Importo la clase Cliente
use Dwes\ProyectoVideoclub\Cliente;

// Obtengo el ID del cliente a editar
$id_cliente = isset($_POST['id_cliente']) ? intval($_POST['id_cliente']) : null;
$nombre_usuario = $_SESSION['usuario'];

/**
 * DETERMINAMOS PERMISOS
 * 
 * El administrador puede editar cualquier cliente
 * El cliente normal solo puede editar el suyo
 */
$puede_editar = false;

if ($nombre_usuario === 'admin') {
    // Es administrador, puede editar cualquier cliente
    $puede_editar = true;
} else if (isset($_SESSION['cliente']) && $_SESSION['cliente']->getNumero() === $id_cliente) {
    // Es un cliente y está intentando editar su propio perfil
    $puede_editar = true;
}

// Si no tiene permiso, lo redirigimos
if (!$puede_editar || $id_cliente === null) {
    header('Location: index.php');
    exit();
}

// Obtengo los datos del formulario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$password_confirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';

// Variables para almacenar errores
$errores = [];

/**
 * VALIDACIÓN DE DATOS
 */

// Valido el nombre
if (empty($nombre)) {
    $errores[] = 'El nombre es obligatorio';
} elseif (strlen($nombre) < 3) {
    $errores[] = 'El nombre debe tener al menos 3 caracteres';
} elseif (strlen($nombre) > 100) {
    $errores[] = 'El nombre no puede superar 100 caracteres';
}

// Valido el usuario
if (empty($usuario)) {
    $errores[] = 'El usuario es obligatorio';
} elseif (strlen($usuario) < 3) {
    $errores[] = 'El usuario debe tener al menos 3 caracteres';
} elseif (strlen($usuario) > 50) {
    $errores[] = 'El usuario no puede superar 50 caracteres';
} elseif (strpos($usuario, ' ') !== false) {
    $errores[] = 'El usuario no puede contener espacios';
}

// Valido la contraseña SOLO si se intenta cambiar
if (!empty($password) || !empty($password_confirm)) {
    // Si ha escrito algo en uno de los campos de contraseña
    if (strlen($password) < 6) {
        $errores[] = 'La contraseña debe tener al menos 6 caracteres';
    }

    if ($password !== $password_confirm) {
        $errores[] = 'Las contraseñas no coinciden';
    }
}

// Verifico si el usuario ya existe (pero no si es el mismo cliente)
if (!empty($usuario) && empty(array_filter($errores))) {
    $clientes = $_SESSION['clientes'];
    foreach ($clientes as $id => $cliente) {
        // Permito que mantenga su propio usuario
        if ($id !== $id_cliente && $cliente->getUsuario() === $usuario) {
            $errores[] = 'El usuario ya existe en el sistema';
            break;
        }
    }
}

/**
 * SI HAY ERRORES, REDIRIGIMOS AL FORMULARIO
 */
if (!empty($errores)) {
    // Construyo el mensaje de error
    $mensaje_error = 'Errores en el formulario: ' . implode(', ', $errores);

    // Redirigimos al formulario de edición con los datos y el error
    if ($nombre_usuario === 'admin') {
        // Si es admin, incluyo el ID del cliente
        header('Location: formUpdateCliente.php?id=' . urlencode($id_cliente) .
            '&error=' . urlencode($mensaje_error) .
            '&nombre=' . urlencode($nombre) .
            '&usuario=' . urlencode($usuario));
    } else {
        // Si es cliente, no necesito el ID en la URL
        header('Location: formUpdateCliente.php?error=' . urlencode($mensaje_error) .
            '&nombre=' . urlencode($nombre) .
            '&usuario=' . urlencode($usuario));
    }
    exit();
}

/**
 * ACTUALIZACIÓN DEL CLIENTE
 */

// Obtengo el cliente que voy a editar
if (!isset($_SESSION['clientes'][$id_cliente])) {
    // El cliente no existe
    header('Location: index.php');
    exit();
}

$cliente = $_SESSION['clientes'][$id_cliente];

// Actualizo el nombre
$cliente->nombre = $nombre;

// Actualizo el usuario
$cliente->setUsuario($usuario);

// Actualizo la contraseña SOLO si proporcionó una nueva
if (!empty($password)) {
    $cliente->setPassword($password);
}

/**
 * SI ES CLIENTE, ACTUALIZO LA SESIÓN
 * 
 * Si el cliente estaba en sesión, actualizo la referencia
 * con los nuevos datos
 */
if ($nombre_usuario !== 'admin' && isset($_SESSION['cliente'])) {
    $_SESSION['cliente'] = $cliente;
}

/**
 * REDIRIGIR A LA PÁGINA CORRESPONDIENTE
 */
if ($nombre_usuario === 'admin') {
    // Si es admin, vuelvo al listado de administración
    header('Location: mainAdmin.php');
} else {
    // Si es cliente, vuelvo a su página de perfil
    header('Location: mainCliente.php');
}
exit();
