<?php

/* Clase Soporte: representa un soporte genérico para el videoclub
Incluye título, número y precio, y métodos para obtener precio con IVA
No tiene setters, solo getters y muestraResumen */

class Soporte {
    //Propiedades
    public $titulo;
    private $numero;
    private $precio;
    
    //Constante IVA
    private const IVA = 0.21; // 21%
    
    // Constructor
    public function __construct($titulo, $numero, $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }
    
    //Método para obtener el precio
    public function getPrecio() {
        return $this->precio;
    }
    
    //Método para obtener el precio con IVA
    public function getPrecioConIVA() {
        return $this->precio + ($this->precio * self::IVA);
    }
    
    //Método para obtener el número
    public function getNumero() {
        return $this->numero;
    }
    
    //Método para mostrar el contenido
    public function infoSoporte() {
        echo "<br><br>";
        echo "<strong>Resumen del Soporte:</strong><br>";
        echo "Título: " . $this->titulo . "<br>";
        echo "Número: " . $this->numero . "<br>";
        echo "Precio: " . $this->precio . " euros<br>";
        echo "Precio con IVA: " . $this->getPrecioConIVA() . " euros<br>";
    }
}

?>