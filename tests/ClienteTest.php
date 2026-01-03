<?php

namespace Dwes\ProyectoVideoclub\Test;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Juego;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

/**
 * Clase de pruebas para Cliente
 */
class ClienteTest extends TestCase
{
    private $cliente;
    private $dvd1;
    private $dvd2;
    private $juego1;
    private $cinta1;
    
    /**
     * Se ejecuta antes de cada prueba
     */
    protected function setUp(): void
    {
        $this->cliente = new Cliente("Juan Pérez", 1, "juanp", "password123", 3);
        $this->dvd1 = new Dvd("Origen", 1, 15, "Español, Inglés", "16:9");
        $this->dvd2 = new Dvd("Matrix", 2, 12, "Español, Inglés", "16:9");
        $this->juego1 = new Juego("God of War", 3, 60, "PS4", 1, 1);
        $this->cinta1 = new CintaVideo("Los cazafantasmas", 4, 3.5, 105);
    }
    
    /**
     * Verifica que el constructor inicializa correctamente los valores
     */
    public function testConstructor()
    {
        $this->assertEquals("Juan Pérez", $this->cliente->nombre);
        $this->assertEquals(1, $this->cliente->getNumero());
        $this->assertEquals("juanp", $this->cliente->getUsuario());
        $this->assertEquals(0, $this->cliente->getNumSoportesAlquilados());
    }
    
    /**
     * Verifica que la contraseña se guarda codificada
     */
    public function testPasswordCodificada()
    {
        $this->assertNotEquals("password123", $this->cliente->getPassword());
        $this->assertTrue(password_verify("password123", $this->cliente->getPassword()));
    }
    
    /**
     * Proveedor de datos para diferentes cupos de alquiler
     */
    public static function proveedorCuposAlquiler()
    {
        return [
            'cupo 1' => [1],
            'cupo 2' => [2],
            'cupo 3' => [3],
            'cupo 5' => [5],
            'cupo 10' => [10],
        ];
    }
    
    /**
     * Verifica que funciona con diferentes cupos de alquiler
     * @dataProvider proveedorCuposAlquiler
     */
    public function testDiferentesCuposAlquiler($cupo)
    {
        $cliente = new Cliente("Test Cliente", 100, "testuser", "pass", $cupo);
        
        // Alquilar hasta el cupo
        for ($i = 0; $i < $cupo; $i++) {
            $dvd = new Dvd("Película " . $i, 100 + $i, 10, "Español", "16:9");
            $cliente->alquilar($dvd);
        }
        
        $this->assertEquals($cupo, $cliente->getNumSoportesAlquilados());
        $this->assertCount($cupo, $cliente->getAlquileres());
    }
    
    /**
     * Verifica que lanza excepción al superar el cupo
     * @dataProvider proveedorCuposAlquiler
     */
    public function testExcepcionAlSuperarCupo($cupo)
    {
        $cliente = new Cliente("Test Cliente", 100, "testuser", "pass", $cupo);
        
        // Alquilar hasta el cupo
        for ($i = 0; $i < $cupo; $i++) {
            $dvd = new Dvd("Película " . $i, 100 + $i, 10, "Español", "16:9");
            $cliente->alquilar($dvd);
        }
        
        // Intentar alquilar uno más debe lanzar excepción
        $this->expectException(CupoSuperadoException::class);
        $dvdExtra = new Dvd("Película Extra", 999, 10, "Español", "16:9");
        $cliente->alquilar($dvdExtra);
    }
    
    /**
     * Verifica que se puede alquilar un soporte
     */
    public function testAlquilarSoporte()
    {
        $this->cliente->alquilar($this->dvd1);
        
        $this->assertEquals(1, $this->cliente->getNumSoportesAlquilados());
        $this->assertTrue($this->cliente->tieneAlquilado($this->dvd1));
        $this->assertTrue($this->dvd1->alquilado);
    }
    
