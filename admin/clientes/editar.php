<?php
    // Verificar autenticacion
    require '../../includes/funciones.php';
    $auth = estaAutenticado();
    if(!$auth) {
        header('Location: ../../');
    }

    //Validar la URL por ID valido
    $idcliente = $_GET['idcliente'];
    $idcliente = filter_var( $idcliente, FILTER_VALIDATE_INT );
    if( !$idcliente ) {
        header( 'Location: ../index.php' );
    }

    //Importar conexion
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Consultar datos de la propiedad
    $consulta = "SELECT * FROM clientes WHERE idcliente = ${idcliente}";
    $resultado = mysqli_query( $db, $consulta );
    $cliente = mysqli_fetch_assoc( $resultado );
    

    //Arreglo con mensajes de errores
    $errores = [];

    $nombrecompleto = $cliente['nombrecompleto'];
    $edad = $cliente['edad'];
    $genero = $cliente['genero'];
    $estado = $cliente['estado'];
    $maneja = $cliente['maneja'];
    $usalentes = $cliente['usalentes'];
    $diabetico = $cliente['diabetico'];
    $enfermedades = $cliente['enfermedades'];
    $idproductor = $cliente['idproductor'];

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

        //Revisar que el array de errores este vacio
        if( empty( $errores ) ) {

            //Insertar en la Base de Datos
            $query = "UPDATE clientes SET nombrecompleto = '${nombrecompleto}', edad = '${edad}', genero = '${genero}', estado = '${estado}', maneja = '${maneja}', usalentes = '${usalentes}', diabetico = '${diabetico}', enfermedades = '${enfermedades}', idproductor = '${idproductor}' WHERE idcliente = '${idcliente}'";
        
            $resultado = mysqli_query( $db, $query );

            if( $resultado ) {
                //Redireccionar al usuario
                header( 'Location: ../index.php?resultado=2' );
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

        <div class="cerrar">
            <?php if($auth) : ?>
                <a href="../../cerrar-cesion.php" class="boton-amarillo">Cerrar Cesión</a>
            <?php endif ?>
        </div>
    </header>

    <main class="contenedor">
        <h2>Editar Cliente</h2>

        <a href="../index.php" class="boton-azul">Volver</a>

        <?php foreach( $errores as $error ): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach ?>

        <form class="formulario" method="POST">
            <fieldset>
                <legend>Info Cliente</legend>

                <label for="nombrecompleto">Nombre Completo</label>
                <input type="text" id="nombrecompleto" name="nombrecompleto" value="<?php echo $nombrecompleto ?>" placeholder="Nombre completo del cliente">

                <label for="edad">Edad</label>
                <input type="number" id="edad" name="edad" value="<?php echo $edad ?>" placeholder="Edad del cliente" min="0" max="127">

                <label for="genero">Genero</label>
                <select id="genero" name="genero">
                    <option value="" <?php echo $genero == $cliente['genero'] ? 'selected' : '' ?>>-- Seleccione --</option>
                    <option value="Femenino" <?php echo $genero == $cliente['genero'] ? 'selected' : '' ?>>Femenino</option>
                    <option value="Masculino" <?php echo $genero == $cliente['genero'] ? 'selected' : '' ?>>Masculino</option>
                </select>

                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    <option value="" <?php echo $estado == $cliente['estado'] ? 'selected' : '' ?>>-- Seleccione --</option>
                    <option value="Activo" <?php echo $estado == $cliente['estado'] ? 'selected' : '' ?>>Activo</option>
                    <option value="No Activo" <?php echo $estado == $cliente['estado'] ? 'selected' : '' ?>>No Activo</option>
                </select>
            </fieldset>

            <fieldset>
                <legend>Analisis de Riesgo</legend>

                <label for="maneja">¿Maneja?</label>
                <select id="maneja" name="maneja">
                    <option value="" <?php echo $maneja == $cliente['maneja'] ? 'selected' : '' ?>>-- Seleccione --</option>
                    <option value="No" <?php echo $maneja == $cliente['maneja'] ? 'selected' : '' ?>>No</option>
                    <option value="Si" <?php echo $maneja == $cliente['maneja'] ? 'selected' : '' ?>>Si</option>
                </select>

                <label for="usalentes">¿Usa lentes?</label>
                <select id="usalentes" name="usalentes">
                    <option value="" <?php echo $usalentes == $cliente['usalentes'] ? 'selected' : '' ?>>-- Seleccione --</option>
                    <option value="No" <?php echo $usalentes == $cliente['usalentes'] ? 'selected' : '' ?>>No</option>
                    <option value="Si" <?php echo $usalentes == $cliente['usalentes'] ? 'selected' : '' ?>>Si</option>
                </select>

                <label for="diabetico">¿Es Diabetico?</label>
                <select id="diabetico" name="diabetico">
                    <option value="" <?php echo $diabetico == $cliente['diabetico'] ? 'selected' : '' ?>>-- Seleccione --</option>
                    <option value="No" <?php echo $diabetico == $cliente['diabetico'] ? 'selected' : '' ?>>No</option>
                    <option value="Si" <?php echo $diabetico == $cliente['diabetico'] ? 'selected' : '' ?>>Si</option>
                </select>

                <label for="enfermedades">Otras enfermedades</label>
                <input type="textarea" id="enfermedades" name="enfermedades" value="<?php echo $enfermedades ?>" placeholder="Otras enfermedades del cliente">
            </fieldset>

            <fieldset>
                <legend>Info Productor</legend>

                <label for="idproductor">Productor Asignado</label>
                <select id="idproductor" name="idproductor">
                    <option value="" <?php echo $idproductor == $cliente['idproductor'] ? 'selected' : '' ?>>-- Seleccione --</option>
                    <option value="1" <?php echo $idproductor == $cliente['idproductor'] ? 'selected' : '' ?>>Juan Perez</option>
                    <option value="2" <?php echo $idproductor == $cliente['idproductor'] ? 'selected' : '' ?>>Pedro Gonzalez</option>
                </select>

            </fieldset>

            <input type="submit" value="Guardar Cambios" class="boton-azul">
        </form>
    </main>
    
</body>
</html>