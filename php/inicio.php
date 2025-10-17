<?php

/* Archivo de prueba: crea un objeto Soporte y muestra sus datos
Se utiliza para comprobar el funcionamiento de la clase Soporte */

include "Soporte.php";

$soporte1 = new Soporte("Tenet", 22, 3); 
echo "<strong>" . $soporte1->titulo . "</strong>"; 
echo "<br>Precio: " . $soporte1->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->infoSoporte();
?>