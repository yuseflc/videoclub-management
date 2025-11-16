<?php

/**
 * deleteCliente.php
 * 
 * He creado este archivo para procesar la eliminación de un cliente.
 * Solo los administradores pueden acceder aquí.
 * 
 * Funcionalidades:
 * - Verificar que el usuario sea administrador
 * - Verificar que sea una solicitud POST
 * - Eliminar el cliente del array de sesión
 * - Guardar los cambios en el archivo JSON
 * - Redirigir a mainAdmin.php
 */

// Incluyo el autoload ANTES de session_start para que las clases estén disponibles
require_once 'autoload.php';

// Incluyo el archivo de persistencia de clientes
require_once 'clientesData.php';

// Inicio la sesión
session_start();

/**
 * VERIFICACIÓN DE SEGURIDAD
 * 
 * Verifico que:
 * 1. El usuario esté logueado
 * 2. El usuario sea administrador
 * 3. La solicitud sea POST
 */
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    // El usuario no es administrador
    header('Location: index.php');
    exit();
}

// Verifico que es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // No es POST, redirigimos al listado
    header('Location: mainAdmin.php');
    exit();
}

// Obtengo el ID del cliente a eliminar
$id_cliente = isset($_POST['id_cliente']) ? intval($_POST['id_cliente']) : null;

/**
 * VALIDACIÓN DEL ID
 * 
 * Verifico que el ID sea válido y que el cliente exista
 */
if ($id_cliente === null || !isset($_SESSION['clientes'][$id_cliente])) {
    // El cliente no existe o el ID es inválido
    header('Location: mainAdmin.php');
    exit();
}

/**
 * ELIMINACIÓN DEL CLIENTE
 * 
 * He removido el cliente del array de clientes en la sesión
 */
unset($_SESSION['clientes'][$id_cliente]);

/**
 * GUARDAR CAMBIOS DE FORMA PERSISTENTE
 * 
 * Guardo los clientes restantes en el archivo JSON
 * para que la eliminación persista entre diferentes sesiones
 */
guardar_clientes($_SESSION['clientes']);

/**
 * REDIRIGIR AL LISTADO
 * 
 * Redirigimos al administrador de vuelta al listado de clientes
 */
header('Location: mainAdmin.php');
exit();
?>
