<?php

//Declaro el namespace donde está esta excepción
//Las excepciones del videoclub las he puesto en Dwes\ProyectoVideoclub\Util
namespace Dwes\ProyectoVideoclub\Util;

/* 
He creado esta excepción para manejar el caso cuando un cliente intenta alquilar un soporte
que ya tiene alquilado
Esta excepción hereda de VideoclubException, que es la excepción base de mi aplicación
*/

class SoporteYaAlquiladoException extends VideoclubException {
    //No necesito añadir ningún método, solo heredo de VideoclubException
    //El autoload se encargará de cargar VideoclubException automáticamente
}

?>
