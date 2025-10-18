<?php

//Incluyo la clase Soporte porque Juego hereda de ella
include_once "Soporte.php";

//Creo la clase Juego que hereda de Soporte
class Juego extends Soporte {
    //Atributos propios del Juego
    public $consola;
    private $minNumJugadores;
    private $maxNumJugadores;
    
    //Constructor
    public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {
        //Llamo al constructor del padre
        parent::__construct($titulo, $numero, $precio);
        //Inicializo los atributos del Juego
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }
    
    //Método para mostrar los jugadores posibles
    public function muestraJugadoresPosibles() {
        //Si el mínimo y el máximo son iguales a 1
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            echo "Para un jugador<br>";
        }
        //Si el mínimo y el máximo son iguales pero no son 1
        else if ($this->minNumJugadores == $this->maxNumJugadores) {
            echo "Para " . $this->maxNumJugadores . " jugadores<br>";
        }
        //Si el mínimo y el máximo son diferentes
        else {
            echo "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores<br>";
        }
    }
    
    //Sobrescribo muestraResumen
    public function muestraResumen() {
        //Llamo al método del padre
        parent::muestraResumen();
        //Añado la info del Juego
        echo "Consola: " . $this->consola . "<br>";
        //Llamo al método muestraJugadoresPosibles
        $this->muestraJugadoresPosibles();
    }
}

?>
