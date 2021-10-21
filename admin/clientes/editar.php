<?php
    //Validar la URL por ID valido
    $idcliente = $_GET['idcliente'];
    $idcliente = filter_var( $idcliente, FILTER_VALIDATE_INT );
    if( !$idcliente ) {
        header( 'Location: ../index.php' );
    }

    //Importar conexion
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Arreglo con mensajes de errores
    $errores = [];

    $nombrecompleto = '';
    $edad = '';
    $genero = '';
    $estado = '';
    $maneja = '';
    $usalentes = '';
    $diabetico = '';
    $enfermedades = '';
    $idproductor = '';

    //Ejecutar el codigo luego que el usuario envia el formulario
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        $nombrecompleto = mysqli_real_escape_string( $db, $_POST['nombrecompleto'] );
        $edad = mysqli_real_escape_string( $db, $_POST['edad'] );
        $genero = mysqli_real_escape_string( $db, $_POST['genero'] );
        $estado = mysqli_real_escape_string( $db, $_POST['estado'] );
        $maneja = mysqli_real_escape_string( $db, $_POST['maneja'] );
        $usalentes = mysqli_real_escape_string( $db, $_POST['usalentes'] );
        $diabetico = mysqli_real_escape_string( $db, $_POST['diabetico'] );
        $enfermedades = mysqli_real_escape_string( $db, $_POST['enfermedades'] );
        $idproductor = mysqli_real_escape_string( $db, $_POST['idproductor'] );

        if( !$nombrecompleto ) {
            $errores[] = 'Debes añadir un nombre';
        }
        if( !$edad ) {
            $errores[] = 'Debes añadir una edad';
        }
        if( !$genero ) {
            $errores[] = 'Debes añadir un genero';
        }
        if( !$estado ) {
            $errores[] = 'Debes añadir un estado';
        }
        if( !$maneja ) {
            $errores[] = 'Debes añadir si maneja';
        }
        if( !$usalentes ) {
            $errores[] = 'Debes añadir si usa lentes';
        }
        if( !$diabetico ) {
            $errores[] = 'Debes añadir si es diabetico';
        }
        if( !$idproductor ) {
            $errores[] = 'Debes añadir un productor asignado';
        }

        // echo '<pre>';
        // var_dump( $errores );
        // echo '</pre>';

        //Revisar que el array de errores este vacio
        if( empty( $errores ) ) {

            //Insertar en la Base de Datos
            $query = "INSERT INTO clientes ( nombrecompleto, edad, genero, estado, maneja, usalentes, diabetico, enfermedades, idproductor ) VALUES ( '$nombrecompleto', '$edad', '$genero', '$estado', '$maneja', '$usalentes', '$diabetico', '$enfermedades', '$idproductor' )";
        
            $resultado = mysqli_query( $db, $query );

            if( $resultado ) {
                //Redireccionar al usuario
                header( 'Location: ../index.php?resultado=1' );
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficticia S.A.</title>
    <link rel="stylesheet" href="../../build/css/app.css">
</head>
<body>
    <header class="header">
        <h1>Ficticia S.A.</h1>
    </header>

    <main class="contenedor">
        <h2>Editar Cliente</h2>

        <a href="../index.php" class="boton-azul">Volver</a>

        <?php foreach( $errores as $error ): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="../clientes/crear.php">
            <fieldset>
                <legend>Info Cliente</legend>

                <label for="nombrecompleto">Nombre Completo</label>
                <input type="text" id="nombrecompleto" name="nombrecompleto" value="<?php echo $nombrecompleto ?>" placeholder="Nombre completo del cliente">

                <label for="edad">Edad</label>
                <input type="number" id="edad" name="edad" value="<?php echo $edad ?>" placeholder="Edad del cliente" min="0" max="127">

                <label for="genero">Genero</label>
                <select id="genero" name="genero">
                    <option value="">-- Seleccione --</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                </select>

                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    <option value="">-- Seleccione --</option>
                    <option value="Activo">Activo</option>
                    <option value="No Activo">No Activo</option>
                </select>
            </fieldset>

            <fieldset>
                <legend>Analisis de Riesgo</legend>

                <label for="maneja">¿Maneja?</label>
                <select id="maneja" name="maneja">
                    <option value="">-- Seleccione --</option>
                    <option value="No">No</option>
                    <option value="Si">Si</option>
                </select>

                <label for="usalentes">¿Usa lentes?</label>
                <select id="usalentes" name="usalentes">
                    <option value="">-- Seleccione --</option>
                    <option value="No">No</option>
                    <option value="Si">Si</option>
                </select>

                <label for="diabetico">¿Es Diabetico?</label>
                <select id="diabetico" name="diabetico">
                    <option value="">-- Seleccione --</option>
                    <option value="No">No</option>
                    <option value="Si">Si</option>
                </select>

                <label for="enfermedades">Otras enfermedades</label>
                <input type="textarea" id="enfermedades" name="enfermedades" value="<?php echo $enfermedades ?>" placeholder="Otras enfermedades del cliente">
            </fieldset>

            <fieldset>
                <legend>Info Productor</legend>

                <label for="idproductor">Productor Asignado</label>
                <select id="idproductor" name="idproductor">
                    <option value="">-- Seleccione --</option>
                    <option value="1">Juan Perez</option>
                    <option value="2">Pedro Gonzalez</option>
                </select>

            </fieldset>

            <input type="submit" value="Guardar Cambios" class="boton-azul">
        </form>
    </main>
    
</body>
</html>