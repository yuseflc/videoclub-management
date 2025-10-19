<?php
include_once "CintaVideo.php";
include_once "Dvd.php";
include_once "Juego.php";
include_once "Cliente.php";

//instanciamos un par de objetos cliente
$cliente1 = new Cliente("Bruce Wayne", 23);
$cliente2 = new Cliente("Clark Kent", 33);

//mostramos el número de cada cliente creado 
echo "<br>El identificador del cliente 1 es: " . $cliente1->getNumero();
echo "<br>El identificador del cliente 2 es: " . $cliente2->getNumero();

//instancio algunos soportes 
$soporte1 = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
$soporte2 = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);  
$soporte3 = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
$soporte4 = new Dvd("El Imperio Contraataca", 4, 3, "es,en","16:9");

//alquilo algunos soportes de forma encadenada
//He utilizado el encadenamiento de métodos (method chaining) para alquilar múltiples soportes en una sola línea
$cliente1->alquilar($soporte1)->alquilar($soporte2)->alquilar($soporte3);

//voy a intentar alquilar de nuevo un soporte que ya tiene alquilado
//el encadenamiento sigue funcionando incluso con errores
$cliente1->alquilar($soporte1);
//el cliente tiene 3 soportes en alquiler como máximo
//este soporte no lo va a poder alquilar
$cliente1->alquilar($soporte4);
//este soporte no lo tiene alquilado, pero devuelvo también encadenado
$cliente1->devolver(4);
//devuelvo dos soportes de forma encadenada
$cliente1->devolver(2)->alquilar($soporte4);
//listo los elementos alquilados
$cliente1->listarAlquileres();
//este cliente no tiene alquileres
$cliente2->devolver(2);
?>
