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
    private $numProductosAlquilados = 0; //Contador de productos que están alquilados actualmente
    private $numTotalAlquileres = 0; //Contador total de alquileres realizados (histórico)
    
    //Constructor
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }
    
    //Getter para obtener el número de productos alquilados actualmente
    public function getNumProductosAlquilados() {
        return $this->numProductosAlquilados;
    }
    
    //Getter para obtener el número total de alquileres realizados
    public function getNumTotalAlquileres() {
        return $this->numTotalAlquileres;
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
    //Ahora se genera automáticamente usuario y contraseña
    public function incluirSocio($nombre, $maxAlquilerConcurrente = 3) {
        // Generamos un usuario basado en el nombre (convertimos a minúsculas y reemplazamos espacios)
        $usuario = strtolower(str_replace(' ', '.', $nombre));
        // Generamos una contraseña por defecto (nombre + año actual)
        $password = strtolower($nombre) . date('Y');
        
        $socio = new Cliente($nombre, $this->numSocios + 1, $usuario, $password, $maxAlquilerConcurrente);
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
            //Si el alquiler se realiza correctamente, incremento los contadores
            $this->numProductosAlquilados++; //Incremento productos alquilados actualmente
            $this->numTotalAlquileres++; //Incremento el total histórico de alquileres
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
    
    //Método para que un socio devuelva un producto
    //Este método también permite encadenar llamadas
    public function devolverSocioProducto(int $numSocio, int $numeroProducto) {
        //Busco el cliente
        $cliente = null;
        foreach ($this->socios as $socio) {
            if ($socio->getNumero() == $numSocio) {
                $cliente = $socio;
                break;
            }
        }
        
        //Si no encuentro el cliente, lanzo excepción
        if ($cliente == null) {
            throw new ClienteNoEncontradoException("No existe el cliente con número " . $numSocio);
        }
        
        //Intento que el cliente devuelva el soporte
        try {
            $cliente->devolver($numeroProducto);
            //Si la devolución se realiza correctamente, decremento el contador
            $this->numProductosAlquilados--; //Disminuyo productos alquilados actualmente
        } catch (SoporteNoEncontradoException $e) {
            //Informo al usuario si no se encuentra el soporte
            echo "<br>Error: " . $e->getMessage() . "<br>";
        }
        
        //Devuelvo $this para permitir el encadenamiento de métodos
        return $this;
    }
    
    //Método para alquilar varios productos a un socio a la vez
    //Recibe el número del socio y un array con los números de los productos a alquilar
    //Primero compruebo que todos los soportes estén disponibles antes de alquilar
    public function alquilarSocioProductos(int $numSocio, array $numerosProductos) {
        //Primero busco el cliente
        $cliente = null;
        foreach ($this->socios as $socio) {
            if ($socio->getNumero() == $numSocio) {
                $cliente = $socio;
                break;
            }
        }
        
        //Si no encuentro el cliente, lanzo excepción
        if ($cliente == null) {
            throw new ClienteNoEncontradoException("No existe el cliente con número " . $numSocio);
        }
        
        //Array para guardar los soportes que voy a alquilar
        $soportesAAlquilar = [];
        
        //Recorro cada número de producto del array
        foreach ($numerosProductos as $numeroProducto) {
            //Busco el soporte en el catálogo de productos
            $soporteEncontrado = null;
            foreach ($this->productos as $producto) {
                if ($producto->getNumero() == $numeroProducto) {
                    $soporteEncontrado = $producto;
                    break;
                }
            }
            
            //Si no encuentro el soporte, lanzo excepción
            if ($soporteEncontrado == null) {
                throw new SoporteNoEncontradoException("No existe el soporte con número " . $numeroProducto);
            }
            
            //Compruebo si el soporte ya está alquilado
            if ($soporteEncontrado->alquilado == true) {
                //Si está alquilado, no alquilo ninguno y muestro mensaje
                echo "<br>Error: El soporte " . $soporteEncontrado->titulo . " ya está alquilado. No se realizará ningún alquiler.<br>";
                return $this; //Salgo del método sin alquilar nada
            }
            
            //Si está disponible, lo guardo en el array para alquilarlo después
            $soportesAAlquilar[] = $soporteEncontrado;
        }
        
        //Si llego aquí es porque todos los soportes están disponibles
        //Ahora sí procedo a alquilarlos uno por uno
        foreach ($soportesAAlquilar as $soporte) {
            try {
                //Intento alquilar el soporte al cliente
                $cliente->alquilar($soporte);
                //Si el alquiler funciona, incremento los contadores
                $this->numProductosAlquilados++;
                $this->numTotalAlquileres++;
            } catch (SoporteYaAlquiladoException $e) {
                //Si ya lo tenía alquilado este cliente, informo
                echo "<br>Error: " . $e->getMessage() . "<br>";
            } catch (CupoSuperadoException $e) {
                //Si supera el cupo, informo y paro de alquilar
                echo "<br>Error: " . $e->getMessage() . "<br>";
                break; //Salgo del bucle para no intentar alquilar más
            }
        }
        
        //Devuelvo $this para permitir el encadenamiento de métodos
        return $this;
    }
    
    //Método para que un socio devuelva varios productos a la vez
    //Recibe el número del socio y un array con los números de los productos a devolver
    public function devolverSocioProductos(int $numSocio, array $numerosProductos) {
        //Busco el cliente
        $cliente = null;
        foreach ($this->socios as $socio) {
            if ($socio->getNumero() == $numSocio) {
                $cliente = $socio;
                break;
            }
        }
        
        //Si no encuentro el cliente, lanzo excepción
        if ($cliente == null) {
            throw new ClienteNoEncontradoException("No existe el cliente con número " . $numSocio);
        }
        
        //Recorro cada número de producto del array para devolverlos
        foreach ($numerosProductos as $numeroProducto) {
            //Intento que el cliente devuelva cada soporte
            try {
                $cliente->devolver($numeroProducto);
                //Si la devolución funciona, decremento el contador
                $this->numProductosAlquilados--; //Disminuyo productos alquilados actualmente
            } catch (SoporteNoEncontradoException $e) {
                //Si no encuentra el soporte, informo y continúo con el siguiente
                echo "<br>Error: " . $e->getMessage() . "<br>";
            }
        }
        
        //Devuelvo $this para permitir el encadenamiento de métodos
        return $this;
    }
}

?>