    /**
     * Verifica que se pueden alquilar múltiples soportes
     */
    public function testAlquilarMultiplesSoportes()
    {
        $this->cliente->alquilar($this->dvd1)
                      ->alquilar($this->dvd2)
                      ->alquilar($this->juego1);
        
        $this->assertEquals(3, $this->cliente->getNumSoportesAlquilados());
        $this->assertTrue($this->cliente->tieneAlquilado($this->dvd1));
        $this->assertTrue($this->cliente->tieneAlquilado($this->dvd2));
        $this->assertTrue($this->cliente->tieneAlquilado($this->juego1));
    }
    
    /**
     * Verifica que lanza excepción al alquilar un soporte ya alquilado
     */
    public function testExcepcionAlAlquilarSoporteYaAlquilado()
    {
        $this->cliente->alquilar($this->dvd1);
        
        $this->expectException(SoporteYaAlquiladoException::class);
        $this->expectExceptionMessage("El cliente ya tiene alquilado el soporte: Origen");
        $this->cliente->alquilar($this->dvd1);
    }
    
    /**
     * Verifica que lanza excepción al superar el cupo de alquileres
     */
    public function testExcepcionAlSuperarCupoAlquileres()
    {
        $this->cliente->alquilar($this->dvd1);
        $this->cliente->alquilar($this->dvd2);
        $this->cliente->alquilar($this->juego1);
        
        $this->expectException(CupoSuperadoException::class);
        $this->cliente->alquilar($this->cinta1);
    }
    
    /**
     * Verifica que se puede devolver un soporte alquilado
     */
    public function testDevolverSoporte()
    {
        $this->cliente->alquilar($this->dvd1);
        $this->cliente->devolver(1);
        
        $this->assertEquals(1, $this->cliente->getNumSoportesAlquilados());
        $this->assertFalse($this->cliente->tieneAlquilado($this->dvd1));
        $this->assertFalse($this->dvd1->alquilado);
    }
    
    /**
     * Verifica que lanza excepción al devolver un soporte no alquilado
     */
    public function testExcepcionAlDevolverSoporteNoAlquilado()
    {
        $this->expectException(SoporteNoEncontradoException::class);
        $this->cliente->devolver(999);
    }
    
    /**
     * Verifica el encadenamiento de métodos
     */
    public function testEncadenamientoMetodos()
    {
        $resultado = $this->cliente->alquilar($this->dvd1)
                                   ->alquilar($this->dvd2)
                                   ->devolver(1)
                                   ->alquilar($this->juego1);
        
        $this->assertInstanceOf(Cliente::class, $resultado);
        $this->assertEquals(3, $this->cliente->getNumSoportesAlquilados());
        $this->assertFalse($this->cliente->tieneAlquilado($this->dvd1));
        $this->assertTrue($this->cliente->tieneAlquilado($this->dvd2));
        $this->assertTrue($this->cliente->tieneAlquilado($this->juego1));
    }
    
    /**
     * Proveedor de datos para diferentes tipos de soportes
     */
    public static function proveedorTiposSoportes()
    {
        return [
            'DVD' => [
                new Dvd("Inception", 10, 15, "Español, Inglés", "16:9"),
                "Inception"
            ],
            'Cinta Video' => [
                new CintaVideo("Star Wars", 20, 8, 120),
                "Star Wars"
            ],
            'Juego' => [
                new Juego("The Last of Us", 30, 50, "PS5", 1, 2),
                "The Last of Us"
            ],
        ];
    }
    
    /**
     * Verifica que se pueden alquilar diferentes tipos de soportes
     * @dataProvider proveedorTiposSoportes
     */
    public function testAlquilarDiferentesTiposSoportes($soporte, $titulo)
    {
        $this->cliente->alquilar($soporte);
        
        $this->assertTrue($this->cliente->tieneAlquilado($soporte));
        $this->assertEquals($titulo, $soporte->titulo);
        $this->assertTrue($soporte->alquilado);
    }
    
