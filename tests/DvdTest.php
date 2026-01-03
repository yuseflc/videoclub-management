<?php

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Dvd;

/**
 * Clase de pruebas para Dvd
 */
class DvdTest extends TestCase
{
    private $dvd;
    
    /**
     * Se ejecuta antes de cada prueba
     */
    protected function setUp(): void
    {
        $this->dvd = new Dvd("Origen", 24, 15, "Español, Inglés", "16:9");
    }
    
    /**
     * Verifica que el constructor inicializa correctamente los valores
     */
    public function testConstructor()
    {
        $this->assertEquals("Origen", $this->dvd->titulo);
        $this->assertEquals(24, $this->dvd->getNumero());
        $this->assertEquals(15, $this->dvd->getPrecio());
        $this->assertEquals("Español, Inglés", $this->dvd->idiomas);
        $this->assertFalse($this->dvd->alquilado);
    }
    
    /**
     * Verifica el cálculo del precio con IVA
     */
    public function testGetPrecioConIVA()
    {
        $precioEsperado = 15 * 1.21;
        $this->assertEquals($precioEsperado, $this->dvd->getPrecioConIVA());
    }
    
    /**
     * Verifica que muestraResumen devuelve una cadena con toda la información
     */
    public function testMuestraResumen()
    {
        ob_start();
        $resultado = $this->dvd->muestraResumen();
        $output = ob_get_clean();
        
        $this->assertIsString($resultado);
        $this->assertStringContainsString("Origen", $resultado);
        $this->assertStringContainsString("24", $resultado);
        $this->assertStringContainsString("15", $resultado);
        $this->assertStringContainsString("Español, Inglés", $resultado);
        $this->assertStringContainsString("16:9", $resultado);
        $this->assertEquals($output, $resultado);
    }
    
    /**
     * Verifica que el soporte comienza no alquilado
     */
    public function testEstadoInicialNoAlquilado()
    {
        $this->assertFalse($this->dvd->alquilado);
    }
    
    /**
     * Verifica que los idiomas se guardan correctamente
     */
    public function testIdiomasPublico()
    {
        $this->assertEquals("Español, Inglés", $this->dvd->idiomas);
    }
}
