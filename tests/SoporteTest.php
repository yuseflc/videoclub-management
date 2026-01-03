<?php

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Juego;

/**
 * Clase de pruebas para Soporte (clase abstracta)
 * Se prueban sus funcionalidades a través de clases concretas
 */
class SoporteTest extends TestCase
{
    private $dvd;
    private $cinta;
    private $juego;
    
    /**
     * Se ejecuta antes de cada prueba
     */
    protected function setUp(): void
    {
        $this->dvd = new Dvd("Test DVD", 1, 15.99, "Español", "16:9");
        $this->cinta = new CintaVideo("Test Cinta", 2, 5.50, 120);
        $this->juego = new Juego("Test Juego", 3, 49.99, "PS5", 1, 4);
    }
    
    /**
     * Verifica que el precio base se obtiene correctamente
     */
    public function testGetPrecio()
    {
        $this->assertEquals(15.99, $this->dvd->getPrecio());
        $this->assertEquals(5.50, $this->cinta->getPrecio());
        $this->assertEquals(49.99, $this->juego->getPrecio());
    }
    
    /**
     * Verifica que el número se obtiene correctamente
     */
    public function testGetNumero()
    {
        $this->assertEquals(1, $this->dvd->getNumero());
        $this->assertEquals(2, $this->cinta->getNumero());
        $this->assertEquals(3, $this->juego->getNumero());
    }
    
    /**
     * Verifica el cálculo del precio con IVA (21%)
     */
    public function testGetPrecioConIVA()
    {
        $this->assertEqualsWithDelta(15.99 * 1.21, $this->dvd->getPrecioConIVA(), 0.01);
        $this->assertEqualsWithDelta(5.50 * 1.21, $this->cinta->getPrecioConIVA(), 0.01);
        $this->assertEqualsWithDelta(49.99 * 1.21, $this->juego->getPrecioConIVA(), 0.01);
    }
    
    /**
     * Proveedor de datos para diferentes precios
     */
    public static function proveedorPrecios()
    {
        return [
            'precio bajo' => [5.00, 5.00 * 1.21],
            'precio medio' => [15.99, 15.99 * 1.21],
            'precio alto' => [49.99, 49.99 * 1.21],
            'precio decimal' => [12.75, 12.75 * 1.21],
            'precio con decimales' => [9.99, 9.99 * 1.21],
        ];
    }
    
    /**
     * Verifica el cálculo del IVA con diferentes precios
     * @dataProvider proveedorPrecios
     */
    public function testCalculoIVADiferentesPrecios($precioBase, $precioConIVA)
    {
        $dvd = new Dvd("Test", 100, $precioBase, "Español", "16:9");
        $this->assertEqualsWithDelta($precioConIVA, $dvd->getPrecioConIVA(), 0.01);
    }
    
    /**
     * Verifica que el título es público y accesible
     */
    public function testTituloPublico()
    {
        $this->assertEquals("Test DVD", $this->dvd->titulo);
        $this->assertEquals("Test Cinta", $this->cinta->titulo);
        $this->assertEquals("Test Juego", $this->juego->titulo);
    }
    
    /**
     * Verifica que se puede modificar el título
     */
    public function testModificarTitulo()
    {
        $this->dvd->titulo = "Nuevo Título";
        $this->assertEquals("Nuevo Título", $this->dvd->titulo);
    }
    
    /**
     * Verifica el estado inicial de alquilado
     */
    public function testEstadoInicialAlquilado()
    {
        $this->assertFalse($this->dvd->alquilado);
        $this->assertFalse($this->cinta->alquilado);
        $this->assertFalse($this->juego->alquilado);
    }
    
    /**
     * Verifica que se puede marcar como alquilado
     */
    public function testMarcarComoAlquilado()
    {
        $this->dvd->alquilado = true;
        $this->assertTrue($this->dvd->alquilado);
        
        $this->cinta->alquilado = true;
        $this->assertTrue($this->cinta->alquilado);
    }
    
    /**
     * Verifica que se puede desmarcar como alquilado
     */
    public function testDesmarcarComoAlquilado()
    {
        $this->dvd->alquilado = true;
        $this->assertTrue($this->dvd->alquilado);
        
        $this->dvd->alquilado = false;
        $this->assertFalse($this->dvd->alquilado);
    }
    
    /**
     * Verifica que muestraResumen devuelve una cadena
     */
    public function testMuestraResumenGeneraSalida()
    {
        ob_start();
        $resultado = $this->dvd->muestraResumen();
        $output = ob_get_clean();
        
        $this->assertIsString($resultado);
        $this->assertNotEmpty($resultado);
        $this->assertStringContainsString("Test DVD", $resultado);
        $this->assertEquals($output, $resultado);
    }
    
    /**
     * Verifica que muestraResumen incluye información básica
     */
    public function testMuestraResumenInformacionBasica()
    {
        ob_start();
        $this->dvd->muestraResumen();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("Título", $output);
        $this->assertStringContainsString("Número", $output);
        $this->assertStringContainsString("Precio", $output);
    }
    
    /**
     * Verifica que diferentes soportes tienen números únicos
     */
    public function testNumerosUnicos()
    {
        $soportes = [
            new Dvd("DVD 1", 1, 10, "Español", "16:9"),
            new Dvd("DVD 2", 2, 10, "Español", "16:9"),
            new CintaVideo("Cinta 1", 3, 5, 100),
            new Juego("Juego 1", 4, 50, "PS5", 1, 1),
        ];
        
        $numeros = array_map(function($s) { return $s->getNumero(); }, $soportes);
        $numerosUnicos = array_unique($numeros);
        
        $this->assertCount(count($soportes), $numerosUnicos);
    }
    
    /**
     * Proveedor de datos para diferentes tipos de soportes
     */
    public static function proveedorTiposSoportes()
    {
        return [
            'dvd' => [
                function() { return new Dvd("Test DVD", 1, 15, "Español", "16:9"); },
                "DVD"
            ],
            'cinta' => [
                function() { return new CintaVideo("Test Cinta", 2, 5, 120); },
                "Cinta"
            ],
            'juego' => [
                function() { return new Juego("Test Juego", 3, 50, "PS5", 1, 1); },
                "Juego"
            ],
        ];
    }
    
    /**
     * Verifica que todos los tipos de soporte calculan el IVA correctamente
     * @dataProvider proveedorTiposSoportes
     */
    public function testTodosTiposSoporteCalculanIVA($creador, $tipo)
    {
        $soporte = $creador();
        $precioBase = $soporte->getPrecio();
        $precioConIVA = $soporte->getPrecioConIVA();
        
        $this->assertEquals($precioBase * 1.21, $precioConIVA);
    }
    
    /**
     * Verifica que el precio con IVA es siempre mayor que el precio base
     */
    public function testPrecioConIVAMayorQuePrecioBase()
    {
        $this->assertGreaterThan($this->dvd->getPrecio(), $this->dvd->getPrecioConIVA());
        $this->assertGreaterThan($this->cinta->getPrecio(), $this->cinta->getPrecioConIVA());
        $this->assertGreaterThan($this->juego->getPrecio(), $this->juego->getPrecioConIVA());
    }
    
    /**
     * Verifica el porcentaje exacto del IVA (21%)
     */
    public function testPorcentajeIVA()
    {
        $precioBase = 100;
        $dvd = new Dvd("Test", 1, $precioBase, "Español", "16:9");
        
        $incremento = $dvd->getPrecioConIVA() - $precioBase;
        $porcentaje = ($incremento / $precioBase) * 100;
        
        $this->assertEquals(21, $porcentaje);
    }
}
