<?php

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Juego;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

/**
 * Clase de pruebas para Videoclub
 */
class VideoclubTest extends TestCase
{
    private $videoclub;
    
    /**
     * Se ejecuta antes de cada prueba
     */
    protected function setUp(): void
    {
        $this->videoclub = new Videoclub("Videoclub Severo 8A");
    }
    
    /**
     * Verifica que el constructor inicializa correctamente
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(Videoclub::class, $this->videoclub);
        $this->assertEquals(0, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(0, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que se puede incluir una cinta de vídeo
     */
    public function testIncluirCintaVideo()
    {
        $this->videoclub->incluirCintaVideo("Los cazafantasmas", 3.5, 105);
        
        ob_start();
        $this->videoclub->listarProductos();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("1 productos disponibles", $output);
        $this->assertStringContainsString("Los cazafantasmas", $output);
    }
    
    /**
     * Verifica que se puede incluir un DVD
     */
    public function testIncluirDvd()
    {
        $this->videoclub->incluirDvd("Origen", 15, "Español, Inglés", "16:9");
        
        ob_start();
        $this->videoclub->listarProductos();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("1 productos disponibles", $output);
        $this->assertStringContainsString("Origen", $output);
    }
    
    /**
     * Verifica que se puede incluir un juego
     */
    public function testIncluirJuego()
    {
        $this->videoclub->incluirJuego("God of War", 60, "PS4", 1, 1);
        
        ob_start();
        $this->videoclub->listarProductos();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("1 productos disponibles", $output);
        $this->assertStringContainsString("God of War", $output);
    }
    
    /**
     * Proveedor de datos para diferentes tipos de productos
     */
    public static function proveedorProductos()
    {
        return [
            'cinta video' => ['incluirCintaVideo', ["Matrix", 5, 136]],
            'dvd' => ['incluirDvd', ["Inception", 18, "Español, Inglés, Francés", "16:9"]],
            'juego' => ['incluirJuego', ["The Last of Us", 50, "PS5", 1, 2]],
        ];
    }
    
    /**
     * Verifica que se pueden incluir múltiples productos
     * @dataProvider proveedorProductos
     */
    public function testIncluirMultiplesProductos($metodo, $parametros)
    {
        $this->videoclub->$metodo(...$parametros);
        $this->videoclub->$metodo(...$parametros);
        $this->videoclub->$metodo(...$parametros);
        
        ob_start();
        $this->videoclub->listarProductos();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("3 productos disponibles", $output);
    }
    
    /**
     * Verifica que se puede incluir un socio
     */
    public function testIncluirSocio()
    {
        $this->videoclub->incluirSocio("Juan Pérez");
        
        ob_start();
        $this->videoclub->listarSocios();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("1 socios del videoclub", $output);
        $this->assertStringContainsString("Juan Pérez", $output);
    }
    
