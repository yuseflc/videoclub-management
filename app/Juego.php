<?php

//Declaro el namespace donde está esta clase
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Ya no necesito incluir Soporte.php porque el autoload cargará automáticamente las clases

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
        $mensaje = "";
        //Si el mínimo y el máximo son iguales a 1
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            $mensaje = "Para un jugador<br>";
        }
        //Si el mínimo y el máximo son iguales pero no son 1
        else if ($this->minNumJugadores == $this->maxNumJugadores) {
            $mensaje = "Para " . $this->maxNumJugadores . " jugadores<br>";
        }
        //Si el mínimo y el máximo son diferentes
        else {
            $mensaje = "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores<br>";
        }
        echo $mensaje;
        return $mensaje;
    }
    
    //Sobrescribo muestraResumen
    public function muestraResumen() {
        //Llamo al método del padre
        $resumen = parent::muestraResumen();
        //Añado la info del Juego
        $infoJuego = "Consola: " . $this->consola . "<br>";
        echo $infoJuego;
        //Llamo al método muestraJugadoresPosibles
        $infoJugadores = $this->muestraJugadoresPosibles();
        return $resumen . $infoJuego . $infoJugadores;
    }
}

?>
