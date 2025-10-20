<?php

//Declaro el namespace donde está esta clase
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Ya no necesito incluir las clases porque el autoload las cargará automáticamente

//Creo la clase Videoclub
class Videoclub {
    //Atributos
    private $nombre;
    private $productos = []; //Array de Soporte
    private $numProductos = 0;
    private $socios = []; //Array de Cliente
    private $numSocios = 0;
    
    //Constructor
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }
    
    //Método privado para incluir un producto en el array
    private function incluirProducto(Soporte $producto) {
        $this->productos[] = $producto;
        $this->numProductos++;
        echo "<br>Incluido soporte " . $this->numProductos . "<br>";
    }
    
    //Método público para incluir una CintaVideo
    public function incluirCintaVideo($titulo, $precio, $duracion) {
        $cinta = new CintaVideo($titulo, $this->numProductos + 1, $precio, $duracion);
        $this->incluirProducto($cinta);
    }
    
    //Método público para incluir un Dvd
    public function incluirDvd($titulo, $precio, $idiomas, $pantalla) {
        $dvd = new Dvd($titulo, $this->numProductos + 1, $precio, $idiomas, $pantalla);
        $this->incluirProducto($dvd);
    }
    
    //Método público para incluir un Juego
    public function incluirJuego($titulo, $precio, $consola, $minJ, $maxJ) {
        $juego = new Juego($titulo, $this->numProductos + 1, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
    }
    
    //Método para incluir un socio con alquiler por defecto = 3
    public function incluirSocio($nombre, $maxAlquilerConcurrente = 3) {
        $socio = new Cliente($nombre, $this->numSocios + 1, $maxAlquilerConcurrente);
        $this->socios[] = $socio;
        $this->numSocios++;
        echo "<br>Incluido socio " . $this->numSocios . "<br>";
    }
    
    //Método para listar los productos del videoclub
    public function listarProductos() {
        echo "<br>Listado de los " . $this->numProductos . " productos disponibles:<br>";
        foreach ($this->productos as $producto) {
            $producto->muestraResumen();
        }
    }
    
    //Método para listar los socios del videoclub
    public function listarSocios() {
        echo "<br>Listado de los " . $this->numSocios . " socios del videoclub:<br>";
        foreach ($this->socios as $socio) {
            $socio->muestraResumen();
        }
    }
    
    //Método para alquilar un soporte a un socio
    //He modificado este método para que devuelva $this y así poder encadenar métodos
    //Esto permite hacer llamadas como: $videoclub->alquilaSocioProducto(1,1)->alquilaSocioProducto(1,2)
    public function alquilaSocioProducto($numeroCliente, $numeroSoporte) {
        //Busco el cliente
        $cliente = null;
        foreach ($this->socios as $socio) {
            if ($socio->getNumero() == $numeroCliente) {
                $cliente = $socio;
                break;
            }
        }
        
        //Si no encuentro el cliente
        if ($cliente == null) {
            echo "<br>No existe el cliente con número " . $numeroCliente . "<br>";
            //Devuelvo $this incluso si hay error, para mantener la cadena
            return $this;
        }
        
        //Busco el soporte
        $soporte = null;
        foreach ($this->productos as $producto) {
            if ($producto->getNumero() == $numeroSoporte) {
                $soporte = $producto;
                break;
            }
        }
        
        //Si no encuentro el soporte
        if ($soporte == null) {
            echo "<br>No existe el soporte con número " . $numeroSoporte . "<br>";
            //Devuelvo $this incluso si hay error, para mantener la cadena
            return $this;
        }
        
        //Si encuentro ambos, alquilo
        $cliente->alquilar($soporte);
        //Devuelvo $this para permitir el encadenamiento de métodos (fluent interface)
        return $this;
    }
}

?>