    /**
     * Verifica que se pueden incluir múltiples socios
     */
    public function testIncluirMultiplesSocios()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 3);
        $this->videoclub->incluirSocio("María García", 5);
        $this->videoclub->incluirSocio("Pedro López", 2);
        
        ob_start();
        $this->videoclub->listarSocios();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("3 socios del videoclub", $output);
        $this->assertStringContainsString("Juan Pérez", $output);
        $this->assertStringContainsString("María García", $output);
        $this->assertStringContainsString("Pedro López", $output);
    }
    
    /**
     * Verifica que se puede alquilar un producto a un socio
     */
    public function testAlquilarSocioProducto()
    {
        $this->videoclub->incluirSocio("Juan Pérez");
        $this->videoclub->incluirDvd("Origen", 15, "Español", "16:9");
        
        $this->videoclub->alquilaSocioProducto(1, 1);
        
        $this->assertEquals(1, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(1, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que se pueden alquilar múltiples productos individualmente
     */
    public function testAlquilarMultiplesProductosIndividual()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 5);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 2", 12, "Español", "16:9");
        $this->videoclub->incluirJuego("Juego 1", 50, "PS4", 1, 1);
        
        $this->videoclub->alquilaSocioProducto(1, 1)
                        ->alquilaSocioProducto(1, 2)
                        ->alquilaSocioProducto(1, 3);
        
        $this->assertEquals(3, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(3, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que lanza excepción al alquilar con cliente no encontrado
     */
    public function testExcepcionAlquilarClienteNoEncontrado()
    {
        $this->videoclub->incluirDvd("Origen", 15, "Español", "16:9");
        
        $this->expectException(ClienteNoEncontradoException::class);
        $this->expectExceptionMessage("No existe el cliente con número 999");
        $this->videoclub->alquilaSocioProducto(999, 1);
    }
    
    /**
     * Verifica que lanza excepción al alquilar con soporte no encontrado
     */
    public function testExcepcionAlquilarSoporteNoEncontrado()
    {
        $this->videoclub->incluirSocio("Juan Pérez");
        
        $this->expectException(SoporteNoEncontradoException::class);
        $this->expectExceptionMessage("No existe el soporte con número 999");
        $this->videoclub->alquilaSocioProducto(1, 999);
    }
    
    /**
     * Verifica que se puede devolver un producto
     */
    public function testDevolverSocioProducto()
    {
        $this->videoclub->incluirSocio("Juan Pérez");
        $this->videoclub->incluirDvd("Origen", 15, "Español", "16:9");
        
        $this->videoclub->alquilaSocioProducto(1, 1);
        $this->assertEquals(1, $this->videoclub->getNumProductosAlquilados());
        
        $this->videoclub->devolverSocioProducto(1, 1);
        $this->assertEquals(0, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(1, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que lanza excepción al devolver con cliente no encontrado
     */
    public function testExcepcionDevolverClienteNoEncontrado()
    {
        $this->expectException(ClienteNoEncontradoException::class);
        $this->expectExceptionMessage("No existe el cliente con número 999");
        $this->videoclub->devolverSocioProducto(999, 1);
    }
    
    /**
     * Verifica el encadenamiento de métodos
     */
    public function testEncadenamientoMetodos()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 5);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 2", 12, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 3", 15, "Español", "16:9");
        
        $resultado = $this->videoclub->alquilaSocioProducto(1, 1)
                                     ->alquilaSocioProducto(1, 2)
                                     ->devolverSocioProducto(1, 1)
                                     ->alquilaSocioProducto(1, 3);
        
        $this->assertInstanceOf(Videoclub::class, $resultado);
        $this->assertEquals(2, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(3, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que se pueden alquilar múltiples productos mediante array
     */
    public function testAlquilarSocioProductosArray()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 5);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 2", 12, "Español", "16:9");
        $this->videoclub->incluirJuego("Juego 1", 50, "PS4", 1, 1);
        
        $this->videoclub->alquilarSocioProductos(1, [1, 2, 3]);
        
        $this->assertEquals(3, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(3, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que lanza excepción al alquilar array con cliente no encontrado
     */
    public function testExcepcionAlquilarArrayClienteNoEncontrado()
    {
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        
        $this->expectException(ClienteNoEncontradoException::class);
        $this->videoclub->alquilarSocioProductos(999, [1]);
    }
    
    /**
     * Verifica que lanza excepción al alquilar array con soporte no encontrado
     */
    public function testExcepcionAlquilarArraySoporteNoEncontrado()
    {
        $this->videoclub->incluirSocio("Juan Pérez");
        
        $this->expectException(SoporteNoEncontradoException::class);
        $this->videoclub->alquilarSocioProductos(1, [999]);
    }
    
    /**
     * Proveedor de datos para arrays de productos
     */
    public static function proveedorArraysProductos()
    {
        return [
            'array 2 elementos' => [[1, 2], 2],
            'array 3 elementos' => [[1, 2, 3], 3],
            'array 4 elementos' => [[1, 2, 3, 4], 4],
            'array 5 elementos' => [[1, 2, 3, 4, 5], 5],
        ];
    }
    
    /**
     * Verifica que se pueden alquilar diferentes cantidades mediante array
     * @dataProvider proveedorArraysProductos
     */
    public function testAlquilarDiferentesCantidadesArray($productos, $cantidad)
    {
        $this->videoclub->incluirSocio("Juan Pérez", 10);
        
        for ($i = 1; $i <= $cantidad; $i++) {
            $this->videoclub->incluirDvd("Película " . $i, 10, "Español", "16:9");
        }
        
        $this->videoclub->alquilarSocioProductos(1, $productos);
        
        $this->assertEquals($cantidad, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals($cantidad, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que no se alquila ninguno si uno ya está alquilado
     */
    public function testNoAlquilarArraySiUnoYaAlquilado()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 5);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 2", 12, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 3", 15, "Español", "16:9");
        
        $this->videoclub->alquilaSocioProducto(1, 2);
        
        ob_start();
        $this->videoclub->alquilarSocioProductos(1, [1, 2, 3]);
        $output = ob_get_clean();
        
        $this->assertStringContainsString("ya está alquilado", $output);
        $this->assertEquals(1, $this->videoclub->getNumProductosAlquilados());
    }
    
    /**
     * Verifica que se pueden devolver múltiples productos mediante array
     */
    public function testDevolverSocioProductosArray()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 5);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 2", 12, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 3", 15, "Español", "16:9");
        
        $this->videoclub->alquilarSocioProductos(1, [1, 2, 3]);
        $this->assertEquals(3, $this->videoclub->getNumProductosAlquilados());
        
        $this->videoclub->devolverSocioProductos(1, [1, 2]);
        $this->assertEquals(1, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(3, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que lanza excepción al devolver array con cliente no encontrado
     */
    public function testExcepcionDevolverArrayClienteNoEncontrado()
    {
        $this->expectException(ClienteNoEncontradoException::class);
        $this->videoclub->devolverSocioProductos(999, [1]);
    }
    
    /**
     * Verifica que se pueden devolver todos los productos
     */
    public function testDevolverTodosProductos()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 5);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 2", 12, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 3", 15, "Español", "16:9");
        
        $this->videoclub->alquilarSocioProductos(1, [1, 2, 3]);
        $this->videoclub->devolverSocioProductos(1, [1, 2, 3]);
        
        $this->assertEquals(0, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(3, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Proveedor de datos para escenarios complejos
     */
    public static function proveedorEscenariosComplejos()
    {
        return [
            'escenario 1: alquilar 3, devolver 1, alquilar 2' => [
                [
                    ['tipo' => 'alquilar_array', 'productos' => [1, 2, 3]],
                    ['tipo' => 'devolver', 'producto' => 2],
                    ['tipo' => 'alquilar_array', 'productos' => [4, 5]],
                ],
                4, // productos alquilados actualmente
                5  // total histórico
            ],
            'escenario 2: alquilar 2, devolver 2, alquilar 3' => [
                [
                    ['tipo' => 'alquilar_array', 'productos' => [1, 2]],
                    ['tipo' => 'devolver_array', 'productos' => [1, 2]],
                    ['tipo' => 'alquilar_array', 'productos' => [3, 4, 5]],
                ],
                3, // productos alquilados actualmente
                5  // total histórico
            ],
        ];
    }
    
    /**
     * Verifica escenarios complejos con múltiples operaciones
     * @dataProvider proveedorEscenariosComplejos
     */
    public function testEscenariosComplejos($operaciones, $esperadoActuales, $esperadoTotal)
    {
        $this->videoclub->incluirSocio("Juan Pérez", 10);
        
        for ($i = 1; $i <= 5; $i++) {
            $this->videoclub->incluirDvd("Película " . $i, 10, "Español", "16:9");
        }
        
        foreach ($operaciones as $op) {
            switch ($op['tipo']) {
                case 'alquilar':
                    $this->videoclub->alquilaSocioProducto(1, $op['producto']);
                    break;
                case 'alquilar_array':
                    $this->videoclub->alquilarSocioProductos(1, $op['productos']);
                    break;
                case 'devolver':
                    $this->videoclub->devolverSocioProducto(1, $op['producto']);
                    break;
                case 'devolver_array':
                    $this->videoclub->devolverSocioProductos(1, $op['productos']);
                    break;
            }
        }
        
        $this->assertEquals($esperadoActuales, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals($esperadoTotal, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica que el contador histórico no se decrementa al devolver
     */
    public function testContadorHistoricoNuncaDecrementa()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 5);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        
        $this->videoclub->alquilaSocioProducto(1, 1);
        $this->assertEquals(1, $this->videoclub->getNumTotalAlquileres());
        
        $this->videoclub->devolverSocioProducto(1, 1);
        $this->assertEquals(1, $this->videoclub->getNumTotalAlquileres());
        
        $this->videoclub->alquilaSocioProducto(1, 1);
        $this->assertEquals(2, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica el funcionamiento con múltiples socios
     */
    public function testMultiplesSociosAlquilando()
    {
        $this->videoclub->incluirSocio("Juan Pérez", 3);
        $this->videoclub->incluirSocio("María García", 3);
        $this->videoclub->incluirDvd("Película 1", 10, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 2", 12, "Español", "16:9");
        $this->videoclub->incluirDvd("Película 3", 15, "Español", "16:9");
        
        $this->videoclub->alquilaSocioProducto(1, 1);
        $this->videoclub->alquilaSocioProducto(2, 2);
        $this->videoclub->alquilaSocioProducto(1, 3);
        
        $this->assertEquals(3, $this->videoclub->getNumProductosAlquilados());
        $this->assertEquals(3, $this->videoclub->getNumTotalAlquileres());
    }
    
    /**
     * Verifica la generación automática de usuarios
     */
    public function testGeneracionAutomaticaUsuarios()
    {
        $this->videoclub->incluirSocio("Juan Pérez");
        
        ob_start();
        $this->videoclub->listarSocios();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("Juan Pérez", $output);
    }
    
    /**
     * Verifica que listarProductos funciona correctamente
     */
    public function testListarProductos()
    {
        $this->videoclub->incluirDvd("Inception", 15, "Español, Inglés", "16:9");
        $this->videoclub->incluirCintaVideo("Matrix", 5, 136);
        $this->videoclub->incluirJuego("God of War", 60, "PS4", 1, 1);
        
        ob_start();
        $this->videoclub->listarProductos();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("3 productos disponibles", $output);
        $this->assertStringContainsString("Inception", $output);
        $this->assertStringContainsString("Matrix", $output);
        $this->assertStringContainsString("God of War", $output);
    }
}
