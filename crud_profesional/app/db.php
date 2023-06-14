<?php

$servidor = "localhost";
$baseDatos = "app";
$usuario = "root";
$contrasenia = "";

try {
   $conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $contrasenia);
} catch (Exception $ex) {
   echo $ex->getMessage();
}
