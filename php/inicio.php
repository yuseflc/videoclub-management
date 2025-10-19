<?php

/* Archivo de prueba para las clases Soporte y CintaVideo
Aquí pruebo que las clases funcionen correctamente y muestren toda la información */

//Incluyo las clases que voy a usar
include "Soporte.php";
include "CintaVideo.php";
include "Dvd.php";
include "Juego.php";

//NOTA: Ya no puedo crear objetos Soporte directamente porque ahora es una clase abstracta
//Solo puedo crear objetos de las clases hijas: CintaVideo, Dvd o Juego
//echo "<h2>Prueba de la clase Soporte</h2>";
//$soporte1 = new Soporte("Tenet", 22, 3); // Esto daría error
//echo "<strong>" . $soporte1->titulo . "</strong>"; 
//echo "<br>Precio: " . $soporte1->getPrecio() . " euros"; 
//echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
//$soporte1->muestraResumen();

//Primera prueba: pruebo la clase CintaVideo que hereda de Soporte
//He añadido la duración como nuevo atributo específico de las cintas
echo "<h2>Prueba de la clase CintaVideo</h2>";
$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107); 
//Muestro el título usando el atributo público heredado de Soporte
echo "<strong>" . $miCinta->titulo . "</strong>"; 
//Uso el método getPrecio() que heredé de la clase padre
echo "<br>Precio: " . $miCinta->getPrecio() . " euros"; 
//Calculo el precio con IVA usando el método heredado
echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
//Llamo al método muestraResumen() que he sobrescrito en CintaVideo
//Este método primero llama al del padre y luego añade la duración
$miCinta->muestraResumen();

//Tercera prueba: pruebo la clase Dvd
echo "<h2>Prueba de la clase Dvd</h2>";
$miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9"); 
echo "<strong>" . $miDvd->titulo . "</strong>"; 
echo "<br>Precio: " . $miDvd->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros";
$miDvd->muestraResumen();

//Cuarta prueba: pruebo la clase Juego
echo "<h2>Prueba de la clase Juego</h2>";
$miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1); 
echo "<strong>" . $miJuego->titulo . "</strong>"; 
echo "<br>Precio: " . $miJuego->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
$miJuego->muestraResumen();
?>