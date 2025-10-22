<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - Gestión Completa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Videoclub</h1>
            <p>Sistema de Gestión Completa</p>
        </div>
        
        <nav class="nav">
            <ul class="nav-links">
                <li><a href="inicio.php">Soportes</a></li>
                <li><a href="inicio2.php">Clientes</a></li>
                <li><a href="inicio3.php" class="active">Gestión Completa</a></li>
            </ul>
        </nav>

<?php

/* 
Archivo de prueba para la clase Videoclub con encadenamiento de métodos
Ahora uso autoload.php para cargar las clases automáticamente
*/

//Incluyo el autoload que se encarga de cargar automáticamente todas las clases
//El autoload ya incluye todas las clases que necesita Videoclub
include '../autoload.php';

//Importo la clase Videoclub del namespace Dwes\ProyectoVideoclub usando 'use'
//Esto me permite usar el nombre sin cualificar (sin poner el namespace completo)
use Dwes\ProyectoVideoclub\Videoclub;

echo '<div class="section">';
echo '<h2 class="section-title">Inicialización del Videoclub</h2>';

$vc = new Videoclub("Severo 8A"); 
echo '<div class="mensaje-exito">Videoclub "Severo 8A" creado correctamente</div>';
echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
echo '<h2 class="section-title">Inclusión de Productos</h2>';

//voy a incluir unos cuantos soportes de prueba 
echo '<div class="mensaje-exito">Juego añadido: God of War - 19.99€ (PS4)</div>';
$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1); 

echo '<div class="mensaje-exito">Juego añadido: The Last of Us Part II - 49.99€ (PS4)</div>';
$vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);

echo '<div class="mensaje-exito">DVD añadido: Torrente - 4.5€</div>';
$vc->incluirDvd("Torrente", 4.5, "es","16:9"); 

echo '<div class="mensaje-exito">DVD añadido: Origen - 4.5€</div>';
$vc->incluirDvd("Origen", 4.5, "es,en,fr", "16:9"); 

echo '<div class="mensaje-exito">DVD añadido: El Imperio Contraataca - 3€</div>';
$vc->incluirDvd("El Imperio Contraataca", 3, "es,en","16:9"); 

echo '<div class="mensaje-exito">Cinta VHS añadida: Los cazafantasmas - 3.5€ (107 min)</div>';
$vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107); 

echo '<div class="mensaje-exito">Cinta VHS añadida: El nombre de la Rosa - 1.5€ (140 min)</div>';
$vc->incluirCintaVideo("El nombre de la Rosa", 1.5, 140); 

echo '<div class="mensaje-info">Total de productos en el catálogo: 7</div>';
echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
echo '<h2 class="section-title">Catálogo de Productos</h2>';

//listo los productos 
$vc->listarProductos(); 

echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
echo '<h2 class="section-title">Gestión de Socios</h2>';

//voy a crear algunos socios 
echo '<div class="mensaje-exito">Socio registrado: Amancio Ortega</div>';
$vc->incluirSocio("Amancio Ortega"); 

echo '<div class="mensaje-exito">Socio registrado: Pablo Picasso (máximo 2 alquileres)</div>';
$vc->incluirSocio("Pablo Picasso", 2); 

echo '<div class="mensaje-info">Total de socios registrados: 2</div>';
echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
echo '<h2 class="section-title">Alquileres</h2>';

//Uso encadenamiento de métodos para alquilar varios productos al socio 1
$vc->alquilaSocioProducto(1,2)->alquilaSocioProducto(1,3);

echo '<div class="mensaje-info">Intentando alquilar producto duplicado...</div>';
//alquilo otra vez el soporte 2 al socio 1. 
// no debe dejarme porque ya lo tiene alquilado 
$vc->alquilaSocioProducto(1,2);

echo '<div class="mensaje-info">Intentando superar cupo de alquileres...</div>';
//alquilo el soporte 6 al socio 1. 
//no se puede porque el socio 1 tiene 2 alquileres como máximo 
$vc->alquilaSocioProducto(1,6); 

echo '</div>';

echo '<div class="separador"></div>';
echo '<div class="section">';
echo '<h2 class="section-title">Listado de Socios y Alquileres</h2>';

//listo los socios 
$vc->listarSocios();

echo '</div>';
?>

        <div class="footer">
            <p>Proyecto Videoclub - DWES</p>
            <p>David Lopez Ferreras y Yusef Laroussi de la Calle</p>
        </div>
    </div>
</body>
</html>
