<?php

//Declaro el namespace donde está esta clase
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

/* He creado esta clase CintaVideo que hereda de Soporte 
Aquí añado la duración de la película, que es específica de las cintas de vídeo */

//Incluyo la clase padre Soporte para poder heredar de ella
include_once "Soporte.php";

class CintaVideo extends Soporte {
    //Añado la duración como atributo privado específico de las cintas
    private $duracion; //La guardo en minutos
    
    //Aquí sobrescribo el constructor para añadir el parámetro duración
    public function __construct($titulo, $numero, $precio, $duracion) {
        //Primero llamo al constructor del padre para inicializar los atributos básicos
        parent::__construct($titulo, $numero, $precio);
        //Luego inicializo el atributo propio de esta clase
        $this->duracion = $duracion;
    }
    
    //Sobrescribo el método muestraResumen para añadir la info de la duración
    public function muestraResumen() {
        //Llamo primero al método del padre para mostrar la info básica (título, número, precio)
        parent::muestraResumen();
        //Después añado la duración que es específica de la cinta de vídeo
        echo "Duración: " . $this->duracion . " minutos<br>";
    }
}

?>
