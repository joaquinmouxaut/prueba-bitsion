<?php
    //Importar Conexion
    require 'includes/config/database.php';
    $db = conectarDB();

    $errores = [];

    //Autenticar Usuario
    if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if( !$email ) {
            $errores[] = "El email no es valido";
        }
        if( !$password ) {
            $errores[] = "El password no es valido";
        }

        if( empty($errores) ) {
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '${email}' ";
            $resultado = mysqli_query($db, $query);

            if( $resultado -> num_rows ) {
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc( $resultado );
                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    //Usuario Autenticado
                    session_start();
                    header('Location: ./admin/index.php');

                    //Llenar arreglo de la sesión
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;
                } else {
                    $errores[] = "Contraseña invalida";
                }
            } else {
                $errores[] = "El usuario no existe";
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
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body>
    <header class="header">
        <h1>Ficticia S.A.</h1>
    </header>

    <main class="contenedor">
        <h2>Iniciar Sesion</h2>

        <?php foreach($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario" novalidate>
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu E-mail" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Contraseña" id="password" required>

                <input type="submit" value="Iniciar Sesion" class="boton-azul" required>
            </fieldset>
        </form>
    </main>
</body>    