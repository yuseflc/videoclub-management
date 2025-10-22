<?php

//Declaro el namespace donde está esta interfaz
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Creo la interfaz Resumible
//Las clases que implementen esta interfaz deben tener el método muestraResumen
//Ya no necesito hacer includes porque el autoload se encargará de cargar las clases automáticamente
interface Resumible {
    public function muestraResumen();
}

?>
