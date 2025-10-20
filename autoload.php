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

//Registro mi función de autoload usando spl_autoload_register
//Esta función se ejecutará automáticamente cuando PHP necesite una clase que no ha sido cargada
spl_autoload_register(function ($nombreClase) {
    
    //El $nombreClase viene con el namespace completo: Dwes\ProyectoVideoclub\Cliente
    //Necesito extraer solo el nombre de la clase sin el namespace
    
    //Busco la última barra invertida en el nombre completo
    $posicionBarra = strrpos($nombreClase, '\\');
    
    //Si encuentro una barra invertida, extraigo solo el nombre de la clase
    if ($posicionBarra !== false) {
        //Extraigo desde la posición después de la última barra hasta el final
        $nombreClase = substr($nombreClase, $posicionBarra + 1);
    }
    
    //Construyo la ruta completa al archivo de la clase
    //Todas mis clases están en la carpeta 'app/'
    $rutaArchivo = __DIR__ . '/app/' . $nombreClase . '.php';
    
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
