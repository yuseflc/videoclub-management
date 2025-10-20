<?php

//Declaro el namespace donde está esta clase
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Ya no necesito incluir Soporte.php porque el autoload cargará automáticamente las clases

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
