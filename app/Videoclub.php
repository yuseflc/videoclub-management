<?php

//Declaro el namespace donde está esta clase
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Ya no necesito incluir las clases porque el autoload las cargará automáticamente

//Importo las excepciones que voy a capturar desde el namespace Util
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;

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
    //Ahora este método captura las excepciones que lanza Cliente e informa al usuario
    public function alquilaSocioProducto($numeroCliente, $numeroSoporte) {
        //Busco el cliente
        $cliente = null;
        foreach ($this->socios as $socio) {
            if ($socio->getNumero() == $numeroCliente) {
                $cliente = $socio;
                break;
            }
        }
        
        //Si no encuentro el cliente, lanzo excepción ClienteNoEncontradoException
        if ($cliente == null) {
            throw new ClienteNoEncontradoException("No existe el cliente con número " . $numeroCliente);
        }
        
        //Busco el soporte
        $soporte = null;
        foreach ($this->productos as $producto) {
            if ($producto->getNumero() == $numeroSoporte) {
                $soporte = $producto;
                break;
            }
        }
        
        //Si no encuentro el soporte, lanzo excepción SoporteNoEncontradoException
        if ($soporte == null) {
            throw new SoporteNoEncontradoException("No existe el soporte con número " . $numeroSoporte);
        }
        
        //Capturo las excepciones que puede lanzar el método alquilar de Cliente
        try {
            //Si encuentro ambos, intento alquilar
            $cliente->alquilar($soporte);
        } catch (SoporteYaAlquiladoException $e) {
            //Informo al usuario si el soporte ya está alquilado
            echo "<br>Error: " . $e->getMessage() . "<br>";
        } catch (CupoSuperadoException $e) {
            //Informo al usuario si ha superado el cupo
            echo "<br>Error: " . $e->getMessage() . "<br>";
        }
        
        //Devuelvo $this para permitir el encadenamiento de métodos (fluent interface)
        return $this;
    }
}

?>
