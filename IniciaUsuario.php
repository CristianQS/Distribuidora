<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="estilos.css">
        <script src="scripts.js"></script>
    </head>

    <body>
        <header id="cabezera">
            <h1>Distribuidoras Refresh</h1>
            <img src="imagenes/truck.png" alt="camión"/>
        </header>
        <nav id="navegador">
            <ul>
                <li><a href="index.php" > Inicio</a></li>
            </ul>
        </nav>
        <h2>Iniciar sesión</h2>
        <form>
            <label>Usuario </label><input type = 'text' name= 'Usuario' id = 'Usuario' size ='20'> <br>
            <label>Contraseña</label><input type = 'password' name= 'Password' id = 'Password' size ='20'><br>
            <input type = 'submit' value = 'Registrase' name= 'Boton' id = 'Boton'><br>
        </form>
    <?php
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    if(isset($_GET['Usuario'])){
        $comprobar = User::login($_GET['Usuario'],$_GET['Password']);
        if($comprobar){
            $res = User::userType();
            User::choosePage($res);
        }else{
            echo "<br><h1>Este usuario no existe</h1>";
        }
    }
    ?>    
    </body>
</html>