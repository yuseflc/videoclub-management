<?php

//Incluyo la clase Soporte porque Dvd hereda de ella
include_once "Soporte.php";

//Creo la clase Dvd que hereda de Soporte
class Dvd extends Soporte {
    //Atributos propios del DVD
    public $idiomas;
    private $formatoPantalla;
    
    //Constructor
    public function __construct($titulo, $numero, $precio, $idiomas, $formatoPantalla) {
        //Llamo al constructor del padre
        parent::__construct($titulo, $numero, $precio);
        //Inicializo los atributos del DVD
        $this->idiomas = $idiomas;
        $this->formatoPantalla = $formatoPantalla;
    }
    
    //Sobrescribo muestraResumen
    public function muestraResumen() {
        //Llamo al método del padre
        parent::muestraResumen();
        //Añado la info del DVD
        echo "Idiomas: " . $this->idiomas . "<br>";
        echo "Formato Pantalla: " . $this->formatoPantalla . "<br>";
    }
}

?>
