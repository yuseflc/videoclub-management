<?php

/* 
Archivo autoload.php
He creado este archivo para registrar una función que cargue automáticamente las clases cuando se necesiten.
Así no tengo que hacer include_once de cada clase en todos los archivos.

El autoload funciona así:
1. Cuando PHP intenta usar una clase que no está cargada (por ejemplo, new Cliente())
2. PHP llama automáticamente a la función que registré con spl_autoload_register()
3. La función construye la ruta del archivo de la clase y lo incluye
4. La clase queda disponible para su uso

Esto hace el código más limpio y fácil de mantener.
*/

//Primero incluyo el autoload de Composer para que cargue las dependencias (Monolog, etc.)
require_once __DIR__ . '/vendor/autoload.php';
//Esta función se ejecutará automáticamente cuando PHP necesite una clase que no ha sido cargada
spl_autoload_register(function ($nombreClase) {
    
    //El $nombreClase viene con el namespace completo: Dwes\ProyectoVideoclub\Cliente
    //o puede venir con subdirectorios: Dwes\ProyectoVideoclub\Util\VideoclubException
    
    //Reemplazo las barras invertidas del namespace por barras normales para construir la ruta
    //Por ejemplo: Dwes\ProyectoVideoclub\Util\VideoclubException -> Dwes/ProyectoVideoclub/Util/VideoclubException
    $rutaClase = str_replace('\\', '/', $nombreClase);
    
    //Quito el prefijo del namespace base para quedarme solo con la ruta relativa
    //Por ejemplo: Dwes/ProyectoVideoclub/Util/VideoclubException -> Util/VideoclubException
    $rutaClase = str_replace('Dwes/ProyectoVideoclub/', '', $rutaClase);
    
    //Construyo la ruta completa al archivo de la clase
    //Todas mis clases están en la carpeta 'app/'
    $rutaArchivo = __DIR__ . '/app/' . $rutaClase . '.php';
    
    //Verifico si el archivo existe antes de incluirlo
    if (file_exists($rutaArchivo)) {
        //Si existe, lo incluyo para que la clase esté disponible
        include_once $rutaArchivo;
    } else {
        //Si no existe, muestro un mensaje de error para ayudarme a depurar
        echo "No se pudo cargar la clase: $nombreClase desde $rutaArchivo<br>";
    }
});

?>
