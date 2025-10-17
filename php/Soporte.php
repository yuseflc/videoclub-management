<?php

/* He creado esta clase Soporte que representa un soporte genérico del videoclub
Puede ser una cinta, un DVD, un juego, etc. Aquí guardo el título, número y precio
Solo he puesto getters, no setters, porque no quiero que se modifiquen después de crear el objeto */

class Soporte {
    //Defino las propiedades del soporte
    public $titulo;      //Lo dejo público para acceder directamente desde fuera
    private $numero;     //Este lo hago privado, solo se accede por el getter
    private $precio;     //También privado para protegerlo
    
    //Defino una constante para el IVA que usaré en los cálculos
    private const IVA = 0.21; //He puesto el 21% que es el IVA general en España
    
    //Constructor: aquí inicializo los valores cuando creo un objeto
    public function __construct($titulo, $numero, $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }
    
    //Método para obtener el precio base sin IVA
    public function getPrecio() {
        return $this->precio;
    }
    
    //Aquí calculo el precio con IVA incluido
    public function getPrecioConIVA() {
        //Sumo al precio base el 21% de IVA
        return $this->precio + ($this->precio * self::IVA);
    }
    
    //Getter para obtener el número identificador
    public function getNumero() {
        return $this->numero;
    }
    
    //Este método muestra un resumen con toda la información del soporte
    public function muestraResumen() {
        echo "<br><br>";
        echo "<strong>Resumen del Soporte:</strong><br>";
        echo "Título: " . $this->titulo . "<br>";
        echo "Número: " . $this->numero . "<br>";
        echo "Precio: " . $this->precio . " euros<br>";
        //Uso el método getPrecioConIVA() para mostrar el precio con IVA
        echo "Precio con IVA: " . $this->getPrecioConIVA() . " euros<br>";
    }
}

?>