<?php

//Importar Conexion
require 'includes/config/database.php';
$db = conectarDB();

//Crear email y password
$email = 'correo@correo.com';
$password = '123456';

$passwordhash = password_hash($password, PASSWORD_DEFAULT);

//Query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordhash}')";

exit;

//Agregarlo a la base de datos
mysqli_query($db, $query);