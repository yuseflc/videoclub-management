<?php

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\CintaVideo;

/**
 * Clase de pruebas para CintaVideo
 */
class CintaVideoTest extends TestCase
{
    private $cinta;
    
    /**
     * Se ejecuta antes de cada prueba
     */
    protected function setUp(): void
    {
        $this->cinta = new CintaVideo("Los cazafantasmas", 20, 3.5, 105);
    }
    
    /**
     * Verifica que el constructor inicializa correctamente los valores
     */
    public function testConstructor()
    {
        $this->assertEquals("Los cazafantasmas", $this->cinta->titulo);
        $this->assertEquals(20, $this->cinta->getNumero());
        $this->assertEquals(3.5, $this->cinta->getPrecio());
        $this->assertFalse($this->cinta->alquilado);
    }
    
    /**
     * Verifica el cálculo del precio con IVA
     */
    public function testGetPrecioConIVA()
    {
        $precioEsperado = 3.5 * 1.21;
        $this->assertEqualsWithDelta($precioEsperado, $this->cinta->getPrecioConIVA(), 0.01);
    }
    
    /**
     * Verifica que muestraResumen devuelve una cadena con toda la información
     */
    public function testMuestraResumen()
    {
        ob_start();
        $resultado = $this->cinta->muestraResumen();
        $output = ob_get_clean();
        
        $this->assertIsString($resultado);
        $this->assertStringContainsString("Los cazafantasmas", $resultado);
        $this->assertStringContainsString("20", $resultado);
        $this->assertStringContainsString("3.5", $resultado);
        $this->assertStringContainsString("105", $resultado);
        $this->assertStringContainsString("minutos", $resultado);
        $this->assertEquals($output, $resultado);
    }
    
    /**
     * Verifica que el soporte comienza no alquilado
     */
    public function testEstadoInicialNoAlquilado()
    {
        $this->assertFalse($this->cinta->alquilado);
    }
    
    /**
     * Verifica que se puede marcar como alquilado
     */
    public function testMarcarComoAlquilado()
    {
        $this->cinta->alquilado = true;
        $this->assertTrue($this->cinta->alquilado);
    }
    
    /**
     * Proveedor de datos para diferentes duraciones
     */
    public static function proveedorDuraciones()
    {
        return [
            'pelicula corta' => [90, "Película Corta"],
            'pelicula media' => [120, "Película Media"],
            'pelicula larga' => [180, "Película Larga"],
            'pelicula muy larga' => [240, "Película Épica"],
        ];
    }
    
    /**
     * Verifica que se pueden crear cintas con diferentes duraciones
     * @dataProvider proveedorDuraciones
     */
    public function testDiferentesDuraciones($duracion, $titulo)
    {
        $cinta = new CintaVideo($titulo, 100, 5, $duracion);
        
        ob_start();
        $cinta->muestraResumen();
        $output = ob_get_clean();
        
        $this->assertStringContainsString((string)$duracion, $output);
        $this->assertStringContainsString($titulo, $output);
    }
    
    /**
     * Verifica que el título es público y accesible
     */
    public function testTituloPublico()
    {
        $this->assertEquals("Los cazafantasmas", $this->cinta->titulo);
        $this->cinta->titulo = "Nuevo Título";
        $this->assertEquals("Nuevo Título", $this->cinta->titulo);
    }
    
    /**
     * Verifica diferentes precios con IVA
     */
    public function testDiferentesPreciosConIVA()
    {
        $cinta1 = new CintaVideo("Test 1", 1, 10, 100);
        $cinta2 = new CintaVideo("Test 2", 2, 20, 100);
        $cinta3 = new CintaVideo("Test 3", 3, 5.99, 100);
        
        $this->assertEquals(10 * 1.21, $cinta1->getPrecioConIVA());
        $this->assertEquals(20 * 1.21, $cinta2->getPrecioConIVA());
        $this->assertEquals(5.99 * 1.21, $cinta3->getPrecioConIVA());
    }
}