    /**
     * Verifica que no coinciden los IDs de diferentes soportes
     */
    public function testIdsNoCoinciden()
    {
        $dvd1 = new Dvd("Película 1", 1, 10, "Español", "16:9");
        $dvd2 = new Dvd("Película 2", 2, 10, "Español", "16:9");
        $dvd3 = new Dvd("Película 3", 3, 10, "Español", "16:9");
        
        $this->assertNotEquals($dvd1->getNumero(), $dvd2->getNumero());
        $this->assertNotEquals($dvd1->getNumero(), $dvd3->getNumero());
        $this->assertNotEquals($dvd2->getNumero(), $dvd3->getNumero());
    }
    
    /**
     * Proveedor de datos para conjunto amplio de soportes
     */
    public static function proveedorConjuntoAmplio()
    {
        return [
            'conjunto 1' => [
                [
                    new Dvd("El Padrino", 101, 20, "Español, Inglés, Italiano", "16:9"),
                    new Dvd("Pulp Fiction", 102, 18, "Español, Inglés", "16:9"),
                    new CintaVideo("Terminator", 103, 12, 107),
                ]
            ],
            'conjunto 2' => [
                [
                    new Juego("Uncharted 4", 201, 55, "PS4", 1, 1),
                    new Juego("FIFA 23", 202, 60, "PS5", 1, 4),
                    new Dvd("Avatar", 203, 25, "Español, Inglés", "16:9"),
                ]
            ],
            'conjunto 3' => [
                [
                    new CintaVideo("Regreso al Futuro", 301, 10, 116),
                    new CintaVideo("Alien", 302, 9, 117),
                    new Juego("Horizon Zero Dawn", 303, 45, "PS4", 1, 1),
                ]
            ],
        ];
    }
    
    /**
     * Verifica que se pueden alquilar conjuntos amplios de soportes
     * @dataProvider proveedorConjuntoAmplio
     */
    public function testAlquilarConjuntoAmplioSoportes($soportes)
    {
        foreach ($soportes as $soporte) {
            $this->cliente->alquilar($soporte);
        }
        
        $this->assertEquals(count($soportes), $this->cliente->getNumSoportesAlquilados());
        
        foreach ($soportes as $soporte) {
            $this->assertTrue($this->cliente->tieneAlquilado($soporte));
            $this->assertTrue($soporte->alquilado);
        }
    }
    
    /**
     * Verifica que getAlquileres devuelve un array
     */
    public function testGetAlquileresDevuelveArray()
    {
        $this->assertIsArray($this->cliente->getAlquileres());
        $this->assertEmpty($this->cliente->getAlquileres());
        
        $this->cliente->alquilar($this->dvd1);
        $this->assertCount(1, $this->cliente->getAlquileres());
    }
    
    /**
     * Verifica que tieneAlquilado devuelve false para soportes no alquilados
     */
    public function testTieneAlquiladoDevuelveFalse()
    {
        $this->assertFalse($this->cliente->tieneAlquilado($this->dvd1));
        
        $this->cliente->alquilar($this->dvd1);
        $this->assertFalse($this->cliente->tieneAlquilado($this->dvd2));
    }
    
    /**
     * Verifica que al devolver un soporte se puede volver a alquilar
     */
    public function testDevolverYVolverAlquilar()
    {
        $this->cliente->alquilar($this->dvd1);
        $this->cliente->devolver(1);
        $this->cliente->alquilar($this->dvd1);
        
        $this->assertTrue($this->cliente->tieneAlquilado($this->dvd1));
        $this->assertEquals(2, $this->cliente->getNumSoportesAlquilados());
        $this->assertCount(1, $this->cliente->getAlquileres());
    }
    
