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
        <?php
        session_start();
        include_once './lib.php';
        $user=User::userType();
        if($user != 1){
            echo "Permiso Denegado";
            User::securityUser($user);
        } else{
            ?>
        <nav id="navegador">
            <ul>
                <li><a href = 'PagAdmin.php' class="active">Ver Usuarios</a></li>  
                <li><a href="CrearUsuario.php" > Crear usuario</a></li>                
                <li><a href = 'gestionStock.php'>Gestión de stock</a></li>
                <li><a href = 'verPedidos.php'>Ver pedidos</a></li>
                <li><a href = 'cerrarSesion.php'>Cerrar Sesion</a></li>
            </ul>
        </nav>
        <section>
        <h2>Tabla usuarios</h2><br>
        <?php
        include_once 'lib.php';
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;');
        View:: alteraTabla('usuarios');
        }
        
        ?>
        </section>
    </body>
</html>