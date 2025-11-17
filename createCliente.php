<?php

/**
 * createCliente.php
 * 
 * Procesa el formulario de creación de cliente.
 * Valida los datos y los inserta en la sesión.
 * Redirige a mainAdmin.php si es exitoso, o de vuelta al formulario si hay error.
 */

// Incluimos el autoload ANTES de session_start
require_once 'autoload.php';

// Iniciamos la sesión
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Verificamos que el usuario es administrador y que la solicitud es POST
 */
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    // El usuario no es administrador
    header('Location: index.php');
    exit();
}

// Verificamos que es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // No es POST, redirigimos al formulario
    header('Location: formCreateCliente.php');
    exit();
}

// Importamos la clase Cliente
use Dwes\ProyectoVideoclub\Cliente;

// Obtenemos los datos del formulario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$password_confirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';

// Variables para almacenar errores
$errores = [];

/**
 * VALIDACIÓN DE DATOS
 */

// Validar nombre
if (empty($nombre)) {
    $errores[] = 'El nombre es obligatorio';
} elseif (strlen($nombre) < 3) {
    $errores[] = 'El nombre debe tener al menos 3 caracteres';
} elseif (strlen($nombre) > 100) {
    $errores[] = 'El nombre no puede superar 100 caracteres';
}

// Validar usuario
if (empty($usuario)) {
    $errores[] = 'El usuario es obligatorio';
} elseif (strlen($usuario) < 3) {
    $errores[] = 'El usuario debe tener al menos 3 caracteres';
} elseif (strlen($usuario) > 50) {
    $errores[] = 'El usuario no puede superar 50 caracteres';
} elseif (strpos($usuario, ' ') !== false) {
    $errores[] = 'El usuario no puede contener espacios';
}

// Validar contraseña
if (empty($password)) {
    $errores[] = 'La contraseña es obligatoria';
} elseif (strlen($password) < 6) {
    $errores[] = 'La contraseña debe tener al menos 6 caracteres';
}

// Validar confirmación de contraseña
if ($password !== $password_confirm) {
    $errores[] = 'Las contraseñas no coinciden';
}

// Verificar si el usuario ya existe
if (!empty($usuario) && empty(array_filter($errores))) {
    // Solo verificamos si no hay errores anteriores y el usuario no está vacío
    $clientes = $_SESSION['clientes'];
    foreach ($clientes as $cliente) {
        if ($cliente->getUsuario() === $usuario) {
            $errores[] = 'El usuario ya existe en el sistema';
            break;
        }
    }
}

/**
 * SI HAY ERRORES, REDIRIGIMOS AL FORMULARIO
 */
if (!empty($errores)) {
    // Construimos el mensaje de error
    $mensaje_error = 'Errores en el formulario: ' . implode(', ', $errores);
    
    // Redirigimos con los datos originales para que el usuario no pierda lo escrito
    header('Location: formCreateCliente.php?error=' . urlencode($mensaje_error) . 
           '&nombre=' . urlencode($nombre) . 
           '&usuario=' . urlencode($usuario));
    exit();
}

/**
 * CREACIÓN DEL NUEVO CLIENTE
 */

// Obtenemos el ID más alto actual para asignar un nuevo ID
$clientes = $_SESSION['clientes'];
$id_nuevo = 1;
foreach ($clientes as $id => $cliente) {
    if ($id >= $id_nuevo) {
        $id_nuevo = $id + 1;
    }
}

// Creamos el nuevo cliente
$nuevo_cliente = new Cliente($nombre, $id_nuevo, $usuario, $password);

// Lo añadimos al array de clientes en la sesión
$_SESSION['clientes'][$id_nuevo] = $nuevo_cliente;

// Redirigimos a mainAdmin.php donde se verá el cliente creado
header('Location: mainAdmin.php');
exit();
?>