    /**
     * Verifica que el array de alquileres se reindexaría correctamente
     */
    public function testReindexacionArrayAlquileres()
    {
        $this->cliente->alquilar($this->dvd1);
        $this->cliente->alquilar($this->dvd2);
        $this->cliente->alquilar($this->juego1);
        
        $this->cliente->devolver(2); // Devolver el del medio
        
        $alquileres = $this->cliente->getAlquileres();
        $this->assertCount(2, $alquileres);
        
        // Verificar que el array está bien indexado
        $this->assertArrayHasKey(0, $alquileres);
        $this->assertArrayHasKey(1, $alquileres);
        $this->assertArrayNotHasKey(2, $alquileres);
    }
    
    /**
     * Verifica el seteo del número de cliente
     */
    public function testSetNumero()
    {
        $this->cliente->setNumero(999);
        $this->assertEquals(999, $this->cliente->getNumero());
    }
    
    /**
     * Verifica el seteo del usuario
     */
    public function testSetUsuario()
    {
        $this->cliente->setUsuario("nuevousuario");
        $this->assertEquals("nuevousuario", $this->cliente->getUsuario());
    }
    
    /**
     * Verifica el seteo de la contraseña
     */
    public function testSetPassword()
    {
        $this->cliente->setPassword("nuevapass");
        $this->assertTrue(password_verify("nuevapass", $this->cliente->getPassword()));
        $this->assertFalse(password_verify("password123", $this->cliente->getPassword()));
    }
    
    /**
     * Verifica el método muestraResumen
     */
    public function testMuestraResumen()
    {
        $this->cliente->alquilar($this->dvd1);
        $this->cliente->alquilar($this->dvd2);
        
        ob_start();
        $this->cliente->muestraResumen();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("Juan Pérez", $output);
        $this->assertStringContainsString("juanp", $output);
        $this->assertStringContainsString("2", $output);
    }
    
    /**
     * Verifica el método listarAlquileres
     */
    public function testListarAlquileres()
    {
        $this->cliente->alquilar($this->dvd1);
        $this->cliente->alquilar($this->juego1);
        
        ob_start();
        $this->cliente->listarAlquileres();
        $output = ob_get_clean();
        
        $this->assertStringContainsString("2 soportes alquilados", $output);
        $this->assertStringContainsString("Origen", $output);
        $this->assertStringContainsString("God of War", $output);
    }
    
    /**
     * Proveedor de datos para escenarios complejos
     */
    public static function proveedorEscenarios()
    {
        return [
            'escenario alquilar 3 devolver 1' => [
                'operaciones' => [
                    ['accion' => 'alquilar', 'id' => 1],
                    ['accion' => 'alquilar', 'id' => 2],
                    ['accion' => 'alquilar', 'id' => 3],
                    ['accion' => 'devolver', 'id' => 2],
                ],
                'esperado' => 3
            ],
            'escenario alquilar 2 devolver 2 alquilar 1' => [
                'operaciones' => [
                    ['accion' => 'alquilar', 'id' => 1],
                    ['accion' => 'alquilar', 'id' => 2],
                    ['accion' => 'devolver', 'id' => 1],
                    ['accion' => 'devolver', 'id' => 2],
                    ['accion' => 'alquilar', 'id' => 3],
                ],
                'esperado' => 3
            ],
        ];
    }
    
    /**
     * Verifica escenarios complejos de alquiler y devolución
     * @dataProvider proveedorEscenarios
     */
    public function testEscenariosComplejos($operaciones, $contadorEsperado)
    {
        $soportes = [
            1 => new Dvd("Película 1", 1, 10, "Español", "16:9"),
            2 => new Dvd("Película 2", 2, 10, "Español", "16:9"),
            3 => new Juego("Juego 1", 3, 50, "PS5", 1, 1),
        ];
        
        foreach ($operaciones as $op) {
            if ($op['accion'] === 'alquilar') {
                $this->cliente->alquilar($soportes[$op['id']]);
            } else {
                $this->cliente->devolver($op['id']);
            }
        }
        
        $this->assertEquals($contadorEsperado, $this->cliente->getNumSoportesAlquilados());
    }
}
