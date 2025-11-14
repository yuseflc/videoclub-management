<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - Gestión de Clientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Videoclub</h1>
            <p>Sistema de Gestión de Alquileres</p>
        </div>
        
        <nav class="nav">
            <ul class="nav-links">
                <li><a href="inicio.php">Soportes</a></li>
                <li><a href="inicio2.php" class="active">Clientes</a></li>
                <li><a href="inicio3.php">Gestión Completa</a></li>
            </ul>
        </nav>

        <div class="content">
<?php

/* 
Archivo de prueba para las clases Cliente con encadenamiento de métodos
Ahora uso autoload.php para cargar las clases automáticamente
*/

//Incluyo el autoload que se encarga de cargar automáticamente todas las clases
include '../autoload.php';

//Importo las clases del namespace Dwes\ProyectoVideoclub usando 'use'
//Esto me permite usar los nombres sin cualificar (sin poner el namespace completo)
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;

//instanciamos un par de objetos cliente
$cliente1 = new Cliente("Bruce Wayne", 23, "bruce.wayne", "batman2024");
$cliente2 = new Cliente("Clark Kent", 33, "clark.kent", "superman2024");

echo '<div class="section">';
echo '<h2 class="section-title">Información de Clientes</h2>';
echo '<div class="cliente-info">';
echo "<strong>Cliente 1:</strong> Bruce Wayne <span class='badge badge-info'>ID: " . $cliente1->getNumero() . "</span>";
echo '</div>';
echo '<div class="cliente-info">';
echo "<strong>Cliente 2:</strong> Clark Kent <span class='badge badge-info'>ID: " . $cliente2->getNumero() . "</span>";
echo '</div>';
echo '</div>';

//instancio algunos soportes 
$soporte1 = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
$soporte2 = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);  
$soporte3 = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
$soporte4 = new Dvd("El Imperio Contraataca", 4, 3, "es,en","16:9");

echo '<div class="section">';
echo '<h2 class="section-title">Catálogo de Soportes Disponibles</h2>';
echo '<div class="soporte-card">';
echo '<div class="titulo">Los cazafantasmas</div>';
echo '<div class="detalle">Cinta de Video - 107 minutos</div>';
echo '<div class="precio">Precio: 3.50€</div>';
echo '</div>';
echo '<div class="soporte-card">';
echo '<div class="titulo">The Last of Us Part II</div>';
echo '<div class="detalle">Juego PS4 - 1 jugador</div>';
echo '<div class="precio">Precio: 49.99€</div>';
echo '</div>';
echo '<div class="soporte-card">';
echo '<div class="titulo">Origen</div>';
echo '<div class="detalle">DVD - Idiomas: es, en, fr - Formato: 16:9</div>';
echo '<div class="precio">Precio: 15.00€</div>';
echo '</div>';
echo '<div class="soporte-card">';
echo '<div class="titulo">El Imperio Contraataca</div>';
echo '<div class="detalle">DVD - Idiomas: es, en - Formato: 16:9</div>';
echo '<div class="precio">Precio: 3.00€</div>';
echo '</div>';
echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
echo '<h2 class="section-title">Proceso de Alquileres</h2>';

//alquilo algunos soportes de forma encadenada
//He utilizado el encadenamiento de métodos (method chaining) para alquilar múltiples soportes en una sola línea
echo '<div class="mensaje-exito">Alquilando soportes a Bruce Wayne...</div>';
$cliente1->alquilar($soporte1)->alquilar($soporte2)->alquilar($soporte3);

//voy a intentar alquilar de nuevo un soporte que ya tiene alquilado
//el encadenamiento sigue funcionando incluso con errores
try {
    $cliente1->alquilar($soporte1);
} catch (Exception $e) {
    echo "<div class='mensaje-error'>" . $e->getMessage() . "</div>";
}

//el cliente tiene 3 soportes en alquiler como máximo
//este soporte no lo va a poder alquilar
try {
    $cliente1->alquilar($soporte4);
} catch (Exception $e) {
    echo "<div class='mensaje-error'>" . $e->getMessage() . "</div>";
}

//este soporte no lo tiene alquilado, pero devuelvo también encadenado
try {
    $cliente1->devolver(4);
} catch (Exception $e) {
    echo "<div class='mensaje-error'>" . $e->getMessage() . "</div>";
}

//devuelvo dos soportes de forma encadenada
echo '<div class="mensaje-info">Devolviendo soporte y alquilando otro...</div>';
try {
    $cliente1->devolver(2)->alquilar($soporte4);
} catch (Exception $e) {
    echo "<div class='mensaje-error'>" . $e->getMessage() . "</div>";
}

echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
echo '<h2 class="section-title">Listado de Alquileres Actuales</h2>';

//listo los elementos alquilados
$cliente1->listarAlquileres();

echo '</div>';

echo '<div class="section">';
echo '<h2 class="section-title">Validaciones</h2>';

//este cliente no tiene alquileres
echo '<div class="mensaje-info">Intentando devolver soporte de cliente sin alquileres...</div>';
try {
    $cliente2->devolver(2);
} catch (Exception $e) {
    echo "<div class='mensaje-error'>" . $e->getMessage() . "</div>";
}

echo '</div>';
?>
        </div>

        <div class="footer">
            <p>Proyecto Videoclub - DWES</p>
            <p>David Lopez Ferreras y Yusef Laroussi de la Calle</p>
        </div>
    </div>
</body>
</html>
