<?php
/**
 * 
 * Este archivo actúa como verificación.
 */

/**
 * EXPLICACIÓN:
 * Esta función es como un vigilante que comprueba si tienes permiso
 * para entrar. Compara lo que escribiste con los datos válidos que tenemos guardados.
 */
function verificarLogin($usuario, $password) {
    // En una aplicación real, los usuarios estarían guardados en una base de datos.
    // Pero para aprender, vamos a usar un array simple con los usuarios válidos.
    
    // Array asociativo: es como un diccionario donde la clave es el usuario
    // y el valor es la contraseña
    $usuarios_validos = array(
        'admin' => 'admin',      // Primer usuario válido: admin / admin
        'usuario' => 'usuario'   // Segundo usuario válido: usuario / usuario
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
    
    // Si llegamos aquí, algo no coincide: usuario no existe o contraseña incorrecta
    return false;
}
?>
