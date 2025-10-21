<?php

//Declaro el namespace donde está esta clase
//He colocado todas las clases del proyecto en el namespace Dwes\ProyectoVideoclub
namespace Dwes\ProyectoVideoclub;

//Ya no necesito incluir las clases porque el autoload las cargará automáticamente

//Importo las excepciones que voy a lanzar desde el namespace Util
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

//Creo la clase Cliente que implementa Resumible
class Cliente implements Resumible {
    public $nombre;
    private $numero;
    private $soportesAlquilados = []; //Array que guarda los soportes alquilados
    private $numSoportesAlquilados = 0; //Contador de alquileres
    private $maxAlquilerConcurrente;
    
    //Constructor
    //maxAlquilerConcurrente es opcional y por defecto vale 3
    public function __construct($nombre, $numero, $maxAlquilerConcurrente = 3) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }
    

    public function getNumero() {
        return $this->numero;
    }
    

    public function setNumero($numero) {
        $this->numero = $numero;
    }
    

    public function getNumSoportesAlquilados() {
        return $this->numSoportesAlquilados;
    }
    
    //Método que muestra el resumen del cliente
    public function muestraResumen() {
        echo "<br><strong>Cliente:</strong> " . $this->nombre . "<br>";
        echo "Cantidad de alquileres: " . count($this->soportesAlquilados) . "<br>";
    }
    
    //Método que comprueba si el cliente tiene alquilado un soporte
    public function tieneAlquilado(Soporte $s) {
        //Recorro el array de soportes alquilados
        foreach ($this->soportesAlquilados as $soporte) {
            //Compruebo si el número del soporte coincide
            if ($soporte->getNumero() == $s->getNumero()) {
                return true; //Si lo encuentra, devuelvo true
            }
        }
        return false; //Si no lo encuentra, devuelvo false
    }
    //Método para alquilar un soporte
    //He modificado este método para que devuelva $this y así poder encadenar métodos
    //Esto permite hacer llamadas como: $cliente->alquilar($soporte1)->alquilar($soporte2)
    //Ahora este método lanza excepciones en lugar de mostrar mensajes de error
    public function alquilar(Soporte $s) {
        //Compruebo si ya tiene alquilado este soporte
        if ($this->tieneAlquilado($s)) {
            //Lanzo una excepción SoporteYaAlquiladoException
            throw new SoporteYaAlquiladoException("El cliente ya tiene alquilado el soporte: " . $s->titulo);
        }
        
        //Compruebo si ha superado el cupo de alquileres
        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            //Lanzo una excepción CupoSuperadoException
            throw new CupoSuperadoException("Este cliente tiene " . count($this->soportesAlquilados) . " elementos alquilados. No puede alquilar más en este videoclub hasta que no devuelva algo.");
        }
        
        //Si pasa las comprobaciones, alquilo el soporte
        $this->soportesAlquilados[] = $s; //Añado el soporte al array
        $this->numSoportesAlquilados++; //Incremento el contador
        echo "<br>Alquilado soporte a: " . $this->nombre . "<br>";
        echo $s->titulo . "<br>";
        //Devuelvo $this para permitir el encadenamiento de métodos (fluent interface)
        return $this;
    }
    
    //Método para devolver un soporte
    //He modificado este método para que devuelva $this y así poder encadenar métodos
    //Esto permite hacer llamadas como: $cliente->devolver(1)->devolver(2)->alquilar($soporte)
    //Ahora este método lanza excepciones en lugar de mostrar mensajes de error
    public function devolver($numSoporte) {
        //Recorro el array de soportes alquilados
        foreach ($this->soportesAlquilados as $indice => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                //Si lo encuentra, lo elimino del array
                unset($this->soportesAlquilados[$indice]);
                //Reindexo el array para evitar huecos
                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                echo "<br>Devuelto soporte: " . $soporte->titulo . "<br>";
                //Devuelvo $this para permitir el encadenamiento de métodos
                return $this;
            }
        }
        //Si no lo encuentra, lanzo una excepción SoporteNoEncontradoException
        throw new SoporteNoEncontradoException("No se ha podido encontrar el soporte en los alquileres de este cliente");
    }
    
    //Método para listar los alquileres del cliente
    public function listarAlquileres() {
        echo "<br>El cliente tiene " . count($this->soportesAlquilados) . " soportes alquilados<br>";
        //Recorro el array y muestro cada soporte
        foreach ($this->soportesAlquilados as $soporte) {
            echo "<br>";
            $soporte->muestraResumen();
        }
    }
}


?>
