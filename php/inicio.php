<?php

/* Archivo de prueba para las clases Soporte y CintaVideo
Aquí pruebo que las clases funcionen correctamente y muestren toda la información */

//Incluyo las clases que voy a usar
include "Soporte.php";
include "CintaVideo.php";

//Primera prueba: creo un soporte genérico para ver si funciona la clase base
echo "<h2>Prueba de la clase Soporte</h2>";
$soporte1 = new Soporte("Tenet", 22, 3); 
echo "<strong>" . $soporte1->titulo . "</strong>"; 
echo "<br>Precio: " . $soporte1->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->muestraResumen();

//Segunda prueba: ahora pruebo la clase CintaVideo que hereda de Soporte
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
?>