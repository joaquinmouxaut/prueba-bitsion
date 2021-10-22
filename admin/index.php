<?php
    // Verificar autenticacion
    require '../includes/funciones.php';
    $auth = estaAutenticado();
    if(!$auth) {
        header('Location: ../');
    }

    //Importar conexion
    require '../includes/config/database.php';
    $db = conectarDB();

    //Mostrar mensaje condicional 
    $resultado = $_GET['resultado'] ?? null;

    //Escribir el query
    $query = 'SELECT * FROM clientes';

    //Consultar la BD
    $resultadoConsulta = mysqli_query( $db, $query );

    if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $idcliente = $_POST['idcliente'];
        $idcliente = filter_var($idcliente, FILTER_VALIDATE_INT);
        if($idcliente) {
            //Eliminar la propiedad
            $query = "DELETE FROM clientes WHERE idcliente = ${idcliente}";

            $resultado = mysqli_query($db, $query);

            if($resultado) {
                header('location: index.php?resultado=3');
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
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body>
    <header class="header">
        <h1>Ficticia S.A.</h1>

        <div class="cerrar">
            <?php if($auth) : ?>
                <a href="../cerrar-cesion.php" class="boton-amarillo">Cerrar Cesión</a>
            <?php endif ?>
        </div>
    </header>

    <main class="contenedor">
        <h2>Administrador de Clientes</h2>

        <?php if( $resultado == 1 ) : ?>
            <p class="alerta exito">Cliente creado correctamente</p>
        <?php elseif( $resultado == 2 ) : ?>
            <p class="alerta exito">Cliente actualizado correctamente</p>
        <?php elseif( $resultado == 3 ) : ?>
            <p class="alerta exito">Cliente eliminado correctamente</p>
        <?php endif ?>

        <a href="./clientes/crear.php" class="boton-azul">Nuevo Cliente</a>

        <table class="clientes">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Genero</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody><!-- Mostrar los resultados -->
                <?php while( $cliente = mysqli_fetch_assoc( $resultadoConsulta ) ) : ?>
                <tr>
                    <td><?php echo $cliente['idcliente']; ?></td>
                    <td><?php echo $cliente['nombrecompleto']; ?></td>
                    <td><?php echo $cliente['edad']; ?></td>
                    <td><?php echo $cliente['genero']; ?></td>
                    <td><?php echo $cliente['estado']; ?></td>
                    <td>
                        <a href="./clientes/editar.php?idcliente=<?php echo $cliente['idcliente']; ?>" class="boton-azul">Editar</a>
                        <form method="POST" class="eliminar">
                            <input type="hidden" name="idcliente" value="<?php echo $cliente['idcliente']; ?>">
                            <input type="submit" value="Eliminar" class="boton-amarillo">
                        </form>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </main>

    <?php
        //Cerrar la conexión
        mysqli_close( $db );
    ?>
</body>
</html>