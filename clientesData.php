<?php

/**
 * clientesData.php
 * 
 * Este archivo gestiona la persistencia de los clientes creados.
 * Guarda y carga los clientes en un archivo JSON para que persistan
 * entre diferentes sesiones.
 */

// Definimos la ruta del archivo de datos
define('CLIENTES_DATA_FILE', __DIR__ . '/data/clientes.json');

/**
 * Crear directorio de datos si no existe
 */
function garantizar_directorio_datos() {
    $dir = __DIR__ . '/data';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

/**
 * Guardar clientes en archivo JSON
 * 
 * @param array $clientes Array de clientes a guardar
 */
function guardar_clientes($clientes) {
    garantizar_directorio_datos();
    
    // Convertimos los clientes a un formato serializable
    $clientes_data = [];
    
    foreach ($clientes as $id => $cliente) {
        $clientes_data[$id] = [
            'nombre' => $cliente->nombre,
            'numero' => $cliente->getNumero(),
            'usuario' => $cliente->getUsuario(),
            'password' => $cliente->getPassword(),
        ];
    }
    
    // Guardamos en JSON
    file_put_contents(CLIENTES_DATA_FILE, json_encode($clientes_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Cargar clientes desde archivo JSON
 * 
 * @return array Array de clientes cargados
 */
function cargar_clientes_persistidos() {
    garantizar_directorio_datos();
    
    if (!file_exists(CLIENTES_DATA_FILE)) {
        return [];
    }
    
    $json = file_get_contents(CLIENTES_DATA_FILE);
    $clientes_data = json_decode($json, true);
    
    if (!is_array($clientes_data)) {
        return [];
    }
    
    return $clientes_data;
}

?>
