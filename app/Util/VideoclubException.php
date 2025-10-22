<?php

//Declaro el namespace donde está esta excepción
//Las excepciones del videoclub las he puesto en Dwes\ProyectoVideoclub\Util
namespace Dwes\ProyectoVideoclub\Util;

//Importo la clase Exception de PHP para poder heredar de ella
use Exception;

/* 
He creado esta clase VideoclubException como excepción base para mi aplicación del videoclub
Esta clase hereda de Exception, que es la clase base de PHP para manejar errores
No necesito sobrescribir ningún método, solo crearla para tener una excepción propia del proyecto
Las demás excepciones específicas heredarán de esta
*/

class VideoclubException extends Exception {
    //No necesito añadir ningún método, la clase Exception ya tiene todo lo necesario
    //Solo la creo para identificar que es una excepción de mi aplicación Videoclub
}

?>
