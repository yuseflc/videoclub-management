<?php

//Declaro el namespace donde está esta interfaz
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Creo la interfaz Resumible
//Las clases que implementen esta interfaz deben tener el método muestraResumen
interface Resumible {
    public function muestraResumen();
}

?>
