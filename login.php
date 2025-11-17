<?php
/**
 * 
 * Este archivo actúa como verificación.
 */

/**
 * EXPLICACIÓN:
 * Esta función es como un vigilante que comprueba si tienes permiso
 * para entrar. Compara lo que escribiste con los datos válidos que tenemos guardados.
 * 
 * Para admin: verifica contra un array hardcodeado
 * Para clientes: solo verifica que sea admin (los clientes se verifican después en index.php)
 */
function verificarLogin($usuario, $password) {
    // Array asociativo: es como un diccionario donde la clave es el usuario
    // y el valor es la contraseña. Solo contiene el admin.
    $usuarios_validos = array(
        'admin' => 'admin'      // Admin: admin / admin
    );
    
    // Comprobamos si el usuario que escribió existe en nuestra lista
    if (isset($usuarios_validos[$usuario])) {
        // Si existe, verificamos que la contraseña coincida
        // === es un comparador "estricto" que verifica igualdad exacta
        if ($usuarios_validos[$usuario] === $password) {
            // ¡Credenciales correctas! Devolvemos true
            return true;
        }
    }
    
    // Si no es admin, simplemente devolvemos true como indicador de que NO es admin
    // La validación real de clientes se hace en index.php contra la sesión
    // Así permitimos que el flujo continúe para buscar el cliente en sesión
    return 'cliente'; // Indicador de que no es admin pero podría ser cliente
}
?>
