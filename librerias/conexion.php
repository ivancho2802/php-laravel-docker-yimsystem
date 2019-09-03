<?php
// $conexion = new mysqli("ec2-107-20-155-148.compute-1.amazonaws.com", "kjogxhvdvnkumx", "b42f2b9f3dda672e63925904f1450b38698f03289409be8008efd07f526c20a9", "delcqdglr7h1b8", 5432);
$conexion = mysqli_connect("ec2-107-20-155-148.compute-1.amazonaws.com", "kjogxhvdvnkumx", "b42f2b9f3dda672e63925904f1450b38698f03289409be8008efd07f526c20a9", "delcqdglr7h1b8");
// $conexion = new mysqli("localhost", "root", "", "panaderia");
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
}	
?>