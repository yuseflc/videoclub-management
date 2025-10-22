<?php

//Declaro el namespace donde está esta clase
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Ya no necesito incluir Resumible.php porque el autoload cargará automáticamente las clases

/* He creado esta clase abstracta Soporte que representa un soporte genérico del videoclub
Puede ser una cinta, un DVD, un juego, etc. Aquí guardo el título, número y precio
Solo he puesto getters, no setters, porque no quiero que se modifiquen después de crear el objeto
Al ser abstracta, no se puede instanciar directamente, solo se usa como base para otras clases
Implementa la interfaz Resumible, por lo que debe tener el método muestraResumen */

abstract class Soporte implements Resumible {
    //Defino las propiedades del soporte
    public $titulo;      //Lo dejo público para acceder directamente desde fuera
    private $numero;     //Este lo hago privado, solo se accede por el getter
    private $precio;     //También privado para protegerlo
    public $alquilado = false; //Esta propiedad indica si el soporte está alquilado o no
    
    //Defino una constante para el IVA que usaré en los cálculos
    private const IVA = 0.21; //He puesto el 21% que es el IVA general en España
    
    //Constructor: aquí inicializo los valores cuando creo un objeto
    public function __construct($titulo, $numero, $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
        //La propiedad alquilado ya está inicializada a false por defecto
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
