<?php

function conectarDB() {
    $db = mysqli_connect( 'localhost', 'root', 'root', 'ficticia_sa' );

    if( !$db ) {
        echo 'Error de conexión';
        exit;
    }

    return $db;
}