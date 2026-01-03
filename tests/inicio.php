<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - Pruebas de Soportes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Videoclub</h1>
            <p>Pruebas de Clases de Soporte</p>
        </div>
        
        <nav class="nav">
            <ul class="nav-links">
                <li><a href="inicio.php" class="active">Soportes</a></li>
                <li><a href="inicio2.php">Clientes</a></li>
                <li><a href="inicio3.php">Gestión Completa</a></li>
            </ul>
        </nav>

<?php

/* 
Archivo de prueba para las clases Soporte y CintaVideo
Aquí pruebo que las clases funcionen correctamente y muestren toda la información
Ahora uso autoload.php para cargar las clases automáticamente
*/

//Incluyo el autoload que se encarga de cargar automáticamente todas las clases
//Ya no necesito hacer include de cada clase individualmente
include '../autoload.php';

//Importo las clases del namespace Dwes\ProyectoVideoclub usando 'use'
//Esto me permite usar los nombres sin cualificar (sin poner el namespace completo)
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;

//NOTA: Ya no puedo crear objetos Soporte directamente porque ahora es una clase abstracta
//Solo puedo crear objetos de las clases hijas: CintaVideo, Dvd o Juego

echo '<div class="section">';
//Primera prueba: pruebo la clase CintaVideo que hereda de Soporte
//He añadido la duración como nuevo atributo específico de las cintas
echo "<h2 class='section-title'>Prueba de la clase CintaVideo</h2>";
$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107); 
//Muestro el título usando el atributo público heredado de Soporte
echo "<div class='soporte-card'>";
echo "<div class='titulo'>" . $miCinta->titulo . "</div>"; 
//Uso el método getPrecio() que heredé de la clase padre
echo "<div class='detalle'>Precio: " . $miCinta->getPrecio() . " euros</div>"; 
//Calculo el precio con IVA usando el método heredado
echo "<div class='detalle'>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros</div>";
//Llamo al método muestraResumen() que he sobrescrito en CintaVideo
//Este método primero llama al del padre y luego añade la duración
echo "<div class='resumen-soporte'>";
$miCinta->muestraResumen();
echo "</div>";
echo "</div>";
echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
//Segunda prueba: pruebo la clase Dvd
echo "<h2 class='section-title'>Prueba de la clase Dvd</h2>";
$miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9"); 
echo "<div class='soporte-card'>";
echo "<div class='titulo'>" . $miDvd->titulo . "</div>"; 
echo "<div class='detalle'>Precio: " . $miDvd->getPrecio() . " euros</div>"; 
echo "<div class='detalle'>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros</div>";
echo "<div class='resumen-soporte'>";
$miDvd->muestraResumen();
echo "</div>";
echo "</div>";
echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
//Tercera prueba: pruebo la clase Juego
echo "<h2 class='section-title'>Prueba de la clase Juego</h2>";
$miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1); 
echo "<div class='soporte-card'>";
echo "<div class='titulo'>" . $miJuego->titulo . "</div>"; 
echo "<div class='detalle'>Precio: " . $miJuego->getPrecio() . " euros</div>"; 
echo "<div class='detalle'>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros</div>";
echo "<div class='resumen-soporte'>";
$miJuego->muestraResumen();
echo "</div>";
echo "</div>";
echo '</div>';
?>

        <div class="footer">
            <p>Proyecto Videoclub - DWES</p>
            <p>David Lopez Ferreras y Yusef Laroussi de la Calle</p>
        </div>
    </div>
</body>
</html>
