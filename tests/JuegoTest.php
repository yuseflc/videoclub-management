<?php

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Juego;

/**
 * Clase de pruebas para Juego
 */
class JuegoTest extends TestCase
{
    private $juego;
    private $juegoUnJugador;
    private $juegoJugadoresIguales;
    
    /**
     * Se ejecuta antes de cada prueba
     */
    protected function setUp(): void
    {
        $this->juego = new Juego("The Last of Us Part II", 26, 49.95, "PS4", 1, 1);
        $this->juegoUnJugador = new Juego("God of War", 27, 39.95, "PS4", 1, 1);
        $this->juegoJugadoresIguales = new Juego("FIFA 23", 28, 59.95, "PS5", 4, 4);
    }
    
    /**
     * Verifica que el constructor inicializa correctamente los valores
     */
    public function testConstructor()
    {
        $this->assertEquals("The Last of Us Part II", $this->juego->titulo);
        $this->assertEquals(26, $this->juego->getNumero());
        $this->assertEquals(49.95, $this->juego->getPrecio());
        $this->assertEquals("PS4", $this->juego->consola);
        $this->assertFalse($this->juego->alquilado);
    }
    
    /**
     * Verifica el cálculo del precio con IVA
     */
    public function testGetPrecioConIVA()
    {
        $precioEsperado = 49.95 * 1.21;
        $this->assertEquals($precioEsperado, $this->juego->getPrecioConIVA());
    }
    
    /**
     * Verifica que muestraResumen devuelve una cadena con toda la información
     */
    public function testMuestraResumen()
    {
        ob_start();
        $resultado = $this->juego->muestraResumen();
        $output = ob_get_clean();
        
        $this->assertIsString($resultado);
        $this->assertStringContainsString("The Last of Us Part II", $resultado);
        $this->assertStringContainsString("26", $resultado);
        $this->assertStringContainsString("49.95", $resultado);
        $this->assertStringContainsString("PS4", $resultado);
        $this->assertStringContainsString("Para un jugador", $resultado);
        $this->assertEquals($output, $resultado);
    }
    
    /**
     * Verifica que muestraJugadoresPosibles devuelve cadena para un jugador
     */
    public function testMuestraJugadoresPosiblesUnJugador()
    {
        ob_start();
        $resultado = $this->juegoUnJugador->muestraJugadoresPosibles();
        $output = ob_get_clean();
        
        $this->assertIsString($resultado);
        $this->assertStringContainsString("Para un jugador", $resultado);
        $this->assertEquals($output, $resultado);
    }
    
    /**
     * Verifica que muestraJugadoresPosibles devuelve cadena para jugadores iguales
     */
    public function testMuestraJugadoresPosiblesJugadoresIguales()
    {
        ob_start();
        $resultado = $this->juegoJugadoresIguales->muestraJugadoresPosibles();
        $output = ob_get_clean();
        
        $this->assertIsString($resultado);
        $this->assertStringContainsString("Para 4 jugadores", $resultado);
        $this->assertEquals($output, $resultado);
    }
    
    /**
     * Verifica que muestraJugadoresPosibles devuelve cadena para rango de jugadores
     */
    public function testMuestraJugadoresPosiblesRango()
    {
        $juegoRango = new Juego("Mario Kart", 29, 44.95, "Switch", 1, 4);
        
        ob_start();
        $resultado = $juegoRango->muestraJugadoresPosibles();
        $output = ob_get_clean();
        
        $this->assertIsString($resultado);
        $this->assertStringContainsString("De 1 a 4 jugadores", $resultado);
        $this->assertEquals($output, $resultado);
    }
    
    /**
     * Verifica que el soporte comienza no alquilado
     */
    public function testEstadoInicialNoAlquilado()
    {
        $this->assertFalse($this->juego->alquilado);
    }
    
    /**
     * Verifica que la consola se guarda correctamente
     */
    public function testConsolaPublico()
    {
        $this->assertEquals("PS4", $this->juego->consola);
    }
}
